<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  class shipping {
    var $modules;

// class constructor
    function shipping($module = '') {
      //global $language, $PHP_SELF;
	  // start indvship
      // global $language, $PHP_SELF;
	  global $language, $PHP_SELF, $cart;
	  $products = $cart->get_products();// BOF: indvship prices
	  $shiptotal = $this->get_shiptotal();
	  $indvcount = $this->get_indvcount();// EOF: indvship prices
	  
	  $cart_total = $cart->show_total();
	  // end indvship

      if (defined('MODULE_SHIPPING_INSTALLED') && tep_not_null(MODULE_SHIPPING_INSTALLED)) {
        $this->modules = explode(';', MODULE_SHIPPING_INSTALLED);

        $include_modules = array();

        if ( (tep_not_null($module)) && (in_array(substr($module['id'], 0, strpos($module['id'], '_')) . '.' . substr($PHP_SELF, (strrpos($PHP_SELF, '.')+1)), $this->modules)) ) {
          $include_modules[] = array('class' => substr($module['id'], 0, strpos($module['id'], '_')), 'file' => substr($module['id'], 0, strpos($module['id'], '_')) . '.' . substr($PHP_SELF, (strrpos($PHP_SELF, '.')+1)));
        } else {
          reset($this->modules);
		
/*		
				// start indvship
          while (list(, $value) = each($this->modules)) {
            $class = substr($value, 0, strrpos($value, '.'));
            $include_modules[] = array('class' => $class, 'file' => $value);
          }
        }

									
	*/
		$exemptFreeShip = 0;
		for ($i=0, $n=sizeof($products); $i<$n; $i++) {
			if (tep_not_null($products[$i]['products_ship_exempt_free']) && ($products[$i]['products_ship_exempt_free'] == 1)) {
				$exemptFreeShip = 1;
				//echo 'Atleast one is free ship.  ';
				break;
			}								
		}
		//echo 'Is ' . $cart_total .  ' > ' . MODULE_SHIPPING_FREEAMOUNT_AMOUNT;
		if ((tep_get_configuration_key_value('MODULE_SHIPPING_FREEAMOUNT_STATUS')) && ((tep_not_null($shiptotal)) || $shiptotal == 0) && ($cart_total > MODULE_SHIPPING_FREEAMOUNT_AMOUNT) && ($exemptFreeShip != 1)){
			//echo ' yes';
				$include_modules[] = array('class'=> 'freeamount', 'file' => 'freeamount.php');
		} else {
			/*if ($exemptFreeShip == 1) {
				echo ' maybe, but is exempt';
			} else {
				echo ' no';
			}
			*/
			if($indvcount==sizeof($products)){
				if ((tep_get_configuration_key_value('MODULE_SHIPPING_INDVSHIP_STATUS')) && ((tep_not_null($shiptotal)) || $shiptotal == 0)) {
					$include_modules[] = array('class'=> 'indvship', 'file' => 'indvship.php');			
				}
			} else { 
			  	if(sizeof($products)>$indvcount){
					while (list(, $value) = each($this->modules)) {
						$class = substr($value, 0, strrpos($value, '.'));
						if (($class !='freeamount') && ($class != 'indvship')) {  //comment to show all ship options
						//if ($class !='freeamount') { // uncomment to show all ship options
							$include_modules[] = array('class' => $class, 'file' => $value);
						}
					}
				}
			}
		}	
	}
		// end indvship 
		

        for ($i=0, $n=sizeof($include_modules); $i<$n; $i++) {
          include(DIR_WS_LANGUAGES . $language . '/modules/shipping/' . $include_modules[$i]['file']);
          include(DIR_WS_MODULES . 'shipping/' . $include_modules[$i]['file']);

          $GLOBALS[$include_modules[$i]['class']] = new $include_modules[$i]['class'];
        }
      }
    }

    function quote($method = '', $module = '') {
      global $total_weight, $shipping_weight, $shipping_quoted, $shipping_num_boxes;

      $quotes_array = array();

      if (is_array($this->modules)) {
        $shipping_quoted = '';
        $shipping_num_boxes = 1;
        $shipping_weight = $total_weight;

        if (SHIPPING_BOX_WEIGHT >= $shipping_weight*SHIPPING_BOX_PADDING/100) {
          $shipping_weight = $shipping_weight+SHIPPING_BOX_WEIGHT;
        } else {
          $shipping_weight = $shipping_weight + ($shipping_weight*SHIPPING_BOX_PADDING/100);
        }

        if ($shipping_weight > SHIPPING_MAX_WEIGHT) { // Split into many boxes
          $shipping_num_boxes = ceil($shipping_weight/SHIPPING_MAX_WEIGHT);
          $shipping_weight = $shipping_weight/$shipping_num_boxes;
        }

        $include_quotes = array();

        reset($this->modules);
        while (list(, $value) = each($this->modules)) {
          $class = substr($value, 0, strrpos($value, '.'));
          if (tep_not_null($module)) {
            if ( ($module == $class) && ($GLOBALS[$class]->enabled) ) {
              $include_quotes[] = $class;
            }
          } elseif ($GLOBALS[$class]->enabled) {
            $include_quotes[] = $class;
          }
        }

        $size = sizeof($include_quotes);
        for ($i=0; $i<$size; $i++) {
          $quotes = $GLOBALS[$include_quotes[$i]]->quote($method);
          if (is_array($quotes)) $quotes_array[] = $quotes;
        }
      }

      return $quotes_array;
    }

	//start indvship modified by mark to allow free shipping by a certain quantity (products_ship_price_two) of products in a group (products_ship_id)
	// the 'free' varible refers to the credits for free shipping.  Only when the free variable is more than zero is free shipping allowed by indvship
	function get_shiptotal() {
		global $cart, $order;
		$this->shiptotal = 0;
		$free=0;
		$products = $cart->get_products();
		$qtyfreeship = array();		
		$exemptFreeShip = 0;
		for ($i=0, $n=sizeof($products); $i<$n; $i++) {
			if (tep_not_null($products[$i]['products_ship_price'])) {
				$products_ship_price = $products[$i]['products_ship_price'];
				$products_ship_price_two = $products[$i]['products_ship_price_two'];
				$products_ship_id = $products[$i]['products_ship_zip'];
				$qty = $products[$i]['quantity'];
				if(tep_not_null($products_ship_price_two || $products_ship_id )) {			
					if (tep_not_null($products[$i]['products_ship_exempt_free']) && ($products[$i]['products_ship_exempt_free'] == 1)) {	//ignore if exempt
						$exemptFreeShip = 1;							
					}
					$qtyfreeship[$products_ship_id] += $qty; // store the qty in an array based on the ship id
					if ($qtyfreeship[$products_ship_id] > $qty) {} else {$free -= $products_ship_price_two;};// add total needed to qualify for free shipping to the free shipping credits
					//check to see if the quantity of the product or its group is enough to allow free shipping
					if ($qty > ($products_ship_price_two-1) || $qtyfreeship[$products_ship_id] > ($products_ship_price_two-1) ) {
						$free += 9999; // $products_ship_price_two; old version, required all items in basket to be free shipping now only requires one. 
					}
					if ($this->shiptotal<$products_ship_price) {
						$this->shiptotal = ($products_ship_price);
					} 
				} else { 
					$products_ship_price = '9';
				
				// if there are no entries for free shipping for this item deny it for all
					/*
					if(tep_not_null($products_ship_price)) {
							$this->shiptotal = ($products_ship_price);
							$free -= 999999;}
					*/
					
				}
			}
			
		}
		if ($exemptFreeShip == 1) {	//ignore if exempt
			$free = 0;							
		}
		//echo ' Free is ' . $free . '.  ';
		if ($free > 0) {$this->shiptotal = 0.00;}; // if all credits have been fufilled allow free shipping
		// CHECK TO SEE IF SHIPPING TO HOME COUNTRY, IF NOT INCREASE SHIPPING COSTS BY AMOUNT SET IN ADMIN/////////////move back here <<------------
		/*if (($order->delivery['country']['id']) != INDIVIDUAL_SHIP_HOME_COUNTRY) {
			if(INDIVIDUAL_SHIP_INCREASE > '0' || $this->shiptotal > '0') {
				$this->shiptotal *= INDIVIDUAL_SHIP_INCREASE;
		    } else {
				$this->shiptotal += INDIVIDUAL_SHIP_INCREASE * $this->get_indvcount();
		    }
		    return $this->shiptotal;
			// not sure why this is needed, but it now works correctly for home country - by Ed
		} else {*/
				$this->shiptotal *= 1;
				return $this->shiptotal;
	//	}
	}

	function get_indvcount() {
	  global $cart;
	  $this->indvcount = '';
	  $products = $cart->get_products();
	  for ($i=0, $n=sizeof($products); $i<$n; $i++) {
	    if (tep_not_null($products[$i]['products_ship_price'])) {
	      $products_ship_price = $products[$i]['products_ship_price'];//}
	      $products_ship_price_two = $products[$i]['products_ship_price_two'];
	      if(is_numeric($products_ship_price)){
	        $this->indvcount += '1';
	      }
	    }
	  }
	  return $this->indvcount;
	}

	// end indvship

    function cheapest() {
      if (is_array($this->modules)) {
        $rates = array();

        reset($this->modules);
        while (list(, $value) = each($this->modules)) {
          $class = substr($value, 0, strrpos($value, '.'));
          if ($GLOBALS[$class]->enabled) {
            $quotes = $GLOBALS[$class]->quotes;
            for ($i=0, $n=sizeof($quotes['methods']); $i<$n; $i++) {
              if (isset($quotes['methods'][$i]['cost']) && tep_not_null($quotes['methods'][$i]['cost'])) {
                $rates[] = array('id' => $quotes['id'] . '_' . $quotes['methods'][$i]['id'],
                                 'title' => $quotes['module'] . ' (' . $quotes['methods'][$i]['title'] . ')',
                                 'cost' => $quotes['methods'][$i]['cost']);
              }
            }
          }
        }

        $cheapest = false;
        for ($i=0, $n=sizeof($rates); $i<$n; $i++) {
          if (is_array($cheapest)) {
            if ($rates[$i]['cost'] < $cheapest['cost']) {
              $cheapest = $rates[$i];
            }
          } else {
            $cheapest = $rates[$i];
          }
        }

        return $cheapest;
      }
    }
  }
?>
