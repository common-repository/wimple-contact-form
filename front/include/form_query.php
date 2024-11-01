<?php
#######################################################################################
# Plugin Name: WIMPLE Contact Form                                                	  #
# Author: SARANGSoft (Email: wp-contact@sarangsoft.com, Web: https://sarangsoft.com)  #
# File Name: form_query.php															  #
# Purpose: Query for form presentation.      										  #
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

global $wpdb;
global $wimplecf_form_theme;

$wimplecf_form_table 	      = $wpdb->prefix . "wimplecf_forms";
$wimplecf_form_field_table    = $wpdb->prefix . "wimplecf_formfields";

$wimplecf_form_values = $wpdb->get_results( 
									$wpdb->prepare( "SELECT * FROM `".$wimplecf_form_table."` cf 
													 INNER JOIN `".$wimplecf_form_field_table."` cff 
													 ON cf.id = cff.form_id 
													 WHERE cf.id = %d 
													 AND cf.status = %s 
													 AND cf.is_deleted = %s 
													 AND cff.is_deleted = %s 
													 ORDER BY cff.field_row_num, cff.field_column_num ASC", 
													 $wimplecf_id, 1, 0, 0 ) );
if ( count( $wimplecf_form_values ) > 0 )	
{									
    $wimplecf_no_of_fields 		= count( $wimplecf_form_values );
    $wimplecf_form_name 	 	= $wimplecf_form_values[0]->name;
	$wimplecf_form_button_label = $wimplecf_form_values[0]->form_button_label;
    $wimplecf_display_form_name = $wimplecf_form_values[0]->display_form_name;
    $wimplecf_form_theme 		= $wimplecf_form_values[0]->theme;
}

?>
