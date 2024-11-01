<?php
#######################################################################################
# Plugin Name: WIMPLE Contact Form                                                	  #
# Author: SARANGSoft (Email: wp-contact@sarangsoft.com, Web: https://sarangsoft.com)  #
# File Name: create_table.php														  #
# Purpose: Create required database tables during plug-in installation.               #
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

	global 	$wimplecf_contact_db_version;
			$wimplecf_contact_db_version = '1.0';
	
	global 	$wpdb, $WIMPLECF_REQUIRED_WP_VERSION;
	
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	
	$wimplecf_charset_collate = $wpdb->get_charset_collate();
			
	$wimplecf_contact_table	  = $wpdb->prefix . "wimplecf_forms";
			
	$wimplecf_sql 			  = "CREATE TABLE IF NOT EXISTS `". $wimplecf_contact_table ."` (
								`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
								`name` VARCHAR(50) NOT NULL ,
								`shortcode` VARCHAR(30) NOT NULL ,
								`mail_to` VARCHAR(50) NOT NULL ,
								`mail_from` VARCHAR(50) NOT NULL ,
								`mail_subject` VARCHAR(80) NOT NULL ,
								`smtp_setup` VARCHAR(30) NOT NULL,
								`operating_system` VARCHAR(30) NOT NULL,
								`test_mail_received` VARCHAR(10) NULL ,
								`mail_cc` VARCHAR(50) NOT NULL ,
								`display_form_name` VARCHAR(10) NOT NULL ,
								`form_button_label` VARCHAR(10) NOT NULL ,
								`theme` VARCHAR(10) NOT NULL ,
								`status` enum('0','1') NULL ,
								`is_deleted` enum('0','1') NOT NULL ,
								`date_added` datetime NOT NULL ,
								 PRIMARY KEY ( `id` ) ) $wimplecf_charset_collate;";
	                
	dbDelta( $wimplecf_sql );
			
			
	$wimplecf_contact_table = $wpdb->prefix . "wimplecf_formfields";
	
	$wimplecf_sql 	 		= "CREATE TABLE IF NOT EXISTS `". $wimplecf_contact_table ."` (
							  `id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
							  `form_id` INT(11) NULL ,
							  `label_name` VARCHAR(255) NOT NULL ,
							  `type` VARCHAR(30) NOT NULL ,
							  `char_limit` INT(4) NULL ,
							  `type_value` TEXT NULL,
							  `note_type_text` TEXT NULL,
							  `dateformat` VARCHAR(30) NOT NULL ,
							  `date_upperlimit` INT(10) NULL,
							  `captcha_length` INT(2) NULL ,
							  `is_required` VARCHAR(3)NOT NULL ,
							  `is_email_required` VARCHAR(3)NOT NULL,
							  `is_numeric_only` VARCHAR(3)NOT NULL,
							  `field_width` INT(11) NULL,
							  `field_row_num` INT(11) NULL ,
							  `field_column_num` INT(11) NULL ,
							  `sortorder` INT(11) NULL ,
							  `field_name` VARCHAR(255) NOT NULL ,
							  `field_class` VARCHAR(50) NOT NULL ,
							  `error_msg` TEXT NULL,
							  `help_msg` TEXT NULL,
							  `placeholder_msg` TEXT NULL,
							  `is_deleted` enum('0','1') NOT NULL ,
							   PRIMARY KEY ( `id` ) ) $wimplecf_charset_collate;";
								
	dbDelta( $wimplecf_sql );
	
	
	$wimplecf_contact_table	 = $wpdb->prefix . "wimplecf_userdetails";
	
	$wimplecf_sql 			 = "CREATE TABLE IF NOT EXISTS `". $wimplecf_contact_table ."` (
							   `id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
							   `form_id` INT( 11 ) NOT NULL ,
							   `user_details` blob NOT NULL ,
							   `ip_address` VARCHAR( 20 ) NOT NULL ,
							   `sent_date` datetime NOT NULL ,
							   `is_deleted` enum( '0','1' ) NOT NULL ,
								PRIMARY KEY ( `id` ) ) $wimplecf_charset_collate;";
								
	dbDelta( $wimplecf_sql );
	
	add_option( 'contact_db_version', $wimplecf_contact_db_version );
?>
