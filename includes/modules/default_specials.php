<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  
    $special_products_query = tep_db_query("select p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price, s.status_front_page from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s where p.products_status = '1' and s.products_id = p.products_id and p.products_id = pd.products_id and pd.language_id = '" . $languages_id . "' and s.status = '1' and s.status_front_page = '1' order by s.specials_date_added DESC limit " . MAX_DISPLAY_SPECIAL_PRODUCTS);
  // select p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price, s.status_front_page from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s where p.products_status = '1' and p.products_id = s.products_id and pd.products_id = s.products_id and pd.language_id = '" . (int)$languages_id . "' and s.status = '1' and s.status_front_page = '1' order by s.specials_date_added desc limit " . MAX_RANDOM_SELECT_SPECIALS
  

  $num_special_products = tep_db_num_rows($special_products_query);

  if ($num_special_products > 0) {
    $counter = 0;
    $col = 0;

    $spec_prods_content = '<table class="productGridTable" border="0" width="100%" cellspacing="0" cellpadding="10">';
    while ($special_products = tep_db_fetch_array($special_products_query)) {
      $counter++;

      if ($col === 0) {
        $spec_prods_content .= '<tr>';
      }

      $spec_prods_content .= '<td width="33%" align="center" valign="bottom"><div class="productGrid"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $special_products["products_id"]) . '">' . tep_image(DIR_WS_IMAGES . $special_products['products_image'], $special_products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'class=shadow1') . '</a><br /><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $special_products['products_id']) . '">' . $special_products['products_name'] . '</a><br /><s>' . $currencies->display_price($special_products['products_price'], tep_get_tax_rate($special_products['products_tax_class_id'])) . '</s><br /><span class="productSpecialPrice">' . $currencies->display_price($special_products['specials_new_products_price'], tep_get_tax_rate($special_products['products_tax_class_id'])) . '</span></div>';

      $col ++;

      if (($col > 2) || ($counter == $num_special_products)) {
        $spec_prods_content .= '</tr>';

        $col = 0;
      }
    }

    $spec_prods_content .= '</table>';
?>
<div class="ui-widget-header infoBoxHeading">
  <?php echo sprintf(TABLE_HEADING_DEFAULT_SPECIALS, strftime('%B')); ?></div>

  <div class="contentText">
    <?php echo $spec_prods_content; ?>
  </div>

<?php
  }
?>
<?php
/*

*/
/*
?>










<!-- special_products //-->

  <tr>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
<?php
$info_box_contents = array();
  $info_box_contents[] = array('align' => 'left', 'text' => ));
  new infoBoxHeading($info_box_contents, false, false, tep_href_link(FILENAME_SPECIALS));

 $new = tep_db_query("select p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price, s.status_front_page from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s where p.products_status = '1' and s.products_id = p.products_id and p.products_id = pd.products_id and pd.language_id = '" . $languages_id . "' and s.status = '1' and s.status_front_page = '1' order by s.specials_date_added DESC limit " . MAX_DISPLAY_SPECIAL_PRODUCTS);
  // select p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price, s.status_front_page from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s where p.products_status = '1' and p.products_id = s.products_id and pd.products_id = s.products_id and pd.language_id = '" . (int)$languages_id . "' and s.status = '1' and s.status_front_page = '1' order by s.specials_date_added desc limit " . MAX_RANDOM_SELECT_SPECIALS
 $info_box_contents = array();
  $row = 0;
  $col = 0;
  while ($special_products = tep_db_fetch_array($new)) {
    $special_products['products_name'] = tep_get_products_name($special_products['products_id']);
    $info_box_contents[$row][$col] = array('align' => 'center',
                                           'params' => 'class="smallText" width="33%" valign="top"',
                                           'text' => '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $special_products["products_id"]) . '">' . tep_image(DIR_WS_IMAGES . $special_products['products_image'], $special_products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'class=shadow1') . '</a><br /><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $special_products['products_id']) . '">' . $special_products['products_name'] . '</a><br /><s>' . $currencies->display_price($special_products['products_price'], tep_get_tax_rate($special_products['products_tax_class_id'])) . '</s><br /><span class="productSpecialPrice">' . $currencies->display_price($special_products['specials_new_products_price'], tep_get_tax_rate($special_products['products_tax_class_id'])) . '</span>');
    $col ++;
    if ($col > 2) {
      $col = 0;
      $row ++;
    }
  }
  new contentBox($info_box_contents);


<!-- special_products_eof //-->*/?>