<?php
#######################################################################################
# Plugin Name: WIMPLE Contact Form                                                	  #
# Author: SARANGSoft (Email: wp-contact@sarangsoft.com, Web: https://sarangsoft.com)  #
# File Name: ajax_row_col_delete.php												  #
# Purpose: Receive data on ajax request, delete row and return form structure.        #
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
global $wpdb;

if ( defined( 'WIMPLECF_GOOGLE_SITE_KEY' ) ) 
{
	$wimplecf_google_site_key = WIMPLECF_GOOGLE_SITE_KEY;
}
if ( defined( 'WIMPLECF_GOOGLE_SECRET_KEY' ) ) 
{
	$wimplecf_google_secret_key = WIMPLECF_GOOGLE_SECRET_KEY;
}

$wimplecf_hidden_values = isset( $_POST["wimplecf_hidden_values"] ) ? (array) $_POST["wimplecf_hidden_values"] : array();
// Any of the WordPress data sanitization functions can be used here
$wimplecf_hidden_values = array_map( 'sanitize_text_field', $wimplecf_hidden_values );

$wimplecf_form_name			= sanitize_text_field( $_POST["wimplecf_current_form_name"] );
$wimplecf_next_row_num		= filter_var( $_POST["wimplecf_next_row_num"], FILTER_SANITIZE_NUMBER_INT );
$wimplecf_delete_row_col_id = filter_var( $_POST["wimplecf_delete_row_col_id"], FILTER_SANITIZE_NUMBER_INT );

if ( count( $wimplecf_hidden_values ) > 0 )
{
	$wimplecf_form_field = '';
	$wimplecf_row_listing = '<option value="wimplecf_newrow">New Row</option>,';

	foreach ( $wimplecf_hidden_values as $wimplecf_hidden_values_esch )
	{
		$wimplecf_each_field = explode( '~',$wimplecf_hidden_values_esch );
		
		if ( $wimplecf_each_field[7] < $wimplecf_delete_row_col_id )
		{
			$wimplecf_revised_row_num = $wimplecf_each_field[7];
			
			$wimplecf_form_field .= $wimplecf_each_field[0].'~'
									.$wimplecf_each_field[1].'~'
									.$wimplecf_each_field[2].'~'
									.$wimplecf_each_field[3].'~'
									.$wimplecf_each_field[4].'~'
									.$wimplecf_each_field[5].'~'
									.$wimplecf_each_field[6].'~'
									.$wimplecf_revised_row_num.'~'
									.$wimplecf_each_field[8].'~'
									.$wimplecf_each_field[9].'~'
									.$wimplecf_each_field[10].'~'
									.$wimplecf_each_field[11].'~'
									.$wimplecf_each_field[12].'~'
									.$wimplecf_each_field[13].'~'
									.$wimplecf_each_field[14].'~'
									.$wimplecf_each_field[15].'~'
									.$wimplecf_each_field[16].'~'
									.$wimplecf_each_field[17].'~'
									.$wimplecf_each_field[18].',';
		}
		else
		{
			$wimplecf_revised_row_num = $wimplecf_each_field[7] - 1;
			
			$wimplecf_form_field .= $wimplecf_each_field[0].'~'
									.$wimplecf_each_field[1].'~'
									.$wimplecf_each_field[2].'~'
									.$wimplecf_each_field[3].'~'
									.$wimplecf_each_field[4].'~'
									.$wimplecf_each_field[5].'~'
									.$wimplecf_each_field[6].'~'
									.$wimplecf_revised_row_num.'~'
									.$wimplecf_each_field[8].'~'
									.$wimplecf_each_field[9].'~'
									.$wimplecf_each_field[10].'~'
									.$wimplecf_each_field[11].'~'
									.$wimplecf_each_field[12].'~'
									.$wimplecf_each_field[13].'~'
									.$wimplecf_each_field[14].'~'
									.$wimplecf_each_field[15].'~'
									.$wimplecf_each_field[16].'~'
									.$wimplecf_each_field[17].'~'
									.$wimplecf_each_field[18].',';
		}
														  
		$wimplecf_row_listing .= '<option value="'.$wimplecf_revised_row_num.'">'.wimplecf_ordinal_number_format( $wimplecf_revised_row_num ).'</option>,';
	}

	$wimplecf_next_row_num = $wimplecf_next_row_num - 1;
	echo 'Success@'.$wimplecf_next_row_num.'<>';
	$wimplecf_row_listing = implode( '', array_unique( explode( ',', rtrim( $wimplecf_row_listing, ',' ) ) ) );
	echo $wimplecf_row_listing.'<>';
		

	$wimplecf_local_form = explode( ',', rtrim( $wimplecf_form_field, ',' ) );

	foreach( $wimplecf_local_form as $wimplecf_local_form_each )
	{
		$wimplecf_each_field_entity = explode( '~',$wimplecf_local_form_each );
		
		$wimplecf_field_id 			= $wimplecf_each_field_entity[0];
		$wimplecf_label_name   		= $wimplecf_each_field_entity[1];
		$wimplecf_type         		= $wimplecf_each_field_entity[2];
		$wimplecf_type_value   		= $wimplecf_each_field_entity[3];
		$wimplecf_all_type_val 		= explode( '|', $wimplecf_type_value );
		$wimplecf_is_required  		= $wimplecf_each_field_entity[4];
		$wimplecf_is_email_required = $wimplecf_each_field_entity[5];					
		$wimplecf_field_width   	= $wimplecf_each_field_entity[6];
		$wimplecf_field_row_num   	= $wimplecf_each_field_entity[7];
		$wimplecf_field_column_num  = $wimplecf_each_field_entity[8];
		$wimplecf_field_name   		= $wimplecf_each_field_entity[9];
		$wimplecf_help_msg     		= $wimplecf_each_field_entity[10];
		$wimplecf_error_msg    		= $wimplecf_each_field_entity[11];
		$wimplecf_placeholder_msg 	= $wimplecf_each_field_entity[12];
		$wimplecf_numeric_only 		= $wimplecf_each_field_entity[13];
		$wimplecf_char_limit 		= $wimplecf_each_field_entity[14];
		$wimplecf_note_type_text 	= $wimplecf_each_field_entity[15];
		$wimplecf_date_format	 	= $wimplecf_each_field_entity[16];
		$wimplecf_captcha_length   	= $wimplecf_each_field_entity[17];
		$wimplecf_date_upper_limit  = $wimplecf_each_field_entity[18];
		
		
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

		if ( isset( $wimplecf_current_row_num ) && $wimplecf_current_row_num != $wimplecf_field_row_num )
		{
			$wimplecf_local_html .= '</div>';
		}
		
		if ( isset( $wimplecf_current_row_num ) && $wimplecf_current_row_num == $wimplecf_field_row_num )
		{
			$wimplecf_local_html .= '<div id="wimplecf_selected_'.$wimplecf_field_row_num.'_'.$wimplecf_field_column_num.'" class="'.$wimplecf_field_class.' '.$wimplecf_outer_div_class.'">';
		}
		else
		{
			$wimplecf_local_html .= '<div class="form-group row '.$wimplecf_field_type_conditional_class.'"  id="wimplecf_rownum_'.$wimplecf_field_row_num.'">
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
			   $wimplecf_type == 'textarea'  ||
			   $wimplecf_type == 'date' ) ) 
		{
			$wimplecf_local_html .= '<label class="col-form-label">';
			
			$wimplecf_local_html .= esc_html( stripslashes( $wimplecf_label_name ) ); 
		
			if ( isset( $wimplecf_is_required ) &&
				 ( $wimplecf_is_required == "on" ) ) 
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
				$wimplecf_local_html .= '<strong class="wimplecf_edit wimplecf_help_icon" id="wimplecf_edit~'.$wimplecf_field_row_num.'_'.$wimplecf_field_column_num.'">
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
		echo $wimplecf_local_html;
	}
}
else
{
	echo 'Nofieldavailable@<div class="wimplecf_blank_form">
		  <div id="wimplecf_first_input_hidden"></div>
			<div class="wimplecf_logo">
				<img src="'.esc_url( plugins_url( 'class-admin/images/plugin_logo.png', WIMPLECF_PLUGIN ) ). '">
			</div>
			<div class="wimplecf_blankform_msg">Add field(s) in the left pane to create layout for the form<br>'."'".esc_html( $wimplecf_form_name )."'".'. </div>
		</div>';
}
?>
<script type="text/javascript">

jQuery( document ).ready( function( $ )  
{
	$('#wimplecf_multiselect_optionsDiv').hide();
		
	$('#wimplecf_multiselect_value').click( function()
	{
		$('#wimplecf_multiselect_optionsDiv').toggle();
	});
	
	$('body').click( function(e)
	{
		if ( ( e.target.className !== "wimplecf_multiselect_valueCls" ) && 
			( e.target.className !== "wimplecf_multiselect_optionsDivCls" ) &&
			( e.target.className !== "wimplecf_multiselect_checkbox" ) && 
			( e.target.className !== "wimplecf_multicheckboxhandlecls" ) )
		{
			$("#wimplecf_multiselect_optionsDiv").hide();
		}
	});	
	
	$(".wimplecf_multicheckboxhandlecls").change( function() 
	{
			var wimplecf_checkedValues = $('.wimplecf_multicheckboxhandlecls:checkbox:checked').map( function() {
			return this.value;
			}).get().join(", ");
			
			$('#wimplecf_multiselect_value').val(wimplecf_checkedValues);
	});
});

</script>