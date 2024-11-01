<?php 
########################################################################################
# File Name: uninstall.php															   #
# Purpose: Drop tables those were created during plugin installation.                  #
########################################################################################

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

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

//when admin clicks on 'Delete' button it will automatically delete tables
//which were created during the installation of the plugin in the database
function wimplecf_DeletePlugin() 
{
	global $wpdb;
	
    $wimplecf_contact_table = $wpdb->prefix . "wimplecf_forms";		
	$wpdb->query( "DROP TABLE IF EXISTS `". $wimplecf_contact_table."`" );
	
	$wimplecf_contact_table = $wpdb->prefix . "wimplecf_formfields";
	$wpdb->query( "DROP TABLE IF EXISTS `". $wimplecf_contact_table."`" );
	
	$wimplecf_contact_table = $wpdb->prefix . "wimplecf_userdetails";
	$wpdb->query( "DROP TABLE IF EXISTS `". $wimplecf_contact_table."`" );

}
	
wimplecf_DeletePlugin();

?>
