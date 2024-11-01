<?php
#######################################################################################
# Plugin Name: WIMPLE Contact Form                                                	  #
# Author: SARANGSoft (Email: wp-contact@sarangsoft.com, Web: https://sarangsoft.com)  #
# File Name: add_form_fields.php													  #
# Purpose: Create / add and edit fields of a form.                                    #
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
wp_register_script( 'wimplecf_bootstrap', 
					esc_url( 
						plugins_url( 'class-admin/js/bootstrap.min.js', WIMPLECF_PLUGIN ) ));

wp_enqueue_script('wimplecf_bootstrap');


if ( defined( 'WIMPLECF_GOOGLE_SITE_KEY' ) ) 
{
	$wimplecf_google_site_key = WIMPLECF_GOOGLE_SITE_KEY;
}
if ( defined( 'WIMPLECF_GOOGLE_SECRET_KEY' ) ) 
{
	$wimplecf_google_secret_key = WIMPLECF_GOOGLE_SECRET_KEY;
}

wp_enqueue_style( 'form_field_create', 
				   esc_url( 
				        plugins_url( 'class-admin/css/field/style.css', WIMPLECF_PLUGIN ) ) );
								
include( plugin_dir_path( WIMPLECF_PLUGIN ) . 'class-admin/include/field_query.php');


$wimplecf_back_link = admin_url( 'admin.php?page=newcontactform&edit_id='.$wimplecf_current_form_id.'&status=edit' );
									  
?>
<input type="hidden" id="wimplecf_file_url" value="<?php echo esc_attr( plugin_dir_url( __FILE__ ) ); ?>">

<input type="hidden" id="wimplecf_next_row_num" value="<?php echo esc_attr( $wimplecf_next_row_num ); ?>">
<input type="hidden" id="wimplecf_current_form" value="<?php echo esc_attr( $wimplecf_current_form_id ); ?>">
<input type="hidden" id="wimplecf_current_form_name" value="<?php echo esc_attr( $wimplecf_form_name ); ?>">
<input type="hidden" id="wimplecf_edit_mode" value="">
<input type="hidden" id="wimplecf_first_value" value="">
<input type="hidden" id="wimplecf_edited_row_number" value="">
<input type="hidden" id="wimplecf_page_current_status" value="<?php echo esc_attr__( "DB_UPDATE_NONE", 'wimple-contact-form' ); ?>">

<div class="wimplecf_wrap">

	<form action="" method="post">
		<header>
			<div class="wimplecf_top_bar_title">
				<div class="wimplecf_top_button">
					<a href="<?php echo esc_url( $wimplecf_back_link ); ?>" id="wiplecf_go_previous_page" 
					   class="btn btn-default btn-main wimplecf_go_back" data-toggle="modal">
						<?php echo esc_html__( 'Back', 'wimple-contact-form' );?>
					</a> 
						
					<button type="submit" name="wimplecf_form_submit" class="btn btn-default btn-main">
						<?php echo esc_html__( 'Save', 'wimple-contact-form' );?>
					</button>
					
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=wimplecontactform') ); ?>" id="wiplecf_go_first_page" 
						class="btn btn-default btn-main wimplecf_go_back" data-toggle="modal">
						<?php echo esc_html__( 'Exit', 'wimple-contact-form' );?>
					</a>  
				</div>
				<h2><?php echo 'Form Layout - <i>'.$wimplecf_form_name.'</i>'; ?></h2>
			</div>
		</header>
			
	<!-- Start Content Section ==================================================-->
		<section>
			<div class="wimplecf_content_sec">
				<!-- Left Sec -->
				<div class="wimplecf_left_sec">
				<div id="wimplecf_left_first">
				
					<div class="wimplecf_left_inner_block">
						<a href="javascript:void(0)" class="wimplecf_help_icon" id="wimplecf_generic_information" data-toggle="modal" data-target="#popupHelp">
							<span class="tooltipTxt"><?php echo esc_html__( 'Help', 'wimple-contact-form' );?></span> 
							<?php echo '<img src="'.esc_url( plugins_url( 'class-admin/images/help-icon.png', WIMPLECF_PLUGIN ) ). '" alt="" >';?>
						</a>
						<h2><?php echo esc_html__( WIMPLECF_PAGE_SUBHEADING1_ADD_FORM_FIELD, 'wimple-contact-form' );?></h2>
						
						<div class="form-group row">
							<div class="col-sm-12">
								<label class="col-form-label wimplecf_left_fix_label">
									<?php echo esc_html__( WIMPLECF_LABEL_FIELD_TYPE_ADD_FORM_FIELD, 'wimple-contact-form' );?>
								</label>
								<select class="form-control" 
								name="wimplecf_type" 
								id="wimplecf_field_type" 
								value="">
								<?php
								echo '<option value="'.esc_attr__( "text", 'wimple-contact-form' ).'">
									 '.esc_html__( "Single-line Text", 'wimple-contact-form' ).
									 '</option>
									 <option value="'.esc_attr__( "textarea", 'wimple-contact-form' ).'">
									 '.esc_html__( "Multi-line Text", 'wimple-contact-form' ).
									 '</option>
									 <option value="'.esc_attr__( "selectbox", 'wimple-contact-form' ).'">
									 '.esc_html__( "Dropdown List", 'wimple-contact-form' ).
									 '</option>
									 <option value="'.esc_attr__( "multiselectcheckbox", 'wimple-contact-form' ).'">
									 '.esc_html__( "Multi-select Dropdown with Checkbox", 'wimple-contact-form' ).
									 '</option>
									 <option value="'.esc_attr__( "checkbox", 'wimple-contact-form' ).'">
									 '.esc_html__( "Checkbox", 'wimple-contact-form' ).
									 '</option>
									 <option value="'.esc_attr__( "radiobutton", 'wimple-contact-form' ).'">
									 '.esc_html__( "Radio Button", 'wimple-contact-form' ).
									 '</option>
									  <option value="'.esc_attr__( "note", 'wimple-contact-form' ).'">
									 '.esc_html__( "Note", 'wimple-contact-form' ).
									 '</option>
									 <option value="'.esc_attr__( "date", 'wimple-contact-form' ).'">
									 '.esc_html__( "Date", 'wimple-contact-form' ).
									 '</option>
									 <option value="'.esc_attr__( "captchacode", 'wimple-contact-form' ).'">
									 '.esc_html__( "CAPTCHA", 'wimple-contact-form' ).
									 '</option> 
									 <option value="'.esc_attr__( "recaptchacode", 'wimple-contact-form' ).'">
									 '.esc_html__( "reCAPTCHA", 'wimple-contact-form' ).
									 '</option>';
								?>
								</select>
								<span class="wimplecf_error_message" id="wimplecf_error_field_type"></span>
							</div>
						</div>
						
						<div class="form-group row">
							<div class="col-sm-12">
								<label class="col-form-label wimplecf_left_fix_label">
									<?php echo esc_html__( WIMPLECF_LABEL_FIELD_NAME_ADD_FORM_FIELD, 'wimple-contact-form' );?>
								</label>
								<input type="text" class="form-control" name="wimplecf_label_name" 
									   placeholder="" maxlength="50" id="wimplecf_label_name" 
									   value="">
								<span class="wimplecf_error_message" id="wimplecf_error_name"></span>
							</div>
						</div>
						
						<div class="form-group row" id="wimplecf_typevalue" style="display:none">
							<div class="col-sm-12">
								<label class="col-form-label wimplecf_left_fix_label">
									<?php echo esc_html__( WIMPLECF_LABEL_OPTION_ADD_FORM_FIELD, 'wimple-contact-form' );?>
								</label>
								<input type="text" 
									   id="wimplecf_type_value" 
									   name="wimplecf_type_value"
									   class="form-control"
									   placeholder="Enter the possible option names separated by pipe (|) (required)"
									   value="">
								<span class="wimplecf_error_message" id="wimplecf_error_options"></span>
							</div>
						</div>
						
						
						<div class="form-group row" id="wimplecf_notetext_block" style="display:none">
							<div class="col-sm-12">
								<label class="col-form-label wimplecf_left_fix_label">
									<?php echo esc_html__( WIMPLECF_LABEL_NOTETEXT_ADD_FORM_FIELD, 'wimple-contact-form' );?>
								</label>
								<?php 
								$wimplecf_content = "Maximum 500 characters";
								$wimplecf_editor_id = "wimplecf_note_text";
								$wimplecf_editor_name = "wimplecf_note_text";
								$wimplecf_args = array( 'media_buttons' => false, 					// Removes the media button.
														'textarea_name' => $wimplecf_editor_name, 	// Set custom name.
														'quicktags' => false, 						// Remove view as HTML button.
														);
								wp_editor( $wimplecf_content, $wimplecf_editor_id, $wimplecf_args );											  
								?>
								
								<span class="wimplecf_error_message" id="wimplecf_error_notetext"></span>
							</div>
						</div>
						
						<div class="form-group row" id="wimplecf_charlimit">
							<div class="col-sm-12">
								<label class="col-form-label wimplecf_left_fix_label">
									<?php echo esc_html__( WIMPLECF_LABEL_CHAR_LIMIT_ADD_FORM_FIELD, 'wimple-contact-form' );?>
								</label>
								<input type="text" 
									   id="wimplecf_char_limit" 
									   name="wimplecf_char_limit"
									   class="form-control" 
									   placeholder="Numeric only (required)"
									   value="">
								<span class="wimplecf_error_message" id="wimplecf_error_charlimit"></span>
							</div>
						</div>
						
						<div class="form-group row wimplecf_date_left_sec" id="wimplecf_dateformat_block" style="display:none">
							<div class="col-sm-12">
								<label class="col-form-label wimplecf_left_fix_label">
									<?php echo esc_html__( WIMPLECF_LABEL_DATE_FORMAT_ADD_FORM_FIELD, 'wimple-contact-form' );?>
								</label>
								<div class="wimplecf_date_select">
									<select class="form-control" 
											name="wimplecf_dateformatlist" 
											id="wimplecf_dateformatlist" 
											value="">
									<?php
									echo '<option value="'.esc_attr__( "M dd, yy", 'wimple-contact-form' ).'">
										 '.esc_html__( "M dd, yy - Jan 01, 2022", 'wimple-contact-form' ).
										 '</option>
										 <option value="'.esc_attr__( "dd/mm/yy", 'wimple-contact-form' ).'">
										 '.esc_html__( "dd/mm/yy - 01/01/2022", 'wimple-contact-form' ).
										 '</option>
										 <option value="'.esc_attr__( "yy/mm/dd", 'wimple-contact-form' ).'">
										 '.esc_html__( "yy/mm/dd - 2022/01/01", 'wimple-contact-form' ).
										 '</option>
										 <option value="'.esc_attr__( "yy-mm-dd", 'wimple-contact-form' ).'">
										 '.esc_html__( "yy-mm-dd - 2022-01-01", 'wimple-contact-form' ).
										 '</option>
										 <option value="'.esc_attr__( "dd-mm-yy", 'wimple-contact-form' ).'">
										 '.esc_html__( "dd-mm-yy - 01-01-2022", 'wimple-contact-form' ).
										 '</option>
										 <option value="'.esc_attr__( "dd M, yy", 'wimple-contact-form' ).'">
										 '.esc_html__( "dd M, yy - 01 Jan, 2022", 'wimple-contact-form' ).
										 '</option>
										  <option value="'.esc_attr__( "dd. M. yy", 'wimple-contact-form' ).'">
										 '.esc_html__( "dd. M. yy - 01. Jan. 2022", 'wimple-contact-form' ).
										 '</option>
										 <option value="'.esc_attr__( "dd MM yy", 'wimple-contact-form' ).'">
										 '.esc_html__( "dd MM yy - 01 January 2022", 'wimple-contact-form' ).
										 '</option>';
									?>
									</select>
								</div>
								
								<div class="wimplecf_date_upperlimit">
									<label class="col-form-label">
										Upper Limit (year)
									</label>								
									<select  class="form-control" 
											 name="wimplecf_dateupperlimit" 
											 id="wimplecf_dateupperlimit" 
											 value="">
										<?php 
										PHP_EOL;
										for ( $i = date("Y")+78; $i >= date("Y")-22; $i-- )
										{
											echo '<option value="' . esc_attr__( $i ) . '">' . esc_html__( $i ). '</option>';
											PHP_EOL;
										}
										?>
									</select>
								</div>
							</div>
						</div>
						
						<div class="form-group row wimplecf_captcha_left_sec" id="wimplecf_captchablock" style="display:none">
							<div class="col-sm-12">
								<div class="wimplecf_captcha_lenth">
									<label class="col-form-label">
										<?php echo esc_html__( WIMPLECF_LABEL_CAPTCHA_LENGTH_ADD_FORM_FIELD, 'wimple-contact-form' );?>
									</label>
									<select name="wimplecf_captcha_length" id="wimplecf_captcha_length" class="form-control">
										<option value="6">6</option>
										<option value="8">8</option>
									</select>
								</div>
							</div>
						</div>
						
						<div class="form-group row wimplecf_captcha_left_sec" id="wimplecf_recaptchablock"  style="display:none">
							<div class="col-sm-12">
								<div class="col-sm-2 wimplecf_recaptcha_leftbox"></div>
								<div class="col-sm-10 wimplecf_recaptcha_rightbox">																			
									<div class="wimplecf_copyclip_recaptcha">
										<p>To use Google reCAPTCHA you need to take the following steps.</p>								   
										<ol class="wimplecf_howtocreateapis">
											<li>Create your Google API keys (
												<a href="javascript:void(0)" class="wimplecf_popClickInfo" id="wimplecf_reCaptcha_get_keys" data-toggle="modal" data-target="#recaptchapopupHelp">click for details
													<div class="wimplecf_overflow modal fade popup_box popup_help " id="recaptchapopupHelp" style="position:absolute">
														<div class="wimplecf_popClickInfoCntnr">
															<div class="wimplecf_recaptcha_helppop" id="wimplecf_reCaptcha_get_keys_help">
																<div>
																	<h2>Please do the following steps to complete the process.</h2>
																	<a title="Close" href="#" class="wimplecf_popClose"></a>
																	<hr>
																	<ol>
																		<li>Go to https://www.google.com/recaptcha.</li>
																		<li>Click Admin Console.</li>
																		<li>Enter a label for your ReCaptcha and select the V2 checkbox.</li>
																		<li>Add the URL for your site in the Domain section.</li>
																		<li>Accept the terms of service and click Submit. </li>
																		<li>Now simply copy the Site Key and Secret Key that Google generates.</li>															
																	</ol>
																</div>							
															</div>
														</div>
													</div>
												</a>
											)</li>
											<li>Please copy the following  two (2) lines of code,
												 add those in  your wp-config.php file, and replace 
												 the placeholder values with your own 
												 ( for  Google Site Key and Google Secret Key ) created in step 1 above.</li>
										</ol>
										 
										<ul id="wimplecf_google_apis">
											<li>define( 'WIMPLECF_GOOGLE_SITE_KEY', 'Google Site Key' );</li>
											<li>define( 'WIMPLECF_GOOGLE_SECRET_KEY', 'Google Secret Key' );</li>
										</ul>
										
										<div class="wimplecf_succescopy" id="wimplecf_googleapis_copied">Text has been copied</div>
										
										<?php 
										if( ( defined( 'WIMPLECF_GOOGLE_SITE_KEY' ) &&
											( WIMPLECF_GOOGLE_SITE_KEY != '' &&
											WIMPLECF_GOOGLE_SITE_KEY != WIMPLECF_DEFAULT_PLACEHOLDER_G_SITE_KEY_ADD_FORM_FIELD ) ) &&
											( defined( 'WIMPLECF_GOOGLE_SECRET_KEY' ) && 
											( WIMPLECF_GOOGLE_SECRET_KEY != '' &&
											WIMPLECF_GOOGLE_SECRET_KEY != WIMPLECF_DEFAULT_PLACEHOLDER_G_SECRET_KEY_ADD_FORM_FIELD ) ) )
										{
											echo '<div class="wimplecf_g_api_copy_btn wimplecf_googleapiscoppied">
												<a id="wimplecf_copycodeinactive" class="">
												<span class="">Copy Code</span>
												</a>
											</div>
											<span class="wimplecf_button_inactive_text">
											Above two lines are already added in wp-config.php file and the placeholder values are replaced.
											</span>';
										}
										else
										{ ?>
											<div class="wimplecf_g_api_copy_btn">
												<a id="wimplecf_clicktocopy" onclick="wimplecf_googleapisToClipboard('wimplecf_google_apis')" >
												<span class="">Copy Code</span>
												</a>
											</div>
										<?php } ?>
										<div id="wimplecf_gapis_not_defined" class="wimplecf_error_message wimplecf_recaptcah_apis_not_set"></div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="clearfix"></div>
						
						<div class="form-group row" id="wimplecf_validation_checklist">						
							<div class="custom-check-radio">
								<div class="wimplecf_checkbox_list">
									<label class="wimplecf_custom_checkbox">
										<?php echo esc_html__( WIMPLECF_LABEL_REQUIRED_ADD_FORM_FIELD, 'wimple-contact-form' );?>
										<input class="wimplecf_check_each_box" name="wimplecf_mandatory" id="wimplecf_mandatory" type="checkbox" >
										<span class="checkmark"></span>
									</label>
								</div>
								
								<div class="wimplecf_checkbox_list" id="wimplecf_emailidrequiredID" >
									<label class="wimplecf_custom_checkbox">
										<?php echo esc_html__( WIMPLECF_LABEL_EMAIL_REQUIRED_ADD_FORM_FIELD, 'wimple-contact-form' );?>
										<input class="wimplecf_check_each_box wimplecf_either_one_check" name="wimplecf_email_validation" id="wimplecf_email_validation" type="checkbox">
										<span class="checkmark"></span>
									</label>
								</div>
								
								<div class="wimplecf_checkbox_list" id="wimplecf_numericonlyID" >
									<label class="wimplecf_custom_checkbox">
										<?php echo esc_html__( WIMPLECF_LABEL_NUMERIC_ONLY_REQUIRED_ADD_FORM_FIELD, 'wimple-contact-form' );?>
										<input class="wimplecf_check_each_box wimplecf_either_one_check" name="wimplecf_numericonly" id="wimplecf_numericonly" type="checkbox">
										<span class="checkmark"></span>
									</label>
								</div>
							</div>	
							
						</div>
					</div>
					 
					<div class="clearfix"></div>
					 
					<div class="wimplecf_left_inner_block">
						<a href="javascript:void(0)" class="wimplecf_help_icon" id="wimplecf_messages" data-toggle="modal" data-target="#popupHelp">
							<span class="tooltipTxt"><?php echo esc_html__( 'Help', 'wimple-contact-form' );?></span> 
							<?php echo '<img src="'.esc_url( plugins_url( 'class-admin/images/help-icon.png', WIMPLECF_PLUGIN ) ). '" alt="" >';?>
						</a>
						<h2><?php echo esc_html__( WIMPLECF_PAGE_SUBHEADING2_ADD_FORM_FIELD, 'wimple-contact-form' );?></h2>
						<div id="wimplecf_placeholder_div" class="form-group row">
							<div class="col-sm-12">
								<label class="col-form-label wimplecf_left_fix_label">
									<?php echo esc_html__( WIMPLECF_LABEL_PROMPT_ADD_FORM_FIELD, 'wimple-contact-form' );?>
								</label>
								<input type="text" class="form-control" name="wimplecf_placeholder" id="wimplecf_placeholder" readonly>
							</div>
						</div>
						
						<div class="form-group row" id="wimplecf_helptext_block">
							<div class="col-sm-12">
								<label class="col-form-label wimplecf_left_fix_label">
									<?php echo esc_html__( WIMPLECF_LABEL_HELP_TEXT_ADD_FORM_FIELD, 'wimple-contact-form' );?>
								</label>
								<input type="text" class="form-control" name="wimplecf_helptext" id="wimplecf_helptext" maxlength="100">
							</div>
						</div>
						
						<div class="form-group row wimplecf_horizental_pos_disable" id="wimplecf_error_input">
							<div class="col-sm-12">
								<label class="col-form-label wimplecf_left_fix_label">
									<?php echo esc_html__( WIMPLECF_LABEL_ERROR_ADD_FORM_FIELD, 'wimple-contact-form' );?>
								</label>
								<input type="text" class="form-control" name="wimplecf_validation_msg" id="wimplecf_validation_msg" value="" maxlength="100">
								<span class="wimplecf_error_message" id="wimplecf_error_validation"></span>
							</div>
						</div>
					</div>
					
					<div class="clearfix"></div>
					
					<div class="wimplecf_left_inner_block">
						<a href="javascript:void(0)" class="wimplecf_help_icon" id="wimplecf_orientation" data-toggle="modal" data-target="#popupHelp">
						<span class="tooltipTxt"><?php echo esc_html__( 'Help', 'wimple-contact-form' );?></span> 
						<?php echo '<img src="'.esc_url( plugins_url( 'class-admin/images/help-icon.png', WIMPLECF_PLUGIN ) ). '" alt="" >';?>
						</a>
						<h2><?php echo esc_html__( WIMPLECF_PAGE_SUBHEADING3_ADD_FORM_FIELD, 'wimple-contact-form' );?></h2>
						<div id="wimplecf_row_wise_cols_display">
						<div class="form-group row left_field_within_form">
						<div class="col-sm-12">
							<label class="col-form-label">
								<?php echo esc_html__( WIMPLECF_LABEL_FIELD_WIDTH_ADD_FORM_FIELD, 'wimple-contact-form' );?>
							</label>
							<select name="wimplecf_field_width" id="wimplecf_field_width" class="form-control">
								<?php
								echo '<option value="'.esc_attr__( "100", 'wimple-contact-form' ).'">
									 '.esc_html__( "100%", 'wimple-contact-form' ).
									 '</option>
									 <option value="'.esc_attr__( "50", 'wimple-contact-form' ).'">
									 '.esc_html__( "50%", 'wimple-contact-form' ).
									 '</option>
									 <option value="'.esc_attr__( "33", 'wimple-contact-form' ).'">
									 '.esc_html__( "33%", 'wimple-contact-form' ).
									 '</option>
									 <option value="'.esc_attr__( "25", 'wimple-contact-form' ).'">
									 '.esc_html__( "25%", 'wimple-contact-form' ).
									 '</option>';
								?>
							</select>
							
							<span class="wimplecf_error_message" id="wimplecf_error_free_width"></span>
						</div>
						</div>
						
						<div class="form-group row wimplecf_left_field_row">
							<div class="col-sm-12">
								<label class="col-form-label">
									<?php echo esc_html__( WIMPLECF_LABEL_SELECT_ROW_ADD_FORM_FIELD, 'wimple-contact-form' );?>
								</label>
								<select name="wimplecf_vertical_pos" id="wimplecf_vertical_pos" class="form-control">
									<?php
									echo '<option value="'.esc_attr__( "wimplecf_vertical_at", 'wimple-contact-form' ).'">
										 '.esc_html__( "On", 'wimple-contact-form' ).
										 '</option>
										 <option value="'.esc_attr__( "wimplecf_vertical_before", 'wimple-contact-form' ).'">
										 '.esc_html__( "Before", 'wimple-contact-form' ).
										 '</option>
										 <option value="'.esc_attr__( "wimplecf_vertical_after", 'wimple-contact-form' ).'">
										 '.esc_html__( "After", 'wimple-contact-form' ).
										 '</option>';
									?>
								</select>
								
								<select name="wimplecf_row_num" id="wimplecf_row_num" class="form-control">
									<?php
									echo '<option value="'.esc_attr__( "wimplecf_newrow", 'wimple-contact-form' ).'">
										 '.esc_html__( "New Row", 'wimple-contact-form' ).
										 '</option>';
										 echo $wimplecf_row_listing;
									?>
								</select>
							</div>
						</div>
						</div>
						
						<div class="form-group row wimplecf_left_within_row">
							<div class="col-sm-12" id="wimplecf_within_row">
								<label class="col-form-label">
									<?php echo esc_html__( WIMPLECF_LABEL_SELECT_COLOMN_FORM_FIELD, 'wimple-contact-form' );?>
								</label>
								<select name="wimplecf_horizental_pos" id="wimplecf_horizental_pos" class="form-control">
									<?php
									echo '<option value="'.esc_attr__( "wimplecf_horizental_left", 'wimple-contact-form' ).'">
										 '.esc_html__( "Left", 'wimple-contact-form' ).
										 '</option>
										 <option value="'.esc_attr__( "wimplecf_horizental_right", 'wimple-contact-form' ).'">
										 '.esc_html__( "Right", 'wimple-contact-form' ).
										 '</option>';
										 ?>
								</select>
								<span><?php echo esc_html__( 'of field', 'wimple-contact-form' );?></span>
								<select name="wimplecf_colomn_num" id="wimplecf_colomn_num" class="form-control">
									<?php
									echo '<option value="'.esc_attr__( "1", 'wimple-contact-form' ).'">
										 '.esc_html__( "First Field", 'wimple-contact-form' ).
										 '</option>';
									?>
								</select>
							</div>
						</div>
					</div>
				</div>
					
				<div class="form-group wimplecf_left_upload_file">
					<button type="button" class="btn btn-default btn-main wimplecf_btn_left_addField" id="wimplecf_addnew_field">
						<?php echo esc_html__( 'Add Field', 'wimple-contact-form' );?>
					</button>
					<button type="button" class="btn btn-default btn-main wimplecf_btn_left_cancel" id="wimplecf_reset_fields">
						<?php echo esc_html__( 'Cancel', 'wimple-contact-form' );?>
					</button>
				</div>
					
				</div>
				<!-- Left Sec -->
				
				<span class="wimplecf_hidden"></span>
				
				<!-- Right Sec-->
				<div class="wimplecf_right_sec">
					<div class="wimplecf_right_inner_sec">
						<input type="hidden" value="<?php echo count($wimplecf_all_field); ?>" id="wimplecf_numberoffieldcreated">
						<input type="hidden" name="hiddendeletedvalus" value="" id="wimplecf_deleted_field_ids">
						<div class="wimplecf_form_content">
						<?php
						$wimplecf_numItems = count($wimplecf_all_field);
						if($wimplecf_numItems > 0)
						{
							$wimplecf_i = 0;
							for ( $i = 0; $i < count($wimplecf_all_field) ; $i++ ) 
							{
								$wimplecf_field_id     		= $wimplecf_all_field[$i]->id;
								$wimplecf_label_name   		= $wimplecf_all_field[$i]->label_name;
								$wimplecf_is_required  		= $wimplecf_all_field[$i]->is_required;
								$wimplecf_is_email_required = $wimplecf_all_field[$i]->is_email_required;
								$wimplecf_type         		= $wimplecf_all_field[$i]->type;
								$wimplecf_type_value   		= $wimplecf_all_field[$i]->type_value;
								$wimplecf_all_type_val 		= explode( '|', $wimplecf_type_value );					
								$wimplecf_field_width   	= $wimplecf_all_field[$i]->field_width;
								$wimplecf_field_row_num   	= $wimplecf_all_field[$i]->field_row_num;
								$wimplecf_field_column_num  = $wimplecf_all_field[$i]->field_column_num;
								$wimplecf_field_name   		= $wimplecf_all_field[$i]->field_name;
								$wimplecf_error_msg    		= $wimplecf_all_field[$i]->error_msg;
								$wimplecf_help_msg     		= $wimplecf_all_field[$i]->help_msg;
								$wimplecf_placeholder_msg 	= $wimplecf_all_field[$i]->placeholder_msg;
								$wimplecf_numeric_only 		= $wimplecf_all_field[$i]->is_numeric_only;
								$wimplecf_char_limit 		= $wimplecf_all_field[$i]->char_limit;
								$wimplecf_note_type_text 	= $wimplecf_all_field[$i]->note_type_text;
								$wimplecf_date_format   	=  str_replace( ",","commaencode", $wimplecf_all_field[$i]->dateformat );
								$wimplecf_captcha_length   	= $wimplecf_all_field[$i]->captcha_length;
								$wimplecf_date_upper_limit  = $wimplecf_all_field[$i]->date_upperlimit;
								
								//static variable                    
								$wimplecf_blank_validation     = '1';
								$wimplecf_email_validation     = '2';
								$wimplecf_captcha_enable_value = '1';
								
								if ( $wimplecf_field_width == 100 )
								{
									$wimplecf_field_class = 'col-sm-12';
								}
								elseif ( $wimplecf_field_width == 50 )
								{
									$wimplecf_field_class = 'col-sm-6';
								}
								elseif ( $wimplecf_field_width == 33 )
								{
									$wimplecf_field_class = 'col-sm-4';
								}
								elseif ( $wimplecf_field_width == 25 )
								{
									$wimplecf_field_class = 'col-sm-3';
								}
								
								if ( $wimplecf_type == 'checkbox' )
								{
									$wimplecf_outer_div_class = 'wimplecf_checkbox_outerclass';
								}
								else
								{
									$wimplecf_outer_div_class = '';
								}
								
								if ( $wimplecf_type == 'note' )
								{
									$wimplecf_field_type_conditional_class = 'wimplecf_notetext_outerclass';
								}
								else
								{
									$wimplecf_field_type_conditional_class = '';
								}
														
								if ( $wimplecf_char_limit > 0 )	
								{
									$wimplecf_input_maxlength = $wimplecf_char_limit;
								}
								else
								{
									$wimplecf_input_maxlength = '';
								}
								
								
								$wimplecf_local_html = '';
							
								if(isset($wimplecf_current_row_num) && $wimplecf_current_row_num != $wimplecf_field_row_num )
								{
									$wimplecf_local_html .= '</div>';
								}
								
								if(isset($wimplecf_current_row_num) && $wimplecf_current_row_num == $wimplecf_field_row_num )
								{
									$wimplecf_local_html .= '<div id="wimplecf_selected_'.$wimplecf_field_row_num.'_'.$wimplecf_field_column_num.'" class="'.$wimplecf_field_class.' '.$wimplecf_outer_div_class.'">';
								}
								else
								{
									$wimplecf_local_html .= '<div class="form-group row '.$wimplecf_field_type_conditional_class.'" id="wimplecf_rownum_'.$wimplecf_field_row_num.'" >
															<span class="wimplecf_delete wimplecf_help_icon" id="wimplecf_delete~'.$wimplecf_field_row_num.'">
																<span class="tooltipTxt">Delete row</span> 
																<img src="'.esc_url( plugins_url( 'class-admin/images/delete-icon.png', WIMPLECF_PLUGIN ) ). '" alt="" width="18">
															</span>
															
															<div id="wimplecf_selected_'.$wimplecf_field_row_num.'_'.$wimplecf_field_column_num.'" class="'.$wimplecf_field_class.' '.$wimplecf_outer_div_class.'">';
								}
								
								$wimplecf_local_html .= '<input type="hidden" 
																id="wimplecf_row_col_'.$wimplecf_field_row_num.'_'.$wimplecf_field_column_num.'"
																name="hiddenvalus[]" 
																value="'.esc_attr( $wimplecf_field_id.'~'
																					.stripslashes( $wimplecf_label_name ).'~'
																					.$wimplecf_type.'~'
																					.$wimplecf_type_value.'~'
																					.$wimplecf_is_required.'~'
																					.$wimplecf_is_email_required.'~'
																					.$wimplecf_field_width.'~'
																					.$wimplecf_field_row_num.'~'
																					.$wimplecf_field_column_num.'~'
																					.$wimplecf_field_name.'~'
																					.$wimplecf_help_msg.'~'
																					.$wimplecf_error_msg.'~'
																					.$wimplecf_placeholder_msg.'~'
																					.$wimplecf_numeric_only.'~'
																					.$wimplecf_char_limit.'~'
																					.htmlentities( $wimplecf_note_type_text ).'~'
																					.$wimplecf_date_format.'~'
																					.$wimplecf_captcha_length.'~'
																					.$wimplecf_date_upper_limit ).'" />';
																					
								if ( isset( $wimplecf_type ) && 
									 ( $wimplecf_type == 'text' || 
									   $wimplecf_type == 'radiobutton' || 
									   $wimplecf_type == 'selectbox' ||  
									   $wimplecf_type == 'multiselectcheckbox' || 
									   $wimplecf_type == 'textarea' ||
									   $wimplecf_type == 'date' ) ) 
								{
									$wimplecf_local_html .= '<label class="col-form-label">';
								
									$wimplecf_local_html .= esc_html( stripslashes( $wimplecf_label_name ) ); 
								
									if ( isset( $wimplecf_is_required ) &&
										 ( $wimplecf_is_required == 'on') ) 
									{
										$wimplecf_local_html .= '<span class="wimplecf_mandatory_field">*</span>'; 
									}
									$wimplecf_local_html .= '<strong class="wimplecf_edit wimplecf_help_icon" id="wimplecf_edit~'.$wimplecf_field_row_num.'_'.$wimplecf_field_column_num.'">
									<span class="tooltipTxt">Edit</span>
									<img src="'.esc_url( plugins_url( 'class-admin/images/edit-icon.png', WIMPLECF_PLUGIN ) ). '" alt="" width="16"></strong>';
								
									$wimplecf_local_html .='</label>';
								}

								if ( isset( $wimplecf_type ) && 
									 $wimplecf_type == 'text' ) 
								{
									$wimplecf_local_html .= '<input type="text" 
																	class="form-control wimplecf_validity_check_cls" 
																	name="'.esc_attr( $wimplecf_field_name ).'" 
																	id="'.esc_attr( $wimplecf_field_name ).'__'.esc_attr( $wimplecf_numeric_only ).'"
																	value="" 
																	placeholder="'.esc_attr( $wimplecf_placeholder_msg ).'" 
																	maxlength="'.$wimplecf_input_maxlength.'" />';
									if ( isset( $wimplecf_help_msg ) && $wimplecf_help_msg != '' )
									{
										$wimplecf_local_html .= '<span class="wimplecf_help_text">'.esc_attr( $wimplecf_help_msg ).'</span>';
									}
								} 
								elseif ( isset( $wimplecf_type ) && 
										 $wimplecf_type == 'radiobutton' ) 
								{									
									$wimplecf_local_html .= '<div class="gender_radio_sec">
																<div class="custom-check-radio">';
									foreach ( $wimplecf_all_type_val as $wimplecf_single_val )
									{
										$wimplecf_local_html .= '<label class="custom_radio">'.esc_html( trim( $wimplecf_single_val ) ).'
												<input type="radio" name="'.esc_attr( $wimplecf_field_name ).'" 
												value="'.esc_attr( trim( $wimplecf_single_val ) ).'">
												<span class="checkmark"></span>
											  </label>';
									}
									$wimplecf_local_html .= '</div>';
									if ( isset( $wimplecf_help_msg ) && $wimplecf_help_msg != '' )
									{
										$wimplecf_local_html .= '<span class="wimplecf_help_text">'.esc_attr( $wimplecf_help_msg ).'</span>';
									}
									$wimplecf_local_html .= '</div>';
								} 
								elseif ( isset( $wimplecf_type ) && 
										 $wimplecf_type == 'selectbox' ) 
								{
									
									$wimplecf_local_html .= '<select class="wimplecf_cat_select_class" name="'.esc_attr( $wimplecf_field_name ).'"  
																value="" required style="margin: 0">';
								    $wimplecf_local_html .= '<option value="" selected>Select option</option>';
									foreach ( $wimplecf_all_type_val as $wimplecf_single_val ) 
									{
										$wimplecf_local_html .= '<span style=" width:100%; display:block; float:left; margin-top:0px;">
																	<option value="'.esc_attr( trim( $wimplecf_single_val ) ).'">
																	'.esc_html( trim( $wimplecf_single_val ) ).'
																	</option>
																 </span>';
									}
									$wimplecf_local_html .= '</select>';
									if ( isset( $wimplecf_help_msg ) && $wimplecf_help_msg != '' )
									{
										$wimplecf_local_html .= '<span class="wimplecf_help_text">'.esc_attr( $wimplecf_help_msg ).'</span>';
									}
								}
								elseif ( isset( $wimplecf_type ) && 
											$wimplecf_type == 'multiselectcheckbox' ) 
								{									
									$wimplecf_local_html .= '<div class="wimplecf_multiselectchechbox"><span class="input"><div class="wimplecf_multiselect_outerDivCls" id="wimplecf_multiselect_outerDiv">';
									$wimplecf_local_html .= '<input type="text" class="wimplecf_multiselect_valueCls" id="wimplecf_multiselect_value" name="'.esc_attr( $wimplecf_field_name ).'" value="" placeholder="Select options" readonly>';	
									$wimplecf_local_html .= '<div class="wimplecf_multiselect_optionsDivCls" id="wimplecf_multiselect_optionsDiv">';
									foreach ( $wimplecf_all_type_val as $wimplecf_single_val ) 
									{										
										$wimplecf_local_html .= '<div class="wimplecf_multi_check_sec">';
										$wimplecf_local_html .= '<input type="checkbox" class="wimplecf_multicheckboxhandlecls" value="'.esc_html( trim( stripslashes( $wimplecf_single_val ) ) ).'">';
										$wimplecf_local_html .= '<label class="wimplecf_multiselect_checkbox">'.esc_html( trim( stripslashes( $wimplecf_single_val ) ) ).'</label>';
										$wimplecf_local_html .= '</div>';
													
									}									
									$wimplecf_local_html .= '</div></div></span></div>';	
															
									if ( isset( $wimplecf_help_msg ) && $wimplecf_help_msg != '' )
									{
										$wimplecf_local_html .= '<span class="wimplecf_help_text">'.esc_attr( $wimplecf_help_msg ).'</span>';
									}
								}
								elseif ( isset( $wimplecf_type ) && 
										 $wimplecf_type == 'textarea' ) 
								{
									$wimplecf_local_html .= '<textarea class="form-control wimplecf_validity_check_cls" 
																	   name="'.esc_attr( $wimplecf_field_name ).'" 
																	   placeholder="'.esc_attr( $wimplecf_placeholder_msg ).'" 
																	   id="'.esc_attr( $wimplecf_field_name ).'__'.esc_attr( $wimplecf_numeric_only ).'" 
																	   rows="2" cols="80" maxlength="'.$wimplecf_input_maxlength.'"></textarea>';
									if ( isset( $wimplecf_help_msg ) && $wimplecf_help_msg != '' )
									{
										$wimplecf_local_html .= '<span class="wimplecf_help_text">'.esc_attr( $wimplecf_help_msg ).'</span>';
									}
								} 
								elseif ( isset( $wimplecf_type ) && 
										 $wimplecf_type == 'note' ) 
								{
									$wimplecf_local_html .= '<div class="wimplecf_note_block">';
									if ( isset( $wimplecf_label_name ) && $wimplecf_label_name != '' )
									{
										$wimplecf_local_html .= '<label class="col-form-label">'.trim( stripslashes( htmlspecialchars_decode( esc_html( $wimplecf_label_name ) ) ) );
										$wimplecf_local_html .= '<strong class="wimplecf_edit wimplecf_help_icon" id="wimplecf_edit~'.$wimplecf_field_row_num.'_'.$wimplecf_field_column_num.'">
															<span class="tooltipTxt">Edit</span>
															<img src="'.esc_url( plugins_url( 'class-admin/images/edit-icon.png', WIMPLECF_PLUGIN ) ). '" alt="" width="16">
															</strong></label>';
									}
									if ( isset( $wimplecf_label_name ) && $wimplecf_label_name != '' )
									{
										$wimplecf_local_html .= '<div class="wimplecf_noteTxt">';
									}
									else
									{
											$wimplecf_local_html .= '<div class="wimplecf_noteTxt wimplecf_nolabel_note">';
									}
												
									$wimplecf_local_html .= trim( stripslashes( htmlspecialchars_decode( esc_html( $wimplecf_note_type_text ) ) ) );
									if ( isset( $wimplecf_label_name ) && $wimplecf_label_name == '' )
									{
										$wimplecf_local_html .= '<strong class="wimplecf_edit wimplecf_help_icon" id="wimplecf_edit~'.$wimplecf_field_row_num.'_'.$wimplecf_field_column_num.'">
																<span class="tooltipTxt">Edit</span>
																<img src="'.esc_url( plugins_url( 'class-admin/images/edit-icon.png', WIMPLECF_PLUGIN ) ). '" alt="" width="16">
																</strong>';
									}
															
									$wimplecf_local_html .= '</div></div>';
								} 
								elseif ( isset( $wimplecf_type ) && 
										 $wimplecf_type == 'date' ) 
								{
									$wimplecf_local_html .= '<input type="text" class="form-control wimplecf_datepicker_validity date_picker" 
																	name="'.esc_attr( $wimplecf_field_name ).'" 
																	id="'.esc_attr( $wimplecf_field_name ).'"
																	value="" 
																	placeholder="'.esc_attr( str_replace( "commaencode",",", $wimplecf_date_format ) ).'" />';
																	
									$wimplecf_local_html .= '<input type="hidden" class="" 
																	id="'.esc_attr( $wimplecf_field_name ).'_hiddenyear"
																	value="'.esc_attr( $wimplecf_date_upper_limit ).'" />';								
																	
									if ( isset( $wimplecf_help_msg ) && $wimplecf_help_msg != '' )
									{
									$wimplecf_local_html .= '<span class="wimplecf_help_text">'.esc_attr( $wimplecf_help_msg ).'</span>';
									}
								}
								elseif ( isset( $wimplecf_type ) && 
										 $wimplecf_type == 'captchacode' ) 
								{
									
									$wimplecf_local_html .= '<div class="wimplecf_form-group wimplecf_row">
									<div class="wimplecf_col-sm-12 wimplecf_captcha_sec">';
									
										$wimplecf_local_html .= '<label class="col-form-label">'.trim( stripslashes( htmlspecialchars_decode( esc_html( $wimplecf_label_name ) ) ) );
										if ( isset( $wimplecf_label_name ) && $wimplecf_label_name != '' )
										{
											$wimplecf_local_html .= '<span class="wimplecf_mandatory_field">*</span>';
										}
										else
										{
											$wimplecf_local_html .= '<span class="wimplecf_mandatory_field">&nbsp;</span>';
										}
									$wimplecf_local_html .= '<strong class="wimplecf_edit wimplecf_help_icon" id="wimplecf_edit~'.$wimplecf_field_row_num.'_'.$wimplecf_field_column_num.'">
															<span class="tooltipTxt">Edit</span>
															<img src="'.esc_url( plugins_url( 'class-admin/images/edit-icon.png', WIMPLECF_PLUGIN ) ). '" alt="" width="16">
															</strong></label>';
									$wimplecf_local_html .= '<div class="wimplecf_captcha_inner">';
									$wimplecf_local_html .= '<input id="captcha_code" name="wimplecf_captcha_code" type="text" placeholder="Enter the Security code">';
									
									
									if( isset( $wimplecf_field_width ) && $wimplecf_field_width == '50' )
									{
										$wimplecf_local_html .= '<span class="wimplecf_col-form-label wimplecf_captcha_img-label-50">Security Code</span>';
									}
									else
									{
										$wimplecf_local_html .= '<span class="wimplecf_col-form-label wimplecf_captcha_img-label">Security Code</span>';
									}
			
			
									$wimplecf_local_html .= '<span class="wimplecf_captcha_image">
															<img src="'.esc_url( plugins_url( 'captcha/captcha.php', WIMPLECF_PLUGIN ).'?c_bit='.esc_attr( $wimplecf_captcha_length ) ).'" id="wimplecf_captchaimg">
															</span>';
									$wimplecf_local_html .= '<input type="hidden" id="wimplecf_captcha_value" value="'.esc_attr( $wimplecf_captcha_length ).'">';
									$wimplecf_local_html .= '<a href="javascript: wimplecf_refreshCaptcha();" class="wimplecf_captcha_refresh_icon">';
									$wimplecf_local_html .= '<img src="'.esc_url( plugins_url( 'image/refresh_icon.png', WIMPLECF_PLUGIN ) ).'" width="25" title="Click to reload new security code"></a>';
									$wimplecf_local_html .= '</div>';
									if ( isset( $wimplecf_help_msg ) && $wimplecf_help_msg != '' )
									{
										$wimplecf_local_html .= '<span class="wimplecf_captcha_bottomTxt wimplecf_help_text">'.esc_attr( $wimplecf_help_msg ).'</span>';
									}
									$wimplecf_local_html .= '<br>';
									$wimplecf_local_html .= '<span class="wimplecf_validation_class wimplecf_error_message" id="wimplecf_captcha_code_id"></span>';
									$wimplecf_local_html .= '</div></div>';
								}
								elseif ( isset( $wimplecf_type ) && 
										 $wimplecf_type == 'recaptchacode' ) 
								{									
									$wimplecf_local_html .= '<div class="wimplecf_form-group wimplecf_row">
															<div class="wimplecf_col-sm-12 wimplecf_captcha_sec">';
									
									$wimplecf_local_html .= '<label class="col-form-label">'.trim( stripslashes( htmlspecialchars_decode( esc_html( $wimplecf_label_name ) ) ) );
									if ( isset( $wimplecf_label_name ) && $wimplecf_label_name != '' )
									{
										$wimplecf_local_html .= '<span class="wimplecf_mandatory_field">*</span>';
									}
									else
									{
										$wimplecf_local_html .= '<span class="wimplecf_mandatory_field">&nbsp;</span>';
									}
									$wimplecf_local_html .= '<strong class="wimplecf_edit wimplecf_help_icon" id="wimplecf_edit~'.$wimplecf_field_row_num.'_'.$wimplecf_field_column_num.'">
															<span class="tooltipTxt">Edit</span>
															<img src="'.esc_url( plugins_url( 'class-admin/images/edit-icon.png', WIMPLECF_PLUGIN ) ). '" alt="" width="16">
															</strong></label>';
									$wimplecf_local_html .= '<div class="wimplecf_captcha_inner">';									
									
									$wimplecf_local_html .= '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
									
									$wimplecf_local_html .= '<div class="fltRgt capchaLabelCnt sec-hig recaptcha_feedback"> 
															<div class="g-recaptcha" data-sitekey="'.$wimplecf_google_site_key.'" data-size="normal"></div> 
															</div>'; 
			
									$wimplecf_local_html .= '</div>';
									if ( isset( $wimplecf_help_msg ) && $wimplecf_help_msg != '' )
									{
										$wimplecf_local_html .= '<span class="wimplecf_captcha_bottomTxt wimplecf_help_text">'.esc_attr( $wimplecf_help_msg ).'</span>';
									}
									$wimplecf_local_html .= '<br>';
									$wimplecf_local_html .= '<span class="wimplecf_validation_class wimplecf_error_message" id="wimplecf_captcha_code_id"></span>';
									$wimplecf_local_html .= '</div></div>';
									
								}
								elseif ( isset( $wimplecf_type ) && 
										 $wimplecf_type == 'checkbox' )
								{
									$wimplecf_local_html .= '<div class="custom-check-radio wimplecf_single_checkbox">
															<div class="wimplecf_checkbox_list">';
									$wimplecf_local_html .= '<label class="wimplecf_custom_checkbox">'.esc_html( trim( stripslashes( $wimplecf_label_name ) ) );
									if ( isset( $wimplecf_is_required ) &&
										 ( $wimplecf_is_required == 'on') ) 
									{
										$wimplecf_local_html .= '<span class="wimplecf_mandatory_field">*</span>'; 
									}						
									$wimplecf_local_html .= '<input type="checkbox" name="'.esc_attr( stripslashes( $wimplecf_field_name ) ).'" 
															value="Yes">
															<span class="checkmark"></span>';
									$wimplecf_local_html .= '</label>';
									$wimplecf_local_html .= '<strong class="wimplecf_edit wimplecf_help_icon" 
																	 id="wimplecf_edit~'.$wimplecf_field_row_num.'_'.$wimplecf_field_column_num.'">
															<span class="tooltipTxt">Edit</span>
															<img src="'.esc_url( plugins_url( 'class-admin/images/edit-icon.png', WIMPLECF_PLUGIN ) ). '" alt="" width="16">
															</strong>';
										  
									$wimplecf_local_html .= '</div>';
									if ( isset( $wimplecf_help_msg ) && $wimplecf_help_msg != '' ) 
									{
										$wimplecf_local_html .= '<span class="wimplecf_help_text">'.esc_attr( $wimplecf_help_msg ).'</span>';
									}
									$wimplecf_local_html .= '</div>';
								} 
								$wimplecf_local_html .= '</div>';
								
								$wimplecf_current_row_num = $wimplecf_field_row_num;
								
								if(++$wimplecf_i === $wimplecf_numItems) 
								{
									$wimplecf_local_html .= '</div>';
								}
								
								echo $wimplecf_local_html;
							}
						}
						else
						{?>
							<div class="wimplecf_blank_form">
							<div id="wimplecf_first_input_hidden"></div>
								<div class="wimplecf_logo">
								<?php echo '<img src="'.esc_url( plugins_url( 'class-admin/images/plugin_logo.png', WIMPLECF_PLUGIN ) ). '">';?>
								</div>
								<div class="wimplecf_blankform_msg">
									<?php echo esc_html__( 'Add field(s) in the left pane to create layout for the form', 'wimple-contact-form' );?>
									<br> 
									'<?php echo esc_html( $wimplecf_form_name ); ?>'. 
								</div>
							</div>
						<?php 
						} ?>   
						</div>
						
						<div class="form-group row" id="wimplecf_dummy_submit_button" style="display:none;">
							<div class="col-sm-12">
								<button type="button" name="" class="btn btn-default btn-main wimplecf_subbutton-disable">
									<?php echo esc_html( $wimplecf_form_button_label ); ?>
								</button>
								<span class="wimplecf_button_inactive">
									<?php echo esc_html__( 'Button is inactive', 'wimple-contact-form' );?>
								</span>
							</div>
						</div>
						
					</div>
				</div>
				<!-- Right Sec -->
				</div>
		</section><!-- End Content Section -->	
	</form>
			

	<!-- Start Popup Section -->
	<!--Field guide/help during creation------------------------>
	<div class="modal fade popup_box popup_help" id="popupHelp">
		<div class="vertical-alignment-helper">
			<div class="modal-dialog vertical-align-center">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title"><?php echo esc_html__( 'Help', 'wimple-contact-form' );?></h4>
						<button type="button" class="close" data-dismiss="modal">
						<?php echo '<img src="'.esc_url( plugins_url( 'class-admin/images/popup-close.png', WIMPLECF_PLUGIN ) ). '">';?>
						</button>
					</div>
				
					<div class="modal-body">
						<div class="popup_box_inner">
							<div class="popup_help_content" id="wimplecf_generic_information_help">
							<?php echo WIMPLECF_HELPMSG_FIELD_GENERIC_INFORMATION; ?>								
							</div>
							
							<div class="popup_help_content" id="wimplecf_messages_help">
							<?php echo WIMPLECF_HELPMSG_FIELD_MESSAGES; ?>								
							</div>
							
							<div class="popup_help_content" id="wimplecf_orientation_help">
							<?php echo WIMPLECF_HELPMSG_FIELD_ORIENTATION; ?>								
							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
        
	<!-- Exit Alert Popup-->
	<div class="modal fade popup_box popup_alert" id="wimplecf_popupAlert">
		<div class="vertical-alignment-helper">
			<div class="modal-dialog vertical-align-center">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title"><?php echo esc_html__( 'Alert', 'wimple-contact-form' );?></h4>
					</div>
				
					<div class="modal-body">
						<div class="popup_box_inner">
							<p class="popupContent">
								<?php echo esc_html__( 'If you leave this page without clicking on Save, 
								the changes you have made till now will not be saved.', 'wimple-contact-form' );?>
								<br />
								<?php echo esc_html__( 'Do you want to proceed?', 'wimple-contact-form' );?>
							</p>
							
							<div class="form-group row text-center alert_button">
								<div class="col-sm-12">
									<button type="button" class="btn btn-default btn-main" id="wimplecf_confirm_leavepage">
										<?php echo esc_html__( 'Ok', 'wimple-contact-form' );?>
									</button>
									<button type="button" class="btn btn-default btn-main" data-dismiss="modal">
										<?php echo esc_html__( 'Cancel', 'wimple-contact-form' );?>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Exit Alert Popup-->
	<!-- End Popup Section ==================================================-->
</div>	
		
<script>
jQuery( document ).ready( function( $ )
{
	$('#wimplecf_googleapis_copied').hide();
	$( '#wimplecf_clicktocopy' ).click( function( event )
	{	
		$('#wimplecf_googleapis_copied').slideDown().delay(3000).slideUp();
	} );	
});
</script>
     
	
<!--action on back and exit button click with saving changes -->
<script>
window.onload = function()
{
	var divToHide = document.getElementById('wimplecf_googleapis_copied');
	alert(divToHide);
	document.onclick = function(e)
	{
		if(e.target.id !== 'wimplecf_field_type')
		{
		  //element clicked wasn't the div; hide the div
		  divToHide.style.display = 'none';
		}
	}
}
</script>

<script type="text/javascript">
function wimplecf_googleapisToClipboard(wimplecf_containerid) 
{
	if (window.getSelection) 
	{
		var range = document.createRange();
		range.selectNode(document.getElementById(wimplecf_containerid));		
		window.getSelection().removeAllRanges();
		window.getSelection().addRange(range);
		document.execCommand("copy");
	}
}

</script>

<script type="text/javascript">
jQuery( document ).ready( function( $ )
{
	$( '.wimplecf_popClickInfo' ).click( function( event )
	{
		$(this).next().show();
		$( '.wimplecf_popClickInfoCntnr > div' ).show();
		$( '.modal-backdrop' ).show();
		event.preventDefault();
	} );
	
	$( '.wimplecf_popClose' ).click( function( event )
	{
		$('.modal-backdrop').hide();
		$('#recaptchapopupHelp').hide();
		event.preventDefault();
	} );
});
</script>
	
<script type="text/javascript">
jQuery( document ).ready( function( $ )
{	
	$( "#wimplecf_page_current_status" ).val( 'DB_UPDATE_NONE' );
	
	$( '.wimplecf_go_back' ).on( 'click', function( ) 
    {
		var wimplecf_page_current_status = $( '#wimplecf_page_current_status' ).val( );
		var wimplecf_backlink_id = $( this ).attr( "id" );
		var wimplecf_href = $("#"+wimplecf_backlink_id).attr("href");
		if ( wimplecf_page_current_status == 'DB_UPDATE_DUE' )
		{
			$( '#wimplecf_popupAlert' ).modal( 'show' );
			$( '#wimplecf_confirm_leavepage' ).on( 'click', function( )
			{
				window.location.href = wimplecf_href;
			});
		}
		else
		{
			window.location.href = wimplecf_href;
		}
	});
});
</script>

<script type="text/javascript">
jQuery( document ).ready( function( $ )
{
	$( document ).on( 'focus', '.wimplecf_validity_check_cls', function ( ) 
	{
		var wimplecf_validation_check_id = $( this ).attr( "id" );
		var wimplecf_split_validation_str = wimplecf_validation_check_id.split( "__" );
		
		var wimplecf_input_type = wimplecf_split_validation_str[ 1 ];
		if ( wimplecf_input_type == 'on' )
		{
			$("#"+wimplecf_validation_check_id).on( 'keypress', function( e )
			{
				return e.metaKey || 							// cmd/ctrl
				e.which <= 0 || 								// arrow keys
				/[0-9]/.test( String.fromCharCode( e.which ) ); // numbers
			});
	
		}
	});
});
</script>

<script type="text/javascript">
jQuery( document ).ready( function( $ )
{			
	$( '.wimplecf_help_icon' ).on( 'click', function( ) 
    {
		var wimplecf_tootip_field_id = $( this ).attr( "id" );
		$( '.popup_help_content' ).show( );
		$( '#'+wimplecf_tootip_field_id+'_help' ).show( );
		$( '.popup_help_content' ).not( '#'+wimplecf_tootip_field_id+'_help' ).hide( );
	});
});
</script>


<script type="text/javascript">
jQuery( document ).ready( function( $ ) 
{
	$( '#wimplecf_label_name' ).attr("placeholder", "Maximum 50 characters (required)");
	$( '#wimplecf_placeholder' ).val( '' );
	$( '#wimplecf_helptext' ).attr("placeholder", "Maximum 100 characters (optional)");
	$( '#wimplecf_validation_msg' ).attr("placeholder", "Maximum 100 characters (optional)");
	$( '#wimplecf_field_type' ).on( 'change', function( ) 
    {
		$( ".wimplecf_error_message" ).empty();
		$( '#wimplecf_label_name' ).attr("placeholder", "Maximum 50 characters (required)");
		$( '#wimplecf_charlimit' ).slideUp();
		$( '#wimplecf_typevalue' ).slideUp();
		$( '#wimplecf_notetext_block' ).slideUp();
		$( '#wimplecf_captchablock' ).slideUp();
		$( '#wimplecf_recaptchablock' ).slideUp();
		$( '#wimplecf_dateformat_block' ).slideUp();
		$('#wimplecf_mandatory').prop('checked', false);
		$('#wimplecf_email_validation').prop('checked', false);
		$('#wimplecf_validation_msg').val('');
		$('#wimplecf_numericonly').prop('checked', false);
		$( '#wimplecf_emailidrequiredID' ).removeClass( 'wimplecf_horizental_pos_disable' );
		$( '#wimplecf_numericonlyID' ).removeClass( 'wimplecf_horizental_pos_disable' );
		$( '#wimplecf_helptext_block' ).removeClass( 'wimplecf_horizental_pos_disable' );
		$( '#wimplecf_validation_checklist' ).removeClass( 'wimplecf_horizental_pos_disable' );
		$( '#wimplecf_error_input' ).addClass( 'wimplecf_horizental_pos_disable' );
		$( "#wimplecf_field_width" ).find( "option" ).remove( ).end( ).append(
			'<option value="100">100%</option><option value="50">50%</option><option value="33">33%</option><option value="25">25%</option>');

		$( '#wimplecf_placeholder' ).val( '' );
		$( '#wimplecf_helptext' ).attr("placeholder", "Maximum 100 characters (optional)");
		$( '#wimplecf_validation_msg' ).attr("placeholder", "Maximum 100 characters (optional)");
		
        if ( $( '#wimplecf_field_type' ).val() == 'text' ) 
        {
			$( '#wimplecf_charlimit' ).slideDown();
			$( '#wimplecf_type_value' ).val( '' );
			$( '#wimplecf_note_text' ).val( '' );
			$( '#wimplecf_placeholder_div' ).removeClass( 'wimplecf_horizental_pos_disable' );
        } 
        else if ( $( '#wimplecf_field_type' ).val() == 'textarea' ) 
        {
			$( '#wimplecf_charlimit' ).slideDown();
			$( '#wimplecf_type_value' ).val( '' );
			$( '#wimplecf_note_text' ).val( '' );
			$('#wimplecf_email_validation').prop('checked', false);
			$( '#wimplecf_placeholder_div' ).removeClass( 'wimplecf_horizental_pos_disable' );
        } 
        else if ( $( '#wimplecf_field_type' ).val() == 'selectbox' ) 
        {
            $( '#wimplecf_typevalue' ).slideDown();
			$( '#wimplecf_char_limit' ).val( '' );
			$( '#wimplecf_note_text' ).val( '' );
			$('#wimplecf_email_validation').prop('checked', false);
			$('#wimplecf_numericonly').prop('checked', false);
			$( '#wimplecf_placeholder' ).val( '' );
			$( '#wimplecf_placeholder_div' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_emailidrequiredID' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_numericonlyID' ).addClass( 'wimplecf_horizental_pos_disable' );
        } 
        else if ( $( '#wimplecf_field_type' ).val() == 'radiobutton' ) 
        {
            $( '#wimplecf_typevalue' ).slideDown();
			$( '#wimplecf_char_limit' ).val( '' );
			$( '#wimplecf_note_text' ).val( '' );
			$('#wimplecf_email_validation').prop('checked', false);
			$('#wimplecf_numericonly').prop('checked', false);
			$( '#wimplecf_placeholder' ).val( '' );			
			$( '#wimplecf_placeholder_div' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_emailidrequiredID' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_numericonlyID' ).addClass( 'wimplecf_horizental_pos_disable' );
        }
		else if ( $( '#wimplecf_field_type' ).val() == 'multiselectcheckbox' ) 
        {
            $( '#wimplecf_typevalue' ).slideDown();
			$( '#wimplecf_char_limit' ).val( '' );
			$( '#wimplecf_note_text' ).val( '' );
			$('#wimplecf_email_validation').prop('checked', false);
			$('#wimplecf_numericonly').prop('checked', false);
			$( '#wimplecf_placeholder' ).val( '' );
			$( '#wimplecf_placeholder_div' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_emailidrequiredID' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_numericonlyID' ).addClass( 'wimplecf_horizental_pos_disable' );
        } 
		else if ( $( '#wimplecf_field_type' ).val() == 'checkbox' ) 
        {
			$( '#wimplecf_char_limit' ).val( '' );
			$( '#wimplecf_type_value' ).val( '' );
			$( '#wimplecf_note_text' ).val( '' );
			$('#wimplecf_email_validation').prop('checked', false);
			$('#wimplecf_numericonly').prop('checked', false);
			$( '#wimplecf_placeholder' ).val( '' );
			$( '#wimplecf_placeholder_div' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_emailidrequiredID' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_numericonlyID' ).addClass( 'wimplecf_horizental_pos_disable' );
		} 
		else if ( $( '#wimplecf_field_type' ).val() == 'note' ) 
        {
			$( '#wimplecf_label_name' ).attr("placeholder", "Maximum 50 characters (optional)");
			$( "#wimplecf_note_text_ifr" ).contents().find("body").html( 'Maximum 500 characters (required)' );
			$( '#wimplecf_notetext_block' ).slideDown();
			$( '#wimplecf_char_limit' ).val( '' );
			$( '#wimplecf_type_value' ).val( '' );
			$('#wimplecf_mandatory').prop('checked', false);
			$('#wimplecf_email_validation').prop('checked', false);
			$('#wimplecf_validation_msg').val('');
			$('#wimplecf_numericonly').prop('checked', false);
			$( '#wimplecf_placeholder' ).val( '' );
			$( '#wimplecf_placeholder_div' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_validation_checklist' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_helptext_block' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( "#wimplecf_field_width" ).find( "option" ).remove( ).end( ).append(
			'<option value="100">100%</option>');
			$( "#wimplecf_field_width" ).prop( 'selectedIndex', 0 );
		}
		else if ( $( '#wimplecf_field_type' ).val() == 'date' ) 
        {
			$( '#wimplecf_dateformatlist' ).prop( "selectedIndex", 0 );
			$( '#wimplecf_dateupperlimit' ).prop( "selectedIndex", 0 );
			$( '#wimplecf_dateformat_block' ).slideDown();
			$( '#wimplecf_char_limit' ).val( '' );
			$( '#wimplecf_type_value' ).val( '' );
			$( '#wimplecf_note_text' ).val( '' );
			$('#wimplecf_email_validation').prop('checked', false);
			$('#wimplecf_numericonly').prop('checked', false);
			$( '#wimplecf_placeholder' ).val( '' );
			$( '#wimplecf_placeholder_div' ).addClass( 'wimplecf_horizental_pos_disable' );			
			$( '#wimplecf_emailidrequiredID' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_numericonlyID' ).addClass( 'wimplecf_horizental_pos_disable' );
		}
		else if ( $( '#wimplecf_field_type' ).val() == 'captchacode' ) 
        {
			$( '#wimplecf_label_name' ).attr("placeholder", "Maximum 50 characters (optional)");
			$( '#wimplecf_captchablock' ).slideDown();
			$( '#wimplecf_char_limit' ).val( '' );
			$( '#wimplecf_type_value' ).val( '' );
			$( '#wimplecf_note_text' ).val( '' );
			$('#wimplecf_mandatory').prop('checked', true);
			$( '#wimplecf_validation_msg' ).val( 'Security code is required to be filled in.' );
			$( '#wimplecf_error_input' ).removeClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_placeholder' ).val( 'Enter the Security code' );
			$( '#wimplecf_placeholder_div' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_validation_checklist' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( "#wimplecf_field_width" ).find( "option" ).remove( ).end( ).append(
			'<option value="100">100%</option><option value="50">50%</option>');
		}
		else if ( $( '#wimplecf_field_type' ).val() == 'recaptchacode' ) 
        {
			$( '#wimplecf_label_name' ).attr("placeholder", "Maximum 50 characters (optional)");
			$( '#wimplecf_recaptchablock' ).slideDown();
			$( '#wimplecf_char_limit' ).val( '' );
			$( '#wimplecf_type_value' ).val( '' );
			$( '#wimplecf_note_text' ).val( '' );
			$('#wimplecf_mandatory').prop('checked', true);
			$( '#wimplecf_validation_msg' ).val( 'Please perform reCAPTCHA verification.' );
			$( '#wimplecf_error_input' ).removeClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_placeholder' ).val( '' );
			$( '#wimplecf_placeholder_div' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_validation_checklist' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( "#wimplecf_field_width" ).find( "option" ).remove( ).end( ).append(
			'<option value="100">100%</option><option value="50">50%</option>');
		}
    });
});
</script>

<script type="text/javascript">
jQuery( document ).ready( function( $ )
{	
	$( '#wimplecf_char_limit' ).on( 'keypress', function( e )
	{
		return e.metaKey || 							// cmd/ctrl
		e.which <= 0 || 								// arrow keys
		/[0-9]/.test( String.fromCharCode( e.which ) ); // numbers
	});
	
	$( ".wimplecf_left_inner_block" ).focusout( function( )
	{
		if ( $( '#wimplecf_field_type' ).val() == 'text' ||
			 $( '#wimplecf_field_type' ).val() == 'textarea' )
		{
			var wimplecf_provided_char = $( '#wimplecf_char_limit' ).val( );
			if ( wimplecf_provided_char != '' && wimplecf_provided_char > 0 )
			{
				var wimplecf_placeholder_auto_text = 'Maximum '+wimplecf_provided_char+' characters';
				
				if ( $( "#wimplecf_numericonly" ).is( ':checked' ) )
					{
						wimplecf_placeholder_auto_text = wimplecf_placeholder_auto_text+' (Numeric only)';
					}
			}
			
			$( '#wimplecf_placeholder' ).val( wimplecf_placeholder_auto_text );
		}
	});
	
	
	if ( $( '#wimplecf_field_width' ).val() == 100 || $( '#wimplecf_row_num' ).val() == 'wimplecf_newrow' )
	{
		$( '#wimplecf_within_row' ).addClass( 'wimplecf_horizental_pos_disable' );
	}
	
	$( '.wimplecf_check_each_box' ).click( function( )
	{
		var wimplecf_left_validation_check_id = $( this ).attr( "id" );
		
		if( wimplecf_left_validation_check_id != 'wimplecf_mandatory' ) 
		{
			$('.wimplecf_either_one_check').not(this).prop('checked', false);
		}
		
		if ( ( $( "#wimplecf_mandatory" ).is( ':checked' ) ) && 
			 ( $( "#wimplecf_email_validation" ).is( ':not(:checked)' ) ) )
		{
			$( '#wimplecf_error_input' ).removeClass( 'wimplecf_horizental_pos_disable' );
			$( "#wimplecf_error_validation" ).slideDown( );
			$( '#wimplecf_validation_msg' ).val( 'This is a required field.' );
		}
		else if ( ( $( "#wimplecf_email_validation" ).is( ':checked' ) ) && 
				  ( $( "#wimplecf_mandatory" ).is( ':not(:checked)' ) ) )
		{
			$( '#wimplecf_error_input' ).removeClass( 'wimplecf_horizental_pos_disable' );
			$( "#wimplecf_error_validation" ).slideDown( );
			$( '#wimplecf_validation_msg' ).val( 'Please enter a valid email id.' );
		}
		else if ( ( $( "#wimplecf_mandatory" ).is( ':checked' ) ) && 
				  ( $( "#wimplecf_email_validation" ).is( ':checked' ) ) )
		{
			$( '#wimplecf_error_input' ).removeClass( 'wimplecf_horizental_pos_disable' );
			$( "#wimplecf_error_validation" ).slideDown( );
			$( '#wimplecf_validation_msg' ).val( 'This is a required field. Please enter a valid email id.' );
		}
		else
		{
			$( '#wimplecf_error_input' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( "#wimplecf_error_validation" ).slideUp( );
			$( '#wimplecf_validation_msg' ).val(' ');
		}
	});
	
	$( "#wimplecf_note_text_ifr" ).contents().find("body").on( 'focus', function( )
	{
		var wimplecf_richtextdefaultvalue = $( "#wimplecf_note_text_ifr" ).contents().find( "body" ).text();
		
		if ( wimplecf_richtextdefaultvalue == 'Maximum 500 characters (required)')
		{
			$( "#wimplecf_note_text_ifr" ).contents().find( "body" ).text( '' );
		}
	});
	
	$( "#wimplecf_note_text_ifr" ).contents().find("body").on( 'focusout', function( )
	{
		var wimplecf_richtextdefaultvalue = $( "#wimplecf_note_text_ifr" ).contents().find( "body" ).text();
		if ( wimplecf_richtextdefaultvalue === '' )
		{
			$( "#wimplecf_note_text_ifr" ).contents().find("body").html( 'Maximum 500 characters (required)' );
		}
	});
		
	
	$( "#wimplecf_left_first input[type='text']" ).focus( function( )
	{
		$( ".wimplecf_error_message" ).empty();
	});
	
	$( "#wimplecf_field_width" ).focus( function( )
	{
		$( "#wimplecf_error_free_width" ).empty();
	});
	
	$( "#wimplecf_vertical_pos" ).focus( function( )
	{
		$( "#wimplecf_error_free_width" ).empty( );
	});
	
	$( "#wimplecf_row_num" ).focus( function( )
	{
		$( "#wimplecf_error_free_width" ).empty();
	});
	
	$("#wimplecf_note_text_ifr").contents().find("body").focus( function( )
	{
		$( ".wimplecf_error_message" ).empty();
	});
	
	
	if ( $( '#wimplecf_numberoffieldcreated' ).val( ) == 0 )
	{
		$( 'option[value="wimplecf_vertical_before"]' ).slideUp( );
		$( 'option[value="wimplecf_vertical_after"]' ).slideUp( );		
	}
	
	$( '#wimplecf_vertical_pos' ).change( function( )
	{
		var wimplecf_edit_fired = $( '#wimplecf_edit_mode' ).val( );
		var wimplecf_vertical_pos 	= $( '#wimplecf_vertical_pos' ).val( );
		
		if ( wimplecf_edit_fired != '' && wimplecf_vertical_pos == 'wimplecf_vertical_at' )
		{
			$( 'option[value="wimplecf_newrow"]' ).slideDown( );
			$( "#wimplecf_row_num" ).prop( 'selectedIndex', 0 );
		}
		else if ( wimplecf_vertical_pos == 'wimplecf_vertical_before' ||
				wimplecf_vertical_pos == 'wimplecf_vertical_after' )
		{
			$( 'option[value="wimplecf_newrow"]' ).slideUp( );
			$( "#wimplecf_row_num" ).prop( 'selectedIndex', 1 );
		}
		else
		{
			$( 'option[value="wimplecf_newrow"]' ).slideDown( );
			$( "#wimplecf_row_num" ).prop( 'selectedIndex', 0 );
		}
	});
	
	$( '#wimplecf_row_wise_cols_display select' ).change( function( )
	{
		$( '#wimplecf_within_row' ).addClass( 'wimplecf_horizental_pos_disable' );
		
		var wimplecf_field_width 	= $( '#wimplecf_field_width' ).val();
		var wimplecf_selected_row 	= $( '#wimplecf_row_num' ).val();
		var wimplecf_vertical_pos 	= $( '#wimplecf_vertical_pos' ).val();
		
		if ( wimplecf_vertical_pos == 'wimplecf_vertical_at' && 
			 wimplecf_selected_row != 'wimplecf_newrow' && 
			 wimplecf_field_width != 100 )
		{
			var wimplecf_row_wise_cols = '';
			$( '[id*="wimplecf_row_col_'+wimplecf_selected_row+'_"]' ).each( function( ) 
			{
				wimplecf_row_wise_cols += $( this ).val()+',';
			});
			
			var wimplecf_col_listing = ( wimplecf_row_wise_cols.replace(/^,|,$/g,'') ).split( "," );
			var wimplecf_field_listing = '';
			for ( var i = 0; i < wimplecf_col_listing.length; i++ ) 
			{
				var wimplecf_each_col_listing = wimplecf_col_listing[i].split( "~" );
				wimplecf_field_listing += '<option value="'+wimplecf_each_col_listing[8]+'">'+wimplecf_each_col_listing[1]+'</option>';
			}
			
			$( '#wimplecf_colomn_num' ).html( wimplecf_field_listing );
			var wimplecf_edited_row_number = $( '#wimplecf_edited_row_number' ).val( );
			if ( wimplecf_each_col_listing[8] > 1 || wimplecf_edited_row_number != wimplecf_selected_row )
			{
				$( '#wimplecf_within_row' ).removeClass( 'wimplecf_horizental_pos_disable' );
			}
		}
	});
	
});
</script>	

<script type="text/javascript">
jQuery( document ).ready( function( $ )
{
	$( document ).on( 'click', '.wimplecf_edit', function ( ) 
	{ 
		$( '.wimplecf_left_sec' ).addClass( 'wimplecf_focus_on_left' );
		$( '.wimplecf_right_sec' ).removeClass( 'wimplecf_focus_on_right' );
		$( "#wimplecf_label_name" ).focus( );
		
		$( '#wimplecf_addnew_field' ).html( 'Update Field' );
		
		if ( $( '#wimplecf_numberoffieldcreated' ).val( ) == 1 )
		{
			$( 'option[value="wimplecf_vertical_before"]' ).slideUp( );
			$( 'option[value="wimplecf_vertical_after"]' ).slideUp( );		
		}
		
		var wimplecf_field_id = $( this ).attr( "id" ); 
		var wimplecf_splited_row_col = wimplecf_field_id.split( "~" );
		var wimplecf_field_row_col_val = wimplecf_splited_row_col[1];
		
		$( "div" ).removeClass( "wimplecf_selected_col" );
		$( "#wimplecf_selected_"+wimplecf_field_row_col_val ).addClass( "wimplecf_selected_col" );
		
		$( "#wimplecf_edit_mode" ).val( wimplecf_field_row_col_val );
		
		var wimplecf_editable_field_val = $( '#wimplecf_row_col_'+wimplecf_field_row_col_val ).val( );
	
		var wimplecf_editable_field_val_each = wimplecf_editable_field_val.split( "~" );
		
		$( "#wimplecf_first_value" ).val( wimplecf_editable_field_val_each[0] );
		
		$( "#wimplecf_label_name" ).val( wimplecf_editable_field_val_each[1] );
		
		
		if ( wimplecf_editable_field_val_each[2] == 'text' )
		{
			var wimplecf_field_type_index = '0';
		}
		else if ( wimplecf_editable_field_val_each[2] == 'textarea' )
		{
			var wimplecf_field_type_index = '1';
		}
		else if ( wimplecf_editable_field_val_each[2] == 'selectbox' )
		{
			var wimplecf_field_type_index = '2';
		}
		else if ( wimplecf_editable_field_val_each[2] == 'checkbox' )
		{
			var wimplecf_field_type_index = '3';
		}
		else if ( wimplecf_editable_field_val_each[2] == 'radiobutton' )
		{
			var wimplecf_field_type_index = '4';
		}
		else if ( wimplecf_editable_field_val_each[2] == 'multiselectcheckbox' )
		{
			var wimplecf_field_type_index = '5';
		}
		else if ( wimplecf_editable_field_val_each[2] == 'note' )
		{
			var wimplecf_field_type_index = '6';
		}
		else if ( wimplecf_editable_field_val_each[2] == 'date' )
		{
			var wimplecf_field_type_index = '7';
		}
		else if ( wimplecf_editable_field_val_each[2] == 'captchacode' )
		{
			var wimplecf_field_type_index = '8';
		}
		else if ( wimplecf_editable_field_val_each[2] == 'recaptchacode' )
		{
			var wimplecf_field_type_index = '9';
		}
		
		$( "#wimplecf_field_type" ).prop( "selectedIndex", wimplecf_field_type_index );
		
		$( '#wimplecf_label_name' ).attr("placeholder", "Maximum 50 characters (required)");
		$( '#wimplecf_captchablock' ).slideUp();
		$( '#wimplecf_recaptchablock' ).slideUp();
		$( "#wimplecf_field_width" ).find( "option" ).remove( ).end( ).append(
		  '<option value="100">100%</option><option value="50">50%</option><option value="33">33%</option><option value="25">25%</option>');
		  		
		if ( wimplecf_editable_field_val_each[2] == 'radiobutton' ||
			 wimplecf_editable_field_val_each[2] == 'selectbox' ||
			 wimplecf_editable_field_val_each[2] == 'multiselectcheckbox' )
		{
			$( '#wimplecf_charlimit' ).slideUp();
			$( '#wimplecf_notetext_block' ).slideUp();
			$( '#wimplecf_dateformat_block' ).slideUp();
			$( '#wimplecf_typevalue' ).slideDown();
			$( '#wimplecf_note_text' ).val('');	
			$( '#wimplecf_char_limit' ).val('');
			$( '#wimplecf_type_value' ).val( wimplecf_editable_field_val_each[3] );
			$( '#wimplecf_placeholder_div' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_validation_checklist' ).removeClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_emailidrequiredID' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_numericonlyID' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_helptext_block' ).removeClass( 'wimplecf_horizental_pos_disable' );
		}
		else if ( wimplecf_editable_field_val_each[2] == 'text' ||
				  wimplecf_editable_field_val_each[2] == 'textarea' )
		{
			$( '#wimplecf_typevalue' ).slideUp();
			$( '#wimplecf_notetext_block' ).slideUp();
			$( '#wimplecf_dateformat_block' ).slideUp();
			$( '#wimplecf_charlimit' ).slideDown();
			$( '#wimplecf_note_text' ).val('');	
			$( '#wimplecf_type_value' ).val('');
			$( '#wimplecf_placeholder_div' ).removeClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_validation_checklist' ).removeClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_helptext_block' ).removeClass( 'wimplecf_horizental_pos_disable' );
			
			if ( wimplecf_editable_field_val_each[14] > 0 )
			{
				$( '#wimplecf_char_limit' ).val( wimplecf_editable_field_val_each[14] );
			}
			$( '#wimplecf_emailidrequiredID' ).removeClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_numericonlyID' ).removeClass( 'wimplecf_horizental_pos_disable' );
		}
		else if ( wimplecf_editable_field_val_each[2] == 'note' )
		{
			$( '#wimplecf_label_name' ).attr("placeholder", "Maximum 50 characters (optional)");
			$( '#wimplecf_typevalue' ).slideUp();
			$( '#wimplecf_charlimit' ).slideUp();
			$( '#wimplecf_dateformat_block' ).slideUp();
			$( '#wimplecf_notetext_block' ).slideDown();
			$( '#wimplecf_type_value' ).val('');	
			$( '#wimplecf_char_limit' ).val('');
			
			var wimplecf_notetext_withoutHTMLTag = wimplecf_editable_field_val_each[15].replaceAll('&comma;', ',')
																					   .replaceAll('&amp;', '&')
																					   .replaceAll('&gt;', '>')
																					   .replaceAll('&lt;', '<')
																					   .replaceAll('&quot;', '"')
																					   .replaceAll('&apos;', "'");
			$("#wimplecf_note_text_ifr").contents().find("body").html( wimplecf_notetext_withoutHTMLTag );
			
			$( '#wimplecf_placeholder_div' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_validation_checklist' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_helptext_block' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( "#wimplecf_field_width" ).find( "option" ).remove( ).end( ).append(
			'<option value="100">100%</option>');
		}
		else if ( wimplecf_editable_field_val_each[2] == 'date' )
		{
			$( '#wimplecf_dateformat_block' ).slideDown();
			$( '#wimplecf_typevalue' ).slideUp();
			$( '#wimplecf_type_value' ).val('');
			$( '#wimplecf_charlimit' ).slideUp();
			$( '#wimplecf_char_limit' ).val('');
			$( '#wimplecf_notetext_block' ).slideUp();
			$( '#wimplecf_note_text' ).val('');	
			$( '#wimplecf_dateformatlist' ).val( wimplecf_editable_field_val_each[16].replace("commaencode", ",") );	
			$('#wimplecf_dateupperlimit').val( wimplecf_editable_field_val_each[18] );
			$( '#wimplecf_placeholder_div' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_validation_checklist' ).removeClass( 'wimplecf_horizental_pos_disable' );
			
			$( '#wimplecf_emailidrequiredID' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_numericonlyID' ).addClass( 'wimplecf_horizental_pos_disable' );
		}
		else if ( wimplecf_editable_field_val_each[2] == 'captchacode' )
		{
			$( '#wimplecf_label_name' ).attr("placeholder", "Maximum 50 characters (optional)");
			$( '#wimplecf_captchablock' ).slideDown();
			$( '#wimplecf_dateformat_block' ).slideUp();
			$( '#wimplecf_typevalue' ).slideUp();
			$( '#wimplecf_type_value' ).val('');
			$( '#wimplecf_charlimit' ).slideUp();
			$( '#wimplecf_char_limit' ).val('');
			$( '#wimplecf_notetext_block' ).slideUp();
			$( '#wimplecf_note_text' ).val('');	
			$( "#wimplecf_captcha_length" ).val( wimplecf_editable_field_val_each[17] );			
			$( '#wimplecf_placeholder_div' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_validation_checklist' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( "#wimplecf_field_width" ).find( "option" ).remove( ).end( ).append(
			'<option value="100">100%</option><option value="50">50%</option>');
		}
		else if ( wimplecf_editable_field_val_each[2] == 'recaptchacode' )
		{
			$( '#wimplecf_label_name' ).attr("placeholder", "Maximum 50 characters (optional)");
			$( '#wimplecf_recaptchablock' ).slideDown();
			$( '#wimplecf_captchablock' ).slideUp();
			$( '#wimplecf_dateformat_block' ).slideUp();
			$( '#wimplecf_typevalue' ).slideUp();
			$( '#wimplecf_type_value' ).val('');
			$( '#wimplecf_charlimit' ).slideUp();
			$( '#wimplecf_char_limit' ).val('');
			$( '#wimplecf_notetext_block' ).slideUp();
			$( '#wimplecf_note_text' ).val('');	
			$( "#wimplecf_captcha_length" ).val( wimplecf_editable_field_val_each[17] );			
			$( '#wimplecf_placeholder_div' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_validation_checklist' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( "#wimplecf_field_width" ).find( "option" ).remove( ).end( ).append(
			'<option value="100">100%</option><option value="50">50%</option>');
		}
		else
		{
			$( '#wimplecf_typevalue' ).slideUp();
			$( '#wimplecf_type_value' ).val('');
			$( '#wimplecf_charlimit' ).slideUp();
			$( '#wimplecf_char_limit' ).val('');
			$( '#wimplecf_notetext_block' ).slideUp();
			$( '#wimplecf_note_text' ).val('');	
			$( '#wimplecf_dateformat_block' ).slideUp();			
			$( '#wimplecf_placeholder_div' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_validation_checklist' ).removeClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_emailidrequiredID' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( '#wimplecf_numericonlyID' ).addClass( 'wimplecf_horizental_pos_disable' );
		}
		
		if ( wimplecf_editable_field_val_each[4] == 'on' )
		{
			$( "#wimplecf_mandatory" ).prop( "checked", true );
		}
		else
		{
			$( "#wimplecf_mandatory" ).prop( "checked", false );
		}
		
		
		if ( wimplecf_editable_field_val_each[5] == 'on' )
		{
			$( "#wimplecf_email_validation" ).prop( "checked", true );
		}
		else
		{
			$( "#wimplecf_email_validation" ).prop( "checked", false );
		}
		
		if ( $( "#wimplecf_mandatory" ).is( ':checked' ) || $( "#wimplecf_email_validation" ).is( ':checked' ) )
		{
			$( '#wimplecf_error_input' ).removeClass( 'wimplecf_horizental_pos_disable' );
			$( "#wimplecf_error_validation" ).slideDown( );
		}
		else
		{
			$( '#wimplecf_error_input' ).addClass( 'wimplecf_horizental_pos_disable' );
			$( "#wimplecf_error_validation" ).slideUp( );
		}
		
		
		if ( wimplecf_editable_field_val_each[6] == '100' )
		{
			var wimplecf_width_index = '0';
		}
		else if ( wimplecf_editable_field_val_each[6] == '50' )
		{
			var wimplecf_width_index = '1';
		}
		else if ( wimplecf_editable_field_val_each[6] == '33' )
		{
			var wimplecf_width_index = '2';
		}
		else if ( wimplecf_editable_field_val_each[6] == '25' )
		{
			var wimplecf_width_index = '3';
		}
		$( "#wimplecf_field_width" ).prop( "selectedIndex", wimplecf_width_index );
		
		$( "#wimplecf_vertical_pos" ).prop( "selectedIndex", 0 );
		
		$( '#wimplecf_edited_row_number' ).val( wimplecf_editable_field_val_each[7] );
		
		$( "#wimplecf_row_num" ).prop( "selectedIndex", wimplecf_editable_field_val_each[7] );
			
		
		
		var wimplecf_row_wise_cols = '';
				
		$( '[id*="wimplecf_row_col_'+wimplecf_editable_field_val_each[7]+'_"]' ).each( function( ) 
		{
			wimplecf_row_wise_cols += $( this ).val()+',';
		});
		
		var wimplecf_col_listing = ( wimplecf_row_wise_cols.replace(/^,|,$/g,'') ).split( "," );
		var wimplecf_field_listing = '';
		
		for ( var i = 0; i < wimplecf_col_listing.length; i++ ) 
		{
			var wimplecf_each_col_listing = wimplecf_col_listing[i].split( "~" );
			wimplecf_field_listing += '<option value="'+wimplecf_each_col_listing[8]+'">'+wimplecf_each_col_listing[1]+'</option>';
		}
		
		var wimplecf_field_width 	= $( '#wimplecf_field_width' ).val();
		var wimplecf_selected_row 	= $( '#wimplecf_row_num' ).val();
		var wimplecf_vertical_pos 	= $( '#wimplecf_vertical_pos' ).val();
		
		if ( wimplecf_vertical_pos == 'wimplecf_vertical_at' && 
			 wimplecf_selected_row != 'wimplecf_newrow' && 
			 wimplecf_field_width != 100 )
		{			
			if ( wimplecf_editable_field_val_each[8] > 1 )
			{			
				$( '#wimplecf_colomn_num' ).html( wimplecf_field_listing );
				$( "#wimplecf_horizental_pos" ).prop( "selectedIndex", 1 );
				$( "#wimplecf_colomn_num" ).prop( "selectedIndex", wimplecf_editable_field_val_each[8]-2 );
				$( '#wimplecf_within_row' ).removeClass( 'wimplecf_horizental_pos_disable' );
			}
			else if ( wimplecf_col_listing.length == 1 )
			{
				$( '#wimplecf_colomn_num' ).html( wimplecf_field_listing );
				$( "#wimplecf_horizental_pos" ).prop( "selectedIndex", 0 );
				$( "#wimplecf_colomn_num" ).prop( "selectedIndex", 0 );
				$( '#wimplecf_within_row' ).addClass( 'wimplecf_horizental_pos_disable' );
			}
			else
			{
				$( '#wimplecf_colomn_num' ).html( wimplecf_field_listing );
				$( "#wimplecf_horizental_pos" ).prop( "selectedIndex", 0 );
				$( "#wimplecf_colomn_num" ).prop( "selectedIndex", 1 );
				$( '#wimplecf_within_row' ).removeClass( 'wimplecf_horizental_pos_disable' );
			}
		}
		else
		{
			$( '#wimplecf_colomn_num' ).html( wimplecf_field_listing );
			$( '#wimplecf_within_row' ).addClass( 'wimplecf_horizental_pos_disable' );
		}
		
		
		$( "#wimplecf_helptext" ).val( wimplecf_editable_field_val_each[10] );
		
		$( "#wimplecf_validation_msg" ).val( wimplecf_editable_field_val_each[11] );
		
		$( "#wimplecf_placeholder" ).val( wimplecf_editable_field_val_each[12] );
		
		if ( wimplecf_editable_field_val_each[13] == 'on' )
		{
			$( "#wimplecf_numericonly" ).prop( "checked", true );
		}
		else
		{
			$( "#wimplecf_numericonly" ).prop( "checked", false );
		}
	});
});
</script>
	

<?php
add_action( 'admin_footer', 'wimplecf_add_new_field' );
function wimplecf_add_new_field() 
{ ?> 
	<script type="text/javascript">
	jQuery( document ).ready( function( $ )
	{
		var wimplecf_numoffieldcreated = $( '#wimplecf_numberoffieldcreated' ).val();
		if ( wimplecf_numoffieldcreated > 0 )
		{
			$( '#wimplecf_dummy_submit_button' ).show();
		}
		
		$( '#wimplecf_addnew_field' ).click( function( )
		{
			var wimplecf_edit_field_id 		= $( '#wimplecf_edit_mode' ).val();
			var wimplecf_first_value 		= $( '#wimplecf_first_value' ).val();
			var wimplecf_numoffieldcreated 	= $( '#wimplecf_numberoffieldcreated' ).val();
			var wimplecf_current_form 		= $( '#wimplecf_current_form' ).val();
			var selected_field_val 			= $( '#wimplecf_row_col_'+wimplecf_edit_field_id ).val();
			var wimplecf_field_type 		= $( '#wimplecf_field_type' ).val();
			var wimplecf_label_name 		= $( '#wimplecf_label_name' ).val().replace(/,/g, "")
																			   .replace(/~/g, "")
																			   .replace(/@/g, "")
																			   .replace(/<>/g, "");

			var wimplecf_char_limit 		= $( '#wimplecf_char_limit' ).val();
			var wimplecf_type_value 		= $.trim($( '#wimplecf_type_value' ).val().replace(/,/g, "")
																					  .replace(/~/g, "")
																					  .replace(/@/g, "")
																					  .replace(/<>/g, ""));
																					  
			var wimplecf_note_type_text 	= $("#wimplecf_note_text_ifr").contents().find("body").html().replaceAll('&nbsp;', '')
																										 .replaceAll('<p><br data-mce-bogus="1"></p>', '')
																										 .replaceAll('<p> <br data-mce-bogus="1"></p>', '')
																										 .replace(/,/g, '&comma;')
																									     .replace(/&/g, '&amp;')
																									     .replace(/>/g, '&gt;')
																									     .replace(/</g, '&lt;')
																									     .replace(/"/g, '&quot;')
																									     .replace(/'/g, '&apos;');
         	

			var wimplecf_date_format		= $( '#wimplecf_dateformatlist' ).val().replace(/,/g, "commaencode"); 
			var wimplecf_dateupperlimit		= $( '#wimplecf_dateupperlimit' ).val();
																										 
			var wimplecf_captcha_length 	= $( '#wimplecf_captcha_length' ).val();

			
			if ( wimplecf_type_value.slice( 0,1 ) == '|' )
			{
				var wimplecf_type_value = wimplecf_type_value.slice( 1 );
			}
			
			if ( wimplecf_type_value.slice( -1 ) == '|' )
			{
				var wimplecf_type_value = wimplecf_type_value.slice( 0,-1 );
			}
						
			if ( $( "#wimplecf_mandatory" ).is( ':checked' ) ) 
			{
				var wimplecf_mandatory = "on";
			}
			else
			{
				var wimplecf_mandatory = "off";
			}

			if ( $( "#wimplecf_email_validation" ).is( ':checked' ) ) 
			{
				var wimplecf_email_validation = "on";
			}
			else
			{
				var wimplecf_email_validation = "off";
			}
			
			if ( $( "#wimplecf_numericonly" ).is( ':checked' ) ) 
			{
				var wimplecf_numericonly = "on";
			}
			else
			{
				var wimplecf_numericonly = "off";
			}
			
			if ( wimplecf_field_type != 'date' )
			{
				wimplecf_date_format = '';
				wimplecf_dateupperlimit = '';
			}
			
			if ( wimplecf_field_type != 'note' )
			{
				wimplecf_note_type_text = '';
			}
			
			if ( wimplecf_field_type != 'captchacode' )
			{
				wimplecf_captcha_length = '';
			}
						
			var wimplecf_field_width 		= $( '#wimplecf_field_width' ).val();
			var wimplecf_vertical_pos 		= $( '#wimplecf_vertical_pos' ).val();
			var wimplecf_row_num 			= $( '#wimplecf_row_num' ).val();
			var wimplecf_horizental_pos 	= $( '#wimplecf_horizental_pos' ).val();
			var wimplecf_colomn_num 		= $( '#wimplecf_colomn_num' ).val();
			var wimplecf_placeholder 		= $( '#wimplecf_placeholder' ).val().replace(/,/g, "").replace(/~/g, "").replace(/@/g, "").replace(/<>/g, "");
			var wimplecf_helptext 			= $( '#wimplecf_helptext' ).val().replace(/,/g, "").replace(/~/g, "").replace(/@/g, "").replace(/<>/g, "");
			var wimplecf_validation_msg 	= $( '#wimplecf_validation_msg' ).val().replace(/,/g, "").replace(/~/g, "").replace(/@/g, "").replace(/<>/g, "");
			
			if ( wimplecf_field_type == 'captchacode' )
			{
				var wimplecf_field_name = 'wimplecf_captchacode1';
			}
			else if ( wimplecf_field_type == 'recaptchacode' )
			{
				var wimplecf_field_name = 'wimplecf_recaptchacode_fieldname';
			}
			else if ( wimplecf_field_type == 'note' )
			{
				var wimplecf_field_name = 'wimplecf_'+ $.now();
			}
			else
			{
				var wimplecf_field_name = 'wimplecf_'+( wimplecf_label_name.replace(/[_\W]+/g, '') ).toLowerCase(); 
			}
						
			var wimplecf_next_row_num       = $( '#wimplecf_next_row_num' ).val();
			var wimplecf_row_max_num        = wimplecf_next_row_num - 1;
			
			var wimplecf_all_inputs = '';
			$( "input[name='hiddenvalus[]']" ).each( function() 
			{
				wimplecf_all_inputs += $( this ).val()+',';
			});
			
			var wimplecf_all_inputs_splitted = ( wimplecf_all_inputs.replace(/^,|,$/g,'') ).split( "," );
			
			var wimplecf_rows = [];
			for ( var i = 0; i < wimplecf_all_inputs_splitted.length; i++ ) 
			{
				var wimplecf_each_rows = wimplecf_all_inputs_splitted[i].split( "~" );
				wimplecf_rows.push( wimplecf_each_rows[7] );
			}
			
			wimplecf_previous_input_data = [];
			$( "input[name='hiddenvalus[]']" ).each( function( ) 
			{
				wimplecf_previous_input_data.push( $( this ).val() );
			});
			var data = 
			{
				'action': 'wimplecf_add_new_field_validation_action',
				'wimplecf_label_name':wimplecf_label_name,
				'wimplecf_field_type':wimplecf_field_type,
				'wimplecf_char_limit':wimplecf_char_limit,
				'wimplecf_type_value':wimplecf_type_value,
				'wimplecf_note_type_text':wimplecf_note_type_text,
				'wimplecf_mandatory':wimplecf_mandatory,
				'wimplecf_field_width':wimplecf_field_width,
				'wimplecf_vertical_pos':wimplecf_vertical_pos,
				'wimplecf_row_num':wimplecf_row_num,
				'wimplecf_validation_msg':wimplecf_validation_msg,
				'wimplecf_hidden_values':wimplecf_previous_input_data,
				'wimplecf_edit_field_id':wimplecf_edit_field_id,
				'selected_field_val':selected_field_val
			};
			jQuery.post( ajaxurl, data, function( response ) 
			{
				var ajaxreturn = response.split( "@" );
				
				if ( ajaxreturn[0] == 'Error' )
				{
					var returnvalue = ajaxreturn[1].split( "||" );
					$( '#'+returnvalue[0]).html( returnvalue[1] );
					$( "#wimplecf_row_col_"+returnvalue[2] ).val( returnvalue[3] );
					
					$( '#'+returnvalue[0] )[0].scrollIntoView( true );
					$( '#'+returnvalue[0] ).scrollTop( 300 );
				}
				else
				{			
					if ( wimplecf_vertical_pos == 'wimplecf_vertical_before' )
					{
						var wimplecf_default_colomn_num = '1';
						if(wimplecf_edit_field_id != '')
						{
							$( '#wimplecf_rownum_'+wimplecf_row_num ).before( $( "#wimplecf_row_col_"+wimplecf_edit_field_id ).val( 'wimplecf_newelement~'
																																	+wimplecf_label_name+'~'
																																	+wimplecf_field_type+'~'
																																	+wimplecf_type_value+'~'
																																	+wimplecf_mandatory+'~'
																																	+wimplecf_email_validation+'~'
																																	+wimplecf_field_width+'~'
																																	+wimplecf_row_num+'~'
																																	+wimplecf_default_colomn_num+'~'
																																	+wimplecf_field_name+'~'
																																	+wimplecf_helptext+'~'
																																	+wimplecf_validation_msg+'~'
																																	+wimplecf_placeholder+'~'
																																	+wimplecf_numericonly+'~'
																																	+wimplecf_char_limit+'~'
																																	+wimplecf_note_type_text+'~'
																																	+wimplecf_date_format+'~' 
																																	+wimplecf_captcha_length+'~' 
																																	+wimplecf_dateupperlimit ) );
						}
						else
						{
							$( '#wimplecf_rownum_'+wimplecf_row_num ).before( '<input type="hidden" id="wimplecf_newinput" name="hiddenvalus[]" value="wimplecf_newelement~'
																																					   +wimplecf_label_name+'~'
																																					   +wimplecf_field_type+'~'
																																					   +wimplecf_type_value+'~'
																																					   +wimplecf_mandatory+'~'
																																					   +wimplecf_email_validation+'~'
																																					   +wimplecf_field_width+'~'
																																					   +wimplecf_row_num+'~'
																																					   +wimplecf_default_colomn_num+'~'
																																					   +wimplecf_field_name+'~'
																																					   +wimplecf_helptext+'~'
																																					   +wimplecf_validation_msg+'~'
																																					   +wimplecf_placeholder+'~'
																																					   +wimplecf_numericonly+'~'
																																					   +wimplecf_char_limit+'~'
																																					   +wimplecf_note_type_text.replace(/,/g, '&comma;')
																																											   .replace(/&/g, '&amp;')
																																											   .replace(/>/g, '&gt;')
																																											   .replace(/</g, '&lt;')
																																											   .replace(/"/g, '&quot;')
																																											   .replace(/'/g, '&apos;')+'~'
																																					   +wimplecf_date_format+'~' 
																																					   +wimplecf_captcha_length+'~' 
																																	                   +wimplecf_dateupperlimit+'">' );
						}
					}
					else if ( wimplecf_vertical_pos == 'wimplecf_vertical_after' )
					{
						var wimplecf_default_colomn_num = '1';
						if ( wimplecf_edit_field_id != '' )
						{
							$( '#wimplecf_rownum_'+wimplecf_row_num ).after( $( "#wimplecf_row_col_"+wimplecf_edit_field_id ).val( 'wimplecf_newelement~'
																																	+wimplecf_label_name+'~'
																																	+wimplecf_field_type+'~'
																																	+wimplecf_type_value+'~'
																																	+wimplecf_mandatory+'~'
																																	+wimplecf_email_validation+'~'
																																	+wimplecf_field_width+'~'
																																	+wimplecf_row_num+'~'
																																	+wimplecf_default_colomn_num+'~'
																																	+wimplecf_field_name+'~'
																																	+wimplecf_helptext+'~'
																																	+wimplecf_validation_msg+'~'
																																	+wimplecf_placeholder+'~'
																																	+wimplecf_numericonly+'~'
																																	+wimplecf_char_limit+'~'
																																	+wimplecf_note_type_text+'~'
																																	+wimplecf_date_format+'~' 
																																	+wimplecf_captcha_length+'~' 
																																	+wimplecf_dateupperlimit ) );
						}
						else
						{
							$( '#wimplecf_rownum_'+wimplecf_row_num ).after( '<input type="hidden" id="wimplecf_newinput" name="hiddenvalus[]" value="wimplecf_newelement~'
																																					  +wimplecf_label_name+'~'
																																					  +wimplecf_field_type+'~'
																																					  +wimplecf_type_value+'~'
																																					  +wimplecf_mandatory+'~'
																																					  +wimplecf_email_validation+'~'
																																					  +wimplecf_field_width+'~'
																																					  +wimplecf_row_num+'~'
																																					  +wimplecf_default_colomn_num+'~'
																																					  +wimplecf_field_name+'~'
																																					  +wimplecf_helptext+'~'
																																					  +wimplecf_validation_msg+'~'
																																					  +wimplecf_placeholder+'~'
																																					  +wimplecf_numericonly+'~'
																																					  +wimplecf_char_limit+'~'
																																					  +wimplecf_note_type_text.replace(/,/g, '&comma;')
																																											  .replace(/&/g, '&amp;')
																																											  .replace(/>/g, '&gt;')
																																											  .replace(/</g, '&lt;')
																																											  .replace(/"/g, '&quot;')
																																											  .replace(/'/g, '&apos;')+'~'
																																					  +wimplecf_date_format+'~' 
																																					  +wimplecf_captcha_length+'~' 
																																	                  +wimplecf_dateupperlimit+'">' );
						}
					}
					else if ( wimplecf_vertical_pos == 'wimplecf_vertical_at' && wimplecf_row_num == 'wimplecf_newrow' )
					{
						var wimplecf_default_colomn_num = '1';
						if ( wimplecf_numoffieldcreated == 0 )
						{
							$( '#wimplecf_first_input_hidden' ).html( '<input type="hidden" id="wimplecf_newinput" name="hiddenvalus[]" value="wimplecf_newelement~'
																																			   +wimplecf_label_name+'~'
																																			   +wimplecf_field_type+'~'
																																			   +wimplecf_type_value+'~'
																																			   +wimplecf_mandatory+'~'
																																			   +wimplecf_email_validation+'~'
																																			   +wimplecf_field_width+'~'
																																			   +wimplecf_row_num+'~'
																																			   +wimplecf_default_colomn_num+'~'
																																			   +wimplecf_field_name+'~'
																																			   +wimplecf_helptext+'~'
																																			   +wimplecf_validation_msg+'~'
																																			   +wimplecf_placeholder+'~'
																																			   +wimplecf_numericonly+'~'
																																			   +wimplecf_char_limit+'~'
																																			   +wimplecf_note_type_text.replace(/,/g, '&comma;')
																																									   .replace(/&/g, '&amp;')
																																									   .replace(/>/g, '&gt;')
																																									   .replace(/</g, '&lt;')
																																									   .replace(/"/g, '&quot;')
																																									   .replace(/'/g, '&apos;')+'~'
																																	           +wimplecf_date_format+'~' 
																																			   +wimplecf_captcha_length+'~' 
																																	           +wimplecf_dateupperlimit+'">' );
						
						}
						else
						{
							if ( wimplecf_edit_field_id != '' )
							{
								$( '#wimplecf_rownum_'+wimplecf_row_max_num ).after( $( "#wimplecf_row_col_"+wimplecf_edit_field_id ).val( 'wimplecf_newelement~'
																																			+wimplecf_label_name+'~'
																																			+wimplecf_field_type+'~'
																																			+wimplecf_type_value+'~'
																																			+wimplecf_mandatory+'~'
																																			+wimplecf_email_validation+'~'
																																			+wimplecf_field_width+'~'
																																			+wimplecf_row_num+'~'
																																			+wimplecf_default_colomn_num+'~'
																																			+wimplecf_field_name+'~'
																																			+wimplecf_helptext+'~'
																																			+wimplecf_validation_msg+'~'
																																			+wimplecf_placeholder+'~'
																																			+wimplecf_numericonly+'~'
																																			+wimplecf_char_limit+'~'
																																			+wimplecf_note_type_text+'~'
																																	        +wimplecf_date_format+'~' 
																																	        +wimplecf_captcha_length+'~' 
																																	        +wimplecf_dateupperlimit ) );
							}
							else
							{
								$( '#wimplecf_rownum_'+wimplecf_row_max_num ).after( '<input type="hidden" id="wimplecf_newinput" name="hiddenvalus[]" value="wimplecf_newelement~'
																																							  +wimplecf_label_name+'~'
																																							  +wimplecf_field_type+'~'
																																							  +wimplecf_type_value+'~'
																																							  +wimplecf_mandatory+'~'
																																							  +wimplecf_email_validation+'~'
																																							  +wimplecf_field_width+'~'
																																							  +wimplecf_row_num+'~'
																																							  +wimplecf_default_colomn_num+'~'
																																							  +wimplecf_field_name+'~'
																																							  +wimplecf_helptext+'~'
																																							  +wimplecf_validation_msg+'~'
																																							  +wimplecf_placeholder+'~'
																																							  +wimplecf_numericonly+'~'
																																							  +wimplecf_char_limit+'~'
																																							  +wimplecf_note_type_text.replace(/,/g, '&comma;')
																																													  .replace(/&/g, '&amp;')
																																													  .replace(/>/g, '&gt;')
																																													  .replace(/</g, '&lt;')
																																													  .replace(/"/g, '&quot;')
																																													  .replace(/'/g, '&apos;')+'~'
																																	                          +wimplecf_date_format+'~' 
																																	                          +wimplecf_captcha_length+'~' 
																																	                          +wimplecf_dateupperlimit+'">' );
							}
						}
						
					}
					else if ( wimplecf_vertical_pos == 'wimplecf_vertical_at' && wimplecf_row_num != 'wimplecf_newrow' )
					{
						if ( wimplecf_edit_field_id != '' && 
						   wimplecf_edit_field_id == wimplecf_row_num+'_'+wimplecf_colomn_num )
						{
							$( "#wimplecf_row_col_"+wimplecf_edit_field_id ).val( 'wimplecf_newelement~'
																				   +wimplecf_label_name+'~'
																				   +wimplecf_field_type+'~'
																				   +wimplecf_type_value+'~'
																				   +wimplecf_mandatory+'~'
																				   +wimplecf_email_validation+'~'
																				   +wimplecf_field_width+'~'
																				   +wimplecf_row_num+'~'
																				   +wimplecf_colomn_num+'~'
																				   +wimplecf_field_name+'~'
																				   +wimplecf_helptext+'~'
																				   +wimplecf_validation_msg+'~'
																				   +wimplecf_placeholder+'~'
																				   +wimplecf_numericonly+'~'
																				   +wimplecf_char_limit+'~'
																				   +wimplecf_note_type_text+'~'
																				   +wimplecf_date_format+'~'
																				   +wimplecf_captcha_length+'~' 
																				   +wimplecf_dateupperlimit );
						}
						else
						{
							if ( wimplecf_horizental_pos == 'wimplecf_horizental_left' )
							{
								if ( wimplecf_edit_field_id != '' )
								{
									$( '#wimplecf_row_col_'+wimplecf_row_num+'_'+wimplecf_colomn_num ).before( $( "#wimplecf_row_col_"+wimplecf_edit_field_id).val( 'wimplecf_newelement~'
																																									 +wimplecf_label_name+'~'
																																									 +wimplecf_field_type+'~'
																																									 +wimplecf_type_value+'~'
																																									 +wimplecf_mandatory+'~'
																																									 +wimplecf_email_validation+'~'
																																									 +wimplecf_field_width+'~'
																																									 +wimplecf_row_num+'~'
																																									 +wimplecf_default_colomn_num+'~'
																																									 +wimplecf_field_name+'~'
																																									 +wimplecf_helptext+'~'
																																									 +wimplecf_validation_msg+'~'
																																									 +wimplecf_placeholder+'~'
																																									 +wimplecf_numericonly+'~'
																																									 +wimplecf_char_limit+'~'
																																									 +wimplecf_note_type_text+'~'
																																	                                 +wimplecf_date_format+'~' 
																																	                                 +wimplecf_captcha_length+'~' 
																																	                                 +wimplecf_dateupperlimit ) );
								}
								else
								{
									$( '#wimplecf_row_col_'+wimplecf_row_num+'_'+wimplecf_colomn_num ).before( '<input type="hidden" id="wimplecf_newinput" name="hiddenvalus[]" value="wimplecf_newelement~'
																																														+wimplecf_label_name+'~'
																																														+wimplecf_field_type+'~'
																																														+wimplecf_type_value+'~'
																																														+wimplecf_mandatory+'~'
																																														+wimplecf_email_validation+'~'
																																														+wimplecf_field_width+'~'
																																														+wimplecf_row_num+'~'
																																														+wimplecf_colomn_num+'~'
																																														+wimplecf_field_name+'~'
																																														+wimplecf_helptext+'~'
																																														+wimplecf_validation_msg+'~'
																																														+wimplecf_placeholder+'~'
																																														+wimplecf_numericonly+'~'
																																														+wimplecf_char_limit+'~'
																																														+wimplecf_note_type_text+'~'
																																	                                                    +wimplecf_date_format+'~' 
																																	                                                    +wimplecf_captcha_length+'~' 
																																	                                                    +wimplecf_dateupperlimit+'">' );
								}
							}
							else
							{
								if ( wimplecf_edit_field_id != '' )
								{
									$( '#wimplecf_row_col_'+wimplecf_row_num+'_'+wimplecf_colomn_num ).after( $( "#wimplecf_row_col_"+wimplecf_edit_field_id).val( 'wimplecf_newelement~'
																																									+wimplecf_label_name+'~'
																																									+wimplecf_field_type+'~'
																																									+wimplecf_type_value+'~'
																																									+wimplecf_mandatory+'~'
																																									+wimplecf_email_validation+'~'
																																									+wimplecf_field_width+'~'
																																									+wimplecf_row_num+'~'
																																									+wimplecf_default_colomn_num+'~'
																																									+wimplecf_field_name+'~'
																																									+wimplecf_helptext+'~'
																																									+wimplecf_validation_msg+'~'
																																									+wimplecf_placeholder+'~'
																																									+wimplecf_numericonly+'~'
																																									+wimplecf_char_limit+'~'
																																									+wimplecf_note_type_text+'~'
																																	                                +wimplecf_date_format+'~' 
																																	                                +wimplecf_captcha_length+'~' 
																																	                                +wimplecf_dateupperlimit ) );
								}
								else
								{
									$( '#wimplecf_row_col_'+wimplecf_row_num+'_'+wimplecf_colomn_num ).after( '<input type="hidden" id="wimplecf_newinput" name="hiddenvalus[]" value="wimplecf_newelement~'
																																													   +wimplecf_label_name+'~'
																																													   +wimplecf_field_type+'~'
																																													   +wimplecf_type_value+'~'
																																													   +wimplecf_mandatory+'~'
																																													   +wimplecf_email_validation+'~'
																																													   +wimplecf_field_width+'~'
																																													   +wimplecf_row_num+'~'
																																													   +wimplecf_colomn_num+'~'
																																													   +wimplecf_field_name+'~'
																																													   +wimplecf_helptext+'~'
																																													   +wimplecf_validation_msg+'~'
																																													   +wimplecf_placeholder+'~'
																																													   +wimplecf_numericonly+'~'
																																													   +wimplecf_char_limit+'~'
																																													   +wimplecf_note_type_text+'~'
																																	                                                   +wimplecf_date_format+'~' 
																																	                                                   +wimplecf_captcha_length+'~' 
																																	                                                   +wimplecf_dateupperlimit+'">' );
								}
							}
						}
					}
					
					form_data = [];
					$( "input[name='hiddenvalus[]']" ).each( function( ) 
					{
						form_data.push( $( this ).val() );
					});
					//exit;
					var data = 
					{
						'action': 'wimplecf_add_new_field_action',
						'wimplecf_vertical_pos':wimplecf_vertical_pos,
						'wimplecf_row_num':wimplecf_row_num,
						'wimplecf_horizental_pos':wimplecf_horizental_pos,
						'wimplecf_colomn_num':wimplecf_colomn_num,
						'wimplecf_hidden_values':form_data,
						'wimplecf_next_row_num':wimplecf_next_row_num,
						'wimplecf_edit_field_id':wimplecf_edit_field_id,
						'wimplecf_rows':wimplecf_rows,
						'wimplecf_first_value':wimplecf_first_value
					};

					jQuery.post( ajaxurl, data, function( response ) 
					{
						var ajaxreturn = response.split( "@" );
						if ( ajaxreturn[0] == 'Success' )
						{
							var returnvalue = ajaxreturn[1].split( "<>" );
														
							$( "#wimplecf_next_row_num" ).val( returnvalue[0] );
							$( '#wimplecf_row_num' ).html( returnvalue[1] );
							$( '.wimplecf_form_content' ).html( returnvalue[2] );
							$( '.wimplecf_left_sec' ).removeClass( 'wimplecf_focus_on_left' );
							$( '.wimplecf_right_sec' ).addClass( 'wimplecf_focus_on_right' );
							$( '#wimplecf_label_name' ).attr("placeholder", "Maximum 50 characters (required)");
							$( "#wimplecf_edit_mode" ).val('');
							$( "#wimplecf_first_value" ).val('');
							$( "#wimplecf_edited_row_number" ).val('');
							$( '#wimplecf_dummy_submit_button' ).show();
							$( '#wimplecf_numberoffieldcreated' ).val( returnvalue[0]-1 );
							$( '.wimplecf_left_sec input[type="text"]' ).val('');
							$("#wimplecf_note_text_ifr").contents().find("body").html( 'Maximum 500 characters (required)' );
							$( '.wimplecf_left_sec select' ).prop( "selectedIndex", 0 );
							$( '#wimplecf_typevalue' ).slideUp();
							$( '#wimplecf_notetext_block' ).slideUp();
							$( '#wimplecf_dateformat_block' ).slideUp();
							$( '#wimplecf_captchablock' ).slideUp();
							$( '#wimplecf_recaptchablock' ).slideUp();
							$( '#wimplecf_charlimit' ).slideDown();
							$( "#wimplecf_mandatory" ).prop( "checked", false );
							$( "#wimplecf_email_validation" ).prop( "checked", false );
							$( "#wimplecf_numericonly" ).prop( "checked", false );
							$( '#wimplecf_placeholder_div' ).removeClass( 'wimplecf_horizental_pos_disable' );
							$( '#wimplecf_validation_checklist' ).removeClass( 'wimplecf_horizental_pos_disable' );
							$( '#wimplecf_emailidrequiredID' ).removeClass( 'wimplecf_horizental_pos_disable' );
							$( '#wimplecf_numericonlyID' ).removeClass( 'wimplecf_horizental_pos_disable' );
							$( '#wimplecf_helptext_block' ).removeClass( 'wimplecf_horizental_pos_disable' );
							$( '#wimplecf_error_input' ).addClass( 'wimplecf_horizental_pos_disable' );
							$( '#wimplecf_within_row' ).addClass( 'wimplecf_horizental_pos_disable' );
							$( '#wimplecf_colomn_num' ).html( '<option value="1">First Field</option>' );
							$( "div" ).removeClass( "wimplecf_selected_col" );
							$("#wimplecf_field_width").find("option").remove().end().append(
							'<option value="100">100%</option><option value="50">50%</option><option value="33">33%</option><option value="25">25%</option>');
							$( '#wimplecf_addnew_field' ).html( 'Add Field' );
							
							$( 'option[value="wimplecf_vertical_before"]' ).slideDown( );
							$( 'option[value="wimplecf_vertical_after"]' ).slideDown( );
		
							$( '#wimplecf_validation_msg' ).val( '' );
							$( "#wimplecf_page_current_status" ).val( 'DB_UPDATE_DUE' );
							
							$( 'html, body' ).animate({
							scrollTop: $( '.wimplecf_right_sec' ).offset().top - 20
							}, 'slow' );
						}
					});						
				}
			});
		});
		
	});
	</script>
<?php } 


add_action( 'admin_footer', 'wimplecf_delete_row_col');
function wimplecf_delete_row_col() 
{ ?> 
	<script type="text/javascript">
	jQuery( document ).ready( function( $ )
	{	
		var wimplecf_numoffieldcreated = $( '#wimplecf_numberoffieldcreated' ).val();
		if ( wimplecf_numoffieldcreated > 0 )
		{
			$( '#wimplecf_dummy_submit_button' ).show();
		}
		else
		{
			$( '#wimplecf_dummy_submit_button' ).hide();
		}
		
		$( document ).on( 'click', '.wimplecf_delete', function ( ) 
		{
			$( ".wimplecf_right_sec" ).addClass( "wimplecf_focus_on_right" );
			$( '.wimplecf_left_sec' ).removeClass( 'wimplecf_focus_on_left' );
		
			var wimplecf_field_id = $( this ).attr( "id" ); 			
			var wimplecf_splited_row_col = wimplecf_field_id.split( "~" );
			var wimplecf_delete_row_col_id = wimplecf_splited_row_col[1];
			
			wimplecf_total_deleting_inputs = $( '[id*="wimplecf_row_col_'+wimplecf_delete_row_col_id+'_"]' ).length;
			if ( wimplecf_total_deleting_inputs == 1 )
			{
				var deleting_row_msg = 'Are you sure about deleting this row?';
			}
			else
			{
				var deleting_row_msg = 'Deleting the row will eliminate all the '+wimplecf_total_deleting_inputs+' fields of this row. \nDo you want to proceed?';
			}
				
			if (confirm( deleting_row_msg ) )
			{
				var wimplecf_deleted_inputs = $( '#wimplecf_deleted_field_ids' ).val()+',';
				
				$( '[id*="wimplecf_row_col_'+wimplecf_delete_row_col_id+'_"]' ).each( function( ) 
				{
					wimplecf_deleted_inputs += $( this ).val()+',';
				});
				
				var wimplecf_deleted_inputs_splitted = ( wimplecf_deleted_inputs.replace(/^,|,$/g,'') ).split( "," );
				var wimplecf_deleted_row_ids = [];
				
				for ( var i = 0; i < wimplecf_deleted_inputs_splitted.length; i++ ) 
				{
					var wimplecf_each_rows = wimplecf_deleted_inputs_splitted[i].split( "~" );
					
					if( wimplecf_each_rows[0] != 'wimplecf_newelement_temp')
					{
						wimplecf_deleted_row_ids.push( wimplecf_each_rows[0] );
					}
				}
				
				$( '#wimplecf_deleted_field_ids' ).val( wimplecf_deleted_row_ids );
				
				$( '[id*="wimplecf_row_col_'+wimplecf_delete_row_col_id+'_"]' ).remove();

				var wimplecf_current_form_name = $( '#wimplecf_current_form_name' ).val();
				var wimplecf_next_row_num = $( '#wimplecf_next_row_num' ).val();
				
				form_data = [];
				$( "input[name='hiddenvalus[]']" ).each( function( ) 
				{
					form_data.push( $( this ).val() );
				});

				var data = 
				{
					'action': 'wimplecf_delete_row_col_action',
					'wimplecf_delete_row_col_id':wimplecf_delete_row_col_id,
					'wimplecf_current_form_name':wimplecf_current_form_name,
					'wimplecf_next_row_num':wimplecf_next_row_num,
					'wimplecf_hidden_values':form_data
				};

				jQuery.post( ajaxurl, data, function( response ) 
				{
					var ajaxreturn = response.split( "@" );
					if ( ajaxreturn[0] == 'Success' )
					{
						var returnvalue = ajaxreturn[1].split( "<>" );
						$( '#wimplecf_next_row_num' ).val( returnvalue[0] );
						$( '#wimplecf_row_num' ).html( returnvalue[1] );
						$( '.wimplecf_form_content' ).html( returnvalue[2] );
						$( '#wimplecf_numberoffieldcreated' ).val( returnvalue[0]-1 );
						$( '.wimplecf_left_sec' ).removeClass( 'wimplecf_focus_on_left' );
						$( '.wimplecf_right_sec' ).removeClass( 'wimplecf_focus_on_right' );
						$( '#wimplecf_label_name' ).attr("placeholder", "Maximum 50 characters (required)");
						$( "#wimplecf_edit_mode" ).val('');
						$( "#wimplecf_first_value" ).val('');
						$( "#wimplecf_edited_row_number" ).val('');
						$( '.wimplecf_left_sec input[type="text"]' ).val('');
						$( '.wimplecf_error_message' ).html('');
						$("#wimplecf_note_text_ifr").contents().find("body").html( 'Maximum 500 characters (required)' );
						$( '.wimplecf_left_sec select' ).prop( "selectedIndex", 0 );
						$( '#wimplecf_typevalue' ).slideUp();
						$( '#wimplecf_notetext_block' ).slideUp();
						$( '#wimplecf_dateformat_block' ).slideUp();
						$( '#wimplecf_captchablock' ).slideUp();
						$( '#wimplecf_recaptchablock' ).slideUp();
						$( '#wimplecf_charlimit' ).slideDown();
						$( "#wimplecf_mandatory" ).prop( "checked", false );
						$( "#wimplecf_email_validation" ).prop( "checked", false );
						$( "#wimplecf_numericonly" ).prop( "checked", false );
						$( '#wimplecf_placeholder_div' ).removeClass( 'wimplecf_horizental_pos_disable' );
						$( '#wimplecf_validation_checklist' ).removeClass( 'wimplecf_horizental_pos_disable' );
						$( '#wimplecf_emailidrequiredID' ).removeClass( 'wimplecf_horizental_pos_disable' );
						$( '#wimplecf_numericonlyID' ).removeClass( 'wimplecf_horizental_pos_disable' );
						$( '#wimplecf_helptext_block' ).removeClass( 'wimplecf_horizental_pos_disable' );
						$( '#wimplecf_error_input' ).addClass( 'wimplecf_horizental_pos_disable' );
						$( '#wimplecf_within_row' ).addClass( 'wimplecf_horizental_pos_disable' );
						$( '#wimplecf_colomn_num' ).html( '<option value="1">First Field</option>' );
						$( "div" ).removeClass( "wimplecf_selected_col" );
						$("#wimplecf_field_width").find("option").remove().end().append(
						'<option value="100">100%</option><option value="50">50%</option><option value="33">33%</option><option value="25">25%</option>');
						$( '#wimplecf_addnew_field' ).html( 'Add Field' );
						
						$( 'option[value="wimplecf_vertical_before"]' ).slideDown( );
						$( 'option[value="wimplecf_vertical_after"]' ).slideDown( );
	
						$( '#wimplecf_validation_msg' ).val( '' );
						$( "#wimplecf_page_current_status" ).val( 'DB_UPDATE_DUE' );
					}
					else if ( ajaxreturn[0] == 'Nofieldavailable' )
					{
						$( "#wimplecf_next_row_num" ).val( '1' );
						$( '#wimplecf_row_num' ).html( '<option value="wimplecf_newrow">New Row</option>' );
						$( '.wimplecf_form_content' ).html( ajaxreturn[1] );
						$( '#wimplecf_numberoffieldcreated' ).val( '0' );
						$( '#wimplecf_dummy_submit_button' ).hide();
						$( '.wimplecf_left_sec' ).removeClass( 'wimplecf_focus_on_left' );
						$( '.wimplecf_right_sec' ).removeClass( 'wimplecf_focus_on_right' );
						$( '#wimplecf_label_name' ).attr("placeholder", "Maximum 50 characters (required)");
						$( "#wimplecf_edit_mode" ).val('');
						$( "#wimplecf_first_value" ).val('');
						$( "#wimplecf_edited_row_number" ).val('');
						$( '.wimplecf_left_sec input[type="text"]' ).val('');
						$( '.wimplecf_error_message' ).html('');
						$("#wimplecf_note_text_ifr").contents().find("body").html( 'Maximum 500 characters (required)' );
						$( '.wimplecf_left_sec select' ).prop( "selectedIndex", 0 );
						$( '#wimplecf_typevalue' ).slideUp();
						$( '#wimplecf_notetext_block' ).slideUp();
						$( '#wimplecf_dateformat_block' ).slideUp();
						$( '#wimplecf_captchablock' ).slideUp();
						$( '#wimplecf_recaptchablock' ).slideUp();
						$( '#wimplecf_charlimit' ).slideDown();
						$( "#wimplecf_mandatory" ).prop( "checked", false );
						$( "#wimplecf_email_validation" ).prop( "checked", false );
						$( "#wimplecf_numericonly" ).prop( "checked", false );
						$( '#wimplecf_placeholder_div' ).removeClass( 'wimplecf_horizental_pos_disable' );
						$( '#wimplecf_validation_checklist' ).removeClass( 'wimplecf_horizental_pos_disable' );
						$( '#wimplecf_emailidrequiredID' ).removeClass( 'wimplecf_horizental_pos_disable' );
						$( '#wimplecf_numericonlyID' ).removeClass( 'wimplecf_horizental_pos_disable' );
						$( '#wimplecf_helptext_block' ).removeClass( 'wimplecf_horizental_pos_disable' );
						$( '#wimplecf_error_input' ).addClass( 'wimplecf_horizental_pos_disable' );
						$( '#wimplecf_within_row' ).addClass( 'wimplecf_horizental_pos_disable' );
						$( '#wimplecf_colomn_num' ).html( '<option value="1">First Field</option>' );
						$( "div" ).removeClass( "wimplecf_selected_col" );
						$("#wimplecf_field_width").find("option").remove().end().append(
						'<option value="100">100%</option><option value="50">50%</option><option value="33">33%</option><option value="25">25%</option>');
						$( '#wimplecf_addnew_field' ).html( 'Add Field' );
						
						$( 'option[value="wimplecf_vertical_before"]' ).slideDown( );
						$( 'option[value="wimplecf_vertical_after"]' ).slideDown( );
	
						$( '#wimplecf_validation_msg' ).val( '' );
						$( "#wimplecf_page_current_status" ).val( 'DB_UPDATE_DUE' );
						
						$( 'option[value="wimplecf_vertical_before"]' ).slideUp( );
						$( 'option[value="wimplecf_vertical_after"]' ).slideUp( );
					}
				});	
			}			
		});
		
	});
	</script>
<?php } ?>

<script type="text/javascript">
jQuery( document ).ready( function( $ )
{
	$( document ).on( 'click', '#wimplecf_reset_fields', function ( ) 
	{ 
		$( '#wimplecf_label_name' ).attr("placeholder", "Maximum 50 characters (required)");
		$( '.wimplecf_left_sec' ).removeClass( 'wimplecf_focus_on_left' );
		$( '.wimplecf_right_sec' ).removeClass( 'wimplecf_focus_on_right' );
		$( "#wimplecf_edit_mode" ).val('');
		$( "#wimplecf_first_value" ).val('');
		$( '.wimplecf_error_message' ).html('');
		$( '.wimplecf_left_sec input[type="text"]' ).val('');
		$( "#wimplecf_note_text_ifr" ).contents().find("body").html( 'Maximum 500 characters (required)' );
		$( '.wimplecf_left_sec select' ).prop( "selectedIndex", 0 );
		$( '#wimplecf_typevalue' ).slideUp();
		$( '#wimplecf_notetext_block' ).slideUp();
		$( '#wimplecf_dateformat_block' ).slideUp();
		$( '#wimplecf_captchablock' ).slideUp();
		$( '#wimplecf_recaptchablock' ).slideUp();
		$( '#wimplecf_charlimit' ).slideDown();
		$( "#wimplecf_mandatory" ).prop( "checked", false );
		$( "#wimplecf_email_validation" ).prop( "checked", false );
		$( "#wimplecf_numericonly" ).prop( "checked", false );
		$( '#wimplecf_placeholder_div' ).removeClass( 'wimplecf_horizental_pos_disable' );
		$( '#wimplecf_validation_checklist' ).removeClass( 'wimplecf_horizental_pos_disable' );
		$( '#wimplecf_emailidrequiredID' ).removeClass( 'wimplecf_horizental_pos_disable' );
		$( '#wimplecf_numericonlyID' ).removeClass( 'wimplecf_horizental_pos_disable' );
		$( '#wimplecf_helptext_block' ).removeClass( 'wimplecf_horizental_pos_disable' );
		$( '#wimplecf_error_input' ).addClass( 'wimplecf_horizental_pos_disable' );
		$( '#wimplecf_within_row' ).addClass( 'wimplecf_horizental_pos_disable' );
		$( '#wimplecf_colomn_num' ).html( '<option value="1">First Field</option>' );
		$( "div" ).removeClass( "wimplecf_selected_col" );
		$("#wimplecf_field_width").find("option").remove().end().append(
		'<option value="100">100%</option><option value="50">50%</option><option value="33">33%</option><option value="25">25%</option>');
		$( '#wimplecf_addnew_field' ).html( 'Add Field' );
		
		if ( ( $( '#wimplecf_edit_mode' ).val( ) == '' && $( '#wimplecf_numberoffieldcreated' ).val( ) == 0 ) ||
		     ( $( '#wimplecf_edit_mode' ).val( ) != '' && $( '#wimplecf_numberoffieldcreated' ).val( ) == 1 ) )
		{
			$( 'option[value="wimplecf_vertical_before"]' ).slideUp( );
			$( 'option[value="wimplecf_vertical_after"]' ).slideUp( );		
		}
		else
		{
			$( 'option[value="wimplecf_vertical_before"]' ).slideDown( );
			$( 'option[value="wimplecf_vertical_after"]' ).slideDown( );	
		}

		$( '#wimplecf_validation_msg' ).val( '' );
		$( '#wimplecf_left_first' )[0].scrollIntoView( true );
		$( '#wimplecf_left_first' ).scrollTop( 300 );
	});
	
});
</script>

<script type="text/javascript">
jQuery( document ).ready( function( $ )
{
	$( ".wimplecf_left_sec" ).on( 'focus','input, Textarea, select', function ( ) 
	{
		$( ".wimplecf_right_sec" ).removeClass( "wimplecf_focus_on_right" );
		$( '.wimplecf_left_sec' ).addClass( 'wimplecf_focus_on_left' );
	});
});
</script>

<script type="text/javascript">
jQuery( document ).ready( function( $ ) 
{
	$( document ).on( 'focus', '.wimplecf_datepicker_validity', function ( ) 
	{	
		var wimple_date_format_id = $( this ).attr( "id" );
		$( '#'+wimple_date_format_id ).attr( 'readonly', true );
		var wimple_date_format = $( '#'+wimple_date_format_id ).attr('placeholder');
		var wimplecf_upper_year = $('#'+wimple_date_format_id+'_hiddenyear' ).val();
		var currentYear= new Date().getFullYear();
		if ( wimplecf_upper_year > currentYear )
		{
			var default_year = "";
		}
		else
		{
			var default_year = "-"+(currentYear - wimplecf_upper_year)+"y";
		}
		
	    var yearrange = '1900:'+wimplecf_upper_year;
		$( '#'+wimple_date_format_id ).datepicker(
		{
			dateFormat : wimple_date_format,
			changeMonth : true,
			changeYear: true,
			yearRange: yearrange,
			defaultDate: default_year
		});	
	});
	
});
</script>

<script type='text/javascript'>
function wimplecf_refreshCaptcha() 
{
	var img = document.images['wimplecf_captchaimg'];
	var wimplecf_captcha_chars = parseInt( document.getElementById( "wimplecf_captcha_value" ).value );
	img.src = img.src.substring( 0, img.src.lastIndexOf( "?" ) ) + "?rand=" + Math.random() * 1000 + "&c_bit=" + wimplecf_captcha_chars;
}
</script>

<script type="text/javascript">		
window.onload = function() 
{
	var wimplecf_fullpath = document.getElementById('wimplecf_file_url').value;
	
	var wimplecf_link = document.createElement("link");
	wimplecf_link.href = wimplecf_fullpath+"css/field/ifamestyle.css";  
	wimplecf_link.rel = "stylesheet"; 
	wimplecf_link.type = "text/css"; 
	frames[0].document.head.appendChild(wimplecf_link); // 0 is an index of iframe 
}
</script>