<?php
/**
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
	
require_once( 'class.aws.service.php' );

function sendEmailToSes( $arrParam )
{
	if ( isset( $arrParam ) &&
         is_array( $arrParam ) &&
		 count( $arrParam ) )
	{
		if ( isset( $arrParam['AccessKey'] ) &&
  		     isset( $arrParam['SecretKey'] ) &&
			 isset( $arrParam['Region'] ) &&
			 isset( $arrParam['From'] ) &&
			 isset( $arrParam['To'] ) &&
			 isset( $arrParam['Subject'] ) &&
			 ( isset( $arrParam['Text'] ) ||
   			   isset( $arrParam['Html'] ) ) )
		{
			$param = array( 'Action' => 'SendEmail' );
			
			if ( '' != trim($arrParam['From'] ) )
			{
				$param['Source'] = trim( $arrParam['From'] );
			}
			else
			{
				return FALSE;
			}
			
			if ( is_array( $arrParam['To'] ) &&
				 count( $arrParam['To'] ) )
			{
				$i = 1;
				
				foreach ( $arrParam['To'] as $to )
				{
					$param['Destination.ToAddresses.member.'.$i] = trim( $to );
					
					$i++;
				}
			}
			elseif ( '' != trim( $arrParam['To'] ) )
			{
				$param['Destination.ToAddresses.member.1'] = trim( $arrParam['To'] );
			}
			else
			{
				return FALSE;
			}
			
			if ( isset( $arrParam['Cc'] ) )
			{
				if ( is_array( $arrParam['Cc'] ) &&
				     count( $arrParam['Cc'] ) )
				{
					$i = 1;
					
					foreach ( $arrParam['Cc'] as $cc )
					{
						$param['Destination.CcAddresses.member.'.$i] = trim( $cc );
						
						$i++;
					}
				}
				elseif ( '' != trim( $arrParam['Cc'] ) )
				{
					$param['Destination.CcAddresses.member.1'] = trim( $arrParam['Cc'] );
				}
			}
			
			if ( isset( $arrParam['Bcc'] ) )
			{
				if ( is_array( $arrParam['Bcc'] ) &&
 				     count( $arrParam['Bcc'] ) )
				{
					$i = 1;
					
					foreach ( $arrParam['Bcc'] as $bcc )
					{
						$param['Destination.BccAddresses.member.'.$i] = trim( $bcc );
						
						$i++;
					}
				}
				elseif ( '' != trim( $arrParam['Bcc'] ) )
				{
					$param['Destination.BccAddresses.member.1'] = trim( $arrParam['Bcc'] );
				}
			}
			
			if ( isset( $arrParam['ReplyTo'] ) )
			{
				if ( is_array( $arrParam['ReplyTo'] ) &&
				     count( $arrParam['ReplyTo'] ) )
				{
					$i = 1;
					
					foreach ( $arrParam['ReplyTo'] as $replyTo )
					{
						$param['ReplyToAddresses.member.'.$i] = trim( $replyTo );
						
						$i++;
					}
				}
				elseif ( '' != trim( $arrParam['ReplyTo'] ) )
				{
					$param['ReplyToAddresses.member.1'] = trim( $arrParam['ReplyTo'] );
				}
			}
			
			if ( ( isset($arrParam['ReturnPath'] ) ) &&
			     ( '' != trim( $arrParam['ReturnPath'] ) ) )
			{
				$param['ReturnPath'] = trim( $arrParam['ReturnPath'] );
			}
			
			if ( '' != trim( $arrParam['Subject'] ) )
			{
				$param['Message.Subject.Data'] = trim( $arrParam['Subject'] );
			}
			else
			{
				return FALSE;
			}
			
			if ( ( isset( $arrParam['SubjectCharset'] ) ) &&
			     ( '' != trim( $arrParam['SubjectCharset'] ) ) )
			{
				$param['Message.Subject.Charset'] = trim( $arrParam['SubjectCharset'] );
			}
			
			if ( ( isset( $arrParam['Text'] ) ) &&
			     ( '' != trim( $arrParam['Text'] ) ) )
			{
				$param['Message.Body.Text.Data'] = trim( $arrParam['Text'] );
			}
			
			if ( ( isset( $arrParam['TextCharset'] ) ) &&
  			     ( '' != trim( $arrParam['TextCharset'] ) ) )
			{
				$param['Message.Body.Text.Charset'] = trim( $arrParam['TextCharset'] );
			}
				
			if ( ( isset( $arrParam['Html'] ) ) &&
  			     ( '' != trim( $arrParam['Html'] ) ) )
			{
				$param['Message.Body.Html.Data'] = trim( $arrParam['Html'] );
			}
				
			if ( ( isset( $arrParam['HtmlCharset'] ) ) &&
 			     ( '' != trim( $arrParam['HtmlCharset'] ) ) )
			{
				$param['Message.Body.Html.Charset'] = trim( $arrParam['HtmlCharset'] );
			}
			
			if ( ( '' != trim( $arrParam['AccessKey'] ) ) &&
			     ( '' != trim( $arrParam['SecretKey'] ) ) &&
				 ( '' != trim( $arrParam['Region'] ) ) )
			{
				$ses = new AWSServiceForWP( trim($arrParam['AccessKey'] ), trim( $arrParam['SecretKey'] ), trim( $arrParam['Region'] ) );
			}
			else
			{
				return false;
			}
			
			$response = $ses->callAWSService( $param );
						
			if ( is_wp_error( $response ) ||
			     200 != wp_remote_retrieve_response_code( $response ) )
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}
?>
