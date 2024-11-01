<?php
#######################################################################################
# Plugin Name: WIMPLE Contact Form                                                	  #
# Author: SARANGSoft (Email: wp-contact@sarangsoft.com, Web: https://sarangsoft.com)  #
# File Name: ajax_submission.php													  #
# Purpose: Get ajax request, complete form submit purpose and send email.          #
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
global $wp_version;	

if ( defined( 'WIMPLECF_GOOGLE_SECRET_KEY' ) ) 
{
	$wimplecf_google_secret_key = WIMPLECF_GOOGLE_SECRET_KEY;
}
	
$wimplecf_form_id 	  = filter_var( $_REQUEST['wimplecf_form_id'], FILTER_SANITIZE_NUMBER_INT );
$wimplecf_fields_info = array_map( 'sanitize_text_field', wp_unslash( $_REQUEST['wimplecf_hdn_values'] ) );
$wimplecf_g_recaptcha_varified = sanitize_text_field( $_POST["wimplecf_g_recaptcha_varified"] );



$wimplecf_formdata     = stripslashes( html_entity_decode( filter_var( $_REQUEST['wimplecf_formdata'], FILTER_SANITIZE_STRING ), ENT_QUOTES ) );
$wimplecf_formdata_arr = explode( "&", $wimplecf_formdata );

$wimplecf_field_data = [];
foreach ( $wimplecf_formdata_arr as $wimplecf_formdata_single )
{
	$wimplecf_field_name_value_pair = explode( "=", $wimplecf_formdata_single );
	$wimplecf_field_data[$wimplecf_field_name_value_pair[0]] = urldecode( $wimplecf_field_name_value_pair[1] );	
}

function wimplecf_change_key( $wimplecf_array, $wimplecf_new_key )
{
    if ( count( $wimplecf_array ) != count( $wimplecf_new_key ) )
    {
        return $wimplecf_array;
    }

    $wimplecf_keys = array_keys( $wimplecf_array );

    foreach ( $wimplecf_array as $wimplecf_old_key=>$wimplecf_val )
    {
        $wimplecf_keys[array_search( $wimplecf_old_key, $wimplecf_keys )] = $wimplecf_new_key[$wimplecf_old_key];
    }
    return array_combine( $wimplecf_keys, $wimplecf_array );
}

$wimplecf_form_table 	      = $wpdb->prefix . "wimplecf_forms";
$wimplecf_form_field_table    = $wpdb->prefix . "wimplecf_formfields";
$wimplecf_contact_userdetails = $wpdb->prefix . "wimplecf_userdetails";

$wimplecf_form_values = $wpdb->get_results( 
							$wpdb->prepare( "SELECT * FROM ".$wimplecf_form_table." cf 
											 INNER JOIN ".$wimplecf_form_field_table." cff 
											 ON cf.id = cff.form_id 
											 WHERE cf.id = %d 
											 AND cf.status = %s 
											 AND cf.is_deleted = %s 
											 AND cff.is_deleted = %s 
											 ORDER BY cff.field_row_num, cff.field_column_num ASC", 
											 $wimplecf_form_id, 1, 0, 0 ) );

if ( count( $wimplecf_form_values ) > 0 )	
{									
    $wimplecf_mail_to 			= $wimplecf_form_values[0]->mail_to;
    $wimplecf_mail_from 	 	= $wimplecf_form_values[0]->mail_from;
    $wimplecf_mail_subject 		= $wimplecf_form_values[0]->mail_subject;
    $wimplecf_smtp_setup	 	= $wimplecf_form_values[0]->smtp_setup;
	$wimplecf_smtp_OS		    = $wimplecf_form_values[0]->operating_system;
    $wimplecf_is_captcha 		= $wimplecf_form_values[0]->captcha_enable;
    $wimplecf_form_name 	 	= $wimplecf_form_values[0]->name;
    $wimplecf_date 			 	= date('Y-m-d @ H:i:s');
}

	$wimplecf_error_message = '';
    $wimplecf_success_msg   = '';
    $wimplecf_i             = 0;
    $wimplecf_label_name    = '';
    $wimplecf_field_name    = '';
    $wimplecf_field_value   = '';
    
    $wimplecf_captcha_check_value = '0';
			
    foreach ( $wimplecf_fields_info as $wimplecf_fields_val ) 
    {
        $wimplecf_field = explode( '~', $wimplecf_fields_val );
		
        $wimplecf_new_key_array = array( 0 => 'e_field_type',
										 1 => 'e_label_name',
										 2 => 'e_field_name',
										 3 => 'e_mandatory_field',
										 4 => 'e_field_err_msg',
										 5 => 'e_email_field',
										 6 => 'e_numeric_field',
										 7 => 'e_field_char_limit' );
                                
        $wimplecf_array_fields = wimplecf_change_key( $wimplecf_field, $wimplecf_new_key_array );

        $wimplecf_label_name = $wimplecf_array_fields['e_label_name'];
        $wimplecf_field_name = trim( $wimplecf_array_fields['e_field_name'] );
		
		$wimplecf_field_value = $wimplecf_field_data[$wimplecf_field_name];
			
		if ( is_array( $wimplecf_field_value ) ) 
        {
			$wimplecf_field_value = implode( ', ', $wimplecf_field_value );
		}

		if ( $wimplecf_array_fields['e_field_type'] != 'recaptchacode' &&
			$wimplecf_array_fields['e_mandatory_field'] == 'on' &&
		    trim( $wimplecf_field_value ) == "" ) 
        {
			$wimplecf_error_message = 'Error@'.$wimplecf_field_name.'_id<>'.esc_html( $wimplecf_array_fields['e_field_err_msg'] );
			echo $wimplecf_error_message;exit;
		} 
		elseif ( $wimplecf_array_fields['e_field_type'] == 'captchacode' ) // for captch validation
		{
			if ( empty( $_SESSION['captcha_code'] ) || 
			     $_SESSION['captcha_code'] != $wimplecf_field_data[$wimplecf_field_name] )
			{  
				$wimplecf_error_message = 'Error@'.$wimplecf_field_name.'_id<>'.esc_html__( WIMPLECF_VALIDATION_ERROR_CAPTCHA_CODE_FORM, 
			                                      'wimple-contact-form' );		
			echo $wimplecf_error_message;exit;
			}
		}
		elseif ( $wimplecf_array_fields['e_field_type'] == 'recaptchacode' ) // for captch validation
		{
			if(isset($wimplecf_g_recaptcha_varified) && strlen($wimplecf_g_recaptcha_varified)> 0 )
			{
				$wimplecf_recaptcha = $wimplecf_g_recaptcha_varified;
				// post request to server
				$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($wimplecf_google_secret_key) .  '&response=' . urlencode($wimplecf_g_recaptcha_varified);
				$response = file_get_contents($url);
				$responseKeys = json_decode($response,true);
				// if($responseKeys["success"]) 
				// {
					// $wimplecf_error_message .= 'fails';
				// }

			}
			else
			{
				$wimplecf_error_message = 'Error@wimplecf_recaptcha_code_id<>'.esc_html( $wimplecf_array_fields['e_field_err_msg'] );
				echo $wimplecf_error_message;exit;
			}
		}
		elseif ( $wimplecf_array_fields['e_email_field'] == 'on' &&
				 trim( $wimplecf_field_value ) != "" &&
				 ( !filter_var( $wimplecf_field_value, FILTER_VALIDATE_EMAIL ) ||
					strchr( $wimplecf_field_value, '..' ) ) ) 
        {
			$wimplecf_error_message = 'Error@'.$wimplecf_field_name.'_id<>'.esc_html( $wimplecf_array_fields['e_field_err_msg'] );
			echo $wimplecf_error_message;exit;
		}
			
        
		if( $wimplecf_array_fields['e_field_type'] != 'captchacode' && 
			$wimplecf_array_fields['e_field_type'] != 'recaptchacode' && 
			$wimplecf_array_fields['e_field_type'] != 'note' )
		{
			$wimplecf_arr[$wimplecf_i] = array( 'e_label_name' => $wimplecf_label_name,
												'e_field_value' => $wimplecf_field_value );
		}
		$wimplecf_field_value = '';
		$wimplecf_i++;
	}

   //user submits form successfully
    if ( $wimplecf_error_message == '' ) 
    {
        $wimplecf_user_details = serialize( $wimplecf_arr );
        $wimplecf_ip_address   = $_SERVER["REMOTE_ADDR"];
          
		$wimplecf_sql = $wpdb->prepare( "INSERT INTO ".$wimplecf_contact_userdetails." ( 
										 form_id,
										 user_details, 
										 ip_address, 
										 sent_date )
										 VALUES ( 
										 %d, 
										 %s, 
										 %s, 
										 %s 
										 )",
										 $wimplecf_form_id, 
										 $wimplecf_user_details, 
										 $wimplecf_ip_address, 
										 date('Y-m-d H:i:s' ) ); 
										 
		$wpdb->get_results( $wimplecf_sql );
        
		$wimplecf_sender_email 	 = $wimplecf_mail_from;
		$wimplecf_receiver_email = $wimplecf_mail_to;
		$wimplecf_subject 		 = $wimplecf_mail_subject;
  
		$wimplecf_mail_body = '<table border="1" cellspacing="0" cellpadding="0" width="70%" style="background: #fff; border-collapse: collapse; border: 1px #ccc solid; font-family: Arial,Open Sans,sans-serif; font-size: 15px;">
								<tbody>
								<tr>
									<td style="border: 1px #ccc solid; padding: 10px; font-weight: bold; text-align: left; font-size: 18px; background: #e5e5e5;">'.esc_html__( WIMPLECF_MAIL_BODY_TEXT_FORM, 'wimple-contact-form' ).'<i>'.esc_html( $wimplecf_form_name ).'</i></td>
								</tr>
								<tr>
									<td>
										<table border="0" cellspacing="0" cellpadding="0" width="100%" style="font-family: Arial,Open Sans,sans-serif; font-size: 15px;">';  
										foreach ( $wimplecf_arr as $wimplecf_s_arr ) 
										{
											$wimplecf_mail_body .= '<tr><td style="border-bottom: 1px #ccc solid; border-right: 1px #ccc solid; padding: 10px;" width="30%"> <strong> '.esc_html( $wimplecf_s_arr['e_label_name'] ).'</strong></td>';
											$wimplecf_mail_body .= '<td style="border-bottom: 1px #ccc solid; padding: 10px;" width="70%">'.esc_html( $wimplecf_s_arr['e_field_value'] ).'</td></tr>';
										}
										$wimplecf_mail_body .= '</table></td></tr>
										<tr><td style="border: 1px #ccc solid; padding: 10px;"><strong>Date &amp; Time: '.esc_html( $wimplecf_date ).'</strong></td></tr>
									</tbody></table>';
						
						
		if ( $wimplecf_smtp_setup == 'wimplecf_amazon_ses_mailer' )
		{
			if ( defined( 'WIMPLECF_AWS_SES_ENDPOINT' ) ) 
			{
				$wimplecf_amazon_host = WIMPLECF_AWS_SES_ENDPOINT;
			}
			
			if ( defined( 'WIMPLECF_AWS_SES_ACCESS_KEY' ) ) 
			{
				$wimplecf_amazon_accesskey = WIMPLECF_AWS_SES_ACCESS_KEY;
			}
			
			if ( defined( 'WIMPLECF_AWS_SES_SECRET_ACCESS_KEY' ) ) 
			{
				$wimplecf_amazon_secretaccesskey = WIMPLECF_AWS_SES_SECRET_ACCESS_KEY;
			}
			
			include( plugin_dir_path( WIMPLECF_PLUGIN ) . 'ses/function.php');
	
			$wimplecf_amazon_host_arr = array();
			$wimplecf_amazon_host_arr = explode( '.', $wimplecf_amazon_host );
			$wimplecf_amazon_region   = $wimplecf_amazon_host_arr[1];

			$wimplecf_arrParameters = [	'AccessKey' 		=> $wimplecf_amazon_accesskey,
										'SecretKey' 		=> $wimplecf_amazon_secretaccesskey,
										'Region' 			=> $wimplecf_amazon_region,
										'From' 				=> $wimplecf_sender_email,
										'To' 				=> [$wimplecf_receiver_email],
										'Subject' 			=> $wimplecf_subject,
										'Html'				=> $wimplecf_mail_body ];
										
			sendEmailToSes($wimplecf_arrParameters);
		}
		elseif( $wimplecf_smtp_setup == 'wimplecf_sendgrid_api_mailer' )
		{
			if ( defined( 'WIMPLECF_SENDGRID_API' ) ) 
			{
				$wimplecf_sendgrid_api = WIMPLECF_SENDGRID_API;
			}
			
			include( plugin_dir_path( WIMPLECF_PLUGIN ) . 'sendgrid/sendgrid-php.php');

			$wimplecf_email = new \SendGrid\Mail\Mail();
			$wimplecf_email->setFrom($wimplecf_sender_email);
			$wimplecf_email->addTo($wimplecf_receiver_email);
			$wimplecf_email->setSubject($wimplecf_subject);
			$wimplecf_email->addContent( "text/html", $wimplecf_mail_body );

			$apiKey = ($wimplecf_sendgrid_api);
			$sendgrid = new \SendGrid($apiKey);

			$sendgrid->send($wimplecf_email);
		}
		else
		{
			if ( $wimplecf_smtp_OS == 'wimplecf_windows_value' )
			{
				if ( defined( 'WIMPLECF_SMTP_SERVER_ADDRESS' ) ) 
				{
					$wimplecf_serveraddress	= WIMPLECF_SMTP_SERVER_ADDRESS;
				}
				
				if ( defined( 'WIMPLECF_SMTP_SERVER_PORT' ) ) 
				{
					$wimplecf_serverport = WIMPLECF_SMTP_SERVER_PORT;
				}
				
				if ( defined( 'WIMPLECF_SMTP_USER_EMAIL_ID' ) ) 
				{
					$wimplecf_smtpusername = WIMPLECF_SMTP_USER_EMAIL_ID;
				}
				
				if ( defined( 'WIMPLECF_SMTP_PASSWORD' ) ) 
				{
					$wimplecf_smtppassword = WIMPLECF_SMTP_PASSWORD;
				}
			

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
				$wimplecf_mail->isSMTP();                                	// Set mailer to use SMTP
				$wimplecf_mail->Host 	   = $wimplecf_serveraddress;    	// Specify main and backup SMTP servers
				$wimplecf_mail->SMTPAuth   = true;                         	// Enable SMTP authentication
				$wimplecf_mail->Username   = $wimplecf_smtpusername;     	// SMTP username
				$wimplecf_mail->Password   = $wimplecf_smtppassword;      	// SMTP password
				$wimplecf_mail->SMTPSecure = 'tls';                      	// Enable TLS encryption, `ssl` also accepted
				$wimplecf_mail->Port 	   = $wimplecf_serverport;        	// TCP port to connect

				//Recipients
				$wimplecf_mail->setFrom( $wimplecf_sender_email );       	// Add sender
				$wimplecf_mail->addAddress( $wimplecf_receiver_email );     // Add a recipient, Name is optional

				//Content
				$wimplecf_mail->isHTML( true );                             // Set email format to HTML
				$wimplecf_mail->Subject = $wimplecf_subject;
				$wimplecf_mail->Body 	= $wimplecf_mail_body;
				$wimplecf_mail->send(); 
			}
			else
			{
				$wimplecf_headers  = "MIME-Version: 1.0\r\n";
				$wimplecf_headers .= "Content-type: text/html; charset=UTF-8\r\n";
				$wimplecf_headers .= "From: <".$wimplecf_sender_email. ">" ;
				
				mail( $wimplecf_receiver_email, 
				      $wimplecf_subject, 
					  $wimplecf_mail_body, 
					  $wimplecf_headers );
			}
		}
	
        echo $wimplecf_success_msg .= 'Success@'.esc_html__( WIMPLECF_MSG_SUCCESS_SUBMIT_FIRST_FORM, 
		                                     'wimple-contact-form' );
    }

?>
