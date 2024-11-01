<?php 
#######################################################################################
# Plugin Name: WIMPLE Contact Form                                                	  #
# Author: SARANGSoft (Email: wp-contact@sarangsoft.com, Web: https://sarangsoft.com)  #
# File Name: add_forms.php															  #
# Purpose: Create / add and edit form.                                   			  #
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

?>

<div class="wimplecf_centered"></div>
<div class="wimplecf_wrap">

<?php


global $wpdb;
$wimplecf_captcha_enable  = '';
wp_enqueue_style( 'my_css_dsslider', 
                   esc_url( 
				   plugins_url( 'class-admin/css/add_form.css', 
								 WIMPLECF_PLUGIN ) ) );  

include( plugin_dir_path( WIMPLECF_PLUGIN ) . 'class-admin/include/form_query.php');

//initialising array for captcha field and setting its key value pair
$wimplecf_captcha_bit 	= array( WIMPLECF_CAPTCHALENGTH_OPTION_VALUE_6_ADD_FORM => WIMPLECF_CAPTCHALENGTH_OPTION_6_ADD_FORM,
								 WIMPLECF_CAPTCHALENGTH_OPTION_VALUE_8_ADD_FORM => WIMPLECF_CAPTCHALENGTH_OPTION_8_ADD_FORM );

if ( isset( $wimplecf_form_captcha_char ) && 
     $wimplecf_form_captcha_char != '' )
{
	$wimplecf_current_capbit_in_array = array();
	$wimplecf_current_capbit_in_array = array( $wimplecf_form_captcha_char => $wimplecf_captcha_bit[$wimplecf_form_captcha_char] );

	unset( $wimplecf_captcha_bit[$wimplecf_form_captcha_char] );
	$wimplecf_final_captcha_array = $wimplecf_current_capbit_in_array + $wimplecf_captcha_bit;
}
else if ( isset( $wimplecf_no_captcha_char ) && 
		  $wimplecf_no_captcha_char != '' )
{
	$wimplecf_current_capbit_in_array = array();
	$wimplecf_current_capbit_in_array = array($wimplecf_no_captcha_char => $wimplecf_captcha_bit[$wimplecf_no_captcha_char]);

	unset( $wimplecf_captcha_bit[$wimplecf_no_captcha_char] );
	$wimplecf_final_captcha_array = $wimplecf_current_capbit_in_array + $wimplecf_captcha_bit;
}


//initialising array for theme field and setting its key value pair
$wimplecf_theme = array( WIMPLECF_THEME_OPTION_VALUE_THEME0 => WIMPLECF_THEME_OPTION_THEME0_ADD_FORM,
						 WIMPLECF_THEME_OPTION_VALUE_THEME1 => WIMPLECF_THEME_OPTION_THEME1_ADD_FORM,
						 WIMPLECF_THEME_OPTION_VALUE_THEME2 => WIMPLECF_THEME_OPTION_THEME2_ADD_FORM,
						 WIMPLECF_THEME_OPTION_VALUE_THEME3 => WIMPLECF_THEME_OPTION_THEME3_ADD_FORM,
						 WIMPLECF_THEME_OPTION_VALUE_THEME4 => WIMPLECF_THEME_OPTION_THEME4_ADD_FORM,
						 WIMPLECF_THEME_OPTION_VALUE_THEME5 => WIMPLECF_THEME_OPTION_THEME5_ADD_FORM );
				
if ( isset( $wimplecf_form_theme ) && 
			$wimplecf_form_theme != '' )
{
	$wimplecf_current_theme_in_array = array();
	$wimplecf_current_theme_in_array = array( $wimplecf_form_theme => $wimplecf_theme[$wimplecf_form_theme] );

	unset( $wimplecf_theme[$wimplecf_form_theme] );
	$wimplecf_final_theme_array = array_merge( $wimplecf_current_theme_in_array , $wimplecf_theme );
}
else if ( isset( $wimplecf_selected_theme ) && 
          $wimplecf_selected_theme != '' )
{
	$wimplecf_current_theme_in_array = array();
	$wimplecf_current_theme_in_array = array( $wimplecf_selected_theme => $wimplecf_theme[$wimplecf_selected_theme] );

	unset( $wimplecf_theme[$wimplecf_selected_theme] );
	$wimplecf_final_theme_array = array_merge( $wimplecf_current_theme_in_array , $wimplecf_theme );	
}

$wimplecf_form_status_array = array( '1' => WIMPLECF_STATUS_ACTIVE,
									 '0' => WIMPLECF_STATUS_INACTIVE );
						
if ( isset( $wimplecf_form_status ) && 
	 ( $wimplecf_form_status != '' || 
	   $wimplecf_form_status == '0' ) )
{
	$wimplecf_current_status_in_array = array();
	$wimplecf_current_status_in_array = array( $wimplecf_form_status => $wimplecf_form_status_array[$wimplecf_form_status] );

	unset( $wimplecf_form_status_array[$wimplecf_form_status] );
	$wimplecf_final_status_array = $wimplecf_current_status_in_array + $wimplecf_form_status_array ;
	
}
else if ( isset( $wimplecf_status ) && 
		  ( $wimplecf_status != '' || 
			$wimplecf_status == '0' ) )
{
	$wimplecf_current_status_in_array = array();
	$wimplecf_current_status_in_array = array( $wimplecf_status => $wimplecf_form_status_array[$wimplecf_status] );
	
	unset( $wimplecf_form_status_array[$wimplecf_status] );
	$wimplecf_final_status_array = $wimplecf_current_status_in_array + $wimplecf_form_status_array ;	
}						

?>
<div>
	<h2>
	<?php 

	//page title for add new form and edit form page
	if ( $wimplecf_current_form_id == true ) 
	{
		echo '<b>'.esc_html__( WIMPLECF_PAGE_HEADING_EDIT_ADD_FORM, 'wimple-contact-form' ). 
		     '<i>'.' '. esc_html( $wimplecf_current_form_name ) . 
			 '</i><br />
			 <span class="wimplecf_header">
			 '.esc_html__(  WIMPLECF_PAGE_SUBHEADING_EDIT_ADD_FORM, 'wimple-contact-form' ). 
			 '</span>
			 </b>';   
	}
	else 
	{
		echo '<b>'.esc_html__( WIMPLECF_PAGE_HEADING_NEWFORM_ADD_FORM, 'wimple-contact-form' ). 
		     '<br />
		     <span class="wimplecf_header">
			 '.esc_html__( WIMPLECF_PAGE_SUBHEADING_NEWFORM_ADD_FORM, 'wimple-contact-form' ). 
			 '</span>
			 </b>';
	}
	?>
	</h2>

    <form name="wimplecf_add_form" method="post" action="">
        <div class="wimplecf_section_title">
			<?php echo esc_html__( WIMPLECF_SECTION_HEADING_FORMDETAILS_ADD_FORM, 'wimple-contact-form' );?>
		</div>
        <table border="0" 
		       cellspacing="0" 
			   cellpadding="0" 
			   class="wimplecf_left_table" 
			   style="width: 100%;">
            <tr>
                <td class="wimplecf_text_class">
					<?php echo esc_html__( WIMPLECF_LABEL_FORMNAME_ADD_FORM, 'wimple-contact-form' );?>
                    <span class="wimplecf_mandatory_field">*</span>
                </td>
				<td class="wimplecf_field_class">
					<input type="text" 
					       name="wimplecf_form_name" 
						   id="wimplecf_frm_name" 
						   placeholder="max 50 characters" 
						   maxlength="50" 
						   size="80" 
						   style="font-size:14px; height: 35px;"
						   value="<?php 
									if ( isset( $wimplecf_form_name ) )
									{
										echo  esc_attr( $wimplecf_form_name );
									}
									elseif ( isset( $wimplecf_current_form_name ) )
									{
										echo esc_attr( $wimplecf_current_form_name );
									}
									?>" />
									
					<span class="wimplecf_display_name_frontend">
						<input type="checkbox" 
						       id="wimplecf_display_name" 
							   name="wimplecf_display_name" 
							   value="yes" 
						       <?php 
						       if ( isset( $wimplecf_display_form_name ) && 
									$wimplecf_display_form_name == 'yes' || 
									isset( $wimplecf_display_current_form_name ) && 
									$wimplecf_display_current_form_name == 'yes' ) 
								{   
									echo 'checked="checked"';
								} 
								?>>
									
						<?php echo esc_html__( WIMPLECF_CHECKBOX_DISPLAY_FRONTEND_ADD_FORM, 'wimple-contact-form' ); ?>
					</span>
				</td>
            </tr>
            <?php
            if( isset( $wimplecf_name_err ) && 
			    $wimplecf_name_err != '' ) 
            {
            ?>
                <tr>
                    <td class="wimplecf_text_class">&nbsp;</td>
                    <td class="wimplecf_error_message"><?php echo esc_html( $wimplecf_name_err );?></td>
                </tr>  
            <?php
            }
			else
			{
			?>
				<tr id="wimplecf_display_name_not_appear" style="display: none;">
					<td class="wimplecf_text_class">&nbsp;</td>
					<td class="wimplecf_help">
						<?php echo esc_html__( WIMPLECF_MSG_DISPLAY_FRONTEND_UNCHECKED_ADD_FORM, 'wimple-contact-form' );?>
					</td>
				</tr>

			
				<tr id="wimplecf_display_name_help" style="display: none;">
					<td class="wimplecf_text_class">&nbsp;</td>
					<td class="wimplecf_help">
						<?php echo esc_html__( WIMPLECF_MSG_DISPLAY_FRONTEND_CHECKED_ADD_FORM, 'wimple-contact-form' );?>
					</td>
				</tr>
			<?php
			}
            ?>
            
            <tr>
                <td height="10px"></td>
            </tr>
			
			<tr>
                <td class="wimplecf_text_class">
					<?php echo esc_html__( WIMPLECF_LABEL_FORMBUTTON_ADD_FORM, 'wimple-contact-form' );?>
                    <span class="wimplecf_mandatory_field">*</span>
                </td>
				<td class="wimplecf_field_class">
					<input type="text" 
					       name="wimplecf_form_button_label" 
						   id="wimplecf_form_button_label" 
						   placeholder="max 10 characters" 
						   maxlength="10" 
						   size="25" 
						   style="font-size:14px; height: 35px;"
						   value="<?php 
									if ( isset( $wimplecf_form_button_label ) )
									{
										echo  esc_attr( $wimplecf_form_button_label );
									}
									elseif ( isset( $wimplecf_current_form_button_label ) )
									{
										echo esc_attr( $wimplecf_current_form_button_label );
									}
									else
									{
										echo 'Submit';
									}
									?>" />
				</td>
            </tr>
			 <?php
            if( isset( $wimplecf_form_button_label_err ) && 
			    $wimplecf_form_button_label_err != '' ) 
            {
            ?>
                <tr>
                    <td class="wimplecf_text_class">&nbsp;</td>
                    <td class="wimplecf_error_message"><?php echo esc_html( $wimplecf_form_button_label_err );?></td>
                </tr>  
            <?php
            }
			else
			{
			?>
			<tr id="">
				<td class="wimplecf_text_class">&nbsp;</td>
				<td class="wimplecf_help">
					<?php echo esc_html__( WIMPLECF_MSG_FORMBUTTON_ADD_FORM, 'wimple-contact-form' );?>
				</td>
			</tr>
			<?php } ?>

			<tr>
                <td height="10px"></td>
            </tr>
			
            <tr>
                <td class="wimplecf_text_class">
					<?php echo esc_html__( WIMPLECF_LABEL_THEME_ADD_FORM, 'wimple-contact-form' );?>
				</td>
                <td class="wimplecf_field_class">
                    <select class="wimplecf_cat_select_class" 
						    name="wimplecf_form_theme"  
							value="">
							<?php
							if ( isset ( $wimplecf_final_theme_array ) && 
								 $wimplecf_final_theme_array != '' ) 
							{
								foreach ( $wimplecf_final_theme_array as $key => $value )
								{
									echo '<option value="'.esc_attr( $key ).'">'.esc_html( $value ).'</option>';
								}
							} 
							else 
							{
								foreach ( $wimplecf_theme as $key => $value )
								{
									echo '<option value="'.esc_attr( $key ).'">'.esc_html( $value ).'</option>';
								}
							}
							?>
                    </select>
                    <br />
                    <span class="wimplecf_help">
                        <?php echo esc_html__( WIMPLECF_MSG_THEME_ADD_FORM, 'wimple-contact-form' );?>
                    </span>
                </td>
            </tr>
                
            <tr>
                <td height="15px"></td>
            </tr>
                
            <tr>
                <td class="wimplecf_text_class">
					<?php echo esc_html__( WIMPLECF_LABEL_STATUS_ADD_FORM, 'wimple-contact-form' );?>
				</td>
                <td class="wimplecf_field_class">
                    <select class="wimplecf_cat_select_class" 
						    name="wimplecf_form_status"  
                            value="">
                        <?php
							if ( isset ( $wimplecf_final_status_array ) && 
								 $wimplecf_final_status_array != '' ) 
							{
								foreach ( $wimplecf_final_status_array as $key => $value )
								{
									echo '<option value="'.esc_attr( $key ).'">'.esc_html( $value ).'</option>';
								}
							} 
							else 
							{
								foreach ( $wimplecf_form_status_array as $key => $value )
								{
									echo '<option value="'.esc_attr( $key ).'">'.esc_html( $value ).'</option>';
								}
							}
							?>
                    </select>
					<br />
					<span class="wimplecf_help">
						<?php echo esc_html__( WIMPLECF_MSG_STATUS_ADD_FORM, 'wimple-contact-form' );?>
					</span>
                </td>
            </tr> 
                
            <tr>
                <td height="20px"></td>
            </tr>
                
            <tr>
                <td>
                    <div class="wimplecf_section_title">
						<?php echo esc_html__( WIMPLECF_SECTION_HEADING_EMAILSETUP_ADD_FORM, 'wimple-contact-form' );?>
					</div>
                    <table style="width:100%;" cellpadding="0" cellspacing="0">
                        <tbody>                          
                            <tr>
                                <td class="wimplecf_text_class">
									<?php echo esc_html__( WIMPLECF_LABEL_SENDER_ADD_FORM, 'wimple-contact-form' );?>
                                    <span class="wimplecf_mandatory_field">*</span>
                                </td>
								<td class="wimplecf_field_class">
									<input type="text" 
										   name="wimplecf_mail_from" 
										   id="wimplecf_mail_from" 
										   class="wimplecf_input"
										   value="<?php 
													
													if ( isset( $wimplecf_form_mail_from ) )
													{
														echo esc_attr( $wimplecf_form_mail_from);
													}
													elseif ( isset( $wimplecf_mail_from ) && 
															 $wimplecf_mail_from != '' )   
													{
														echo esc_attr( $wimplecf_mail_from );
													} 
													else
													{
														echo esc_attr( $wimplecf_usermail );
													}
													?>">
								</td>
                            </tr>
                            <?php 
                            if ( isset( $wimplecf_email_from_err ) && 
							     $wimplecf_email_from_err !='' ) 
                            { 
                            ?>
								<tr>
									<td class="wimplecf_text_class">&nbsp;</td>
									<td class="wimplecf_error_message">
										<?php echo esc_html( $wimplecf_email_from_err );?>
									</td>
								</tr>  
                            <?php
                            }
							else
							{
							?>
								<tr>
								<td class="wimplecf_text_class">&nbsp;</td>
								<td class="wimplecf_help">
									<?php echo esc_html__( WIMPLECF_MSG_SENDER_ADD_FORM, 'wimple-contact-form' );?>
								</td>
								</tr>  
							<?php    
							}
							?>

                            <tr>
                                <td height="10px"></td>
                            </tr>

							<tr>
								<td class="wimplecf_text_class">
									<?php echo esc_html__( WIMPLECF_LABEL_RECIPIENT_ADD_FORM, 'wimple-contact-form' );?>
									<span class="wimplecf_mandatory_field">*</span>
								</td>
								<td class="wimplecf_field_class">
									<input type="text" 
									       name="wimplecf_mail_to" 
										   id="wimplecf_mail_to"  
										   class="wimplecf_input"
										   value="<?php 
													if( isset( $wimplecf_form_mail_to ) )
													{
														echo esc_attr( $wimplecf_form_mail_to );
													}
													elseif ( isset( $wimplecf_mail_to ) && 
													         $wimplecf_mail_to != ''  ) 
													{
														echo esc_attr( $wimplecf_mail_to );
													}
													else
													{
														echo esc_attr( $wimplecf_usermail );
													}
													?>">
								</td>
							</tr>
                            <?php
                            if ( isset( $wimplecf_email_to_err ) && 
							     $wimplecf_email_to_err != '' )
                            { 
                            ?>
								<tr>
									<td class="wimplecf_text_class">&nbsp;</td>
									<td class="wimplecf_error_message">
										<?php echo esc_html( $wimplecf_email_to_err ); ?>
									</td>
								</tr>
                            <?php 
                            }
							else
							{
							?>
								<tr>
									<td class="wimplecf_text_class">&nbsp;</td>
									<td class="wimplecf_help">
									<?php echo esc_html__( WIMPLECF_MSG_RECIPIENT_ADD_FORM, 'wimple-contact-form' );?>
									</td>
								</tr>  

							<?php    
							}
							?>
                            
                            <tr>
                                <td height="10px"></td>
                            </tr>							
                            
							<tr>
								<td class="wimplecf_text_class">
									<?php echo esc_html__( WIMPLECF_LABEL_SUBJECT_ADD_FORM, 'wimple-contact-form' );?>
									<span class="wimplecf_mandatory_field">*</span>
								</td>
								<td class="wimplecf_field_class">
									<input type="text" 
										   name="wimplecf_mail_subject" 
										   id="wimplecf_mail_subject" 
										   placeholder="max 80 characters" 
										   maxlength="80" 
										   class="wimplecf_input"
										   value="<?php 
													if ( isset( $wimplecf_form_mail_subject ) )
													{
														echo  esc_attr( $wimplecf_form_mail_subject );
													}
													elseif ( isset( $wimplecf_mail_subject ) )
													{                        
														echo esc_attr( $wimplecf_mail_subject );
													}
													?>">
								</td>
							</tr>
                            <?php
                            if ( isset( $wimplecf_email_sub_err ) && 
							     $wimplecf_email_sub_err != '' ) 
                            { 
                            ?>
                                <tr>
                                    <td class="wimplecf_text_class">&nbsp;</td>
                                    <td class="wimplecf_error_message">
										<?php echo esc_html( $wimplecf_email_sub_err );?>
									</td>
                                </tr>  
                            <?php 
                            }
							else
							{
							?>
								<tr>
									<td class="wimplecf_text_class">&nbsp;</td>
									<td class="wimplecf_help">
										<?php echo esc_html__( WIMPLECF_MSG_SUBJECT_ADD_FORM, 'wimple-contact-form' );?>
									</td>
								</tr>  
							<?php    
							}
							?>
                            
                            <tr>
                                <td height="10px"></td>
                            </tr>
							
                            <tr>
                                <td class="wimplecf_option_class">
									<?php echo esc_html__( WIMPLECF_LABEL_MAIL_SETTING_ADD_FORM, 'wimple-contact-form' );?>
								</td>
								
                                <td class="wimplecf_field_class">
									<input type="hidden" 
										   name="selected_mailer" 
										   value="<?php 
													if ( isset( $wimplecf_form_smtp_mailer ) )
													{
														echo esc_attr( $wimplecf_form_smtp_mailer );
													}
													elseif ( isset( $wimplecf_smtp_mailer ) )
													{
														echo esc_attr( $wimplecf_smtp_mailer );
													}
													?>">
                                    <select class="wimplecf_cat_select_class" name="wimplecf_mail_server_selection" id="wimplecf_mail_server_selection">
										 <option value="wimplecf_amazon_ses_mailer"><?php echo esc_html__( WIMPLECF_RADIOBUTTON_AWS_SES_ADD_FORM, 'wimple-contact-form' ); ?></option>
										 <option value="wimplecf_default_php_mailer"><?php echo esc_html__( WIMPLECF_RADIOBUTTON_DEFAULT_PHP_ADD_FORM, 'wimple-contact-form' ); ?></option>
										 <option value="wimplecf_sendgrid_api_mailer"><?php echo esc_html__( WIMPLECF_RADIOBUTTON_SENDGRID_ADD_FORM, 'wimple-contact-form' ); ?></option>
									</select>
								</td>
                            </tr>
                            
                            <?php
                            if ( isset( $wimplecf_form_smtp_mailer_err ) && 
							     $wimplecf_form_smtp_mailer_err != '' ) 
                            { 
                            ?>
                                <tr>
                                    <td class="wimplecf_text_class">&nbsp;</td>
                                    <td class="wimplecf_error_message">
										<?php echo esc_html( $wimplecf_form_smtp_mailer_err );?>
									</td>
                                </tr>  
                            <?php 
                            } 
                            ?>
                            
                            <tr>
                                <td class="wimplecf_text_class">&nbsp;</td>
                                <td class="wimplecf_field_class">
                                    <div id="wimplecf_default_php_mailer" class="wimplecf_mailer_class">
                                    
									    <div class="wimplecf_select_os">
											
											<input type="hidden" 
											name="selected_os" 
											value="<?php 
													if ( isset( $wimplecf_form_phpmail_os ) )
													{
														echo esc_attr( $wimplecf_form_phpmail_os );
													}
													elseif ( isset( $wimplecf_selected_os ) )
													{
														echo esc_attr( $wimplecf_selected_os );
													}
													?>">
													
                                            <input type="radio" name="wimplecf_phpmail_os" value="wimplecf_linux_value"> 
											<span class="wimplecf_linux_windows">
											<?php echo esc_html__( WIMPLECF_RADIOBUTTON_DEFAULT_PHP_FOR_LINUX_ADD_FORM, 'wimple-contact-form' ); ?>
											</span>
											
                                            <input type="radio" name="wimplecf_phpmail_os" value="wimplecf_windows_value"> 
											<span class="wimplecf_linux_windows">
											<?php echo esc_html__( WIMPLECF_RADIOBUTTON_DEFAULT_PHP_FOR_WINDOWS_ADD_FORM, 'wimple-contact-form' ); ?>
											</span>
										</div>
										<?php
										if ( isset( $wimplecf_form_server_os_err ) && 
										     $wimplecf_form_server_os_err != '' ) 
										{ 
										?>
											<div class="wimplecf_error_message">
												<?php echo esc_html( $wimplecf_form_server_os_err );?>
											</div>
										<?php 
										} 
										?>
									   
										<div class="wimplecf_default_php_config" id="wimplecf_linux_value">
											<?php echo WIMPLECF_MSG_DEFAULT_PHP_ADD_FORM; ?>
											<input class="wimplecf_ste-button-primary button-primary wimplecf_popFrmBtn" 
													id="wimplecf_default_php_test" 
													type="button" 
													value="Send Test Email"/>
										</div>
											   
										<div class="wimplecf_default_php_config" id="wimplecf_windows_value">
											<?php echo WIMPLECF_MSG_PHP_MAILER_ADD_FORM; ?>
											
											<div class="wimplecf_copyclip">
												<?php echo WIMPLECF_OTHER_SMTP_INSTRUCTION_ADD_FORM; ?>
												   
												 
												<ul id="div2">
												<li>define( 'WIMPLECF_SMTP_SERVER_ADDRESS', 'SMTP Server Address' );</li>
												<li>define( 'WIMPLECF_SMTP_SERVER_PORT', 'Port Number' );</li>
												<li>define( 'WIMPLECF_SMTP_USER_EMAIL_ID', 'User Email Id' );</li>
												<li>define( 'WIMPLECF_SMTP_PASSWORD', 'Password' );</li>
												</ul>
												
												<?php 
												if( ( defined( 'WIMPLECF_SMTP_SERVER_ADDRESS' ) && 
													  ( WIMPLECF_SMTP_SERVER_ADDRESS != '' &&
													    WIMPLECF_SMTP_SERVER_ADDRESS != WIMPLECF_DEFAULT_PLACEHOLDER_SERVER_ADDRESS_ADD_FORM ) ) &&
													( defined( 'WIMPLECF_SMTP_SERVER_PORT' ) && 
													  ( WIMPLECF_SMTP_SERVER_PORT != '' &&
													    WIMPLECF_SMTP_SERVER_PORT != WIMPLECF_DEFAULT_PLACEHOLDER_SERVER_PORT_ADD_FORM ) ) &&
													( defined( 'WIMPLECF_SMTP_USER_EMAIL_ID' ) && 
													  ( WIMPLECF_SMTP_USER_EMAIL_ID != '' &&
													    WIMPLECF_SMTP_USER_EMAIL_ID != WIMPLECF_DEFAULT_PLACEHOLDER_SMTP_USERNAME_ADD_FORM ) ) &&
													( defined( 'WIMPLECF_SMTP_PASSWORD' ) &&
													  ( WIMPLECF_SMTP_PASSWORD != '' &&
													    WIMPLECF_SMTP_PASSWORD != WIMPLECF_DEFAULT_PLACEHOLDER_SMTP_PASSWORD_ADD_FORM ) ) )
												{
													echo '<button class="wimplecf_alreadydefined" type="button" disabled>
														 <span class="">
														 '.esc_html__( WIMPLECF_BUTTON_COPY_CODE_ADD_FORM, 'wimple-contact-form' ).
														 '</span>
														 </button>
														 <span class="wimplecf_button_inactive">
														 '.esc_html__( WIMPLECF_OTHER_MSG_DEFINED_ADD_FORM, 'wimple-contact-form' ).
														 '</span>';
												}
												else
												{
												?>
													<div class="wimplecf_copy_code">
														<div id="wimplecf_othersmtp_copied" class="wimplecf_email_sepup_copied_msg"></div>
														<button class="btn" type="button" onclick="wimplecf_OtherSMTPInfosToClipboard('div2')">
														<span>
														<?php echo esc_html__( WIMPLECF_BUTTON_COPY_CODE_ADD_FORM, 'wimple-contact-form' ); ?>
														</span>
														</button>
													</div>
												<?php
												}
												?>
													
												<div id="wimplecf_othersmtp_not_defined" class="wimplecf_values_not_set_in_config">
													<?php
													if( isset( $wimplecf_other_smtp_config_err ) && 
													    $wimplecf_other_smtp_config_err != '' )
													{
														echo esc_html( $wimplecf_other_smtp_config_err );
													}
													?>
												</div>
										
												<p class="wimplecf_mailsetupnote">
                                                   <?php echo WIMPLECF_NOTE_COPY_CODE_ADD_FORM; ?> 
                                                </p>
                                             </div>
											
											
											<input class="wimplecf_ste-button-primary button-primary wimplecf_popFrmBtn" 
												   id="wimplecf_phpmailer_test" 
												   type="button" 
												   value="Send Test Email"/>
										</div>
											   
										<div class="wimplecf_mailSendingInfo wimplecf_mailSendingInfoDisabled">
											<?php echo esc_html__( WIMPLECF_CONFIRMATION_MAIL_RECEIVED_ADD_FORM, 'wimple-contact-form' ); ?>
											<input id="wimplecf_iDDisabledSpl" 
											       class="button button-primary wimplecf_confirmJsClick wimplecf_jsCls" 
												   name="wimplecf_mailreceived" 
											       type="button" 
												   value="Yes"/>
												   
											<input id="wimplecf_iDDisabledSpl" 
											       class="button button-primary wimplecf_jsCls" 
												   type="button" 
												   value="No"/>
                                        </div>
                                    </div>
                                    
                                    <div id="wimplecf_amazon_ses_mailer" class="wimplecf_mailer_class">
										<?php echo WIMPLECF_MSG_AWS_SES_ADD_FORM; ?>
										<form>
											<div class="wimplecf_copyclip">
												<?php echo WIMPLECF_AWS_SES_INSTRUCTION_ADD_FORM; ?>
												 
												 
												 
                                                <ul id="div1">
                                                    <li>define( 'WIMPLECF_AWS_SES_ENDPOINT', 'AWS Endpoint' );</li>
                                                    <li>define( 'WIMPLECF_AWS_SES_ACCESS_KEY', 'AWS Access key (20 chars)' );</li>
                                                    <li>define( 'WIMPLECF_AWS_SES_SECRET_ACCESS_KEY', 'AWS Secret Access key (40 chars)' );</li>
                                                </ul>
												
												<?php 
												if( ( defined( 'WIMPLECF_AWS_SES_ENDPOINT' ) &&
													  ( WIMPLECF_AWS_SES_ENDPOINT != '' &&
													    WIMPLECF_AWS_SES_ENDPOINT != WIMPLECF_DEFAULT_PLACEHOLDER_ENDPOINT_ADD_FORM ) ) &&
													( defined( 'WIMPLECF_AWS_SES_ACCESS_KEY' ) && 
													  ( WIMPLECF_AWS_SES_ACCESS_KEY != '' &&
													    WIMPLECF_AWS_SES_ACCESS_KEY != WIMPLECF_DEFAULT_PLACEHOLDER_ACCESS_KEY_ADD_FORM ) ) &&
													( defined( 'WIMPLECF_AWS_SES_SECRET_ACCESS_KEY' ) &&
													  ( WIMPLECF_AWS_SES_SECRET_ACCESS_KEY != '' &&
													    WIMPLECF_AWS_SES_SECRET_ACCESS_KEY != WIMPLECF_DEFAULT_PLACEHOLDER_SECRET_ACCESS_KEY_ADD_FORM ) ) )
												{
													echo '<button class="wimplecf_alreadydefined" type="button" disabled>
													     <span class="">
														 '.esc_html__( WIMPLECF_BUTTON_COPY_CODE_ADD_FORM, 'wimple-contact-form' ).
														 '</span>
														 </button>
													     <span class="wimplecf_button_inactive">
														 '.esc_html__( WIMPLECF_AWS_MSG_DEFINED_ADD_FORM, 'wimple-contact-form' ).
														 '</span>';
												}
												else
												{
												?>
													<div class="wimplecf_copy_code">
														<div id="wimplecf_awsses_copied" class="wimplecf_email_sepup_copied_msg"></div>
														<button class="btn" type="button" onclick="wimplecf_AWSInfosToClipboard('div1')">
														<span><?php echo WIMPLECF_BUTTON_COPY_CODE_ADD_FORM; ?></span>
														</button>
													</div>    
												<?php
												}
												?>
											
												<div id="wimplecf_awsses_not_defined" class="wimplecf_values_not_set_in_config">
													<?php
													if( isset( $wimplecf_aws_ses_config_err ) && 
														$wimplecf_aws_ses_config_err != '' )
													{
														echo esc_html( $wimplecf_aws_ses_config_err );
													}
													?>
												</div>
												<p class="wimplecf_mailsetupnote">
													<?php echo WIMPLECF_NOTE_COPY_CODE_ADD_FORM; ?>  
												</p>
											</div>
                                            <input class="wimplecf_ste-button-primary button-primary wimplecf_popFrmBtn"
   											       id="wimplecf_amazon_ses_test" 
												   type="button" 
											       value="<?php echo esc_attr( WIMPLECF_BUTTON_SEND_TEST_EMAIL_ADD_FORM, 'wimple-contact-form' ) ?>"/>
                                                   
                                            
                                            <div class="wimplecf_mailSendingInfo wimplecf_mailSendingInfoDisabled">
											
												<?php echo esc_html__( WIMPLECF_CONFIRMATION_MAIL_RECEIVED_ADD_FORM, 'wimple-contact-form' ); ?>
											
												<input id="wimplecf_iDDisabledSpl" 
												       class="button button-primary wimplecf_confirmJsClick wimplecf_jsCls" 
													   name="wimplecf_mailreceived" 
													   type="button" 
												       value="<?php echo esc_attr( WIMPLECF_BUTTON_YES_ADD_FORM, 'wimple-contact-form' ) ?>">
                                            
												<input id="wimplecf_iDDisabledSpl" 
												       class="button button-primary wimplecf_jsCls"  
													   type="button" 
												       value="<?php echo esc_attr( WIMPLECF_BUTTON_NO_ADD_FORM, 'wimple-contact-form' ) ?>">
                                            </div>
                                            
                                        </form>
                                    </div>
                                    
                                <div id="wimplecf_sendgrid_api_mailer" class="wimplecf_mailer_class">
										<?php echo WIMPLECF_MSG_SENDGRID_ADD_FORM; ?>
										<?php echo WIMPLECF_MSG_SENDGRID_FOR_WINDOWS_ADD_FORM; ?>
										<form>
											<div class="wimplecf_copyclip">
												<?php echo WIMPLECF_SENDGRID_INSTRUCTION_ADD_FORM; ?>
												 <span id="div3" class="wimplecf_wsa">define( 'WIMPLECF_SENDGRID_API', 'SendGrid API Key' );</span>             
												<?php 
												if( ( defined( 'WIMPLECF_SENDGRID_API' ) &&
													  ( WIMPLECF_SENDGRID_API != '' &&
													    WIMPLECF_SENDGRID_API != WIMPLECF_DEFAULT_PLACEHOLDER_SENDGRID_API_ADD_FORM ) ) )
												{
													echo '<button class="wimplecf_alreadydefined" type="button" disabled>
													     <span class="">
														 '.esc_html__( WIMPLECF_BUTTON_COPY_CODE_ADD_FORM, 'wimple-contact-form' ).
														 '</span>
														 </button>
													     <span class="wimplecf_button_inactive">
														 '.esc_html__( WIMPLECF_SENDGRID_MSG_DEFINED_ADD_FORM, 'wimple-contact-form' ).
														 '</span>';
												}
												else
												{
												?>
													<div class="wimplecf_copy_code">
														<div id="wimplecf_sendgrid_copied" class="wimplecf_email_sepup_copied_msg"></div>
														<button class="btn" type="button" onclick="wimplecf_SendgridToClipboard('div3')">
														<span><?php echo WIMPLECF_BUTTON_COPY_CODE_ADD_FORM; ?></span>
														</button>
													</div>    
												<?php
												}
												?>
											
												<div id="wimplecf_sendgrid_not_defined" class="wimplecf_values_not_set_in_config">
													<?php
													if( isset( $wimplecf_aws_ses_config_err ) && 
														$wimplecf_aws_ses_config_err != '' )
													{
														echo esc_html( $wimplecf_aws_ses_config_err );
													}
													?>
												</div>
												<p class="wimplecf_mailsetupnote">
													<?php echo WIMPLECF_NOTE_COPY_CODE_ADD_FORM; ?>  
												</p>
											</div>
                                            <input class="wimplecf_ste-button-primary button-primary wimplecf_popFrmBtn"
   											       id="wimplecf_sendgridapi_test" 
												   type="button" 
											       value="<?php echo esc_attr( WIMPLECF_BUTTON_SEND_TEST_EMAIL_ADD_FORM, 'wimple-contact-form' ) ?>"/>
                                                   
                                            
                                            <div class="wimplecf_mailSendingInfo wimplecf_mailSendingInfoDisabled">
											
												<?php echo esc_html__( WIMPLECF_CONFIRMATION_MAIL_RECEIVED_ADD_FORM, 'wimple-contact-form' ); ?>
											
												<input id="wimplecf_iDDisabledSpl" 
												       class="button button-primary wimplecf_confirmJsClick wimplecf_jsCls" 
													   name="wimplecf_mailreceived" 
													   type="button" 
												       value="<?php echo esc_attr( WIMPLECF_BUTTON_YES_ADD_FORM, 'wimple-contact-form' ) ?>">
                                            
												<input id="wimplecf_iDDisabledSpl" 
												       class="button button-primary wimplecf_jsCls"  
													   type="button" 
												       value="<?php echo esc_attr( WIMPLECF_BUTTON_NO_ADD_FORM, 'wimple-contact-form' ) ?>">
                                            </div>
                                            
                                        </form>
                                    </div>
									
									
									
									</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr> 
			
			<tr>
                <td height="65px">
				 <?php echo WIMPLECF_MSG_SPF_DKIM_ADD_FORM; ?>
                  
					<div class="wimplecf_mailSendingStatus">
                        <?php echo esc_html__( WIMPLECF_MSG_NOTE_ADD_FORM, 'wimple-contact-form' ); ?>
					</div>
                </td>
            </tr>
			<tr class="wimplecf_submit_successMsg">
                <td><?php 
					if ( $wimplecf_current_form_id == true ) 
					{
						echo esc_html__( WIMPLECF_MSG_FORM_UPDATE_ADD_FORM, 'wimple-contact-form' );
					}
					else
					{
						echo esc_html__( WIMPLECF_MSG_FORM_SAVE_ADD_FORM, 'wimple-contact-form' );
					}
					?></td>
             </tr>
            <input type="hidden" 
			       id="wimplecf_mailreceivedvalue" 
				   name="wimplecf_mailreceivedvalue" 
				   value="<?php 
							if ( isset( $wimplecf_test_mail_received)) 
							{
								echo esc_attr( $wimplecf_test_mail_received );
							}
							?>">
            <tr class="wimplecf_submit">
                <td>
                    <input type="submit" 
					       name="wimplecf_form_submit" 
						   id="wimplecf_form_submit" 
						   class="wimplecf_save_button_primary button-primary" 
						   style="width: 80px;" 
						   value="<?php echo esc_attr( WIMPLECF_BUTTON_SAVE, 'wimple-contact-form'); ?>"/>
                </td>
             </tr>
             
             
        </table>
    </form>
</div>
</div>

<script>
function wimplecf_AWSInfosToClipboard(containerid) 
{
	document.getElementById("wimplecf_awsses_not_defined").innerHTML = "";
	if (window.getSelection) 
	{
		var range = document.createRange();
		range.selectNode(document.getElementById(containerid));		
		window.getSelection().removeAllRanges();
		window.getSelection().addRange(range);
		document.execCommand("copy");
		document.getElementById("wimplecf_awsses_copied").innerHTML = "Text has been copied";
	}
}

function wimplecf_OtherSMTPInfosToClipboard(containerid) 
{
	document.getElementById("wimplecf_othersmtp_not_defined").innerHTML = "";
	if (window.getSelection) 
	{
		var range = document.createRange();
		range.selectNode(document.getElementById(containerid));
		window.getSelection().removeAllRanges();
		window.getSelection().addRange(range);
		document.execCommand("copy");
		document.getElementById("wimplecf_othersmtp_copied").innerHTML = "Text has been copied";
	}
}

function wimplecf_SendgridToClipboard(containerid) 
{
	document.getElementById("wimplecf_sendgrid_not_defined").innerHTML = "";
	if (window.getSelection) 
	{
		var range = document.createRange();
		range.selectNode(document.getElementById(containerid));		
		window.getSelection().removeAllRanges();
		window.getSelection().addRange(range);
		document.execCommand("copy");
		document.getElementById("wimplecf_sendgrid_copied").innerHTML = "Text has been copied";
	}
}
</script>



<script type="text/javascript">
jQuery( document ).ready( function( $ )
{
	if ( $( "#wimplecf_display_name" ).is( ":checked" ))
	{
		$( '#wimplecf_display_name_help' ).show( );
	}
	else
	{
		$( '#wimplecf_display_name_not_appear' ).show( );
	}
	
	$( "#wimplecf_display_name" ).click( function()
	{
	    if ( $( this ).is( ":checked" ) )
	    {
			$( '#wimplecf_display_name_help' ).show( );
			$( '#wimplecf_display_name_not_appear' ).hide( );
	    }
	    else
	    {
			$( '#wimplecf_display_name_not_appear' ).show( );
			$( '#wimplecf_display_name_help' ).hide( );
	    }
	} );	
} );
</script>

<script type="text/javascript">
jQuery( document ).ready( function( $ )
{
	$( '.wimplecf_popClickInfo' ).click( function( event )
	{
		$(this).next().show();
		$( '.wimplecf_centered' ).show();
		event.preventDefault();
	} );
	
	$( '.wimplecf_popClose' ).click( function( event )
	{
		$( '.wimplecf_popClickInfoCntnr > div' ).hide();
		$( '.wimplecf_popClickInfoCntnr-box > div' ).hide();
		$( '.wimplecf_centered' ).hide();
		event.preventDefault();
	} );
	
	
	$('.wimplecf_mailSendingInfo input').prop('disabled', true);
	
    if ( $( "input[name$='wimplecf_mailreceivedvalue']" ).val() == 'Yes' )
	{
		$( '.wimplecf_mailSendingStatus' ).hide();  
	}
        
	$( '.wimplecf_confirmJsClick' ).click( function( )
	{
		$( '.wimplecf_mailSendingStatus' ).hide();
        $( "#wimplecf_mailreceivedvalue" ).val( $( "input[name$='wimplecf_mailreceived']" ).val());
                
	} );
	
	$( '.wimplecf_field_class input[type="radio"]' ).click( function( )
	{
		$( '.wimplecf_mailSendingStatus' ).show();
        $( "#wimplecf_mailreceivedvalue" ).val(' ');
		
		$( '.wimplecf_mailSendingInfo' ).find( 'input' ).prop( 'disabled', true );
		$( '.wimplecf_mailSendingInfo' ).addClass( 'wimplecf_mailSendingInfoDisabled' );
		$( '.wimplecf_jsCls' ).attr( 'id', 'wimplecf_iDDisabledSpl' );
	});

});

</script>

<script>    
jQuery(document).ready( function( $ )
{
    $( "div.wimplecf_mailer_class" ).hide();
	var onloadselectedmailer = $( "input[name$='selected_mailer']" ).val(); 
	
	if ( onloadselectedmailer == '' || onloadselectedmailer == 'wimplecf_amazon_ses_mailer' )
    {
        var wimplecf_mailersmtp_type_index = '0';
    }
	else if ( onloadselectedmailer == 'wimplecf_default_php_mailer' )
	{
		var wimplecf_mailersmtp_type_index = '1';
	}
	else if ( onloadselectedmailer == 'wimplecf_sendgrid_api_mailer' )
	{
		var wimplecf_mailersmtp_type_index = '2';
	}
	
	$( "#wimplecf_mail_server_selection" ).prop( "selectedIndex", wimplecf_mailersmtp_type_index );

	
    var selectedmailer = $( "#wimplecf_mail_server_selection" ).val();
    $( "#" + selectedmailer ).show();
    $( "#wimplecf_mail_server_selection" ).change( function( )
    {
        var mailerval = $(this).val();
        $( "div.wimplecf_mailer_class" ).hide();
        $( "#" + mailerval ).show();
		
		$( '.wimplecf_mailSendingInfo' ).find( 'input' ).prop( 'disabled', true );
		$( '.wimplecf_mailSendingInfo' ).addClass( 'wimplecf_mailSendingInfoDisabled' );
		$( '.wimplecf_jsCls' ).attr( 'id', 'wimplecf_iDDisabledSpl' );
		
    } );
	
	$( "div.wimplecf_default_php_config" ).hide();
	var onloadselected_os = $( "input[name$='selected_os']" ).val();
	if ( onloadselected_os == '' )
    {
        $( 'input:radio[name="wimplecf_phpmail_os"]' ).filter( '[value="wimplecf_linux_value"]' ).attr( 'checked', true );
    }
	else
	{
		$( 'input:radio[name="wimplecf_phpmail_os"]' ).filter( '[value='+onloadselected_os+']' ).attr( 'checked', true );
	}
	var selectedos = $( "input[type=radio][name='wimplecf_phpmail_os']:checked" ).val();
    $( "#" + selectedos ).show();
	$( "input[name$='wimplecf_phpmail_os']" ).click( function( )
    {
        var osselected = $(this).val();
        $( "div.wimplecf_default_php_config" ).hide();
        $( "#" + osselected ).show();
    } );
	
} );  
</script>

<?php
add_action( 'admin_footer', 'wimplecf_default_mailer_javascript');
function wimplecf_default_mailer_javascript() { ?> 
	<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		var emailvalidfationrule = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		$( '#wimplecf_default_php_test' ).click( function( )
		{
			var wimplecf_recipient_mail = $( '#wimplecf_mail_to' ).val();
			var wimplecf_sender_mail 	= $( '#wimplecf_mail_from' ).val();
			var wimplecf_mail_subject 	= $( '#wimplecf_mail_subject' ).val();
			
			if ( emailvalidfationrule.test(wimplecf_sender_mail) == false  )
			{
				alert('Please enter valid sender\'s email id.');
			}
			else if ( emailvalidfationrule.test(wimplecf_recipient_mail) == false )
			{
				alert('Please enter valid recipient\'s email id.');
			}
			else if ( wimplecf_mail_subject == '' )
			{
				alert('Please enter subject line which will be presented as the subject line for user\'s feedback email.');
			}
			else
			{
				var data = 
				{
					'action': 'wimplecf_default_mailer',
					'wimplecf_recipient_mail':wimplecf_recipient_mail,
					'wimplecf_sender_mail':wimplecf_sender_mail,
					'wimplecf_mail_subject':wimplecf_mail_subject
				};

				jQuery.post(ajaxurl, data, function(response) 
				{
					$( '.wimplecf_mailSendingInfo' ).find( 'input' ).prop( 'disabled', false ).removeAttr( 'id' );
					$( '.wimplecf_mailSendingInfo' ).removeClass( 'wimplecf_mailSendingInfoDisabled' );
				});	
			}				
		});
		
	});
	</script>
<?php }

add_action( 'admin_footer', 'wimplecf_phpmailer_javascript');
function wimplecf_phpmailer_javascript() { ?> 
	<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		$( '#wimplecf_phpmailer_test' ).click( function( )
		{
			var emailvalidfationrule = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			$('#wimplecf_othersmtp_copied').html('');
			
			var wimplecf_recipient_mail = $( '#wimplecf_mail_to' ).val();
			var wimplecf_sender_mail 	= $( '#wimplecf_mail_from' ).val();
			var wimplecf_mail_subject 	= $( '#wimplecf_mail_subject' ).val();
			
			if ( emailvalidfationrule.test(wimplecf_sender_mail) == false  )
			{
				alert('Please enter valid sender\'s email id.');
			}
			else if ( emailvalidfationrule.test(wimplecf_recipient_mail) == false )
			{
				alert('Please enter valid recipient\'s email id.');
			}
			else if ( wimplecf_mail_subject == '' )
			{
				alert('Please enter subject line which will be presented as the subject line for user\'s feedback email.');
			}
			else
			{
				var data = 
				{
					'action': 'wimplecf_phpmailer',
					'wimplecf_recipient_mail':wimplecf_recipient_mail,
					'wimplecf_sender_mail':wimplecf_sender_mail,
					'wimplecf_mail_subject':wimplecf_mail_subject
				};
			
				jQuery.post(ajaxurl, data, function(response) 
				{
					var wimplecf_retrun = response.split(':');
					if ( wimplecf_retrun[0] == 'wimplecf_error' )
					{
						$("#wimplecf_othersmtp_not_defined").html(wimplecf_retrun[1]);
					}
					else
					{				
						$( '.wimplecf_mailSendingInfo' ).find( 'input' ).prop( 'disabled', false ).removeAttr( 'id' );
						$( '.wimplecf_mailSendingInfo' ).removeClass( 'wimplecf_mailSendingInfoDisabled' );
					}
				});	
			}			
		});
		
	});
	</script>
<?php }

add_action( 'admin_footer', 'wimplecf_amazonses_javascript' );

function wimplecf_amazonses_javascript() { ?>
	<script type="text/javascript" >
	jQuery(document).ready(function($)
	{
		var emailvalidfationrule = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		$( '#wimplecf_amazon_ses_test' ).click( function( )
		{
			$('#wimplecf_awsses_copied').html('');
			var wimplecf_recipient_mail = $( '#wimplecf_mail_to' ).val();
			var wimplecf_sender_mail 	= $( '#wimplecf_mail_from' ).val();
			var wimplecf_mail_subject 	= $( '#wimplecf_mail_subject' ).val();
			
			if ( emailvalidfationrule.test(wimplecf_sender_mail) == false  )
			{
				alert('Please enter valid sender\'s email id.');
			}
			else if ( emailvalidfationrule.test(wimplecf_recipient_mail) == false )
			{
				alert('Please enter valid recipient\'s email id.');
			}
			else if ( wimplecf_mail_subject == '' )
			{
				alert('Please enter subject line which will be presented as the subject line for user\'s feedback email.');
			}
			else
			{
				var data = 
				{
					'action': 'wimplecf_amazonses',
					'wimplecf_recipient_mail':wimplecf_recipient_mail,
					'wimplecf_sender_mail':wimplecf_sender_mail,
					'wimplecf_mail_subject':wimplecf_mail_subject
				};

				jQuery.post(ajaxurl, data, function(response) 
				{
					var wimplecf_retrun = response.split(':');
					if ( wimplecf_retrun[0] == 'wimplecf_error' )
					{
						$("#wimplecf_awsses_not_defined").html(wimplecf_retrun[1]);
					}
					else
					{				
						$( '.wimplecf_mailSendingInfo' ).find( 'input' ).prop( 'disabled', false ).removeAttr( 'id' );
						$( '.wimplecf_mailSendingInfo' ).removeClass( 'wimplecf_mailSendingInfoDisabled' );
					}
					
				});
			}
		});
	});
	</script> 
<?php
}

add_action( 'admin_footer', 'wimplecf_sendgrid_javascript');
function wimplecf_sendgrid_javascript() { ?> 
	<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		var emailvalidfationrule = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		$( '#wimplecf_sendgridapi_test' ).click( function( )
		{
			$('#wimplecf_sendgrid_copied').html('');
			var wimplecf_recipient_mail = $( '#wimplecf_mail_to' ).val();
			var wimplecf_sender_mail 	= $( '#wimplecf_mail_from' ).val();
			var wimplecf_mail_subject 	= $( '#wimplecf_mail_subject' ).val();
			if ( emailvalidfationrule.test(wimplecf_sender_mail) == false  )
			{
				alert('Please enter valid sender\'s email id.');
			}
			else if ( emailvalidfationrule.test(wimplecf_recipient_mail) == false )
			{
				alert('Please enter valid recipient\'s email id.');
			}
			else if ( wimplecf_mail_subject == '' )
			{
				alert('Please enter subject line which will be presented as the subject line for user\'s feedback email.');
			}
			else
			{
				var data = 
				{
					'action': 'wimplecf_sendgrid',
					'wimplecf_recipient_mail':wimplecf_recipient_mail,
					'wimplecf_sender_mail':wimplecf_sender_mail,
					'wimplecf_mail_subject':wimplecf_mail_subject
				};
				
				jQuery.post(ajaxurl, data, function(response) 
				{
					var wimplecf_retrun = response.split(':');
					if ( wimplecf_retrun[0] == 'wimplecf_error' )
					{
						$("#wimplecf_sendgrid_not_defined").html(wimplecf_retrun[1]);
					}
					else
					{				
						$( '.wimplecf_mailSendingInfo' ).find( 'input' ).prop( 'disabled', false ).removeAttr( 'id' );
						$( '.wimplecf_mailSendingInfo' ).removeClass( 'wimplecf_mailSendingInfoDisabled' );
					}
				});	
			}				
		});
		
	});
	</script>
<?php }
?>
