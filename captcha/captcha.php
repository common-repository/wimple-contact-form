<?php
########################################################################################
# Plugin Name: WIMPLE Contact Form                                                	   #
# Author: SARANGSoft (Email: wp-contact@sarangsoft.com, Web: https://sarangsoft.com/)  #
# File Name: captcha.php															   #
# Purpose: Generate random CAPTCHA Code.                                               #
########################################################################################

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

	session_start();
	include( "phpCaptchaGenerateClass.php" );
	
	$wimplecf_captcha_chars = intval( $_REQUEST['c_bit'] );

	/*Object of the class is created*/
	$wimplecf_CaptchaGenerateObj = new wimplecf_CaptchaGenerateClass();
	$wimplecf_CaptchaGenerateObj->wimplecf_SetBitData( $wimplecf_captcha_chars );
	
	/*Inputs and function to genrate image with alpha numeric number*/
	
	$wimplecf_c_fontcolor   = '#246263'; // Font color of CAPTCHA characters
	$wimplecf_c_forecolor   = '#d5d5d5'; // Body color of CAPTCHA image
	$wimplecf_c_width       = 140;       // Width of CAPTCHA image
	$wimplecf_c_height      = 35;        // Height of CAPTCHA image
	$wimplecf_c_bgdot_lines = 10;        // Small lines in CAPTCHA image background frame 
	$wimplecf_c_bgdot_dots  = 30;        // Dots in CAPTCHA image background frame 
	
	$wimplecf_CaptchaGenerateObj->wimplecf_CaptchaGenerateFunction( $wimplecf_c_fontcolor, 
																	$wimplecf_c_forecolor, 
																	$wimplecf_c_width, 
																	$wimplecf_c_height, 
																	$wimplecf_c_bgdot_lines, 
																	$wimplecf_c_bgdot_dots );
?>	
	