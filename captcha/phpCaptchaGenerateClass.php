<?php
########################################################################################
# Plugin Name: WIMPLE Contact Form                                                	   #
# Author: SARANGSoft (Email: wp-contact@sarangsoft.com, Web: https://sarangsoft.com/)  #
# File Name: phpCaptchaGenerateClass.php                                          	   #
# Purpose: phpTextClass for generating random CAPTCHA Code.                       	   #
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

class wimplecf_CaptchaGenerateClass
{
	public function wimplecf_SetBitData( $wimplecf_bitdata )
	{
		$this->c_bit = intval( $wimplecf_bitdata );
	}
	
	public function wimplecf_CaptchaGenerateFunction( $wimplecf_textColor, 
													  $wimplecf_backgroundColor, 
													  $wimplecf_imgWidth, 
													  $wimplecf_imgHeight, 
													  $wimplecf_noiseLines = 0, 
													  $wimplecf_noiseDots = 0, 
													  $wimplecf_noiseColor = '#000' )
	{
		/* Settings */
		$wimplecf_text      	  = $this->wimplecf_Random();
		$wimplecf_font      	  = dirname(__FILE__) . '/font/monofont.ttf'; /* font */
		$wimplecf_textColor 	  = $this->wimplecf_HexToRGB($wimplecf_textColor);	
		$wimplecf_fontSize  	  = $wimplecf_imgHeight * 0.75;
	
		$wimplecf_img       	  = imagecreatetruecolor( $wimplecf_imgWidth, $wimplecf_imgHeight );	
		$wimplecf_textColor 	  = imagecolorallocate( $wimplecf_img, 
														$wimplecf_textColor['r'],
														$wimplecf_textColor['g'],
														$wimplecf_textColor['b'] );			
		
		$wimplecf_backgroundColor = $this->wimplecf_HexToRGB( $wimplecf_backgroundColor );
		$wimplecf_backgroundColor = imagecolorallocate( $wimplecf_img, 
														$wimplecf_backgroundColor['r'],
														$wimplecf_backgroundColor['g'],
														$wimplecf_backgroundColor['b'] );
				
		/* generating lines randomly in background of image */
		if ( $wimplecf_noiseLines > 0 ) 
        {
			$wimplecf_noiseColor = $this->wimplecf_HexToRGB( $wimplecf_noiseColor );	
			$wimplecf_noiseColor = imagecolorallocate( $wimplecf_img, 
													   $wimplecf_noiseColor['r'],
													   $wimplecf_noiseColor['g'],
													   $wimplecf_noiseColor['b'] );
			for ( $i=0; $i < $wimplecf_noiseLines; $i++ ) 
            {				
				imageline( $wimplecf_img, 
						   mt_rand( 0, $wimplecf_imgWidth ),
						   mt_rand( 0, $wimplecf_imgHeight ),
						   mt_rand( 0, $wimplecf_imgWidth ), 
						   mt_rand( 0, $wimplecf_imgHeight ),
						   $wimplecf_noiseColor );
			}
		}
		
		/* generating the dots randomly in background */	
		if ( $wimplecf_noiseDots > 0 ) 
        {
			for ( $i = 0; $i < $wimplecf_noiseDots; $i++ ) 
            {
				imagefilledellipse( $wimplecf_img, 
									mt_rand( 0, $wimplecf_imgWidth ),
									mt_rand( 0, $wimplecf_imgHeight ),
									3, 
									3,
									$wimplecf_textColor );
			}
		}		
		
		imagefill( $wimplecf_img, 
		           0, 
				   0, 
				   $wimplecf_backgroundColor );	
		list ( $wimplecf_x, 
		       $wimplecf_y ) = $this->wimplecf_ImageTTFCenter( $wimplecf_img, 
		                                                       $wimplecf_text, 
												    		   $wimplecf_font, 
															   $wimplecf_fontSize );	
		imagettftext( $wimplecf_img, 
		              $wimplecf_fontSize, 
					  0, 
					  $wimplecf_x, 
					  $wimplecf_y, 
					  $wimplecf_textColor, 
					  $wimplecf_font, 
					  $wimplecf_text );		

		/* Showing image */
		imagejpeg( $wimplecf_img, NULL, 90 ); 
		
		/* defining the image type to be shown in browser widow */
		header( 'Content-Type: image/jpeg' ); 
		
		/* Destroying image instance */
		imagedestroy( $wimplecf_img ); 
		if ( isset( $_SESSION ) ) 
        {
			/* set random text in session for captcha validation*/
			$_SESSION['captcha_code'] = $wimplecf_text; 
		}
	}
	/*for random string*/
	protected function wimplecf_Random( $wimplecf_characters = '', 
										$wimplecf_letters = '23456789bcdfghjkmnpqrstvwxyz' ) 
    {
		$wimplecf_str = '';
		$wimplecf_characters = $this->c_bit;
		for ( $i = 0; $i < $wimplecf_characters; $i++ ) 
        {
			$wimplecf_str .= substr( $wimplecf_letters, 
									 mt_rand( 0, strlen( $wimplecf_letters )-1 ), 
							         1 );
		}
		$_SESSION["captcha_code"] = $wimplecf_str;
		return $wimplecf_str;
		
	}	
	
	/*function to convert hex value to rgb array*/
	protected function wimplecf_HexToRGB( $wimplecf_colour ) 
    {
		if ( $wimplecf_colour[0] == '#' ) 
        {
			$wimplecf_colour = substr( $wimplecf_colour, 1 );
		}
		if ( strlen( $wimplecf_colour ) == 6 ) 
        {
			list( $r, $g, $b ) = array( $wimplecf_colour[0] . $wimplecf_colour[1], 
			                            $wimplecf_colour[2] . $wimplecf_colour[3], 
										$wimplecf_colour[4] . $wimplecf_colour[5] );
		} 
        elseif ( strlen( $wimplecf_colour ) == 3 ) 
        {
			list( $r, $g, $b ) = array( $wimplecf_colour[0] . $wimplecf_colour[0], 
			                            $wimplecf_colour[1] . $wimplecf_colour[1], 
										$wimplecf_colour[2] . $wimplecf_colour[2] );
		}
        else 
        {
			return false;
		}
        
		$r = hexdec( $r );
		$g = hexdec( $g );
		$b = hexdec( $b );
		return array( 'r' => $r, 
					  'g' => $g, 
					  'b' => $b );
	}	

		
	/*function to get center position on image*/
	protected function wimplecf_ImageTTFCenter( $wimplecf_image, 
												$wimplecf_text, 
												$wimplecf_font, 
												$wimplecf_size, 
												$wimplecf_angle = 8 ) 
    {
		$wimplecf_xi  = imagesx( $wimplecf_image );
		$wimplecf_yi  = imagesy( $wimplecf_image );
		$wimplecf_box = imagettfbbox( $wimplecf_size, 
		                              $wimplecf_angle, 
									  $wimplecf_font, 
									  $wimplecf_text );
		// index 2 and 4 indicate lower right corner, 
		// X position and upper right corner, 
		// X position respectively 
		$wimplecf_xr   = abs( 
							max( $wimplecf_box[2], $wimplecf_box[4] ) ); 
		// index 5 and 7 indicate upper right corner, 
		// Y position and upper left corner, 
		// Y position respectively */
		$wimplecf_yr = abs( 
						  max( $wimplecf_box[5], $wimplecf_box[7] ) ); 
		$wimplecf_x  = intval( ( $wimplecf_xi - $wimplecf_xr ) / 2 );
		$wimplecf_y  = intval( ( $wimplecf_yi + $wimplecf_yr ) / 2 );
		return array( $wimplecf_x, $wimplecf_y );	
	}
}  // End class phptextClass
?>