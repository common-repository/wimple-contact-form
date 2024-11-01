<?php
#######################################################################################
# Plugin Name: WIMPLE Contact Form                                                	  #
# Author: SARANGSoft (Email: wp-contact@sarangsoft.com, Web: https://sarangsoft.com)  #
# File Name: amazon_ses_mailer.php													  #
# Purpose: Send test email via AWS SES.                                               #
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

if ( defined( 'WIMPLECF_AWS_SES_ENDPOINT' ) ) 
{
	$wimplecf_amazon_host = WIMPLECF_AWS_SES_ENDPOINT;
}
else
{
	$wimplecf_amazon_host = '';
}
if ( defined( 'WIMPLECF_AWS_SES_ACCESS_KEY' ) ) 
{
	$wimplecf_amazon_accesskey = WIMPLECF_AWS_SES_ACCESS_KEY;
}
else
{
	$wimplecf_amazon_accesskey = '';
}
if ( defined( 'WIMPLECF_AWS_SES_SECRET_ACCESS_KEY' ) ) 
{
	$wimplecf_amazon_secretaccesskey = WIMPLECF_AWS_SES_SECRET_ACCESS_KEY;
}
else
{
	$wimplecf_amazon_secretaccesskey = '';
}


if ( $wimplecf_amazon_host == '' ||
     $wimplecf_amazon_accesskey == '' || 
	 $wimplecf_amazon_secretaccesskey == '' )
{
	echo 'wimplecf_error: Please copy the above lines and paste in your wp-config.php file.';
}
elseif ( $wimplecf_amazon_host == WIMPLECF_DEFAULT_PLACEHOLDER_ENDPOINT_ADD_FORM ||
		 $wimplecf_amazon_accesskey == WIMPLECF_DEFAULT_PLACEHOLDER_ACCESS_KEY_ADD_FORM ||
		 $wimplecf_amazon_secretaccesskey == WIMPLECF_DEFAULT_PLACEHOLDER_SECRET_ACCESS_KEY_ADD_FORM )
{
	echo 'wimplecf_error: Replace the default placeholder values with actual information.';
}
else
{
	
	include( plugin_dir_path( WIMPLECF_PLUGIN ) . 'ses/function.php');
	
	$wimplecf_amazon_host_arr = array();
	$wimplecf_amazon_host_arr = explode( '.', $wimplecf_amazon_host );
	$wimplecf_amazon_region   = $wimplecf_amazon_host_arr[1];

	$wimplecf_arrParameters = [	'AccessKey' 		=> $wimplecf_amazon_accesskey,
								'SecretKey' 		=> $wimplecf_amazon_secretaccesskey,
								'Region' 			=> $wimplecf_amazon_region,
								'From' 				=> $wimplecf_sender_mail,
								'To' 				=> [$wimplecf_recipient_mail],
								'Subject' 			=> $wimplecf_mail_subject.' [Test purpose for WIMPLE Contact Form admin]',
								'Html'				=> '<div>This is a test mail to check SES
															 settings of your AWS account
															 with the options you have provided
															 in the admin section of WIMPLE Contact 
															 Form plugin.</div>' ];

	$wimplecf_result = sendEmailToSes($wimplecf_arrParameters);
}

?>
