<?php
#######################################################################################
# Plugin Name: WIMPLE Contact Form                                                	  #
# Author: SARANGSoft (Email: wp-contact@sarangsoft.com, Web: https://sarangsoft.com)  #
# File Name: sendgrid_api_mailer.php												  #
# Purpose: Send test email via SendGrid API.                                          #
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

$wimplecf_recipient_mail = sanitize_email( $_POST["wimplecf_recipient_mail"] );
$wimplecf_sender_mail    = sanitize_email( $_POST["wimplecf_sender_mail"] );
$wimplecf_mail_subject   = sanitize_text_field( $_POST["wimplecf_mail_subject"] );

if ( defined( 'WIMPLECF_SENDGRID_API' ) ) 
{
	$wimplecf_sendgrid_api = WIMPLECF_SENDGRID_API;
}
else
{
	$wimplecf_sendgrid_api = '';
}

if ( $wimplecf_sendgrid_api == '' )
{
	echo 'wimplecf_error: Please copy the above line and paste in your wp-config.php file.';
}
elseif ( $wimplecf_sendgrid_api == WIMPLECF_DEFAULT_PLACEHOLDER_SENDGRID_API_ADD_FORM  )
{
	echo 'wimplecf_error: Replace the default placeholder value with actual information.';
}
else
{
	include( plugin_dir_path( WIMPLECF_PLUGIN ) . 'sendgrid/sendgrid-php.php');

	$email = new \SendGrid\Mail\Mail();
	$email->setFrom($wimplecf_sender_mail);
	$email->setSubject($wimplecf_mail_subject.' [Test purpose for WIMPLE Contact Form admin]');
	$email->addTo($wimplecf_recipient_mail);
	$email->addContent( "text/html", '<div>This is a test mail to check mail
						settings of your SendGrid account
						with the options you have provided
						in the admin section of WIMPLE Contact 
						Form plugin.</div>' );
						
	$apiKey = ($wimplecf_sendgrid_api);
	$sendgrid = new \SendGrid($apiKey);

	$response = $sendgrid->send($email);
}
?>
