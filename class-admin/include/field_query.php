<?php
#######################################################################################
# Plugin Name: WIMPLE Contact Form                                                	  #
# Author: SARANGSoft (Email: wp-contact@sarangsoft.com, Web: https://sarangsoft.com)  #
# File Name: field_query.php														  #
# Purpose: SQL query for creating and editing dynamic fields for specific form.    	  #
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

require_once WIMPLECF_PLUGIN_LANGUAGE_DIR . '/string_setting.php';

$wimplecf_current_form_id  = '';
$wimplecf_row_listing_str  = '';
      
$wimplecf_form_table 	   = $wpdb->prefix . "wimplecf_forms";
$wimplecf_form_field_table = $wpdb->prefix . "wimplecf_formfields";

if ( isset( $_REQUEST['form_id'] ) ) 
{
    $wimplecf_current_form_id =  intval( $_REQUEST['form_id'] );
}

//retrieving form basic details(data) 
$wimplecf_form_details = $wpdb->get_results( 
							 $wpdb->prepare( "SELECT * FROM `".$wimplecf_form_table."`  
											  WHERE `id` = %d", 
											  $wimplecf_current_form_id ) );
                            
$wimplecf_form_name  		= $wimplecf_form_details[0]->name;
$wimplecf_form_button_label = $wimplecf_form_details[0]->form_button_label;
$wimplecf_form_theme 		= $wimplecf_form_details[0]->theme;

//getting last row ID from DB on page load time 
$wimplecf_next_row = $wpdb->get_results( 
								  $wpdb->prepare( "SELECT max( field_row_num ) as nextrow FROM `".$wimplecf_form_field_table."` 
												   WHERE `form_id` = %d
												   and is_deleted = %s", 
												   $wimplecf_current_form_id,0 ) );

$wimplecf_next_row_num = $wimplecf_next_row[0]->nextrow + 1;

//retrieving all rows and it's corresponding data on page load time
$wimplecf_all_field = $wpdb->get_results( 
								  $wpdb->prepare( "SELECT * FROM `".$wimplecf_form_field_table."` 
												   WHERE `form_id` = %d and `is_deleted` = %s
												   ORDER BY field_row_num, field_column_num ASC", 
												   $wimplecf_current_form_id,0 ) );
//making row list on page load time 												   
foreach ( $wimplecf_all_field as $wimplecf_each_field )
{
	$wimplecf_row_listing_str .= '<option value="'.$wimplecf_each_field->field_row_num.'">'.Wimplecf_ordinal_number_format( $wimplecf_each_field->field_row_num ).'</option>,';
}
$wimplecf_row_listing = implode( '', array_unique( explode( ',', rtrim( $wimplecf_row_listing_str, ',' ) ) ) );

//getting value of properties for each field, 
//validate those, add or edit accordingly
if ( isset( $_REQUEST['wimplecf_form_submit'] ) ) 
{	
	$wimplecf_all_field_values = $_POST['hiddenvalus'];
	
	foreach ( $wimplecf_all_field_values as $wimplecf_each_field )
	{
		$wimplecf_field_value = explode( '~', $wimplecf_each_field );		
		
		if( $wimplecf_field_value[0] != 'wimplecf_newelement_temp' )
		{
			$wimplecf_sql = $wpdb->prepare( "UPDATE `".$wimplecf_form_field_table."` 
											SET label_name = %s, 
											type = %s, 
										    type_value = %s, 
											is_required = %s,
											is_email_required = %s,
											field_width = %d, 
											field_row_num = %d,
											field_column_num = %d,
											field_name = %s , 
											help_msg = %s,
											error_msg = %s,
											placeholder_msg = %s,
											is_numeric_only =%s,
											char_limit = %d,
											note_type_text = %s,
											dateformat = %s,
											captcha_length = %d,
											date_upperlimit = %d
											WHERE id = %d",
											stripslashes( $wimplecf_field_value[1] ), 
											$wimplecf_field_value[2], 
											$wimplecf_field_value[3], 
											$wimplecf_field_value[4], 
											$wimplecf_field_value[5], 
											$wimplecf_field_value[6], 
											$wimplecf_field_value[7],
											$wimplecf_field_value[8], 
											$wimplecf_field_value[9],
											$wimplecf_field_value[10],
											$wimplecf_field_value[11],
											$wimplecf_field_value[12],
											$wimplecf_field_value[13],
											$wimplecf_field_value[14],
											$wimplecf_field_value[15],
											$wimplecf_field_value[16],
											$wimplecf_field_value[17],
											$wimplecf_field_value[18],
											$wimplecf_field_value[0] );
		  
            $wpdb->get_results( $wimplecf_sql );
		}
		else
		{
			$wimplecf_sql = $wpdb->prepare( "INSERT INTO `".$wimplecf_form_field_table."` ( 
											label_name, 
											form_id, 
											type, 
											type_value, 
											is_required, 
											is_email_required,
											field_width, 
											field_row_num,
											field_column_num,
											field_name,
											help_msg, 
											error_msg, 
											placeholder_msg,
											is_numeric_only,
											char_limit,
											note_type_text,
											dateformat,
                                            captcha_length,
     										date_upperlimit	)
											VALUES ( 
											%s, 
											%d, 
											%s, 
											%s, 
											%s,
											%s,											 
											%d,
											%d,
											%d,											 
											%s, 
											%s,
											%s,
											%s,
											%s,
											%d,
											%s,
											%s,
											%d,
											%d )",
											stripslashes( $wimplecf_field_value[1] ), 
											$wimplecf_current_form_id, 
											$wimplecf_field_value[2], 
											$wimplecf_field_value[3], 
											$wimplecf_field_value[4],
											$wimplecf_field_value[5],
											$wimplecf_field_value[6], 
											$wimplecf_field_value[7], 
											$wimplecf_field_value[8],
											$wimplecf_field_value[9],
											$wimplecf_field_value[10], 
											$wimplecf_field_value[11], 
											$wimplecf_field_value[12],
											$wimplecf_field_value[13],
											$wimplecf_field_value[14],
											$wimplecf_field_value[15],
											$wimplecf_field_value[16],
											$wimplecf_field_value[17],
											$wimplecf_field_value[18] );
							
		    $wpdb->get_results( $wimplecf_sql );
		}
	}
	
	echo $wimplecf_deleted_ids = $_POST['hiddendeletedvalus'];
	$wimplecf_deleted_id_arr = explode( ',', $wimplecf_deleted_ids );
	
	foreach ( $wimplecf_deleted_id_arr as $wimplecf_deleted_id )
	{
		$wimplecf_sql = $wpdb->prepare( "UPDATE `".$wimplecf_form_field_table."` 
										SET is_deleted = %s
										WHERE id = %d",
										'1',
										$wimplecf_deleted_id );
	  
		$wpdb->get_results( $wimplecf_sql );
	}

	$wimplecf_destination_url = esc_url( admin_url( 'admin.php?page=wimplecontactform' ) );
	wp_redirect( $wimplecf_destination_url );
	exit();
}
?>
