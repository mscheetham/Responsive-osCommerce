<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

  PHPLOT 4.4.6 Copyright (c) 1998-2001 Afan Ottenheimer
*/

class PHPlot{

	var $is_inline = 0;			//0 = Sends headers, 1 = sends just raw image data
	var $browser_cache = '1';	// 0 = Sends headers for browser to not cache the image, (i.e. 0 = don't let browser cache image)
									// (only if is_inline = 0 also)
	var $session_set = '';		//Do not change
	var $scale_is_set = '';		//Do not change
	var $draw_plot_area_background = '';

	var $image_width;	//Total Width in Pixels 
	var $image_height; 	//Total Height in Pixels
	var $image_border_type = ''; //raised, plain, ''
	var $x_left_margin;
	var $y_top_margin;
	var $x_right_margin;
	var $y_bot_margin;
	var $plot_area = array(5,5,600,400);
	var $x_axis_position = 0;	//Where to draw the X_axis (world coordinates)
	var $y_axis_position = '';  //Leave blank for Y axis at left of plot. (world coord.)
	var $xscale_type = 'linear';  //linear or log
	var $yscale_type = 'linear';

//Use for multiple plots per image
	var $print_image = 1;  //Used for multiple charts per image. 

//Fonts
	var $use_ttf  = 0;		  //Use TTF fonts (1) or not (0)
	var $font_path = './';  //To be added 
	var $font = './benjamingothic.ttf';

	///////////Fonts: Small/Generic
	var $small_ttffont_size = 12; //
	//non-ttf
	var $small_font = 2; // fonts = 1,2,3,4 or 5
	var $small_font_width = 6.0; // width in pixels (2=6,3=8,4=8)
	var $small_font_height = 8.0; // height in pixels (2=8,3=10,4=12)

	//////////   Fonts:Title
	var $title_ttffont = './benjamingothic.ttf';
	var $title_ttffont_size = 14;
	var $title_angle= 0;
	//non-ttf
	var $title_font = '4'; // fonts = 1,2,3,4,5

	//////////////  Fonts:Axis
	var $axis_ttffont = './benjamingothic.ttf';
	var $axis_ttffont_size = 8;
	var $x_datalabel_angle = 0;
	//non-ttf
	var $axis_font = 2;

	////////////////Fonts:Labels of Data
	var $datalabel_font = '2';

	//////////////// Fonts:Labels (Axis Titles)
	var $x_label_ttffont = './benjamingothic.ttf';
	var $x_label_ttffont_size = '12';
	var $x_label_angle = '0';

	var $y_label_ttffont = './benjamingothic.ttf';
	var $y_label_ttffont_size = '12';
	var $y_label_angle = 90;
	var $y_label_width = '';

//Formats
	var $file_format = 'png';
	var $file_name = '';  //For output to a file instead of stdout

//Plot Colors
	var $shading = 0;
	var $color_array = 1;	//1 = include small list
							//2 = include large list
							//array =  define your own color translation. See rgb.inc.php and SetRGBArray
	var $bg_color;
	var $plot_bg_color;
	var $grid_color;
	var $light_grid_color;
	var $tick_color;
	var $title_color;
	var $label_color;
	var $text_color;
	var $i_light = '';

//Data
	var $data_type = 'text-data'; //text-data, data-data-error, data-data 
	var $plot_type= 'linepoints'; //bars, lines, linepoints, area, points, pie, thinbarline
	var $line_width = 2;
	var $line_style = array('solid','solid','solid','dashed','dashed','solid'); //Solid or dashed lines

	var $data_color = ''; //array('blue','green','yellow',array(0,0,0));
	var $data_border_color = '';

	var $label_scale_position = '.5';  //1 = top, 0 = bottom
	var $group_frac_width = '.7'; //value from 0 to 1 = width of bar
	var $bar_width_adjust = '1'; //1 = bars of normal width, must be > 0

	var $point_size = 10;
	var $point_shape = 'diamond'; //rect,circle,diamond,triangle,dot,line,halfline
	var $error_bar_shape = 'tee'; //tee, line
	var $error_bar_size = 5; //right left size of tee
	var $error_bar_line_width = ''; //If set then use it, else use $line_width for thickness
	var $error_bar_color = ''; 
	var $data_values;

	var $plot_border_type = 'full'; //left, none, full
	var $plot_area_width = '';
	var $number_x_points;
	var $plot_min_x; // Max and min of the plot area
	var $plot_max_x= ''; // Max and min of the plot area
	var $plot_min_y= ''; // Max and min of the plot area
	var $plot_max_y = ''; // Max and min of the plot area
	var $min_y = '';
	var $max_y = '';
	var $max_x = 10;  //Must not be = 0;
	var $y_precision = '1';
	var $x_precision = '1';
	var $si_units = '';

//Labels
	var $draw_data_labels = '0';  
	var $legend = '';  //an array
	var $legend_x_pos = '';
	var $legend_y_pos = '';
	var $title_txt = "";
	var $y_label_txt = '';
	var $x_label_txt = "";

//DataAxis Labels (on each axis)
	var $y_grid_label_type = 'data';    //data, none, time, other
	var $y_grid_label_pos = 'plotleft'; //plotleft, plotright, yaxis, both
	var $x_grid_label_type = 'data';    //data, title, none, time, other
	var $draw_x_data_labels = '';       // 0=false, 1=true, ""=let program decide 
	var $x_time_format = "%H:%m:%s";    //See http://www.php.net/manual/html/function.strftime.html
	var $x_datalabel_maxlength = 10;	

//Tick Formatting
	var $tick_length = '10';   //pixels: tick length from axis left/downward
	//tick_length2 to be implemented
	//var $tick_length2 = '';  //pixels: tick length from axis line rightward/upward
	var $draw_vert_ticks = 1;  //1 = draw ticks, 0 = don't draw ticks
	var $num_vert_ticks = '';
	var $vert_tick_increment=''; //Set num_vert_ticks or vert_tick_increment, not both.
	var $vert_tick_position = 'both'; //plotright=(right of plot only), plotleft=(left of plot only), 
								//both = (both left and right of plot), yaxis=(crosses y axis)
	var $horiz_tick_increment=''; //Set num_horiz_ticks or horiz_tick_increment, not both.
	var $num_horiz_ticks='';
	var $skip_top_tick = '0';
	var $skip_bottom_tick = '0';

//Grid Formatting
	var $draw_x_grid = 0;
	var $draw_y_grid = 1;


//BEGIN CODE
//////////////////////////////////////////////////////
	//Constructor: Setup Img pointer, Colors and Size of Image
	function PHPlot($which_width=600,$which_height=400,$which_output_file="",$which_input_file="") {

		$this->SetRGBArray('2'); 
		$this->background_done = 0; //Set to 1 after background image first drawn

		if ($which_output_file != "") { $this->SetOutputFile($which_output_file);  };

		if ($which_input_file != "") { 
			$this->SetInputFile($which_input_file) ; 
		} else { 
			$this->SetImageArea($which_width, $which_height);
			$this->InitImage();
		}

		if ( ($this->session_set == 1) && ($this->img == "") ) {  //For sessions
			//Do nothing
		} else { 
			$this->SetDefaultColors();
		}

		$this->SetIndexColors();

	}
	    
	//Set up the image and colors
	function InitImage() {
		//if ($this->img) { 
		//	ImageDestroy($this->img);
		//}
		$this->img = ImageCreate($this->image_width, $this->image_height);
		return true;
	}

	function SetBrowserCache($which_browser_cache) {  //Submitted by Thiemo Nagel
		$this->browser_cache = $which_browser_cache;
		return true;
	}

	function SetPrintImage($which_pi) {
		$this->print_image = $which_pi;
		return true;
	}

	function SetIsInline($which_ii) {
		$this->is_inline = $which_ii;
		return true;
	}

	function SetUseTTF($which_ttf) {
		$this->use_ttf = $which_ttf;
		return true;
	}

	function SetTitleFontSize($which_tfs) {
		//TTF
		$this->title_ttffont_size = $which_tfs; //pt size

		//Non-TTF settings
		if (($which_tfs > 5) && (!$this->use_ttf)) {
			$this->DrawError('Non-TTF font size must be 1,2,3,4 or 5');
			return false;
		} else {
			$this->title_font = $which_tfs;
			//$this->title_font_height = ImageFontHeight($which_tfs) // height in pixels 
			//$this->title_font_width = ImageFontWidth($which_tfs); // width in pixels 
		}
		return true;
	}

	function SetLineStyles($which_sls){
		$this->line_style = $which_sls;
		return true;
	}

	function SetLegend($which_leg){
		if (is_array($which_leg)) { 
			$this->legend = $which_leg;
			return true;
		} else { 
			$this->DrawError('Error: SetLegend argument must be an array');
			return false;
		}
	}

	function SetLegendPixels($which_x,$which_y,$which_type) { 
		//which_type not yet used
		$this->legend_x_pos = $which_x;
		$this->legend_y_pos = $which_y;
		return true;
	}

	function SetLegendWorld($which_x,$which_y,$which_type='') { 
		//which_type not yet used
		//Must be called after scales are set up. 
		if ($this->scale_is_set != 1) { $this->SetTranslation(); };
		$this->legend_x_pos = $this->xtr($which_x);
		$this->legend_y_pos = $this->ytr($which_y);
		return true;
	}
/* ***************************************
	function SetFileFormat($which_file_format) { //Only works with PHP4
		$asked = strtolower($which_file_format);
		if( $asked =="jpg" || $asked =="png" || $asked =="gif" || $asked =="wbmp" ) {
			if( $asked=="jpg" && !(imagetypes() & IMG_JPG) )
				return false;
			elseif( $asked=="png" && !(imagetypes() & IMG_PNG) ) 
				return false;
			elseif( $asked=="gif" && !(imagetypes() & IMG_GIF) ) 	
				return false;
			elseif( $asked=="wbmp" && !(imagetypes() & IMG_WBMP) ) 	
				return false;
			else {
				$this->img_format=$asked;
				return true;
			}
		}
		else
			return false;
	}	

*************************************** */
	function SetFileFormat($which_file_format) {
	//eventually test to see if that is supported - if not then return false
		$asked = strtolower(trim($which_file_format));
		if( ($asked=='jpg') || ($asked=='png') || ($asked=='gif') || ($asked=='wbmp') ) {
			$this->file_format = $asked;
			return true;
		} else {
			return false;
		}
	}

	function SetInputFile($which_input_file) { 
		//$this->SetFileFormat($which_frmt);
		$size = GetImageSize($which_input_file);
		$input_type = $size[2]; 

		switch($input_type) {  //After SetFileFormat is in lower case
			case "1":
				$im = @ImageCreateFromGIF ($which_input_file);
				if (!$im) { // See if it failed 
					$this->PrintError("Unable to open $which_input_file as a GIF");
					return false;
				}
			break;
			case "3":
				$im = @ImageCreateFromPNG ($which_input_file); 
				if (!$im) { // See if it failed 
					$this->PrintError("Unable to open $which_input_file as a PNG");
					return false;
				}
			break;
			case "2":
				$im = @ImageCreateFromJPEG ($which_input_file); 
				if (!$im) { // See if it failed 
					$this->PrintError("Unable to open $which_input_file as a JPG");
					return false;
				}
			break;
			default:
				$this->PrintError('Please select wbmp,gif,jpg, or png for image type!');
				return false;
			break;
		}

		//Get Width and Height of Image
		$this->SetImageArea($size[0],$size[1]);

		$this->img = $im;

		return true;

	}

	function SetOutputFile($which_output_file) { 
		$this->output_file = $which_output_file;
		return true;
	}

	function SetImageArea($which_iw,$which_ih) {
		//Note this is now an Internal function - please set w/h via PHPlot()
		$this->image_width = $which_iw;
		$this->image_height = $which_ih;

		return true;
	}


	function SetYAxisPosition($which_pos) {
		$this->y_axis_position = $which_pos;
		return true;
	}
	function SetXAxisPosition($which_pos) {
		$this->x_axis_position = $which_pos;
		return true;
	}
	function SetXTimeFormat($which_xtf) {
		$this->x_time_format = $which_xtf;
		return true;
	}
	function SetXDataLabelMaxlength($which_xdlm) { 
		if ($which_xdlm >0 ) { 
			$this->x_datalabel_maxlength = $which_xdlm;
			return true;
		} else { 
			return false;
		}
	}
	function SetXDataLabelAngle($which_xdla) { 
		$this->x_datalabel_angle = $which_xdla;
		return true;
	}
	function SetXScaleType($which_xst) { 
		$this->xscale_type = $which_xst;
		return true;
	}
	function SetYScaleType($which_yst) { 
		$this->yscale_type = $which_yst;
		if ($this->x_axis_position <= 0) { 
			$this->x_axis_position = 1;
		}
		return true;
	}

	function SetPrecisionX($which_prec) {
		$this->x_precision = $which_prec;
		return true;
	}
	function SetPrecisionY($which_prec) {
		$this->y_precision = $which_prec;
		return true;
	}


	function SetIndexColors() { //Internal Method called to set colors and preserve state
		//These are the colors of the image that are used. They are initialized
		//to work with sessions and PHP. 

		$this->ndx_i_light = $this->SetIndexColor($this->i_light);
		$this->ndx_i_dark  = $this->SetIndexColor($this->i_dark);
		$this->ndx_bg_color= $this->SetIndexColor($this->bg_color);
		$this->ndx_plot_bg_color= $this->SetIndexColor($this->plot_bg_color);

		$this->ndx_title_color= $this->SetIndexColor($this->title_color);
		$this->ndx_tick_color= $this->SetIndexColor($this->tick_color);
		$this->ndx_label_color= $this->SetIndexColor($this->label_color);
		$this->ndx_text_color= $this->SetIndexColor($this->text_color);
		$this->ndx_light_grid_color= $this->SetIndexColor($this->light_grid_color);
		$this->ndx_grid_color= $this->SetIndexColor($this->grid_color);

		reset($this->error_bar_color);  
		unset($ndx_error_bar_color);
		$i = 0; 
		while (list(, $col) = each($this->error_bar_color)) {
		  $this->ndx_error_bar_color[$i] = $this->SetIndexColor($col);
			$i++;
		}
		//reset($this->data_border_color);
		unset($ndx_data_border_color);
		$i = 0;
		while (list(, $col) = each($this->data_border_color)) {
			$this->ndx_data_border_color[$i] = $this->SetIndexColor($col);
			$i++;
		}
		//reset($this->data_color); 
		unset($ndx_data_color);
		$i = 0;
		while (list(, $col) = each($this->data_color)) {
			$this->ndx_data_color[$i] = $this->SetIndexColor($col);
			$i++;
		}

		return true;
	}


	function SetDefaultColors() {

		$this->i_light = array(194,194,194);
		$this->i_dark =  array(100,100,100);
		$this->SetPlotBgColor(array(222,222,222));
		$this->SetBackgroundColor(array(200,222,222)); //can use rgb values or "name" values
		$this->SetLabelColor('black');
		$this->SetTextColor('black');
		$this->SetGridColor('black');
		$this->SetLightGridColor(array(175,175,175));
		$this->SetTickColor('black');
		$this->SetTitleColor(array(0,0,0)); // Can be array or name
		$this->data_color = array('blue','green','yellow','red','orange');
		$this->error_bar_color = array('blue','green','yellow','red','orange');
		$this->data_border_color = array('black');

		$this->session_set = 1; //Mark it down for PHP session() usage.
	}

	function PrintImage() {

		if ( ($this->browser_cache == 0) && ($this->is_inline == 0)) { //Submitted by Thiemo Nagel
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
			header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . 'GMT');
			header('Cache-Control: no-cache, must-revalidate');
			header('Pragma: no-cache');
		}

		switch($this->file_format) {
			case "png":
				if ($this->is_inline == 0) {
					Header('Content-type: image/png');
				}
				if ($this->is_inline == 1 && $this->output_file != "") {
					ImagePng($this->img,$this->output_file);
				} else {
					ImagePng($this->img);
				}
				break;
			case "jpg":
				if ($this->is_inline == 0) {
					Header('Content-type: image/jpeg');
				}
				if ($this->is_inline == 1 && $this->output_file != "") {
					ImageJPEG($this->img,$this->output_file);
				} else {
					ImageJPEG($this->img);
				}
				break;
			case "gif":
				if ($this->is_inline == 0) {
					Header('Content-type: image/gif');
				}
				if ($this->is_inline == 1 && $this->output_file != "") {
					ImageGIF($this->img,$this->output_file);
				} else {
					ImageGIF($this->img);
				}

				break;
			case "wbmp":
				if ($this->is_inline == 0) {
					Header('Content-type: image/wbmp');
				}
				if ($this->is_inline == 1 && $this->output_file != "") {
					ImageWBMP($this->img,$this->output_file);
				} else {
					ImageWBMP($this->img);
				}

				break;
			default:
				$this->PrintError('Please select an image type!<br />');
				break;
		}
		ImageDestroy($this->img);
		return true;
	}


	function DrawBackground() {
		//if ($this->img == "") { $this->InitImage(); };
		if ($this->background_done == 0) { //Don't draw it twice if drawing two plots on one image
			ImageFilledRectangle($this->img, 0, 0,
				$this->image_width, $this->image_height, $this->ndx_bg_color);
			$this->background_done = 1;
		}
		return true;
	}

	function DrawImageBorder() {
		switch ($this->image_border_type) {
			case "raised":
				ImageLine($this->img,0,0,$this->image_width-1,0,$this->ndx_i_light);
				ImageLine($this->img,1,1,$this->image_width-2,1,$this->ndx_i_light);
				ImageLine($this->img,0,0,0,$this->image_height-1,$this->ndx_i_light);
				ImageLine($this->img,1,1,1,$this->image_height-2,$this->ndx_i_light);
				ImageLine($this->img,$this->image_width-1,0,$this->image_width-1,$this->image_height-1,$this->ndx_i_dark);
				ImageLine($this->img,0,$this->image_height-1,$this->image_width-1,$this->image_height-1,$this->ndx_i_dark);
				ImageLine($this->img,$this->image_width-2,1,$this->image_width-2,$this->image_height-2,$this->ndx_i_dark);
				ImageLine($this->img,1,$this->image_height-2,$this->image_width-2,$this->image_height-2,$this->ndx_i_dark);
			break;
			case "plain":
				ImageLine($this->img,0,0,$this->image_width,0,$this->ndx_i_dark);
				ImageLine($this->img,$this->image_width-1,0,$this->image_width-1,$this->image_height,$this->ndx_i_dark);
				ImageLine($this->img,$this->image_width-1,$this->image_height-1,0,$this->image_height-1,$this->ndx_i_dark);
				ImageLine($this->img,0,0,0,$this->image_height,$this->ndx_i_dark);
			break;
			default:
			break;
		}
		return true;
	}

	function SetPlotBorderType($which_pbt) {
		$this->plot_border_type = $which_pbt; //left, none, anything else=full
	}

	function SetImageBorderType($which_sibt) {
		$this->image_border_type = $which_sibt; //raised, plain
	}

	function SetDrawPlotAreaBackground($which_dpab) {
		$this->draw_plot_area_background = $which_dpab;  // 1=true or anything else=false
	}

	function SetDrawDataLabels($which_ddl) {  //Draw next to datapoints
		$this->draw_data_labels = $which_ddl;  // 1=true or anything else=false
	}

	function SetDrawXDataLabels($which_dxdl) {  //Draw on X Axis
		$this->draw_x_data_labels = $which_dxdl;  // 1=true or anything else=false
	}

	function SetDrawYGrid($which_dyg) {
		$this->draw_y_grid = $which_dyg;  // 1=true or anything else=false
	}

	function SetDrawXGrid($which_dxg) {
		$this->draw_x_grid = $which_dxg;  // 1=true or anything else=false
	}

	function SetYGridLabelType($which_yglt) {
		$this->y_grid_label_type = $which_yglt;
		return true;
	}

	function SetXGridLabelType($which_xglt) {
		$this->x_grid_label_type = $which_xglt;
		return true;
	}

	function SetXLabel($xlbl) {
		$this->x_label_txt = $xlbl;
		return true;
	}
	function SetYLabel($ylbl) {
		$this->y_label_txt = $ylbl;
		return true;
	}
	function SetTitle($title) {
		$this->title_txt = $title;
		return true;
	}

	//function SetLabels($xlbl,$ylbl,$title) {
	//	$this->title_txt = $title;
	//	$this->x_label_txt = $xlbl;
	//	$this->y_label_txt = $ylbl;
	//}

	function DrawLabels() {
		$this->DrawTitle();
		$this->DrawXLabel();
		$this->DrawYLabel();
		return true;
	}

	function DrawXLabel() {
		if ($this->use_ttf == 1) { 
			$xpos = $this->xtr(($this->plot_max_x + $this->plot_min_x)/2.0) ;
			$ypos = $this->ytr($this->plot_min_y) + $this->x_label_height/2.0;
			$this->DrawText($this->x_label_ttffont, $this->x_label_angle,
				$xpos, $ypos, $this->ndx_label_color, $this->x_label_ttffont_size, $this->x_label_txt,'center');
		} else { 
			//$xpos = 0.0 - (ImageFontWidth($this->small_font)*strlen($this->x_label_txt)/2.0) + $this->xtr(($this->plot_max_x+$this->plot_min_x)/2.0) ;
			$xpos = 0.0 + $this->xtr(($this->plot_max_x+$this->plot_min_x)/2.0) ;
			$ypos = ($this->ytr($this->plot_min_y) + $this->x_label_height/2);

			$this->DrawText($this->small_font, $this->x_label_angle, 
				$xpos, $ypos, $this->ndx_label_color, "", $this->x_label_txt, 'center');

		}
		return true;
	}

	function DrawYLabel() {
		if ($this->use_ttf == 1) { 
			$size = $this->TTFBBoxSize($this->y_label_ttffont_size, 90, $this->y_label_ttffont, $this->y_label_txt);
			$xpos = 8 + $size[0];
			$ypos = ($size[1])/2 + $this->ytr(($this->plot_max_y + $this->plot_min_y)/2.0) ;
			$this->DrawText($this->y_label_ttffont, 90,
				$xpos, $ypos, $this->ndx_label_color, $this->y_label_ttffont_size, $this->y_label_txt);
		} else { 
			$xpos = 8;
			$ypos = (($this->small_font_width*strlen($this->y_label_txt)/2.0) +
					$this->ytr(($this->plot_max_y + $this->plot_min_y)/2.0) );
			$this->DrawText($this->small_font, 90,
				$xpos, $ypos, $this->ndx_label_color, $this->y_label_ttffont_size, $this->y_label_txt);
		}
		return true;
	}

	function DrawText($which_font,$which_angle,$which_xpos,$which_ypos,$which_color,$which_size,$which_text,$which_halign='left',$which_valign='') {

		if ($this->use_ttf == 1 ) { 
			$size = $this->TTFBBoxSize($which_size, $which_angle, $which_font, $which_text); 
			if ($which_valign == 'bottom') { 
				$which_ypos = $which_ypos + ImageFontHeight($which_font);
			}
			if ($which_halign == 'center') { 
				$which_xpos = $which_xpos - $size[0]/2;
			}
			ImageTTFText($this->img, $which_size, $which_angle, 
				$which_xpos, $which_ypos, $which_color, $which_font, $which_text); 
		} else { 
			if ($which_valign == 'top') { 
				$which_ypos = $which_ypos - ImageFontHeight((int)$which_font);
			}
			$which_text = preg_replace("/\r/","",$which_text);
			$str = explode("\n",$which_text); //multiple lines submitted by Remi Ricard
			$height = ImageFontHeight((int)$which_font);
			$width = ImageFontWidth((int)$which_font);
			if ($which_angle == 90) {  //Vertical Code Submitted by Marlin Viss
				for($i=0;$i<count($str);$i++) { 
					ImageStringUp($this->img, $which_font, ($i*$height + $which_xpos), $which_ypos, $str[$i], $which_color);
				} 
			} else {
				for($i=0;$i<count($str);$i++) { 
					if ($which_halign == 'center') { 
                    	$xpos = $which_xpos - strlen($str[$i]) * $width/2;
 						ImageString($this->img, (int)$which_font, $xpos, ($i*$height + $which_ypos), $str[$i], $which_color);
					} else { 
						ImageString($this->img, (int)$which_font, $which_xpos, ($i*$height + $which_ypos), $str[$i], $which_color);
					}
				} 
			}

		} 
		return true; 

	}
	function DrawTitle() {
		if ($this->use_ttf == 1 ) { 
			$xpos = ($this->plot_area[0] + $this->plot_area_width / 2);
			$ypos = $this->y_top_margin/2;
			$this->DrawText($this->title_ttffont, $this->title_angle, 
				$xpos, $ypos, $this->ndx_title_color, $this->title_ttffont_size, $this->title_txt,'center'); 
		} else { 
			$xpos = ($this->plot_area[0] + $this->plot_area_width / 2);
			$ypos = ImageFontHeight($this->title_font); 
			$this->DrawText($this->title_font, $this->title_angle, 
				$xpos, $ypos, $this->ndx_title_color, '', $this->title_txt,'center'); 
		} 
		return true; 

	}

	function DrawPlotAreaBackground() {
		ImageFilledRectangle($this->img,$this->plot_area[0],
			$this->plot_area[1],$this->plot_area[2],$this->plot_area[3],
			$this->ndx_plot_bg_color);
	}

	function SetBackgroundColor($which_color) {
		$this->bg_color= $which_color;
		$this->ndx_bg_color= $this->SetIndexColor($which_color);
		return true;
	}
	function SetPlotBgColor($which_color) {
		$this->plot_bg_color= $which_color;
		$this->ndx_plot_bg_color= $this->SetIndexColor($which_color);
		return true;
	}

	function SetShading($which_s) { 
		$this->shading = $which_s;
		return true;
	}

	function SetTitleColor($which_color) {
		$this->title_color= $which_color;
		$this->ndx_title_color= $this->SetIndexColor($which_color);
		return true;
	}

	function SetTickColor ($which_color) {
		$this->tick_color= $which_color;
		$this->ndx_tick_color= $this->SetIndexColor($which_color);
		return true;
	}

	function SetLabelColor ($which_color) {
		$this->label_color= $which_color;
		$this->ndx_label_color= $this->SetIndexColor($which_color);
		return true;
	}

	function SetTextColor ($which_color) {
		$this->text_color= $which_color;
		$this->ndx_text_color= $this->SetIndexColor($which_color);
		return true;
	}

	function SetLightGridColor ($which_color) {
		$this->light_grid_color= $which_color;
		$this->ndx_light_grid_color= $this->SetIndexColor($which_color);
		return true;
	}

	function SetGridColor ($which_color) {
		$this->grid_color = $which_color;
		$this->ndx_grid_color= $this->SetIndexColor($which_color);
		return true;
	}

	function SetCharacterHeight() {
		//to be set
		return true;
	}

	function SetPlotType($which_pt) {
		$accepted = "bars,lines,linepoints,area,points,pie,thinbarline";
		$asked = trim($which_pt);
		if (preg_match('/' . $asked .'/i', $accepted)) {
			$this->plot_type = $which_pt;
			return true;
		} else {
			$this->DrawError('$which_pt not an acceptable plot type');
			return false;
		}
	}

	function FindDataLimits() {
		//Text-Data is different than data-data graphs. For them what
		// we have, instead of X values, is # of records equally spaced on data.
		//text-data is passed in as $data[] = (title,y1,y2,y3,y4,...)
		//data-data is passed in as $data[] = (title,x,y1,y2,y3,y4,...) 

		$this->number_x_points = count($this->data_values);

		switch ($this->data_type) {
			case "text-data":
				$minx = 0; //valid for BAR TYPE GRAPHS ONLY
				$maxx = $this->number_x_points - 1 ;  //valid for BAR TYPE GRAPHS ONLY
				$miny = (double) $this->data_values[0][1];
				$maxy = $miny;
				if ($this->draw_x_data_labels == "") { 
					$this->draw_x_data_labels = 1;  //labels_note1: prevent both data labels and x-axis labels being both drawn and overlapping
				}
			break;
			default:  //Everything else: data-data, etc.
				$maxx = $this->data_values[0][1];
				$minx = $maxx;
				$miny = $this->data_values[0][2];
				$maxy = $miny;
				$maxy = $miny;
			break;
		}

		$max_records_per_group = 0;
		$total_records = 0;
		$mine = 0; //Maximum value for the -error bar (assume error bars always > 0) 
		$maxe = 0; //Maximum value for the +error bar (assume error bars always > 0) 

		reset($this->data_values);
		while (list($dat_key, $dat) = each($this->data_values)) {  //for each X barchart setting
		//foreach($this->data_values as $dat)  //can use foreach only in php4

			$tmp = 0;
			$total_records += count($dat) - 1; // -1 for label

			switch ($this->data_type) {
				case "text-data":
					//Find the relative Max and Min

					while (list($key, $val) = each($dat)) {
						if ($key != 0) {  //$dat[0] = label
							SetType($val,"double");
							if ($val > $maxy) {
								$maxy = $val ;
							}
							if ($val < $miny) {
								$miny = (double) $val ;
							}
						}
						$tmp++;
					}
				break;
				case "data-data":  //X-Y data is passed in as $data[] = (title,x,y,y2,y3,...) which you can use for multi-dimentional plots.

					while (list($key, $val) = each($dat)) {
						if ($key == 1) {  //$dat[0] = label
							SetType($val,"double");
							if ($val > $maxx) {
								$maxx = $val;
							} elseif ($val < $minx) {
								$minx = $val;
							}
						} elseif ($key > 1) {
							SetType($val,"double");
							if ($val > $maxy) {
								$maxy = $val ;
							} elseif ($val < $miny) {
								$miny = $val ;
							}
						}
						$tmp++;
					}
					$tmp = $tmp - 1; //# records per group
				break;
				case "data-data-error":  //Assume 2-D for now, can go higher
				//Regular X-Y data is passed in as $data[] = (title,x,y,error+,error-,y2,error2+,error2-)

					while (list($key, $val) = each($dat)) {
						if ($key == 1) {  //$dat[0] = label
							SetType($val,'double');
							if ($val > $maxx) {
								$maxx = $val;
							} elseif ($val < $minx) {
								$minx = $val;
							}
						} elseif ($key%3 == 2) {
							SetType($val,'double');
							if ($val > $maxy) {
								$maxy = $val ;
							} elseif ($val < $miny) {
								$miny = $val ;
							}
						} elseif ($key%3 == 0) {
							SetType($val,'double');
							if ($val > $maxe) {
								$maxe = $val ;
							}
						} elseif ($key%3 == 1) {
							SetType($val,'double');
							if ($val > $mine) {
								$mine = $val ;
							}
						}
						$tmp++;
					}
					$maxy = $maxy + $maxe;
					$miny = $miny - $mine; //assume error bars are always > 0

				break;
				default:
					$this->PrintError('ERROR: unknown chart type');
				break;
			}
			if ($tmp > $max_records_per_group) {
				$max_records_per_group = $tmp;
			}
		}


		$this->min_x = $minx;
		$this->max_x = $maxx;
		$this->min_y = $miny;
		$this->max_y = $maxy;


		if ($max_records_per_group > 1) {
			$this->records_per_group = $max_records_per_group - 1;
		} else {
			$this->records_per_group = 1;
		}


		//$this->data_count = $total_records ;
	} // function FindDataLimits

	function SetMargins() {
		/////////////////////////////////////////////////////////////////
		// When the image is first created - set the margins
		// to be the standard viewport.
		// The standard viewport is the full area of the view surface (or panel),
		// less a margin of 4 character heights all round for labelling.
		// It thus depends on the current character size, set by SetCharacterHeight().
		/////////////////////////////////////////////////////////////////

		$str = explode("\n",$this->title_txt);
		$nbLines = count($str); 

		if ($this->use_ttf == 1) {
			$title_size = $this->TTFBBoxSize($this->title_ttffont_size, $this->title_angle, $this->title_ttffont, 'X'); //An array
			if ($nbLines == 1) { 
				$this->y_top_margin = $title_size[1] * 4;
			} else { 
				$this->y_top_margin = $title_size[1] * ($nbLines+3);
			}

			//ajo working here
			//$x_label_size = $this->TTFBBoxSize($this->x_label_ttffont_size, 0, $this->axis_ttffont, $this->x_label_txt);

			$this->y_bot_margin = $this->x_label_height ;
			$this->x_left_margin = $this->y_label_width * 2 + $this->tick_length;
			$this->x_right_margin = 33.0; // distance between right and end of x axis in pixels 
		} else {
			$title_size = array(ImageFontWidth($this->title_font) * strlen($this->title_txt),ImageFontHeight($this->title_font));
			//$this->y_top_margin = ($title_size[1] * 4);
			if ($nbLines == 1) { 
				$this->y_top_margin = $title_size[1] * 4;
			} else { 
				$this->y_top_margin = $title_size[1] * ($nbLines+3);
			}
			if ($this->x_datalabel_angle == 90) {
				$this->y_bot_margin = 76.0; // Must be integer
			} else {
				$this->y_bot_margin = 66.0; // Must be integer
			}
			$this->x_left_margin = 77.0; // distance between left and start of x axis in pixels
			$this->x_right_margin = 33.0; // distance between right and end of x axis in pixels
		}

//exit;
		$this->x_tot_margin = $this->x_left_margin + $this->x_right_margin;
		$this->y_tot_margin = $this->y_top_margin + $this->y_bot_margin;

		if ($this->plot_max_x && $this->plot_max_y && $this->plot_area_width ) { //If data has already been analysed then set translation
			$this->SetTranslation();
		}
	}

	function SetMarginsPixels($which_lm,$which_rm,$which_tm,$which_bm) { 
		//Set the plot area using margins in pixels (left, right, top, bottom)
		$this->SetNewPlotAreaPixels($which_lm,$which_tm,($this->image_width - $which_rm),($this->image_height - $which_bm));
		return true;
	}

	function SetNewPlotAreaPixels($x1,$y1,$x2,$y2) {
		//Like in GD 0,0 is upper left set via pixel Coordinates
		$this->plot_area = array($x1,$y1,$x2,$y2);
		$this->plot_area_width = $this->plot_area[2] - $this->plot_area[0];
		$this->plot_area_height = $this->plot_area[3] - $this->plot_area[1];
		$this->y_top_margin = $this->plot_area[1];
		if ($this->plot_max_x) {
			$this->SetTranslation();
		}
		return true;
	}

	function SetPlotAreaPixels($x1,$y1,$x2,$y2) {
		//Like in GD 0,0 is upper left
		if (!$this->x_tot_margin) {
			$this->SetMargins();
		}
		if ($x2 && $y2) {
			$this->plot_area = array($x1,$y1,$x2,$y2);
		} else {
			$this->plot_area = array($this->x_left_margin, $this->y_top_margin,
								$this->image_width - $this->x_right_margin,
								$this->image_height - $this->y_bot_margin
							);
		}
		$this->plot_area_width = $this->plot_area[2] - $this->plot_area[0];
		$this->plot_area_height = $this->plot_area[3] - $this->plot_area[1];

		return true;

	}

	function SetPlotAreaWorld($xmin,$ymin,$xmax,$ymax) {
		if (($xmin == "")  && ($xmax == "")) {
			//For automatic setting of data we need $this->