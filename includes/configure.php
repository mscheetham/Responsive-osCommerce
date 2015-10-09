<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://test.oscommerce.com

  Copyright (c) 2014 osCommerce

  Released under the GNU General Public License
*/

// Define the webserver and path parameters
// * DIR_FS_* = Filesystem directories (local/physical)
// * DIR_WS_* = Webserver directories (virtual/URL)
  define('HTTP_SERVER', 'http://test.cadservices.co.uk'); // eg, http://localhost - should not be empty for productive servers
  define('HTTPS_SERVER', 'https://test.cadservices.co.uk');// eg, https://localhost - should not be empty for productive servers
  define('ENABLE_SSL', true); // secure webserver for checkout procedure?
  define('HTTP_COOKIE_DOMAIN', 'test.cadservices.co.uk');
  define('HTTPS_COOKIE_DOMAIN', 'test.cadservices.co.uk');
  define('HTTP_COOKIE_PATH', '/');
  define('HTTPS_COOKIE_PATH', '/');
  define('DIR_WS_HTTP_CATALOG', '/');
  define('DIR_WS_HTTPS_CATALOG', '/');
  if ($request_type == 'NONSSL') {
		define('DIR_ES_MEDIA', HTTP_SERVER . '/media/');
		define('DIR_ES_IMAGES',HTTP_SERVER . '/media/images/');
		define('DIR_WS_IMAGES','media/images/');
  } else { 
		define('DIR_ES_MEDIA', HTTPS_SERVER . '/media/');
		define('DIR_ES_IMAGES',HTTPS_SERVER . '/media/images/');
		define('DIR_WS_IMAGES','media/images/');
  }
  //define('DIR_WS_IMAGES', 'images/');

  define('DIR_WS_ICONS', DIR_WS_IMAGES . 'icons/');
  define('DIR_WS_INCLUDES', 'includes/');
  define('DIR_WS_FUNCTIONS', DIR_WS_INCLUDES . 'functions/');
  define('DIR_WS_CLASSES', DIR_WS_INCLUDES . 'classes/');
  define('DIR_WS_MODULES', DIR_WS_INCLUDES . 'modules/');
  define('DIR_WS_LANGUAGES', DIR_WS_INCLUDES . 'languages/');

  define('DIR_WS_DOWNLOAD_PUBLIC', 'pub/');
  define('DIR_FS_CATALOG', dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/');
  define('DIR_FS_DOWNLOAD', DIR_FS_CATALOG . 'download/');
  define('DIR_FS_DOWNLOAD_PUBLIC', DIR_FS_CATALOG . 'pub/');

// define our database connection
  define('DB_SERVER', 'localhost'); // eg, localhost - should not be empty for productive servers
  define('DB_SERVER_USERNAME', 'mahmtadb_test');
  define('DB_SERVER_PASSWORD', 's0^g^VZD#f#mEK3j');
  define('DB_DATABASE', 'mahmtadb_test');
  define('USE_PCONNECT', 'false'); // use persistent connections?
  define('STORE_SESSIONS', 'mysql'); // leave empty '' for default handler or set to 'mysql'
?>