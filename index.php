<?php
/*

Plugin Name: WP-Backbone
Plugin URI: http://wp-backbone.cannylab.com
Description: This is a basic wordpress plugin to integrate beauty of Backbone.js in the Wordpress Plugin development .
Version: 1.0.0
Author: Md Imranur Rahman  <imran.aspire@gmail.com>
Author URI: http://mdimran.net

*/

/**
 *  @package wp-backbone
 *  @author  Md Imranur Rahman <imran.apsire@gmail.com>
 *  @version 1.0.0
 *
 *
 *  Copyright 2013 CannyLab, Inc.  (email : imran.apsire@gmail.com)
 *
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License, version 2, as
 *  published by the Free Software Foundation.
 *
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.

 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */




/* Enable to display error messages on screen (not recommended for production) */

//ini_set( 'error_reporting' , E_ALL );
//ini_set( 'display_errors' , "1" );


ini_set( 'log_errors', 1 );

ini_set( 'error_log', WP_CONTENT_DIR . '/plugins/wp-backbone/log/debug.log' );


//ini_set( 'error_reporting', E_ALL ^ E_NOTICE );



@set_time_limit( 0 );
@ini_set( "memory_limit", "256M" );
@ini_set( "max_input_time", "-1" );


// ===============
// = Plugin Name =
// ===============
define( 'WBF_PLUGIN_NAME', 'wbf-plugin' );

// ===================
// = Plugin Basename =
// ===================
define( 'WBF_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

// ==================
// = Plugin Version =
// ==================
define( 'WBF_VERSION', '1.0.0' );

// ===============
// = Plugin Path =
// ===============
define( 'WBF_PATH', dirname( __FILE__ ) );


// ==============
// = Plugin Url =
// ==============
define( 'WBF_URL', plugins_url( '' , __FILE__ ) );

// ================
// = CSS Path =
// ================
define( 'WBF_CSS_URL', WBF_URL . '/static/css' );

// ================
// = JS Path =
// ================
define( 'WBF_JS_URL', WBF_URL . '/static/js' );

// ================
// = JS Path =
// ================
define( 'WBF_JS_BACKBONE_URL', WBF_URL . '/static/js/backbone' );

// ================
// = Images Path =
// ================
define( 'WBF_IMAGES_URL', WBF_URL . '/static/images' );


// ===============
// = Controller Path =
// ===============
define( 'WBF_APP_PATH', WBF_PATH . '/app' );

// ===============
// = REST API  Path =
// ===============
define( 'WBF_REST_PATH', WBF_PATH . '/rest-api' );

// ===============
// = REST API  end point Path =
// ===============
define( 'WBF_END_POINT_PATH', WBF_PATH . '/rest-api/endpoint' );


include(WBF_REST_PATH. "/class-wbf-rest-api.php");
include(WBF_APP_PATH. "/class-wbf-controller.php");

global $wbf_rest_api, $wbf_controller;

$wbf_rest_api = WBF_Rest_Api::get_instance();
$wbf_controller= WBF_Controller::get_instance();


?>