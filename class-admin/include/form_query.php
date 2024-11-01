<?php 
#######################################################################################
# Plugin Name: WIMPLE Contact Form                                                    #
# Author: SARANGSoft (Email: wp-contact@sarangsoft.com, Web: https://sarangsoft.com)  #
# File Name: form_query.php														      #
# Purpose: SQL query for creating new form and editing existing form.                 #
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
	 
function wimplecf_test_input( $wimplecf_data ) 
{
	$wimplecf_data = trim( $wimplecf_data );
	$wimplecf_data = stripslashes( $wimplecf_data );
	$wimplecf_data = htmlspecialchars( $wimplecf_data );
	return $wimplecf_data;
}

$wimplecf_current_form_id = '';

$wimplecf_form_table = $wpdb->prefix . "wimplecf_forms";
$wimplecf_user_table = $wpdb->prefix . "users";

//retrieving all forms
$wimplecf_all_form_lists = $wpdb->get_results( 
							   $wpdb->prepare( "SELECT * FROM `".$wimplecf_form_table."` 
												WHERE `is_deleted` = %s", 
												0 ) );

//retrieving administrator email id from existing WordPress setup 
$wimplecf_user_details = $wpdb->get_results( 
							 $wpdb->prepare( "SELECT user_email FROM `".$wimplecf_user_table."` 
											  WHERE `user_status` = %d", 
											  0 ) );
								
$wimplecf_usermail = $wimplecf_user_details[0]->user_email;
			
if ( isset( $_REQUEST['edit_id'] ) ) 
{
	$wimplecf_current_form_id = intval( $_REQUEST['edit_id'] );
}
				
if ( isset( $wimplecf_current_form_id ) && 
	 $wimplecf_current_form_id == true ) 
{
	$wimplecf_form_details = $wpdb->get_results( 
								 $wpdb->prepare( "SELECT * FROM `".$wimplecf_form_table."` 
												  WHERE id = %d", 
												  $wimplecf_current_form_id ) );

	$wimplecf_status            		= $wimplecf_form_details[0]->status;
	$wimplecf_mail_to          			= $wimplecf_form_details[0]->mail_to;
	$wimplecf_mail_from         		= $wimplecf_form_details[0]->mail_from;
	$wimplecf_mail_subject      		= $wimplecf_form_details[0]->mail_subject;
	$wimplecf_smtp_mailer	   			= $wimplecf_form_details[0]->smtp_setup;
	$wimplecf_selected_os	   			= $wimplecf_form_details[0]->operating_system;
	$wimplecf_test_mail_received		= $wimplecf_form_details[0]->test_mail_received;
	$wimplecf_selected_theme     		= $wimplecf_form_details[0]->theme;
	$wimplecf_current_form_name 		= $wimplecf_form_details[0]->name;
	$wimplecf_current_form_button_label = $wimplecf_form_details[0]->form_button_label;
	$wimplecf_display_current_form_name = $wimplecf_form_details[0]->display_form_name;
	
}

//getting field values of form, validation, add and edit
if ( isset( $_REQUEST['wimplecf_form_submit'] ) )
{
	$wimplecf_form_phpmail_os = '';	
	
	$wimplecf_form_name 		= sanitize_text_field( stripslashes( $_POST['wimplecf_form_name'] ) );
	$wimplecf_form_button_label = sanitize_text_field( stripslashes( $_POST['wimplecf_form_button_label'] ) );

	if ( isset( $_POST['wimplecf_display_name'] ) )
	{
		$wimplecf_display_form_name = sanitize_text_field( $_POST['wimplecf_display_name'] );	
	}
	else
	{
		$wimplecf_display_form_name = '';
	}
	
	$wimplecf_form_mail_to      = sanitize_email( $_POST['wimplecf_mail_to'] );
	$wimplecf_form_mail_from    = sanitize_email( $_POST['wimplecf_mail_from'] );
	$wimplecf_form_mail_subject = sanitize_text_field( stripslashes( $_POST['wimplecf_mail_subject'] ) );
	$wimplecf_form_smtp_mailer  = sanitize_text_field( $_POST['wimplecf_mail_server_selection'] );
	$wimplecf_form_mailreceived = sanitize_text_field( $_POST['wimplecf_mailreceivedvalue'] );
	$wimplecf_form_status       = intval( $_POST['wimplecf_form_status'] );
	$wimplecf_form_theme        = sanitize_text_field( $_POST['wimplecf_form_theme'] );
	
	
	if ( $wimplecf_form_smtp_mailer == 'wimplecf_amazon_ses_mailer' )
	{
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
	}
	
	if ( $wimplecf_form_smtp_mailer == 'wimplecf_sendgrid_api_mailer' )
	{
		if ( defined( 'WIMPLECF_SENDGRID_API' ) ) 
		{
			$wimplecf_sendgrid_api = WIMPLECF_SENDGRID_API;
		}
		else
		{
			$wimplecf_sendgrid_api = '';
		}
	}
	
	if ( $wimplecf_form_smtp_mailer == 'wimplecf_default_php_mailer' )
	{
		$wimplecf_form_phpmail_os = sanitize_text_field( $_POST['wimplecf_phpmail_os'] );
	}
	
	if ( $wimplecf_form_smtp_mailer == 'wimplecf_default_php_mailer' && 
	     $wimplecf_form_phpmail_os == 'wimplecf_windows_value' )
	{
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
	}
	
	
    if ( $wimplecf_current_form_id == true )
    {
		$wimplecf_exists_formname = $wpdb->get_results( 
										$wpdb->prepare( "SELECT * FROM `".$wimplecf_form_table."` 
														 WHERE `name` != %s", 
														 $wimplecf_current_form_name ) );

        for ( $m = 0; $m < count( $wimplecf_exists_formname ); $m++ ) 
        {
            $wimplecf_existing_form_name = $wimplecf_exists_formname[$m]->name;

            if ( $wimplecf_form_name == $wimplecf_existing_form_name ) 
            {
                $wimplecf_error_name_exist = '1';
            }
        }
		
        if ( $wimplecf_form_name == '' ) 
        {
			$wimplecf_name_err = WIMPLECF_VALIDATION_ERROR_NAME_BLANK_ADD_FORM;
        }
		elseif ( $wimplecf_form_button_label == '' )	
        {
			$wimplecf_form_button_label_err = 'Please enter form button label.';
        }  
		elseif ( isset( $wimplecf_error_name_exist ) && 
				 $wimplecf_error_name_exist != '' )	
        {
			$wimplecf_name_err = WIMPLECF_VALIDATION_ERROR_NAME_EXISTS_ADD_FORM;
        } 
			elseif ( empty( $_POST["wimplecf_mail_to"] ) ) 
        {
			$wimplecf_email_to_err = WIMPLECF_VALIDATION_ERROR_RECIPENT_EMAIL_ADD_FORM;
        } 
        elseif ( !filter_var( wimplecf_test_input( $_POST["wimplecf_mail_to"] ), FILTER_VALIDATE_EMAIL ) )
        {
			$wimplecf_email_to_err = WIMPLECF_VALIDATION_ERROR_RECIPENT_EMAIL_ADD_FORM;
        } 
        elseif ( empty( $_POST["wimplecf_mail_from"] ) ) 
        {
			$wimplecf_email_from_err = WIMPLECF_VALIDATION_ERROR_SENDER_EMAIL_ADD_FORM;
        } 
        elseif ( !filter_var( wimplecf_test_input( $_POST["wimplecf_mail_from"] ), FILTER_VALIDATE_EMAIL ) ) 
        {
			$wimplecf_email_from_err = WIMPLECF_VALIDATION_ERROR_SENDER_EMAIL_ADD_FORM;
        } 
        elseif ( $_POST["wimplecf_mail_subject"] == '' ) 
        {
			$wimplecf_email_sub_err = WIMPLECF_VALIDATION_ERROR_SUBJECT_ADD_FORM;
        }
		elseif ( $wimplecf_form_smtp_mailer == '' ) 
        {
			$wimplecf_form_smtp_mailer_err = WIMPLECF_VALIDATION_ERROR_SMTP_SETTING_ADD_FORM;
        }
		elseif ( $wimplecf_form_smtp_mailer == 'wimplecf_default_php_mailer' && 
				 $wimplecf_form_phpmail_os == '' ) 
        {
			$wimplecf_form_server_os_err = WIMPLECF_VALIDATION_ERROR_SERVER_OS_ADD_FORM;
        }
		elseif ( $wimplecf_form_smtp_mailer == 'wimplecf_amazon_ses_mailer' &&
				 ( $wimplecf_amazon_host == '' ||
				   $wimplecf_amazon_accesskey == '' || 
				   $wimplecf_amazon_secretaccesskey == '' ) )
		{
			$wimplecf_aws_ses_config_err = 'Please copy the above lines and paste in your wp-config.php file.';
		}
		elseif( $wimplecf_form_smtp_mailer == 'wimplecf_amazon_ses_mailer' &&
				( $wimplecf_amazon_host == WIMPLECF_DEFAULT_PLACEHOLDER_ENDPOINT_ADD_FORM ||
				  $wimplecf_amazon_accesskey == WIMPLECF_DEFAULT_PLACEHOLDER_ACCESS_KEY_ADD_FORM ||
				  $wimplecf_amazon_secretaccesskey == WIMPLECF_DEFAULT_PLACEHOLDER_SECRET_ACCESS_KEY_ADD_FORM ) )
		{
			$wimplecf_aws_ses_config_err = 'Replace the default placeholder values with actual information.';
		}
		elseif ( $wimplecf_form_phpmail_os == 'wimplecf_windows_value' &&
				 ( $wimplecf_server_address == '' ||
				   $wimplecf_server_port == '' || 
				   $wimplecf_auth_username == '' ||
				   $wimplecf_auth_password == '' ) )
		{
			$wimplecf_other_smtp_config_err = 'Please copy the above lines and paste in your wp-config.php file.';
		}
		elseif( $wimplecf_form_phpmail_os == 'wimplecf_windows_value' &&
				( $wimplecf_server_address == WIMPLECF_DEFAULT_PLACEHOLDER_SERVER_ADDRESS_ADD_FORM ||
				  $wimplecf_server_port == WIMPLECF_DEFAULT_PLACEHOLDER_SERVER_PORT_ADD_FORM ||
				  $wimplecf_auth_username == WIMPLECF_DEFAULT_PLACEHOLDER_SMTP_USERNAME_ADD_FORM ||
				  $wimplecf_auth_password == WIMPLECF_DEFAULT_PLACEHOLDER_SMTP_PASSWORD_ADD_FORM ) )
		{
			$wimplecf_other_smtp_config_err = 'Replace the default placeholder values with actual information.';
		}
		elseif ( $wimplecf_form_smtp_mailer == 'wimplecf_sendgrid_api_mailer' && $wimplecf_sendgrid_api == '' )
		{
			$wimplecf_aws_ses_config_err = 'Please copy the above line(s) and paste in your wp-config.php file.';
		}
		elseif ( $wimplecf_form_smtp_mailer == 'wimplecf_sendgrid_api_mailer' && $wimplecf_sendgrid_api == WIMPLECF_DEFAULT_PLACEHOLDER_SENDGRID_API_ADD_FORM )
		{
			$wimplecf_aws_ses_config_err = 'Replace the default placeholder values with actual information.';
		}
		else 
        {
            $wimplecf_sql= $wpdb->prepare( "UPDATE `".$wimplecf_form_table."` 
											SET name = %s, 
											display_form_name = %s, 
											mail_to = %s, 
											mail_from = %s, 
											mail_subject = %s, 
											smtp_setup = %s, 
											operating_system = %s,
											test_mail_received = %s,
											form_button_label = %s,
											theme = %s, 
											status = %s 
											WHERE id = %d", 
											$wimplecf_form_name, 
											$wimplecf_display_form_name, 
											$wimplecf_form_mail_to, 
											$wimplecf_form_mail_from, 
											$wimplecf_form_mail_subject, 
											$wimplecf_form_smtp_mailer, 
											$wimplecf_form_phpmail_os,
											$wimplecf_form_mailreceived, 
											$wimplecf_form_button_label,
											$wimplecf_form_theme,
											$wimplecf_form_status, 
											$wimplecf_current_form_id 
											);
	
            $wpdb->get_results( $wimplecf_sql );
	    

			$wimplecf_destination_url = esc_url( 
											 admin_url( 'admin.php?page=contactformfields&form_id='.$wimplecf_current_form_id ) );
			wp_redirect( str_replace( '#038;', '&', $wimplecf_destination_url ) );
			exit();
        }
    } 
    else 
    {
	    for ( $i = 0; $i < count( $wimplecf_all_form_lists ); $i++ ) 
        {
		    $wimplecf_existing_form_name = $wimplecf_all_form_lists[$i]->name;
            
		    if ( $wimplecf_form_name == $wimplecf_existing_form_name ) 
            {
		        $wimplecf_error_name_exist = '1';
		    }
		}
	    if ( $wimplecf_form_name == '' ) 
        {
            $wimplecf_name_err = WIMPLECF_VALIDATION_ERROR_NAME_BLANK_ADD_FORM;
        } 
		elseif ( $wimplecf_form_button_label == '' ) 
        {
            $wimplecf_form_button_label_err = 'Please enter form button label.';
        }
        elseif ( isset( $wimplecf_error_name_exist ) && 
		         $wimplecf_error_name_exist != '' ) 
        {
            $wimplecf_name_err = WIMPLECF_VALIDATION_ERROR_NAME_EXISTS_ADD_FORM;
        } 
        elseif ( empty( $_POST["wimplecf_mail_to"] ) ) 
        {
            $wimplecf_email_to_err = WIMPLECF_VALIDATION_ERROR_RECIPENT_EMAIL_ADD_FORM;
        } 
        elseif ( !filter_var( wimplecf_test_input( $_POST["wimplecf_mail_to"] ), FILTER_VALIDATE_EMAIL ) ) 
        {
            $wimplecf_email_to_err = WIMPLECF_VALIDATION_ERROR_RECIPENT_EMAIL_ADD_FORM;
        } 
        elseif ( empty( $_POST["wimplecf_mail_from"] ) ) 
        {
            $wimplecf_email_from_err = WIMPLECF_VALIDATION_ERROR_SENDER_EMAIL_ADD_FORM;
        } 
        elseif ( !filter_var( wimplecf_test_input( $_POST["wimplecf_mail_from"] ), FILTER_VALIDATE_EMAIL ) ) 
        {
            $wimplecf_email_from_err = WIMPLECF_VALIDATION_ERROR_SENDER_EMAIL_ADD_FORM;
        } 
        elseif ( $_POST["wimplecf_mail_subject"] == '' ) 
        {
            $wimplecf_email_sub_err = WIMPLECF_VALIDATION_ERROR_SUBJECT_ADD_FORM;
        }
		elseif ( $wimplecf_form_smtp_mailer == '' ) 
        {
            $wimplecf_form_smtp_mailer_err = WIMPLECF_VALIDATION_ERROR_SMTP_SETTING_ADD_FORM;
        }
		elseif ( $wimplecf_form_smtp_mailer == 'wimplecf_default_php_mailer' && 
		         $wimplecf_form_phpmail_os == '' ) 
        {
			$wimplecf_form_server_os_err = WIMPLECF_VALIDATION_ERROR_SERVER_OS_ADD_FORM;
        }
		elseif ( $wimplecf_form_smtp_mailer == 'wimplecf_amazon_ses_mailer' &&
				 ( $wimplecf_amazon_host == '' ||
				   $wimplecf_amazon_accesskey == '' || 
				   $wimplecf_amazon_secretaccesskey == '' ) )
		{
			$wimplecf_aws_ses_config_err = 'Please copy the above lines and paste in your wp-config.php file.';
		}
		elseif ( $wimplecf_form_smtp_mailer == 'wimplecf_amazon_ses_mailer' &&
				 ( $wimplecf_amazon_host == WIMPLECF_DEFAULT_PLACEHOLDER_ENDPOINT_ADD_FORM ||
				   $wimplecf_amazon_accesskey == WIMPLECF_DEFAULT_PLACEHOLDER_ACCESS_KEY_ADD_FORM ||
				   $wimplecf_amazon_secretaccesskey == WIMPLECF_DEFAULT_PLACEHOLDER_SECRET_ACCESS_KEY_ADD_FORM ) )
		{
			$wimplecf_aws_ses_config_err = 'Replace the default placeholder values with actual information.';
		}
		elseif ( $wimplecf_form_phpmail_os == 'wimplecf_windows_value' &&
				 ( $wimplecf_server_address == '' ||
				   $wimplecf_server_port == '' || 
				   $wimplecf_auth_username == '' ||
				   $wimplecf_auth_password == '' ) )
		{
			$wimplecf_other_smtp_config_err = 'Please copy the above lines and paste in your wp-config.php file.';
		}
		elseif( $wimplecf_form_phpmail_os == 'wimplecf_windows_value' &&
				( $wimplecf_server_address == WIMPLECF_DEFAULT_PLACEHOLDER_SERVER_ADDRESS_ADD_FORM ||
				  $wimplecf_server_port == WIMPLECF_DEFAULT_PLACEHOLDER_SERVER_PORT_ADD_FORM ||
				  $wimplecf_auth_username == WIMPLECF_DEFAULT_PLACEHOLDER_SMTP_USERNAME_ADD_FORM ||
				  $wimplecf_auth_password == WIMPLECF_DEFAULT_PLACEHOLDER_SMTP_PASSWORD_ADD_FORM ) )
		{
			$wimplecf_other_smtp_config_err = 'Replace the default placeholder values with actual information.';
		}
		elseif ( $wimplecf_form_smtp_mailer == 'wimplecf_sendgrid_api_mailer' && $wimplecf_sendgrid_api == '' )
		{
			$wimplecf_aws_ses_config_err = 'Please copy the above line(s) and paste in your wp-config.php file.';
		}
		elseif ( $wimplecf_form_smtp_mailer == 'wimplecf_sendgrid_api_mailer' && $wimplecf_sendgrid_api == WIMPLECF_DEFAULT_PLACEHOLDER_SENDGRID_API_ADD_FORM )
		{
			$wimplecf_aws_ses_config_err = 'Replace the default placeholder values with actual information.';
		}
        else 
        {
            $wimplecf_sql = $wpdb->prepare( "INSERT INTO `".$wimplecf_form_table."` (
											 name, 
											 display_form_name, 
											 mail_to, mail_from, 
											 mail_subject, 
											 smtp_setup, 
											 operating_system,
											 test_mail_received,
											 form_button_label,
											 theme, 
											 status, 
											 date_added )
											 VALUES (
											 %s, 
											 %s, 
											 %s, 
											 %s, 
											 %s, 
											 %s,
											 %s,					
											 %s,
											 %s,											 
											 %s, 
											 %s, 
											 %s )",
											 $wimplecf_form_name, 
											 $wimplecf_display_form_name, 
											 $wimplecf_form_mail_to, 
											 $wimplecf_form_mail_from, 
											 $wimplecf_form_mail_subject, 
											 $wimplecf_form_smtp_mailer, 
											 $wimplecf_form_phpmail_os,
											 $wimplecf_form_mailreceived, 
											 $wimplecf_form_button_label,
											 $wimplecf_form_theme, 
											 $wimplecf_form_status, 
											 date('Y-m-d H:i:s') );
								    
            $wpdb->get_results( $wimplecf_sql );
		
			//shortcode generation (shortcode is like function macro)		
            $wimplecf_last_form_id = $wpdb->insert_id;
				    
            $wimplecf_shortcode = '[WimpleContactForm id="'.$wimplecf_last_form_id.'"]';
						
            $wimplecf_sql1 = $wpdb->prepare( "UPDATE `".$wimplecf_form_table."` 
											  SET shortcode = %s 
											  WHERE id = %d",
											  $wimplecf_shortcode, 
											  $wimplecf_last_form_id );

            $wpdb->get_results( $wimplecf_sql1 );
	    
            $wimplecf_destination_url = esc_url( 
											admin_url( 'admin.php?page=contactformfields&form_id='. $wimplecf_last_form_id ) );
            wp_redirect( str_replace( '#038;', '&', $wimplecf_destination_url ) );
            exit();
        }
    }
}
?>
