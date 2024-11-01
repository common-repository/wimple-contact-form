<?php
#######################################################################################
# Plugin Name: WIMPLE Contact Form                                                	  #
# Author: SARANGSoft (Email: wp-contact@sarangsoft.com, Web: https://sarangsoft.com)  #
# File Name: php_default_mailer.php													  #
# Purpose: Send test email via default PHP mail function.                             #
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

global $wpdb;

$wimplecf_recipient_mail = sanitize_email( $_POST["wimplecf_recipient_mail"] );
$wimplecf_sender_mail 	 = sanitize_email( $_POST["wimplecf_sender_mail"] );
$wimplecf_mail_subject 	 = sanitize_text_field( $_POST["wimplecf_mail_subject"] );

$wimplecf_to 	  = $wimplecf_recipient_mail;
$wimplecf_from 	  = $wimplecf_sender_mail; 
$wimplecf_subject = $wimplecf_mail_subject.' [Test purpose for WIMPLE Contact Form admin]';

//create email headers

$wimplecf_headers = "MIME-Version: 1.0" . "\r\n";
$wimplecf_headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
$wimplecf_headers .= "From: $wimplecf_from \r\n";
		
$wimplecf_message = '<html><body>';

$wimplecf_message .= '<div style="font-family: Tahoma, Arial, Helvetica, sans-serif; font-size: 10pt; line-height: 1.6;">
						This is a test mail to check whether email system is working properly in LINUX environment with default options
						of WIMPLE Contact Form plugin.
					  </div>';

$wimplecf_message .= '</body></html>';

mail( $wimplecf_to, $wimplecf_subject, $wimplecf_message, $wimplecf_headers );
?>
