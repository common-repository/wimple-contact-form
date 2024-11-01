<?php 
#####################################################################################################
# Plugin Name: WIMPLE Contact Form                                                				    #
# Author: SARANGSoft (Email: wp-contact@sarangsoft.com, Web: https://sarangsoft.com)  				#
# File Name: form_display.php															            #
# Purpose: SQL query for showing list of all created forms and perform delete query.                #
#####################################################################################################

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

$wimplecf_form_table = $wpdb->prefix . "wimplecf_forms";

//retrieving all forms  
$wimplecf_form_list = $wpdb->get_results( 
						  $wpdb->prepare( "SELECT * FROM `".$wimplecf_form_table."` 
										   WHERE `is_deleted` = %s 
										   ORDER BY date_added DESC", 0 ) );
     
if ( isset( $_REQUEST['form_id'] ) ) 
{
    $wimplecf_form_id = intval( $_REQUEST['form_id'] );
}

if ( isset( $_REQUEST['status'] ) ) 
{
    $wimplecf_form_delete = sanitize_text_field( $_REQUEST['status'] );
}

//altering database on form deletion action by admin
if ( isset( $wimplecf_form_delete ) && 
	 $wimplecf_form_delete == 'form_delete' ) 
{
    $sql = $wpdb->prepare( "UPDATE `".$wimplecf_form_table."` 
							SET is_deleted = %s 
							WHERE id = %d", 
							1, 
							$wimplecf_form_id );					

    $wpdb->get_results( $sql );
    $wimplecf_destination_url = admin_url( 'admin.php?page=wimplecontactform' );
    wp_redirect( esc_url( $wimplecf_destination_url ) );
    exit();
}
?>
