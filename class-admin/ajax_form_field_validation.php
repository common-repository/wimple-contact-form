<?php
#######################################################################################
# Plugin Name: WIMPLE Contact Form                                                	  #
# Author: SARANGSoft (Email: wp-contact@sarangsoft.com, Web: https://sarangsoft.com)  #
# File Name: ajax_form_field_validation.php											  #
# Purpose: Recieve data on ajax request and match validity criteria.                    #
#######################################################################################

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

global $wp_version;
global $wpdb;

require_once WIMPLECF_PLUGIN_LANGUAGE_DIR . '/string_setting.php';
												   												
$wimplecf_label_name 		= sanitize_text_field( stripslashes( $_POST["wimplecf_label_name"] ) );
$wimplecf_field_type 		= sanitize_text_field( $_POST["wimplecf_field_type"] );
$wimplecf_char_limit 		= filter_var( $_POST["wimplecf_char_limit"], FILTER_SANITIZE_NUMBER_INT );
$wimplecf_optionvalue 		= sanitize_text_field( rtrim( $_POST['wimplecf_type_value'], ',' ) );
$wimplecf_notetext 			= trim( sanitize_text_field( htmlspecialchars_decode( $_POST['wimplecf_note_type_text'] ) ) );
$wimplecf_mandatory 		= filter_var( $_POST["wimplecf_mandatory"], FILTER_SANITIZE_STRING );
$wimplecf_field_width 		= filter_var( $_POST["wimplecf_field_width"], FILTER_SANITIZE_NUMBER_INT );
$wimplecf_vertical_pos 		= sanitize_text_field( $_POST["wimplecf_vertical_pos"] );
$wimplecf_row_num 			= sanitize_text_field( $_POST["wimplecf_row_num"] );
$wimplecf_validation_msg 	= sanitize_text_field( $_POST["wimplecf_validation_msg"] );

// to make sure data are set before using them
$wimplecf_hidden_values = isset( $_POST["wimplecf_hidden_values"] ) ? (array) $_POST["wimplecf_hidden_values"] : array();
// Any of the WordPress data sanitization functions can be used here
$wimplecf_hidden_values = array_map( 'sanitize_text_field', $wimplecf_hidden_values );

$wimplecf_edit_field_id		= sanitize_text_field( $_POST["wimplecf_edit_field_id"] );
$selected_field_val			= sanitize_text_field( $_POST["selected_field_val"] );

$wimplecf_edit_field_id_seperate = explode("_", $wimplecf_edit_field_id);
$wimplecf_edit_row_num = $wimplecf_edit_field_id_seperate[0];
$wimplecf_edit_col_num = $wimplecf_edit_field_id_seperate[1];

//field add validation
$wimplecf_all_row_num_array = array();
foreach ( $wimplecf_hidden_values as $wimplecf_hidden_values_each )
{
	$wimplecf_each_value = explode( '~' ,$wimplecf_hidden_values_each );
	if ( $wimplecf_each_value[7].'_'.$wimplecf_each_value[8] != $wimplecf_edit_field_id )
	{
		$existing_lebel_name = $wimplecf_each_value[1];
		
		if ( $existing_lebel_name != '' && $wimplecf_label_name == $existing_lebel_name ) 
		{
			$wimplecf_error_name_exist = '1';
		}
		
		if ( ( $wimplecf_field_type == 'captchacode' || $wimplecf_field_type == 'recaptchacode' ) &&
		     ( $wimplecf_each_value[2] == 'captchacode' || $wimplecf_each_value[2] == 'recaptchacode' ) )
		{
			$existing_captcha_type = 'One captcha is already added';
		}	
	}
}

if ( ( $wimplecf_vertical_pos == 'wimplecf_vertical_at' ) && ( $wimplecf_row_num != 'wimplecf_newrow' ) )
{
	$wimplecf_occupied_width = '0';
	foreach ( $wimplecf_hidden_values as $wimplecf_hidden_values_each )
	{
		$wimplecf_each_value = explode( '~' ,$wimplecf_hidden_values_each );
		
		if ( $wimplecf_edit_row_num == $wimplecf_row_num &&
			 $wimplecf_each_value[7] == $wimplecf_edit_row_num && 
			 $wimplecf_each_value[8] != $wimplecf_edit_col_num )
		{
			$wimplecf_occupied_width = $wimplecf_occupied_width + $wimplecf_each_value[6];
		}
		elseif ( $wimplecf_each_value[7] != $wimplecf_edit_row_num &&
				 $wimplecf_each_value[7] == $wimplecf_row_num &&
				 $wimplecf_each_value[0] != 'wimplecf_newelement' )
		{
			$wimplecf_occupied_width = $wimplecf_occupied_width + $wimplecf_each_value[6];
			
		}
		
	}
	$wimplecf_free_width = 100 - $wimplecf_occupied_width;
}

if ( isset( $existing_captcha_type ) && $existing_captcha_type != '' ) 
{
	echo 'Error@wimplecf_error_field_type||'.WIMPLECF_VALIDATION_ERROR_FIELDTYPE_EXISTS_ADD_FORM_FIELD.'||'.$wimplecf_edit_field_id.'||'.$selected_field_val;
}
elseif ( $wimplecf_field_type == 'recaptchacode' && ( !defined( 'WIMPLECF_GOOGLE_SITE_KEY' ) || !defined( 'WIMPLECF_GOOGLE_SECRET_KEY' ) ) )
{
	echo 'Error@wimplecf_gapis_not_defined||Please copy the above lines and paste in your wp-config.php file.||'.$wimplecf_edit_field_id.'||'.$selected_field_val;
}
elseif ( $wimplecf_field_type == 'recaptchacode' && ( ( defined( 'WIMPLECF_GOOGLE_SITE_KEY' ) && 
													  ( WIMPLECF_GOOGLE_SITE_KEY == '' || 
														WIMPLECF_GOOGLE_SITE_KEY == WIMPLECF_DEFAULT_PLACEHOLDER_G_SITE_KEY_ADD_FORM_FIELD ) ) ||
													  ( defined( 'WIMPLECF_GOOGLE_SECRET_KEY' ) && 
													  ( WIMPLECF_GOOGLE_SECRET_KEY == '' || 
														WIMPLECF_GOOGLE_SECRET_KEY == WIMPLECF_DEFAULT_PLACEHOLDER_G_SECRET_KEY_ADD_FORM_FIELD ) ) ) )
{
	echo 'Error@wimplecf_gapis_not_defined||Replace the default placeholder values with actual information.||'.$wimplecf_edit_field_id.'||'.$selected_field_val;
}
elseif ( ( $wimplecf_field_type != 'note' && $wimplecf_field_type != 'captchacode' && $wimplecf_field_type != 'recaptchacode' ) &&
		$wimplecf_label_name == '' ) 
{
	echo 'Error@wimplecf_error_name||'.WIMPLECF_VALIDATION_ERROR_NAME_BLANK_ADD_FORM_FIELD.'||'.$wimplecf_edit_field_id.'||'.$selected_field_val;
}
elseif ( strlen( $wimplecf_label_name ) > 50 )
{
	echo 'Error@wimplecf_error_name||Field name should not exceed 50 characters limit.||'.$wimplecf_edit_field_id.'||'.$selected_field_val;
} 
elseif ( isset( $wimplecf_error_name_exist ) && $wimplecf_error_name_exist != '' ) 
{
	echo 'Error@wimplecf_error_name||'.WIMPLECF_VALIDATION_ERROR_NAME_EXISTS_ADD_FORM_FIELD.'||'.$wimplecf_edit_field_id.'||'.$selected_field_val;
}
elseif ( ( $wimplecf_field_type == 'text' || $wimplecf_field_type == 'textarea' ) &&
( isset( $wimplecf_char_limit ) && $wimplecf_char_limit == '' || $wimplecf_char_limit == 0 ) ) 

{
	echo 'Error@wimplecf_error_charlimit||'.WIMPLECF_VALIDATION_ERROR_INPUTCHARLIMIT_ADD_FORM_FIELD.'||'.$wimplecf_edit_field_id.'||'.$selected_field_val;
}
elseif ( ( $wimplecf_field_type == 'selectbox' || $wimplecf_field_type == 'radiobutton' || $wimplecf_field_type == 'multiselectcheckbox' ) && 
		   $wimplecf_optionvalue == '' ) 
{
	echo 'Error@wimplecf_error_options||'.WIMPLECF_VALIDATION_ERROR_FIELD_OPTIONS_ADD_FORM_FIELD.'||'.$wimplecf_edit_field_id.'||'.$selected_field_val;	
}
elseif ( $wimplecf_field_type == 'note' && ( $wimplecf_notetext == '' || $wimplecf_notetext == 1 || $wimplecf_notetext == 'Maximum 500 characters (required)')  ) 
{
	echo 'Error@wimplecf_error_notetext||'.WIMPLECF_VALIDATION_ERROR_FIELD_NOTETEXT_ADD_FORM_FIELD.'||'.$wimplecf_edit_field_id.'||'.$selected_field_val;	
}
elseif ( $wimplecf_field_type == 'note' && strlen( str_replace( '&comma;', ',', $wimplecf_notetext ) ) > 500  ) 
{
	echo 'Error@wimplecf_error_notetext||'.WIMPLECF_VALIDATION_ERROR_FIELD_NOTETEXT_CHARLIMIT_ADD_FORM_FIELD.'||'.$wimplecf_edit_field_id.'||'.$selected_field_val;	
}
elseif( isset( $wimplecf_free_width ) && $wimplecf_free_width < $wimplecf_field_width )
{
	echo 'Error@wimplecf_error_free_width||Space not available in selected row.||'.$wimplecf_edit_field_id.'||'.$selected_field_val;
}
elseif ( ( $wimplecf_mandatory == 'on' && $wimplecf_validation_msg == '' ) ) 
{
	echo 'Error@wimplecf_error_validation||'.WIMPLECF_VALIDATION_ERROR_FIELD_ERROR_ADD_FORM_FIELD.'||'.$wimplecf_edit_field_id.'||'.$selected_field_val;	
}
?>
