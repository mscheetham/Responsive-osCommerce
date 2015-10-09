<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

// define the database table names used in the project
  define('TABLE_ACTION_RECORDER', 'action_recorder');
  define('TABLE_ADDRESS_BOOK', 'address_book');
  define('TABLE_ADDRESS_FORMAT', 'address_format');
  define('TABLE_ADMINISTRATORS', 'administrators');
  define('TABLE_BANNERS', 'banners');
  define('TABLE_BANNERS_HISTORY', 'banners_history');
  define('TABLE_CATEGORIES', 'categories');
  define('TABLE_CATEGORIES_DESCRIPTION', 'categories_description');
  define('TABLE_CONFIGURATION', 'configuration');
  define('TABLE_CONFIGURATION_GROUP', 'configuration_group');
  define('TABLE_COUNTRIES', 'countries');
  define('TABLE_CURRENCIES', 'currencies');
  define('TABLE_CUSTOMERS', 'customers');
  define('TABLE_CUSTOMERS_BASKET', 'customers_basket');
  define('TABLE_CUSTOMERS_BASKET_ATTRIBUTES', 'customers_basket_attributes');
  define('TABLE_CUSTOMERS_INFO', 'customers_info');
  define('TABLE_LANGUAGES', 'languages');
  define('TABLE_MANUFACTURERS', 'manufacturers');
  define('TABLE_MANUFACTURERS_INFO', 'manufacturers_info');
  define('TABLE_ORDERS', 'orders');
  define('TABLE_ORDERS_PRODUCTS', 'orders_products');
  define('TABLE_ORDERS_PRODUCTS_ATTRIBUTES', 'orders_products_attributes');
  define('TABLE_ORDERS_PRODUCTS_DOWNLOAD', 'orders_products_download');
  define('TABLE_ORDERS_STATUS', 'orders_status');
  define('TABLE_ORDERS_STATUS_HISTORY', 'orders_status_history');
  define('TABLE_ORDERS_TOTAL', 'orders_total');
  define('TABLE_PRODUCTS', 'products');
  define('TABLE_PRODUCTS_ATTRIBUTES', 'products_attributes');
  define('TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD', 'products_attributes_download');
  define('TABLE_PRODUCTS_DESCRIPTION', 'products_description');
  define('TABLE_PRODUCTS_IMAGES', 'products_images');
  define('TABLE_PRODUCTS_NOTIFICATIONS', 'products_notifications');
  // start indvship
  define('TABLE_PRODUCTS_SHIPPING', 'products_shipping');
  // end indvship
  define('TABLE_PRODUCTS_OPTIONS', 'products_options');
  define('TABLE_PRODUCTS_OPTIONS_VALUES', 'products_options_values');
  define('TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS', 'products_options_values_to_products_options');
  define('TABLE_PRODUCTS_TO_CATEGORIES', 'products_to_categories');
  define('TABLE_REVIEWS', 'reviews');
  define('TABLE_REVIEWS_DESCRIPTION', 'reviews_description');
  define('TABLE_SESSIONS', 'sessions');
  define('TABLE_SPECIALS', 'specials');
  define('TABLE_TAX_CLASS', 'tax_class');
  define('TABLE_TAX_RATES', 'tax_rates');
  define('TABLE_GEO_ZONES', 'geo_zones');
  define('TABLE_ZONES_TO_GEO_ZONES', 'zones_to_geo_zones');
  define('TABLE_WHOS_ONLINE', 'whos_online');
  define('TABLE_ZONES', 'zones');
  /* MAZ BEGIN latest news
     - added 'define' statement below */
  define('TABLE_LATEST_NEWS', 'latest_news');
  /* MAZ //END latest news */
    //MAZ BOF FAMILIES
  define('TABLE_FAMILIES', 'families');
  define('TABLE_PRODUCTS_FAMILIES', 'products_families');
  //MAZ EOF FAMILIES
  // Linuxuk HTTP Error
  //define('TABLE_LINUXUK_HTTP_ERROR', 'linuxuk_error_log');
  //define('TABLE_IPTRAP', 'linuxuk_iptrap');
  //define('TABLE_LINUXUK_BAN_BOTS', 'linuxuk_ban_bots');
  // Linuxuk HTTP Error
  //define('TABLE_BLACKLIST', 'card_blacklist');
// BMC CC Mod End
//MAZ EOF SWITCH DEBIT CARDS
/*** Begin Header Tags SEO ***/
//  define('TABLE_HEADERTAGS', 'headertags');
//  define('TABLE_HEADERTAGS_CACHE', 'headertags_cache');
//  define('TABLE_HEADERTAGS_DEFAULT', 'headertags_default');
//  define('TABLE_HEADERTAGS_KEYWORDS', 'headertags_keywords');  
//  define('TABLE_HEADERTAGS_SEARCH', 'headertags_search');
//  define('TABLE_HEADERTAGS_SILO', 'headertags_silo');
//  define('TABLE_HEADERTAGS_SOCIAL', 'headertags_social');  
  /*** End Header Tags SEO ***/
  //Define Content
  define('TABLE_DEFINE_CONTENT', 'define_content');
  
?>
