<?php
#######################################################################################
# Plugin Name: WIMPLE Contact Form                                                	  #
# Author: SARANGSoft (Email: wp-contact@sarangsoft.com, Web: https://sarangsoft.com)  #
# File Name: form.php															      #
# Purpose: Present / display form on user side (frontend).                            #
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

include( plugin_dir_path( WIMPLECF_PLUGIN ) . 'front/include/form_query.php');
									  
if ( defined( 'WIMPLECF_GOOGLE_SITE_KEY' ) ) 
{
	$wimplecf_google_site_key = WIMPLECF_GOOGLE_SITE_KEY;
}
if ( defined( 'WIMPLECF_GOOGLE_SECRET_KEY' ) ) 
{
	$wimplecf_google_secret_key = WIMPLECF_GOOGLE_SECRET_KEY;
}									  

//theme selection
switch( $wimplecf_form_theme ) 
{
	case WIMPLECF_THEME_OPTION_VALUE_THEME1:
         wp_enqueue_style( 'my_css_wimplecontact', 
		                    plugins_url( '/front/css/theme_skyblue.css', WIMPLECF_PLUGIN ) );
         break;
			
    case WIMPLECF_THEME_OPTION_VALUE_THEME2:
         wp_enqueue_style( 'my_css_wimplecontact', 
		                    plugins_url( '/front/css/theme_darkgreen.css', WIMPLECF_PLUGIN ) );
         break;
		
    case WIMPLECF_THEME_OPTION_VALUE_THEME3:
         wp_enqueue_style( 'my_css_wimplecontact', 
		                    plugins_url( '/front/css/theme_grayshade.css', WIMPLECF_PLUGIN ) );
         break;
		
	case WIMPLECF_THEME_OPTION_VALUE_THEME4:
         wp_enqueue_style( 'my_css_wimplecontact', 
		                    plugins_url( '/front/css/theme_shadowbackground.css', WIMPLECF_PLUGIN ) );
         break;
		
	case WIMPLECF_THEME_OPTION_VALUE_THEME5:
         wp_enqueue_style( 'my_css_wimplecontact', 
		                    plugins_url( '/front/css/theme_withoutbackground.css', WIMPLECF_PLUGIN ) );
         break;
}
?>
<div class="wimplecf_full_form" id="loadmore">
    <?php 
	if ( isset( $wimplecf_display_form_name ) && 
		 $wimplecf_display_form_name == 'yes' ) 
	{	
		echo '<h2><b>'.esc_html( $wimplecf_form_name ).'</b></h2>';
	}
	    
    if ( isset( $wimplecf_no_of_fields ) > 0 ) 
    { 
    ?>
        <form name="wimplecf_contact_form" id="wimplecf_ajaxsubmitid" class="wimplecf_ajaxsubmit" method="post" action="" >
            <input type="hidden" name="u_form_id" id="wimplecf_form_id" value="<?php echo esc_attr( $wimplecf_id ); ?>" />
            <div class="wimplecf_form_fields"> 
                <div class="wimplecf_form-group wimplecf_row wimplecf_success_message_outer">
 					<div class="wimplecf_col-sm-12">
                    	<div class="wimplecf_success_message" style="display:none;"></div>
                    </div>
                </div>

                <?php
                $wimplecf_i = 0;
				for ( $i = 0; $i < $wimplecf_no_of_fields ; $i++ ) 
				{
					$wimplecf_field_id     		= $wimplecf_form_values[$i]->id;
					$wimplecf_label_name   		= $wimplecf_form_values[$i]->label_name;
					$wimplecf_is_required  		= $wimplecf_form_values[$i]->is_required;
					$wimplecf_is_email_required = $wimplecf_form_values[$i]->is_email_required;
					$wimplecf_type         		= $wimplecf_form_values[$i]->type;
					$wimplecf_type_value   		= $wimplecf_form_values[$i]->type_value;
					$wimplecf_all_type_val 		= explode( '|', $wimplecf_type_value );					
					$wimplecf_field_width   	= $wimplecf_form_values[$i]->field_width;
					$wimplecf_field_row_num   	= $wimplecf_form_values[$i]->field_row_num;
					$wimplecf_field_column_num  = $wimplecf_form_values[$i]->field_column_num;
					$wimplecf_field_name   		= $wimplecf_form_values[$i]->field_name;
					$wimplecf_error_msg    		= $wimplecf_form_values[$i]->error_msg;
					$wimplecf_help_msg     		= $wimplecf_form_values[$i]->help_msg;
					$wimplecf_placeholder_msg 	= $wimplecf_form_values[$i]->placeholder_msg;
					$wimplecf_numeric_only 		= $wimplecf_form_values[$i]->is_numeric_only;
					$wimplecf_char_limit 		= $wimplecf_form_values[$i]->char_limit;
					$wimplecf_note_type_text 	= $wimplecf_form_values[$i]->note_type_text;
					$wimplecf_date_format 	 	= $wimplecf_form_values[$i]->dateformat;
					$wimplecf_captcha_length   	= $wimplecf_form_values[$i]->captcha_length;
					$wimplecf_date_upper_limit  = $wimplecf_form_values[$i]->date_upperlimit;
					
					echo '<input type="hidden" id="wimplecf_formvalues" name="hdn[]" 
								 value="'.esc_attr( $wimplecf_type.'~'.$wimplecf_label_name.'~'.$wimplecf_field_name.'~'
													.$wimplecf_is_required.'~'.$wimplecf_error_msg.'~'
													.$wimplecf_is_email_required.'~'.$wimplecf_numeric_only.'~'
													.$wimplecf_char_limit ).'" />';
			 
					//static variable                    
					$wimplecf_captcha_enable_value = '1';
					
					if ( $wimplecf_field_width == 100 )
					{
						$wimplecf_field_class = 'wimplecf_col-sm-12';
					}
					elseif ( $wimplecf_field_width == 50 )
					{
						$wimplecf_field_class = 'wimplecf_col-sm-6';
					}
					elseif ( $wimplecf_field_width == 33 )
					{
						$wimplecf_field_class = 'wimplecf_col-sm-4';
					}
					elseif ( $wimplecf_field_width == 25 )
					{
						$wimplecf_field_class = 'wimplecf_col-sm-3';
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
				
					if ( isset( $wimplecf_current_row_num ) && $wimplecf_current_row_num != $wimplecf_field_row_num )
					{
						$wimplecf_local_html .= '</div>';
					}
					
					if ( isset( $wimplecf_current_row_num ) && $wimplecf_current_row_num == $wimplecf_field_row_num )
					{
						$wimplecf_local_html .= '<div id="wimplecf_selected_'.$wimplecf_field_row_num.'_'.$wimplecf_field_column_num.'" class="'.$wimplecf_field_class.'">';
					}
					else
					{
						$wimplecf_local_html .= '<div class="wimplecf_form-group wimplecf_row" id="wimplecf_rownum_'.$wimplecf_field_row_num.'" >
												<div id="wimplecf_selected_'.$wimplecf_field_row_num.'_'.$wimplecf_field_column_num.'" class="'.$wimplecf_field_class.'">';
					}
					
					$wimplecf_local_html .= '<input type="hidden" 
													id="wimplecf_row_col_'.$wimplecf_field_row_num.'_'.$wimplecf_field_column_num.'"
													name="hiddenvalus[]" 
													value="'.esc_attr( $wimplecf_field_id.'~'
																		.$wimplecf_label_name.'~'
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
																		.$wimplecf_note_type_text.'~'
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
						$wimplecf_local_html .= '<label class="wimplecf_col-form-label">';
						$wimplecf_local_html .= esc_html( stripslashes( $wimplecf_label_name ) ); 
						if ( isset( $wimplecf_is_required ) &&
							 ( $wimplecf_is_required == 'on') ) 
						{
							$wimplecf_local_html .= '<span class="wimplecf_mandatory_field">*</span>'; 
						}					
						$wimplecf_local_html .='</label>';
					}					

					if ( isset( $wimplecf_type ) && 
						 $wimplecf_type == 'text' ) 
					{
						$wimplecf_local_html .= '<input type="text" 
														class="wimplecf_form-control wimplecf_validity_check_cls" 
														name="'.esc_attr( $wimplecf_field_name ).'" 
														id="'.esc_attr( $wimplecf_field_name ).'__'.esc_attr( $wimplecf_numeric_only ).'"
														value="" 
														placeholder="'.esc_attr( $wimplecf_placeholder_msg ).'" 
														maxlength="'.$wimplecf_input_maxlength.'" />';
														
						if ( isset( $wimplecf_help_msg ) && $wimplecf_help_msg != '' )
						{
							$wimplecf_local_html .= '<span class="wimplecf_help_text">('.esc_attr( $wimplecf_help_msg ).')</span>';
						}
					} 
					elseif ( isset( $wimplecf_type ) && 
							 $wimplecf_type == 'radiobutton' ) 
					{									
						$wimplecf_local_html .= '<div class="wimplecf_gender_radio_sec">
													<div class="wimplecf_custom-check-radio">';
						foreach ( $wimplecf_all_type_val as $wimplecf_single_val )
						{
							$wimplecf_local_html .= '<label class="wimplecf_custom_radio">'.esc_html( trim( $wimplecf_single_val ) ).'
														<input type="radio" name="'.esc_attr( $wimplecf_field_name ).'" 
															   value="'.esc_attr( trim( $wimplecf_single_val ) ).'">
														<span class="wimplecf_checkmark"></span>
													</label>';
						}
						$wimplecf_local_html .= '</div>';
						if ( isset( $wimplecf_help_msg ) && $wimplecf_help_msg != '' )
						{
							$wimplecf_local_html .= '<span class="wimplecf_help_text">('.esc_attr( $wimplecf_help_msg ).')</span>';
						}
						$wimplecf_local_html .= '</div>';
					} 
					elseif ( isset( $wimplecf_type ) && 
								$wimplecf_type == 'selectbox' ) 
					{
						$wimplecf_local_html .= '<select class="wimplecf_cat_select_class" id="wimplecf_slectbox_id" aria-label="Default select example" name="'.esc_attr( $wimplecf_field_name ).'"  
														 value="" style="margin: 0">';
						$wimplecf_local_html .= '<option class="wimplecf_placeholder" value="" selected>Select option</option>';	
						foreach ( $wimplecf_all_type_val as $wimplecf_single_val ) 
						{
							$wimplecf_local_html .= '<span style=" width:100%; display:block; float:left; margin-top:0px;">
									<option class="wimplecf_others" value="'.esc_attr( trim( $wimplecf_single_val ) ).'">
									'.esc_html( trim( $wimplecf_single_val ) ).'
									</option>
								  </span>';
						}
						$wimplecf_local_html .= '</select>';
						if ( isset( $wimplecf_help_msg ) && $wimplecf_help_msg != '' )
						{
							$wimplecf_local_html .= '<span class="wimplecf_help_text">('.esc_attr( $wimplecf_help_msg ).')</span>';
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
						$wimplecf_local_html .= '<textarea class="wimplecf_form-control wimplecf_validity_check_cls" 
														   name="'.esc_attr( $wimplecf_field_name ).'" 
														   placeholder="'.esc_attr( $wimplecf_placeholder_msg ).'" 
														   id="'.esc_attr( $wimplecf_field_name ).'__'.esc_attr( $wimplecf_numeric_only ).'" 
														   rows="2" cols="80" maxlength="'.$wimplecf_input_maxlength.'"></textarea>';
						if ( isset( $wimplecf_help_msg ) && $wimplecf_help_msg != '' )
						{
							$wimplecf_local_html .= '<span class="wimplecf_help_text">('.esc_attr( $wimplecf_help_msg ).')</span>';
						}
					}
					elseif ( isset( $wimplecf_type ) && 
							 $wimplecf_type == 'note' ) 
					{
						$wimplecf_local_html .= '<div>
												<div>';
						$wimplecf_local_html .= '<label>'.trim( stripslashes( htmlspecialchars_decode( esc_html( $wimplecf_note_type_text ) ) ) );
						$wimplecf_local_html .= '</label>';
						$wimplecf_local_html .= '</div>';
						$wimplecf_local_html .= '</div>';
					} 
					elseif ( isset( $wimplecf_type ) && 
							 $wimplecf_type == 'date' ) 
					{
						$wimplecf_local_html .= '<input type="text" class="form-control wimplecf_datepicker_validity date_picker" 
											name="'.esc_attr( $wimplecf_field_name ).'" 
											id="'.esc_attr( $wimplecf_field_name ).'"
											value="" 
											placeholder="'.esc_attr(  str_replace( "commaencode",",", $wimplecf_date_format ) ).'" />';
											
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
						if( isset( $wimplecf_field_width ) && $wimplecf_field_width == '50' )
						{
							$wimplecf_local_html .= '<div class="wimplecf_captcha_sec wimplecf_captcha_sec-50">';
						}
						else
						{
							$wimplecf_local_html .= '<div class="wimplecf_captcha_sec">';
						}
						
						$wimplecf_local_html .= '<label class="col-form-label">'.trim( stripslashes( htmlspecialchars_decode( esc_html( $wimplecf_label_name ) ) ) );
						if ( isset( $wimplecf_label_name ) && $wimplecf_label_name != '' )
						{
							$wimplecf_local_html .= '<span class="wimplecf_mandatory_field">*</span>';
						}
						else
						{
							$wimplecf_local_html .= '<span class="wimplecf_mandatory_field">&nbsp;</span>';
						}
						$wimplecf_local_html .= '</label>';
						$wimplecf_local_html .= '<div class="wimplecf_captcha_inner">';
						$wimplecf_local_html .= '<input id="captcha_code" name="'.esc_attr( $wimplecf_field_name ).'" type="text" placeholder="Enter the code" maxlength="'.esc_attr( $wimplecf_captcha_length ).'">';
						
						if( isset( $wimplecf_field_width ) && $wimplecf_field_width == '50' )
						{
							$wimplecf_local_html .= '<label class="wimplecf_col-form-label wimplecf_captcha_img-label-50">Security Code</label>';
						}
						else
						{
							$wimplecf_local_html .= '<label class="wimplecf_col-form-label wimplecf_captcha_img-label">Security Code</label>';
						}
						
						$wimplecf_local_html .= '<span class="wimplecf_captcha_image">
												<img src="'.esc_url( plugins_url( 'captcha/captcha.php', WIMPLECF_PLUGIN ).'?c_bit='.esc_attr( $wimplecf_captcha_length ) ).'" id="wimplecf_captchaimg">
												</span>';
						$wimplecf_local_html .= '<input type="hidden" id="wimplecf_captcha_value" value="'.esc_attr( $wimplecf_captcha_length ).'">';
						$wimplecf_local_html .= '<a href="javascript: wimplecf_refreshCaptcha();" class="wimplecf_captcha_refresh_icon">';
						$wimplecf_local_html .= '<img src="'.esc_url( plugins_url( 'image/refresh_icon.png', WIMPLECF_PLUGIN ) ).'" width="25"></a>';
						$wimplecf_local_html .= '</div>';
						if ( isset( $wimplecf_help_msg ) && $wimplecf_help_msg != '' )
						{
							$wimplecf_local_html .= '<span class="wimplecf_captcha_bottomTxt wimplecf_help_text">'.esc_attr( $wimplecf_help_msg ).'</span>';
						}
						$wimplecf_local_html .= '<br>';
						$wimplecf_local_html .= '<span class="wimplecf_validation_class wimplecf_error_message" id="wimplecf_captcha_code_id"></span>';
						$wimplecf_local_html .= '</div>';
					}
					elseif ( isset( $wimplecf_type ) && 
							$wimplecf_type == 'recaptchacode' ) 
					{
						$wimplecf_local_html .= '<div class="wimplecf_captcha_sec wimplecf_recaptcha_outer">
												<div class="sec-box">';
												
						$wimplecf_local_html .= '<label class="col-form-label">'.trim( stripslashes( htmlspecialchars_decode( esc_html( $wimplecf_label_name ) ) ) );
						$wimplecf_local_html .= '</label>';
							   
						$wimplecf_local_html .= '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
						
						$wimplecf_local_html .= '<div class="fltRgt capchaLabelCnt sec-hig recaptcha_feedback"> 
												<div class="g-recaptcha" data-sitekey="'.$wimplecf_google_site_key.'" data-size="normal"></div> 
												</div>'; 
						
						if ( isset( $wimplecf_help_msg ) && $wimplecf_help_msg != '' )
						{
							$wimplecf_local_html .= '<span class="wimplecf_captcha_bottomTxt wimplecf_help_text">'.esc_attr( $wimplecf_help_msg ).'</span>';
						}
						$wimplecf_local_html .= '<span class="wimplecf_validation_class wimplecf_error_message" id="wimplecf_recaptcha_code_id"></span>';
						$wimplecf_local_html .= '</div></div>';
					}
					elseif ( isset( $wimplecf_type ) && 
							 $wimplecf_type == 'checkbox' )
					{
						$wimplecf_local_html .= '<div class="wimplecf_custom-check-radio wimplecf_single_checkbox">
												<div class="wimplecf_checkbox_list">';
						$wimplecf_local_html .= '<label class="wimplecf_custom_checkbox">'.esc_html( trim( $wimplecf_label_name ) );
						if ( isset( $wimplecf_is_required ) &&
							 ( $wimplecf_is_required == 'on') ) 
						{
							$wimplecf_local_html .= '<span class="wimplecf_mandatory_field">*</span>'; 
						}
						$wimplecf_local_html .= '<input type="checkbox" name="'.esc_attr( $wimplecf_field_name ).'" value="Yes">
												<span class="wimplecf_checkmark"></span>';
						$wimplecf_local_html .= '</label>';
							  
						$wimplecf_local_html .= '</div>';
						if ( isset( $wimplecf_help_msg ) && $wimplecf_help_msg != '' ) 
						{
							$wimplecf_local_html .= '<span class="wimplecf_help_text">('.esc_attr( $wimplecf_help_msg ).')</span>';
						}
						$wimplecf_local_html .= '</div>';
					} 
					
					if ( ( isset( $wimplecf_is_required ) &&
						 ( $wimplecf_is_required == 'on') ) ||
						 ( isset( $wimplecf_is_email_required ) &&
						 ( $wimplecf_is_email_required == 'on') )						 ) 
					{
						$wimplecf_local_html .= '<span class="wimplecf_validation_class wimplecf_error_message" 
															  id="'.esc_attr( $wimplecf_field_name ).'_id"></span>'; 
					}
						
					$wimplecf_local_html .= '</div>';
					
					$wimplecf_current_row_num = $wimplecf_field_row_num;
					
					if ( ++$wimplecf_i === $wimplecf_no_of_fields ) 
					{
						$wimplecf_local_html .= '</div>';
					}
					
					echo $wimplecf_local_html;
				} 
                ?>
                <div class="wimplecf_form-group wimplecf_row">
					<div class="wimplecf_col-sm-12 wimplecf_button_sec">
						<input class="wimplecf_subbutton" type="submit" 
							   name="" id="wimplecf_form_submit" 
					           value="<?php echo esc_attr( $wimplecf_form_button_label ); ?>">
					</div>
                </div>
            </div>
		</form>
    <?php
    }
    ?>
</div>
 
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

<script type="text/javascript">
jQuery( document ).ready( function( $ )
{
	$( document ).on( 'focus','.wimplecf_validity_check_cls', function ( ) 
	{
		var wimplecf_validation_check_id = $( this ).attr( "id" );
		var wimplecf_split_validation_str = wimplecf_validation_check_id.split( "__" );
		
		var wimplecf_input_type = wimplecf_split_validation_str[ 1 ];
		if ( wimplecf_input_type == 'on' )
		{			
			$( "#"+wimplecf_validation_check_id ).on( 'keypress', function( e )
			{
				return e.metaKey || 							// cmd/ctrl
				e.which <= 0 || 								// arrow keys
				/[0-9]/.test( String.fromCharCode( e.which ) ); // numbers
			});
		}
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

<script type='text/javascript'>

document.addEventListener("DOMContentLoaded", function() 
{ 
    document.getElementById('wimplecf_slectbox_id').addEventListener('change', function() 
	{
		if (this.value === "") 
		{
			if (!this.classList.contains('wimplecf_placeholder')) 
			{
				this.classList.add('wimplecf_placeholder');
			}
			if (this.classList.contains('wimplecf_others')) 
			{
				this.classList.remove('wimplecf_others');
			}
		} 
		else 
		{
			if (!this.classList.contains('wimplecf_others')) 
			{
				this.classList.add('wimplecf_others');
			}
			if (this.classList.contains('wimplecf_placeholder')) 
			{
				this.classList.remove('wimplecf_placeholder');
			}
		}
    });
});

</script>