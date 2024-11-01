<?php
/*
Plugin Name: WIMPLE Contact Form
Plugin URI: https://wordpress.org/plugins/wimple-contact-form
Description: A super-flexible Web Form plug-in for WordPress to create Contact or any kind of forms for WP-based websites.
Version: 2.4
Author: SARANGSoft 
Text Domain: wimple-contact-form
License: GPLv2 or later
*/

/*
Copyright (c) 2020, SARANGSoft.

WIMPLE Contact Form is free software: you can redistribute it and/or modify it
under the terms of the GNU General Public License as published by the Free Software 
Foundation, either version 2 of the License, or any later version.

WIMPLE Contact Form is distributed in the hope that it will be useful, but 
WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or 
FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with   
WIMPLE Contact Form. If not, see https://www.gnu.org/licenses/
*/

if( !isset( $_SESSION ) )
{
	session_start();
}
ob_start();

define( 'WIMPLECF_VERSION', '2.4' );

define( 'WIMPLECF_REQUIRED_WP_VERSION', '5.8' );

define( 'WIMPLECF_PLUGIN', __FILE__ );

define( 'WIMPLECF_PLUGIN_DIR', untrailingslashit( dirname( WIMPLECF_PLUGIN ) ) );
	
define( 'WIMPLECF_PLUGIN_CLASS_DIR', WIMPLECF_PLUGIN_DIR . '/class-admin' );

define( 'WIMPLECF_PLUGIN_INCLUDE_DIR', WIMPLECF_PLUGIN_DIR . '/include' );

define( 'WIMPLECF_PLUGIN_LANGUAGE_DIR', WIMPLECF_PLUGIN_DIR . '/languages' );

define( 'WIMPLECF_PLUGIN_FRONT_DIR', WIMPLECF_PLUGIN_DIR . '/front' );

define( 'WIMPLECF', 'wimplecf_' );

define( 'WIMPLECF_SUBMENU_POSITION', '0' );

define( 'WIMPLECF_SUBMENU_ACTION', '0' );


function wimplecf_contact_install() 
{
	require_once WIMPLECF_PLUGIN_INCLUDE_DIR . '/create_table.php';
}	
	
function wimplecf_contact() 
{
	require_once WIMPLECF_PLUGIN_CLASS_DIR . '/form_list.php';
}
			
function wimplecf_new_contact_form() 
{
	require_once WIMPLECF_PLUGIN_CLASS_DIR . '/add_forms.php';
}
			
function wimplecf_new_contact_form_field() 
{
	require_once WIMPLECF_PLUGIN_CLASS_DIR . '/add_form_fields.php';	
}
			
function wimplecf_form_preview() 
{
	require_once WIMPLECF_PLUGIN_CLASS_DIR . '/form_preview.php';	
}
	
function wimplecf_contact_admin_actions() 
{
	
	//The number is defining the positioning of the appearance of menu for WIMPLE Contact Form in admin left menu.
	//The distance is measured from top of the page. The positioning can be changed as required.
	$icon_position = 29.3; 
        
    add_menu_page( "WIMPLE Contact", 
				   "WIMPLE Contact", 
		           'activate_plugins', 
				   "wimplecontactform",
				   "wimplecf_contact", 
		            plugins_url ( 'image/icon_silver.png', WIMPLECF_PLUGIN ),
		            $icon_position );
        
    global $submenu;
		
    add_submenu_page( "wimplecontactform",
					  "New Contact Form",
					  "New Contact Form",
					  'activate_plugins',
					  "newcontactform", 
					  "wimplecf_new_contact_form" );
		
    add_submenu_page( "contactformfields", 
					  "Contact Form Fields", 
					  "Contact Form Fields", 
					  'activate_plugins',
					  "contactformfields", 
					  "wimplecf_new_contact_form_field" );
  
    add_submenu_page( "formpreview", 
					  "Form Preview", 
					  "Form Preview", 
					  'activate_plugins', 
					  "formpreview",
					  "wimplecf_form_preview" );
		
	//first [0] is for the position of sub-lable and second [0] for rename action
	$submenu['wimplecontactform'][WIMPLECF_SUBMENU_POSITION][WIMPLECF_SUBMENU_ACTION] = 'Contact Forms';
	
}
add_action( 'admin_menu', 'wimplecf_contact_admin_actions' );

register_activation_hook( WIMPLECF_PLUGIN, 'wimplecf_contact_install' );

//to display the form which is created in the admin side, in the front end 
function wimplecf_contact_form( $atts, $content = null, $code = '' ) 
{
   	global $wimplecf_id;
	if ( 'WimpleContactForm' == $code ) 
    {
		$atts = shortcode_atts( array('id' => 0), $atts );
        $wimplecf_id = ( int ) $atts['id'];
		require_once WIMPLECF_PLUGIN_FRONT_DIR . '/form.php';
	}
}
add_shortcode( 'WimpleContactForm', 'wimplecf_contact_form' );


//wordpress jQuery UI Datepicker calling
add_action( 'init', 'wimplecf_multiselectcheckbox' );
function wimplecf_multiselectcheckbox() 
{
	wp_enqueue_script('jquery');
	wp_register_script('wimplecf_jquery-multicheckboxhandle', esc_url( plugins_url( 'include/multiselect-checkbox/js/multicheckboxhandle.js', WIMPLECF_PLUGIN ) ));
	wp_enqueue_script('wimplecf_jquery-multicheckboxhandle');
}

//common style for front end UI
add_action( 'wp_enqueue_scripts', 'wimplecf_common_style' );
function wimplecf_common_style() 
{
	wp_enqueue_style( 'custom-style', esc_url( plugins_url( 'front/css/wimple_common_theme_style.css', WIMPLECF_PLUGIN ) ) );
}

//wordpress jQuery UI Datepicker calling
add_action( 'wp_loaded', 'wimplecf_datepicker', 11 );
function wimplecf_datepicker() 
{
	wp_enqueue_script('jquery-ui-datepicker');	
	wp_enqueue_style( 'wimplecf_datepicker-ui', esc_url( plugins_url( 'include/jquery-ui/themes/base/datepicker.css', WIMPLECF_PLUGIN ) ),  array(), '1.13.1' );
}
 
function wimplecf_ordinal_number_format( $wimplecf_num, $wimplecf_sup = false )
{
  $wimplecf_ordinal = 'th Row';
  $wimplecf_numlen = strlen( $wimplecf_num );
  $wimplecf_lasttwodigit = substr( $wimplecf_num, $wimplecf_numlen - 2,2 );
  $wimplecf_lastdigit = substr( $wimplecf_num, $wimplecf_numlen -1, 1 );
  if ( ( $wimplecf_lastdigit == 1 || $wimplecf_num == 1 ) && $wimplecf_lasttwodigit != 11 )
  {
    $wimplecf_ordinal = 'st Row';
  } 
  elseif ( $wimplecf_lastdigit == 2 && $wimplecf_lasttwodigit != 12 )
  {
    $wimplecf_ordinal = 'nd Row';
  } 
  elseif ( $wimplecf_lastdigit == 3 && $wimplecf_lasttwodigit != 13 )
  {
    $wimplecf_ordinal = 'rd Row';
  }
  if ( $wimplecf_sup === true )
  {
    $wimplecf_ordinal = '<sup>'.$wimplecf_ordinal.'</sup>';
  }
  return $wimplecf_num.$wimplecf_ordinal;
}


add_action( 'wp_ajax_wimplecf_default_mailer', 'wimplecf_default_mailer' );

function wimplecf_default_mailer() 
{
	require_once WIMPLECF_PLUGIN_CLASS_DIR . '/php_default_mailer.php';
	wp_die(); // this is required to terminate immediately and return a proper response
}


add_action( 'wp_ajax_wimplecf_phpmailer', 'wimplecf_phpmailer' );

function wimplecf_phpmailer() 
{
	require_once WIMPLECF_PLUGIN_CLASS_DIR . '/windows_phpmailer.php';
	wp_die(); // this is required to terminate immediately and return a proper response
}


add_action( 'wp_ajax_wimplecf_amazonses', 'wimplecf_amazonses' );

function wimplecf_amazonses() 
{
	require_once WIMPLECF_PLUGIN_CLASS_DIR . '/amazon_ses_mailer.php';
	wp_die(); // this is required to terminate immediately and return a proper response
}

add_action( 'wp_ajax_wimplecf_sendgrid', 'wimplecf_sendgrid' );

function wimplecf_sendgrid() 
{
	require_once WIMPLECF_PLUGIN_CLASS_DIR . '/sendgrid_api_mailer.php';
	wp_die(); // this is required to terminate immediately and return a proper response
}

add_action( 'wp_ajax_wimplecf_add_new_field_validation_action', 'wimplecf_add_new_field_validation_action' );

function wimplecf_add_new_field_validation_action() 
{
	require_once WIMPLECF_PLUGIN_CLASS_DIR . '/ajax_form_field_validation.php';
	wp_die(); // this is required to terminate immediately and return a proper response
}


add_action( 'wp_ajax_wimplecf_add_new_field_action', 'wimplecf_add_new_field_action' );

function wimplecf_add_new_field_action() 
{
	require_once WIMPLECF_PLUGIN_CLASS_DIR . '/ajax_form_creation.php';
	wp_die(); // this is required to terminate immediately and return a proper response
}

add_action( 'wp_ajax_wimplecf_delete_row_col_action', 'wimplecf_delete_row_col_action' );

function wimplecf_delete_row_col_action() 
{
	require_once WIMPLECF_PLUGIN_CLASS_DIR . '/ajax_row_col_delete.php';
	wp_die(); // this is required to terminate immediately and return a proper response
}

function wimplecf_ajax_form_scripts() 
{
	$wimplecf_adminajaxpath_arr = array(
        'ajax_url' => admin_url( 'admin-ajax.php' )
    );
	wp_enqueue_script( 'wimplecf_ajaxsubmitform',  esc_url( plugins_url( '/front/js/wcf_form_submit.js', WIMPLECF_PLUGIN ) ), array('jquery'), true  );
    wp_localize_script( 'wimplecf_ajaxsubmitform', 'frontend_ajax_object', $wimplecf_adminajaxpath_arr );
}
add_action( 'wp_enqueue_scripts', 'wimplecf_ajax_form_scripts' );



add_action("wp_ajax_wimplecf_form_submit" , "wimplecf_form_submit");
add_action("wp_ajax_nopriv_wimplecf_form_submit" , "wimplecf_form_submit");

function wimplecf_form_submit()
{
   require_once WIMPLECF_PLUGIN_FRONT_DIR . '/include/ajax_submission.php';
   wp_die(); // this is required to terminate immediately and return a proper response
}

?>
