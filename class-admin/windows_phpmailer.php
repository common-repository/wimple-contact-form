<?php
#######################################################################################
# Plugin Name: WIMPLE Contact Form                                                	  #
# Author: SARANGSoft (Email: wp-contact@sarangsoft.com, Web: https://sarangsoft.com)  #
# File Name: windows_phpmailer.php													  #
# Purpose: Sending test email via SMTP server other than AWS SES.                     #
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
require_once WIMPLECF_PLUGIN_LANGUAGE_DIR . '/string_setting.php';

$wimplecf_recipient_mail = sanitize_email( $_POST["wimplecf_recipient_mail"] );
$wimplecf_sender_mail    = sanitize_email( $_POST["wimplecf_sender_mail"] );
$wimplecf_mail_subject   = sanitize_text_field( $_POST["wimplecf_mail_subject"] );

if ( defined( 'WIMPLECF_SMTP_SERVER_ADDRESS' ) ) 
{
	$wimplecf_server_address = WIMPLECF_SMTP_SERVER_ADDRESS;
}
else
{
	$wimplecf_server_address = '';
}

if ( defined( 'WIMPLECF_SMTP_SERVER_PORT' ) ) 
{
	$wimplecf_server_port = WIMPLECF_SMTP_SERVER_PORT;
}
else
{
	$wimplecf_server_port = '';
}

if ( defined( 'WIMPLECF_SMTP_USER_EMAIL_ID' ) ) 
{
	$wimplecf_auth_username = WIMPLECF_SMTP_USER_EMAIL_ID;
}
else
{
	$wimplecf_auth_username = '';
}

if ( defined( 'WIMPLECF_SMTP_PASSWORD' ) ) 
{
	$wimplecf_auth_password = WIMPLECF_SMTP_PASSWORD;
}
else
{
	$wimplecf_auth_password = '';
}


if ( $wimplecf_server_address == '' ||
     $wimplecf_server_port == '' || 
	 $wimplecf_auth_username == '' ||
	 $wimplecf_auth_password == '' )
{
	echo 'wimplecf_error: Please copy the above lines and paste in your wp-config.php file.';
}
else if ( $wimplecf_server_address == WIMPLECF_DEFAULT_PLACEHOLDER_SERVER_ADDRESS_ADD_FORM ||
		  $wimplecf_server_port == WIMPLECF_DEFAULT_PLACEHOLDER_SERVER_PORT_ADD_FORM ||
		  $wimplecf_auth_username == WIMPLECF_DEFAULT_PLACEHOLDER_SMTP_USERNAME_ADD_FORM ||
		  $wimplecf_auth_password == WIMPLECF_DEFAULT_PLACEHOLDER_SMTP_PASSWORD_ADD_FORM )
{
	echo 'wimplecf_error: Replace the default placeholder values with actual information.';
}
else
{
	if ( version_compare( $wp_version, '5.4.99' ) > 0 ) 
	{
		require_once ABSPATH . WPINC . '/PHPMailer/PHPMailer.php';
		require_once ABSPATH . WPINC . '/PHPMailer/SMTP.php';
		require_once ABSPATH . WPINC . '/PHPMailer/Exception.php';
		$wimplecf_mail = new PHPMailer\PHPMailer\PHPMailer();
	}
	else 
	{
		require_once ABSPATH . WPINC . '/class-phpmailer.php';
		$wimplecf_mail = new \PHPMailer( true );
	}
		

	//Server settings
	$wimplecf_mail->isSMTP();                                 // Set mailer to use SMTP
	$wimplecf_mail->Host 	   = $wimplecf_server_address;    // Specify main and backup SMTP servers
	$wimplecf_mail->SMTPAuth   = true;                        // Enable SMTP authentication
	$wimplecf_mail->Username   = $wimplecf_auth_username;     // SMTP username
	$wimplecf_mail->Password   = $wimplecf_auth_password;     // SMTP password
	$wimplecf_mail->SMTPSecure = 'tls';                       // Enable TLS encryption, `ssl` also accepted
	$wimplecf_mail->Port 	   = $wimplecf_server_port;       // TCP port to connect

	// Recipients
	$wimplecf_mail->setFrom( $wimplecf_sender_mail );         // Add sender
	$wimplecf_mail->addAddress( $wimplecf_recipient_mail );   // Add a recipient, Name is optional

	// Content
	$wimplecf_mail->isHTML( true );                           // Set email format to HTML
	$wimplecf_mail->Subject = $wimplecf_mail_subject.' [Test purpose for WIMPLE Contact Form admin]';
	$wimplecf_mail->Body = 'This is a test mail to check whether the email system is working
							properly with the options you have provided in the admin section
							of WIMPLE Contact Form plugin.';
	$wimplecf_mail->send();
}
 
?>
