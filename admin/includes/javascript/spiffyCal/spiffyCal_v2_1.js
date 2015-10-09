/*
 * Bazillyo's Spiffy DHTML Popup Calendar Control - version 2.1
 * ©2001 S. Ousta 
 * see the included readme.htm file for license information and release notes.
 * 
 * For more information see:
 * http://www.geocities.com/bazillyo/spiffy/calendar/index.htm or
 * http://groups.yahoo.com/group/spiffyDHTML or
 * email me: bazillyo@yahoo.com
 *
 */

// GLOBAL variables
var scImgPath = './includes/javascript/spiffyCal/images/';

var scIE=((navigator.appName == "Microsoft Internet Explorer") || ((navigator.appName == "Netscape") && (parseInt(navigator.appVersion)==5)));
var scNN6=((navigator.appName == "Netscape") && (parseInt(navigator.appVersion)==5));
var scNN=((navigator.appName == "Netscape")&&(document.layers));

var img_Del=new Image();
var img_Close=new Image();

img_Del.src= scImgPath +"btn_del_small.gif";
img_Close.src= scImgPath +"btn_close_small.gif";

var scBTNMODE_DEFAULT=0;
var scBTNMODE_CUSTOMBLUE=1;
var scBTNMODE_CALBTN=2;

var focusHack;

/*================================================================================
 * Calendar Manager Object
 *
 * 	the functions:
 * 		isDate(), formatDate(), _isInteger(), _getInt(), and getDateFromFormat()
 * 	are based on ones courtesy of Matt Kruse (mkruse@netexpress.net) http://www.mattkruse.com/javascript/
 * 	with some modifications by myself and Michael Brydon
 *
 */

function spiffyCalManager() {

	this.showHelpAlerts = false;
	this.defaultDateFormat='dd-MMM-yyyy';
	this.lastSelectedDate=new Date();
	this.calendars=new Array();
	this.matchedFormat="";
	this.DefBtnImgPath=scImgPath; //'./js/common/calendar/';

	// methods	 ----------------------------------------------------------------------
	this.getCount= new Function("return this.calendars.length;");

	function addCalendar(objWhatCal) {
		var intIndex = this.calendars.length;
		this.calendars[intIndex] = objWhatCal;
	}
	this.addCalendar=addCalendar;


	function hideAllCalendars(objExceptThisOne) {
		var i=0;
		for (i=0;i<this.calendars.length;i++) {
			if (objExceptThisOne!=this.calendars[i]) {
				this.calendars[i].hide();
			}
		}

	}
	this.hideAllCalendars=hideAllCalendars;

	function swapImg(objWhatCal, strToWhat, blnStick) {
		if (document.images) {
			// this makes it so that the button sticks down when the cal is visible
			if ((!(objWhatCal.visible) || (blnStick))&& (objWhatCal.enabled)) {
				document.images[objWhatCal.btnName].src = eval(objWhatCal.varName+strToWhat + ".src");
			}
		}
		window.status=' ';
	//	return true;
	}
	this.swapImg=swapImg;

	// *** HOLIDAYS ***************************
	
	this.Holidays = new Array("Dec-25","Jul-4", "Feb-14","Mar-17","Oct-31");
	this.HolidaysDesc = new Array("Christmas Day","Independance Day","Valentine's Day","St. Patrick's Day","Halloween");

	//*****************************************
	
	function isHoliday(whatDate) {
		var i=0;var found=-1;
		for (i=0;i<this.Holidays.length;i++) {
			if (whatDate==this.Holidays[i]) {
				found=i;
				break;
			}
		}
		return found;
	}
	this.isHoliday=isHoliday;


	this.AllowedFormats = new Array(
// Days first list
'd.M',
'd-M',
'd/M',

'd.MMM',
'd-MMM',
'd/MMM',

'd.M.yy',
'd-M-yy',
'd/M/yy',

'd.M.yyyy',
'd-M-yyyy',
'd/M/yyyy',

'd.MM.yyyy',
'd-MM-yyyy',
'd/MM/yyyy',

'd.MMM.yy',
'd-MMM-yy',
'd/MMM/yy',

'd.MMM.yyyy',
'd-MMM-yyyy',
'd/MMM/yyyy',

'd.MM.yy',
'd-MM-yy',
'd/MM/yy',

'dd.MM.yy',
'dd-MM-yy',
'dd/MM/yy',

'dd.M.yy',
'dd-M-yy',
'dd/M/yy',

'dd.MM.yyyy',
'dd-MM-yyyy',
'dd/MM/yyyy',

'dd.MMM.yy',
'dd-MMM-yy',
'dd/MMM/yy',

'dd.MMM.yyyy',
'dd-MMM-yyyy',
'dd/MMM/yyyy',

'M.d',
'M-d',
'M/d',

// Months first list

'MMM.d',
'MMM-d',
'MMM/d',

'M.d.yy',
'M-d-yy',
'M/d/yy',

'MM.d.yyyy',
'MM-d-yyyy',
'MM/d/yyyy',

'MMM.d.yy',
'MMM-d-yy',
'MMM/d/yy',

'MMM.d.yyyy',
'MMM-d-yyyy',
'MMM/d/yyyy',

'MM.d.yy',
'MM-d-yy',
'MM/d/yy',

'MM.dd.yy',
'MM-dd-yy',
'MM/dd/yy',

'M.dd.yy',
'M-dd-yy',
'M/dd/yy',

'MM.dd.yyyy',
'MM-dd-yyyy',
'MM/dd/yyyy',

'MMM.dd.yy',
'MMM-dd-yy',
'MMM/dd/yy',

'MMM.dd.yyyy',
'MMM-dd-yyyy',
'MMM/dd/yyyy'

);
	var MONTH_NAMES = new Array('January','February','March','April','May','June','July','August','September','October','November','December','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');

	this.lastBoxValidated=null;


	function validateDate(eInput, bRequired, dStartDate, dEndDate){
		var i = 0; var strTemp=''; var formatMatchCount=0; var firstMatchAt=0;var secondMatchAt=0;
		var bOK = false; var bIsEmpty=false;
		var strStart=MONTH_NAMES[dStartDate.getMonth()]+'-'+dStartDate.getDate()+'-'+dStartDate.getFullYear();
		var strEnd=MONTH_NAMES[dEndDate.getMonth()]+'-'+dEndDate.getDate()+'-'+dEndDate.getFullYear();
		var rangeMsg = 'This input box is set up to accept dates between:\n\n   '+
					strStart+'\n\nand\n\n   '+strEnd+'\n\nPlease enter a date no ';

		this.lastBoxValidated=eInput;
		this.matchedFormat="";
		bIsEmpty=(eInput.value=='' || eInput.value==null);
		if (!(bRequired && bIsEmpty)) {
			for(i=0;i<this.AllowedFormats.length;i++){
//alert('checking=eInput.value='+eInput.value+'  this.AllowedFormats[i]='+this.AllowedFormats[i]+'\nisDate='+isDate(eInput.value, this.AllowedFormats[i]));
				if (isDate(eInput.value, this.AllowedFormats[i])==true){
					bOK = true;
					formatMatchCount+=1;
					if (formatMatchCount==1) {firstMatchAt=i;}
					if (formatMatchCount>1) {

						if (this.AllowedFormats[i].substr(0,1)!=this.AllowedFormats[firstMatchAt].substr(0,1)) {
							secondMatchAt=i; break;
						}
						else { // don't count same format with padded zeros as a different format
							formatMatchCount=1;
						}
					}
				}
			}
		}
alert('formatMatchCount='+formatMatchCount);
		if (formatMatchCount>1) {

			if (this.showHelpAlerts) {

				var date1=getDateFromFormat(eInput.value,this.AllowedFormats[firstMatchAt]);
				var choice1 = MONTH_NAMES[date1.getMonth()]+'-'+date1.getDate()+'-'+date1.getFullYear();
				var date2=getDateFromFormat(eInput.value,this.AllowedFormats[secondMatchAt]);
				var choice2 = MONTH_NAMES[date2.getMonth()]+'-'+date2.getDate()+'-'+date2.getFullYear();
				if (date1.getTime()!=date2.getTime()) {
					var Msg='You have entered an ambiguous date.\n\n Click OK for:\n'+ choice1 +'\n\nor Click Cancel for:\n'+choice2;
					if (confirm(Msg)) {
						bOK=true;
					}
					else {
						firstMatchAt=secondMatchAt;
						bOK=true;
						//return false;
					}
					eInput.focus();
					eInput.select();
				}
			}
			else {
				// continue and take first match in list
				bOK=true;
			}
		}
alert('TEST    '+dThis.getDate()+"-"+dThis.getMonth());

		if (bOK==true) {
			eInput.className = "cal-TextBox";
			//Check for Start/End Dates

			if (dStartDate!=null) {
				var dThis = getDateFromFormat(eInput.value,this.AllowedFormats[i]);
				if (dStartDate>dThis){
					eInput.className = "cal-TextBoxInvalid";
					if (this.showHelpAlerts) { alert(rangeMsg + 'earlier than  '+ strStart + '.');}
					eInput.focus();
					eInput.select();
					return false;
				}
			}
			if (dEndDate!=null) {
				var dThis = getDateFromFormat(eInput.value,this.AllowedFormats[i]);
				if (dEndDate<dThis) {
					eInput.className = "cal-TextBoxInvalid";
					if (this.showHelpAlerts) {  alert(rangeMsg +'later than  '+ strEnd + '.');}
					eInput.focus();
					eInput.select();
					return false;
				}
			}
			this.matchedFormat=this.AllowedFormats[firstMatchAt];

			this.lastBoxValidated = null;
		}
		else {

			if (bRequired && bIsEmpty) {
				eInput.className = "cal-TextBoxInvalid";
				if (this.showHelpAlerts) {
					alert('This date field is required.\n\nPlease enter a valid date before proceeding.');
				}
			}
			else {
				if (!bRequired && bIsEmpty) {
					eInput.className = "cal-TextBox";
				}
				else {
					eInput.className = "cal-TextBoxInvalid";
					if (this.showHelpAlerts) {
						for(i=0;i<this.AllowedFormats.length;i++){
							strTemp+=this.AllowedFormats[i]+'\t';
						}
						alert('Please enter a valid date.\n\nExample 01-Jan-2002\n\nValid formats are:\n\n'+strTemp);
					}
				}
			}
			eInput.focus();
			eInput.select();
			focusHack=eInput;

			setTimeout('focusHack.focus();focusHack.select();');
			return false;
		}
	}
	this.validateDate=validateDate;


	function formatDate(eInput, strFormat) {
		//Always called directly following validateDate  - put validate in onchange and format in onblur.
		if(this.matchedFormat!="") {
			var d = getDateFromFormat(eInput.value,this.matchedFormat);
			if(d!=0){
				eInput.value = scFormatDate(d, strFormat);
			}
		}
	}
	this.formatDate=formatDate;

	function isDate(val,format) {
		var date = getDateFromFormat(val,format);
		if (date == 0) { return false; }
		return true;
	}
	this.isDate=isDate;


	function scFormatDate(date,format) {
		format = format+"";
		var result = "";
		var i_format = 0;
		var c = "";
		var token = "";
		var y = date.getFullYear()+"";
		var M = date.getMonth()+1;
		var d = date.getDate();
		var h = date.getHours();
		var m = date.getMinutes();
		var s = date.getSeconds();
		var yyyy,yy,MMM,MM,dd;
		// Convert real date parts into formatted versions
		// Year
		if (y.length < 4) {
			y = y-0+1900;
			}
		y = ""+y;
		yyyy = y;
		yy = y.substring(2,4);
		// Month
		if (M < 10) { MM = "0"+M; }
			else { MM = M; }
		MMM = MONTH_NAMES[M-1+12];
		// Date
		if (d < 10) { dd = "0"+d; }
			else { dd = d; }
		// Now put them all into an object!
		var value = new Object();
		value["yyyy"] = yyyy;
		value["yy"] = yy;
		value["y"] = y;
		value["MMM"] = MMM;
		value["MM"] = MM;
		value["M"] = M;
		value["dd"] = dd;
		value["d"] = d;

		while (i_format < format.length) {
			// Get next token from format string
			c = format.charAt(i_format);
			token = "";
			while ((format.charAt(i_format) == c) && (i_format < format.length)) {
				token += format.charAt(i_format);
				i_format++;
				}
			if (value[token] != null) {
				result = result + value[token];
				}
			else {
				result = result + token;
				}
			}
		return result;
	}
	this.scFormatDate=scFormatDate;

	function _isInteger(val) {
		var digits = "1234567890";
		for (var i=0; i < val.length; i++) {
			if (digits.indexOf(val.charAt(i)) == -1) { return false; }
			}
		return true;
	}

	function _getInt(str,i,minlength,maxlength) {
		for (x=maxlength; x>=minlength; x--) {
			var token = str.substring(i,i+x);
			if (_isInteger(token)) {
				return token;
				}
			}
		return null;
	}

	function getDateFromFormat(val,format) {
		val = val+"";
		format = format+"";
		var i_val = 0;
		var i_format = 0;
		var c = "";
		var token = "";
		var token2= "";
		var x,y;
		var year  = 0;
		var month = 0;
		var date  = 0;
		var bYearProvided = false;
		while (i_format < format.length) {
			// Get next token from format string
			c = format.charAt(i_format);
			token = "";

			while ((format.charAt(i_format) == c) && (i_format < format.length)) {
				token += format.charAt(i_format);
				i_format++;
			}

			// Extract contents of value based on format token
			if (token=="yyyy" || token=="yy" || token=="y") {
				if (token=="yyyy") { x=4;y=4; }// 4-digit year
				if (token=="yy")   { x=2;y=2; }// 2-digit year
				if (token=="y")    { x=2;y=4; }// 2-or-4-digit year
				year = _getInt(val,i_val,x,y);
				bYearProvided = true;
				if (year == null) {
					return 0;
					//Default to current year
				}
				if (year.length != token.length){
					return 0;
				}

				i_val += year.length;
			}
			else if (token=="MMM") { // Month name
				month = 0;
				for (var i=0; i<MONTH_NAMES.length; i++) {
					var month_name = MONTH_NAMES[i];
					if (val.substring(i_val,i_val+month_name.length).toLowerCase() == month_name.toLowerCase()) {
						month = i+1;
						if (month>12) { month -= 12; }
						i_val += month_name.length;
						break;
					}
				}

				if (month == 0) { return 0; }
				if ((month < 1) || (month>12)) {
					return 0
				}
			}
			else if (token=="MM" || token=="M") {
				x=token.length; y=2;
				month = _getInt(val,i_val,x,y);
				if (month == null) { return 0; }
				if ((month < 1) || (month > 12)) { return 0; }
				i_val += month.length;
			}
			else if (token=="dd" || token=="d") {
				x=token.length; y=2;
				date = _getInt(val,i_val,x,y);
				if (date == null) { return 0; }
				if ((date < 1) || (date>31)) { return 0; }
				i_val += date.length;
			}
			else {
				if (val.substring(i_val,i_val+token.length) != token) {
					return 0;
				}
				else {
					i_val += token.length;
				}
			}
		}
		// If there are any trailing characters left in the value, it doesn't match
		if (i_val != val.length) {
			return 0;
		}
		// Is date valid for month?

		if (month == 2) {
			// Check for leap year
			if ( ( (year%4 == 0)&&(year%100 != 0) ) || (year%400 == 0) ) { // leap year
				if (date > 29){ return false; }
			}
			else {
				if (date > 28) { return false; }
			}
		}
		if ((month==4)||(month==6)||(month==9)||(month==11)) {
			if (date > 30) { return false; }
		}

		//JS dates uses 0 based months.
		month = month - 1;

		if (bYearProvided==false) {
			//Default to current
			var dCurrent = new Date();
			year = dCurrent.getFullYear();
		}

		var lYear = parseInt(year);
		if (lYear<=20) {
			year = 2000 + lYear;
		}
		else if (lYear >=21 && lYear<=99) {
			year = 1900 + lYear;
		}

		var newdate = new Date(year,month,date,0,0,0);

		return newdate;
	}
	this.getDateFromFormat=getDateFromFormat;


}



var calMgr = new spiffyCalManager();



//================================================================================
// Calendar Object

function ctlSpiffyCalendarBox(strVarName, strFormName, strTextBoxName, strBtnName, strDefaultValue, intBtnMode) {

	var msNames     = new makeArray0('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
	var msDays      = new makeArray0(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	var msDOW       = new makeArray0('S','M','T','W','T','F','S');


	var blnInConstructor=true;
	var img_DateBtn_UP=new Image();
	var img_DateBtn_OVER=new Image();
	var img_DateBtn_DOWN=new Image();
	var img_DateBtn_DISABLED=new Image();

	var strBtnW;
	var strBtnH;
	var strBtnImg;

	var dteToday=new Date;
	var dteCur=new Date;

	var dteMin=new Date;
	var dteMax=new Date;

	var scX=4; // default where to display calendar
	var scY=4;

	// Defaults
	var strDefDateFmt='dd-MMM-yyyy';

	var intDefBtnMode=0;
	var strDefBtnImgPath=calMgr.DefBtnImgPath;
	/* PROPERTIES =============================================================
	 *
	 */
	// Generic Properties
	this.varName=strVarName;
	this.enabled=true;
	this.readonly=false;
	this.focusClick=false;
	this.hideButton=false;
	this.visible=false;
	this.displayLeft=false;
	this.displayTop=false;
	// Name Properties
	this.formName=strFormName;
	this.textBoxName=strTextBoxName;
	this.btnName=strBtnName;
	this.required=false;
	this.x=scX;
	this.y=scY;

	this.imgUp=img_DateBtn_UP;
	this.imgOver=img_DateBtn_OVER;
	this.imgDown=img_DateBtn_DOWN;
	this.imgDisabled=img_DateBtn_DISABLED;

	// look
	this.showWeekends=true;
	this.showHolidays=true;
	this.disableWeekends=false;
	this.disableHolidays=false;

	this.textBoxWidth=160;
	this.textBoxHeight=20;
	this.btnImgWidth=strBtnW;
	this.btnImgHeight=strBtnH;
	if ((intBtnMode==null)||(intBtnMode<0 && intBtnMode>2)) {
		intBtnMode=intDefBtnMode
	}
	switch (intBtnMode) {
		case 0 :
			strBtnImg=strDefBtnImgPath+'btn_date_up.gif';
			img_DateBtn_UP.src=strDefBtnImgPath+'btn_date_up.gif';
			img_DateBtn_OVER.src=strDefBtnImgPath+'btn_date_over.gif';
			img_DateBtn_DOWN.src=strDefBtnImgPath+'btn_date_down.gif';
			img_DateBtn_DISABLED.src=strDefBtnImgPath+'btn_date_disabled.gif';
			strBtnW = '18';
			strBtnH = '20';
			break;
		case 1 :
			strBtnImg=strDefBtnImgPath+'btn_date1_up.gif';
			img_DateBtn_UP.src=strDefBtnImgPath+'btn_date1_up.gif';
			img_DateBtn_OVER.src=strDefBtnImg