/*
#######################################################################################
# Plugin Name: WIMPLE Contact Form                                                	  #
# Author: SARANGSoft (Email: wp-contact@sarangsoft.com, Web: https://sarangsoft.com)  #
# File Name: wcf_form_submit.js													      #
# Purpose: Submit front end form via ajax call and send data in the background.       #
#######################################################################################
 
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
jQuery( document ).ready( function( $ )
{
	$( ".wimplecf_ajaxsubmit" ).on( 'focus','input, textarea, select, iframe', function ( ) 
	{
		var wimplecf_input_field_name = $(this).attr("name");
		$('#'+wimplecf_input_field_name+'_id').html('');
	} );
	
	$('iframe').contents().find("body").focus( function( )
	{
		alert( "Yes" );
	});

	$( ".g-recaptcha" ).on( 'click', function ( ) 
	{
		$('#wimplecf_recaptcha_code_id').html('');
	} );
	
	$( 'form.wimplecf_ajaxsubmit' ).on( 'submit', function( e )
	{
		e.preventDefault( );
		var that = $( this ),
		url = that.attr( 'action' ),
		type = that.attr( 'method' );
		
		if( $('#g-recaptcha-response').length > 0 )
		{
			var wimplecf_g_recaptcha_varified = $('#g-recaptcha-response').val();
		}
	   
		var wimplecf_form_id = $('#wimplecf_form_id').val();
	   
		form_data = [];
		$( "input[name='hdn[]']" ).each( function( ) 
		{
			form_data.push( $( this ).val() );
		});
		
		var wimplecf_formdata = $( '#wimplecf_ajaxsubmitid :input:not(:hidden)' ).serialize();
		var formdata = {
					'action': 'wimplecf_form_submit',     //action name
					'wimplecf_form_id':wimplecf_form_id,  //form ID
					'wimplecf_hdn_values': form_data,     // some additional data to send
					'wimplecf_g_recaptcha_varified': wimplecf_g_recaptcha_varified, //get value after recaptcha checked by user
					'wimplecf_formdata':wimplecf_formdata //form data to send
				};
				
		jQuery.post(frontend_ajax_object.ajax_url, formdata, function(response) 
		{
			var ajaxreturn = response.split("@");
			if(ajaxreturn[0] == 'Error')
			{
				var returnvalue = ajaxreturn[1].split("<>");
				$('#'+returnvalue[0]).html(returnvalue[1]);				
				$('html, body').animate({
				scrollTop: $('#'+returnvalue[0]).offset().top - 100
				}, 'slow');
			}
			else if(ajaxreturn[0] == 'Success')
			{				
				$('.wimplecf_success_message').show();
				$('.wimplecf_success_message').html(ajaxreturn[1]);
				$('html, body').animate({
				scrollTop: $('.wimplecf_success_message').offset().top - 100
				}, 'slow');
				$('.wimplecf_ajaxsubmit')[0].reset();
				$('#wimplecf_recaptcha_code_id').html('');
				grecaptcha.reset();
			}
		});
	});
});
