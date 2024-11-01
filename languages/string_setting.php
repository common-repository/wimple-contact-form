<?php
#######################################################################################
# Plugin Name: WIMPLE Contact Form                                                	  #
# Author: SARANGSoft (Email: wp-contact@sarangsoft.com, Web: https://sarangsoft.com)  #
# File Name: string_setting.php														  #
# Purpose: Setting string values to constants.                                        #
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

//common strings

define( 'WIMPLECF_BUTTON_ADDNEW', 'Add New' );
define( 'WIMPLECF_BUTTON_EDIT', 'Edit' );
define( 'WIMPLECF_BUTTON_DELETE', 'Delete' );
define( 'WIMPLECF_BUTTON_PREVIEW', 'Preview' );
define( 'WIMPLECF_STATUS_ACTIVE', 'Active' );
define( 'WIMPLECF_STATUS_ACTIVE_VALUE', '1' );
define( 'WIMPLECF_STATUS_INACTIVE', 'Inactive' );
define( 'WIMPLECF_STATUS_INACTIVE_VALUE', '0' );

define( 'WIMPLECF_THEME_OPTION_VALUE_THEME0', 'Theme0' );
define( 'WIMPLECF_THEME_OPTION_VALUE_THEME1', 'Theme1' );
define( 'WIMPLECF_THEME_OPTION_VALUE_THEME2', 'Theme2' );
define( 'WIMPLECF_THEME_OPTION_VALUE_THEME3', 'Theme3' );
define( 'WIMPLECF_THEME_OPTION_VALUE_THEME4', 'Theme4' );
define( 'WIMPLECF_THEME_OPTION_VALUE_THEME5', 'Theme5' );

define( 'WIMPLECF_BUTTON_SAVE', 'Save' );

define( 'WIMPLECF_FIELD_TYPE_TEXT', 'text' );
define( 'WIMPLECF_FIELD_TYPE_TEXTAREA', 'textarea' );
define( 'WIMPLECF_FIELD_TYPE_SELECTBOX', 'selectbox' );
define( 'WIMPLECF_FIELD_TYPE_RADIOBUTTON', 'radiobutton' );
define( 'WIMPLECF_FIELD_TYPE_CHECKBOX', 'checkbox' );

define( 'WIMPLECF_MANDATORY_OPTIONAL', '0' );
define( 'WIMPLECF_MANDATORY_REQUIRED', '1' );
define( 'WIMPLECF_MANDATORY_EMAIL_REQUIRED', '2' );

//form listing display page strings

define( 'WIMPLECF_PAGE_HEADING_FORM_LIST', 'List of Contact Forms' );
define( 'WIMPLECF_LABEL_FORMNAME_FORM_LIST', 'Form Name' );
define( 'WIMPLECF_LABEL_SHORTCODE_FORM_LIST', 'Shortcode' );
define( 'WIMPLECF_LABEL_CONTACT_EMAIL_FORM_LIST', 'Contact Email Recipient' );
define( 'WIMPLECF_LABEL_STATUS_FORM_LIST', 'Status' );
define( 'WIMPLECF_LABEL_ACTION_FORM_LIST', 'Actions' );

define( 'WIMPLECF_MSG_NO_FORM_FORM_LIST', 'No form is created.' );


//form add/edit page strings

define( 'WIMPLECF_PAGE_HEADING_NEWFORM_ADD_FORM', 'Add New Contact Form' );
define( 'WIMPLECF_PAGE_SUBHEADING_NEWFORM_ADD_FORM', 
        'Add contact form name and other information.' );
define( 'WIMPLECF_PAGE_HEADING_EDIT_ADD_FORM', 'Edit' );
define( 'WIMPLECF_PAGE_SUBHEADING_EDIT_ADD_FORM', 
        'Edit contact form name and other information.' );

define( 'WIMPLECF_SECTION_HEADING_FORMDETAILS_ADD_FORM', 'Form Details' );

define( 'WIMPLECF_LABEL_FORMNAME_ADD_FORM', 'Form Name:' );
define( 'WIMPLECF_CHECKBOX_DISPLAY_FRONTEND_ADD_FORM', 'Display in Frontend' );
define( 'WIMPLECF_MSG_DISPLAY_FRONTEND_CHECKED_ADD_FORM', 
        'Form name will be displayed as form title.' );
define( 'WIMPLECF_MSG_DISPLAY_FRONTEND_UNCHECKED_ADD_FORM', 
        'Form name will not be displayed as form title.' ); 
		
define( 'WIMPLECF_LABEL_FORMBUTTON_ADD_FORM', 'Form Button Label:' );
define( 'WIMPLECF_MSG_FORMBUTTON_ADD_FORM', 
		'Label of the Form button shown at the bottom of the form layout.' );

define( 'WIMPLECF_LABEL_CAPTCHA_ADD_FORM', 'Use CAPTCHA?' );
define( 'WIMPLECF_CAPTCHA_OPTION_YES_ADD_FORM', 'Yes' );
define( 'WIMPLECF_CAPTCHA_OPTION_NO_ADD_FORM', 'No' );

define( 'WIMPLECF_MSG_CAPTCHA_ADD_FORM', 
        'You can use CAPTCHA against robot systems submitting junk data through such forms.' );
define( 'WIMPLECF_LABEL_CAPTCHALENGTH_ADD_FORM', 'CAPTCHA Length:' );
define( 'WIMPLECF_CAPTCHALENGTH_OPTION_VALUE_6_ADD_FORM', '6' );
define( 'WIMPLECF_CAPTCHALENGTH_OPTION_VALUE_8_ADD_FORM', '8' );

define( 'WIMPLECF_CAPTCHALENGTH_OPTION_6_ADD_FORM', '6' );
define( 'WIMPLECF_CAPTCHALENGTH_OPTION_8_ADD_FORM', '8' );
define( 'WIMPLECF_MSG_CAPTCHALENGTH_ADD_FORM', 
        'Choose the number of characters ( 6 or 8 ) to use in CAPTCHA.' );

define( 'WIMPLECF_LABEL_THEME_ADD_FORM', 'Color Choice:' ); 

define( 'WIMPLECF_THEME_OPTION_THEME0_ADD_FORM', 'Default Style' );
define( 'WIMPLECF_THEME_OPTION_THEME1_ADD_FORM', 'Sky Blue' );
define( 'WIMPLECF_THEME_OPTION_THEME2_ADD_FORM', 'Dark Green' );
define( 'WIMPLECF_THEME_OPTION_THEME3_ADD_FORM', 'Gray Shade' );
define( 'WIMPLECF_THEME_OPTION_THEME4_ADD_FORM', 'Shadow Background' );
define( 'WIMPLECF_THEME_OPTION_THEME5_ADD_FORM', 'Simple &amp; Without Background' );

define( 'WIMPLECF_MSG_THEME_ADD_FORM', 
        'Choose one of the available color choices for displaying the form in the frontend ( to users ).' );

define( 'WIMPLECF_LABEL_STATUS_ADD_FORM', 'Status:' );
define( 'WIMPLECF_MSG_STATUS_ADD_FORM', 
        'Activate or deactivate this form.' );

define( 'WIMPLECF_SECTION_HEADING_EMAILSETUP_ADD_FORM', 
        'Auto-generated Email Details' );

define( 'WIMPLECF_LABEL_RECIPIENT_ADD_FORM', 'To Email ID:' );
define( 'WIMPLECF_MSG_RECIPIENT_ADD_FORM', 
        'By default administrator email id is set. You can change it as per your choice.' );

define( 'WIMPLECF_LABEL_SENDER_ADD_FORM', 
        'From Email ID:' );
define( 'WIMPLECF_MSG_SENDER_ADD_FORM', 
        'By default administrator email id is set. You can change it as per your choice.' );

define( 'WIMPLECF_LABEL_SUBJECT_ADD_FORM', 
        'Email Subject:' );
		
define( 'WIMPLECF_MSG_SUBJECT_ADD_FORM', 
        'Enter subject line for the generated email with form data.' );
		
define( 'WIMPLECF_FIXED_SUBJECT_ADD_FORM', 
        ' [Test purpose for WIMPLE Contact Form admin]' );		

define( 'WIMPLECF_LABEL_MAIL_SETTING_ADD_FORM', 
        'Choose Mail Settings:' );
		
define( 'WIMPLECF_RADIOBUTTON_DEFAULT_PHP_ADD_FORM', 
        'Use other SMTP server (not AWS SES)' );
define( 'WIMPLECF_RADIOBUTTON_DEFAULT_PHP_FOR_WINDOWS_ADD_FORM', 
		'Other SMTP service (LINUX or Windows)' );
		
define( 'WIMPLECF_RADIOBUTTON_DEFAULT_PHP_FOR_LINUX_ADD_FORM', 
		'Your own SMTP service (LINUX only)' );
		
define( 'WIMPLECF_RADIOBUTTON_AWS_SES_ADD_FORM', 
        'Use AWS SES of your own AWS account' );
		
define( 'WIMPLECF_RADIOBUTTON_SENDGRID_ADD_FORM', 
        'Use API Key of your own SendGrid account' );

define( 'WIMPLECF_MSG_DEFAULT_PHP_ADD_FORM', 
		'<div class="wimplecf_steps">Steps:</div>
		   <div class="wimplecf_popClickInfoCntnr"><strong>a)</strong>
			<a href="#" class="wimplecf_popClickInfo">Steps for sending mail only in LINUX environment</a>
			<div>
				<a title="Close" href="#" class="wimplecf_popClose"></a>
				<strong>Steps for sending mail only in LINUX environment</strong>
				<p>Please do the following steps to complete the process.</p>
				<hr>
				<ol>
					<li>Check if the SMTP service is running on your server.</li>
					<li>Install one of the following Mail Transfer Agents (MTA) on your server:
						<ol>
							<li>sendmail</li>
							<li>postfix</li>
						</ol>
					</li>
					<li>Click on the \'Send Test Email\' button to check your email sending arrangement.</li>
				</ol>
			</div>                                        
		</div>' );

define( 'WIMPLECF_MSG_PHP_MAILER_ADD_FORM', 
		'  <div class="wimplecf_steps">Steps:</div>
		   <div class="wimplecf_popClickInfoCntnr"><strong>a)</strong>
			<a href="#" class="wimplecf_popClickInfo">Steps for sending mail in LINUX or Windows environment</a>
			<div>
				<a title="Close" href="#" class="wimplecf_popClose"></a>
				<strong>Steps for sending mail in LINUX or Windows environment</strong>
				<p>Please do the following steps to complete the process.</p>
				<hr>
				<ol>
					<li>Provide your SMTP server address.</li>
					<li>Provide server port.</li>
					<li>Provide valid SMTP username / email ID.</li>
					<li>Provide valid SMTP password.</li>
				</ol>
				<div class="wimplecf_note"><p><strong>NOTE:</strong> Based on the SMTP server you choose, you may need to do
																	 some settings as per the requirement of the SMTP server 
																	 to send mail. Please check with / contact your SMTP server
																	 provider.</p></div>
			</div>                                        
		</div>' );
		
define( 'WIMPLECF_OTHER_SMTP_INSTRUCTION_ADD_FORM', 
        '<span><strong>b)</strong></span>&nbsp;<span class="wimplecf_threeline">Please copy the following  four (4) lines of code,
		 add those in your wp-config.php file, and replace 
		 the placeholder values with your own 
		 ( for SMTP Server Address, Port Number, User Email Id and Password ).</span>' );
												   
define( 'WIMPLECF_DEFAULT_PLACEHOLDER_SERVER_ADDRESS_ADD_FORM', 'SMTP Server Address' );												   
define( 'WIMPLECF_DEFAULT_PLACEHOLDER_SERVER_PORT_ADD_FORM', 'Port Number' );
define( 'WIMPLECF_DEFAULT_PLACEHOLDER_SMTP_USERNAME_ADD_FORM', 'User Email Id' );
define( 'WIMPLECF_DEFAULT_PLACEHOLDER_SMTP_PASSWORD_ADD_FORM', 'Password' );
										
define( 'WIMPLECF_CONFIRMATION_MAIL_RECEIVED_ADD_FORM', 
        'Has the test email reached the intended recipient\'s account?' );

define( 'WIMPLECF_MSG_AWS_SES_ADD_FORM', 
		'  <div class="wimplecf_steps">Steps:</div>
		   <div class="wimplecf_popClickInfoCntnr"><strong>a)</strong>
			<a href="#" class="wimplecf_popClickInfo">Steps for setting up AWS Simple Email Service (SES) to generate emails</a>
			<div>
				<a title="Close" href="#" class="wimplecf_popClose"></a>
				<strong>Steps for setting up AWS Simple Email Service (SES) to generate emails</strong>
				<p>Please do the following steps to complete the process.</p>
				<hr>
				<ol>
					<li>You need to have an Amazon AWS account or create a new one.</li>
					<li>Log into your AWS account.</li>
					<li>Click on \'Simple Email Service\' (SES) under \'Customer Engagement\' in AWS Dashboard.</li>
					<li>Click on \'Email Addresses\' in the left-pane in \'Simple Email service\' page.</li>
					<li>Click on the \'Verify a New Email Address\' button.</li>
					<li>In \'Email Address\' textbox enter the email id that you have already entered in the \'From Email ID\' 
						field in \'Auto-generated Email Details\' section of your contact form.</li>
					<li>Next click on the \'Verify This Email Address\' button.</li>
					<li>An email will be sent to the email account specified in Step 6 above. Please click on the link in that 
						email to verify your account.</li>
					<li>Now that you have verified the sender email id, you can send emails from it using AWS-SES.</li>
					<li>Repeat steps 4 - 8 to verify the Recipient Email Id you have entered in \'Recipient email id\' field in 
						\'Auto-generated Email Details\' section of your contact form.</li>
					<li>Once the sender and recipient email ids are verified, create an Identity and Access Management (IAM) account 
						in your AWS account as follows:
						<ol>
							<li>Click on IAM under \'Security, Identity & Compliance\' in AWS Dashboard.</li>
							<li>In IAM page, click on \'Groups\' to create a new group.</li>
							<li>Click on \'Create New Group\' button to create the group and set permission to it.</li>
							<li>Attach \'AmazonSESFullAccess\' policy in the \'Permission\' section.</li>
							<li>Next click on \'Users\' in the left-pane to create an user.</li>
							<li>Add this user to the newly-created group, so that this user will get \'AmazonSESFullaccess\' 
								permission level.</li>
							<li>Once the user is created, you will get the \'Access Key\' and \'Secret Access Key\' for that user.</li>
						</ol>
					</li>
					<li>You need to provide an API Endpoint as \'Host\' based on the region of your account (located on the top-right 
						corner after you log into your AWS account).<br />For a list of region based endpoints, please see the link 
						<a target="_blank" href="https://docs.aws.amazon.com/general/latest/gr/ses.html">
							https://docs.aws.amazon.com/general/latest/gr/ses.html
						</a>
					</li>
					<li>Please provide the \'API endpoint\' from Step 12 as \'Host\' and \'Access Key\', \'Secret Access Key\' 
						from Step 11 (g) in the three text boxes below.</li>
					<li>Click on the \'Send Test Email\' button to check your email sending arrangement.</li>
				</ol>
			</div>
		</div>' );
									
define( 'WIMPLECF_AWS_SES_INSTRUCTION_ADD_FORM', 
        '<span><strong>b)</strong></span>&nbsp;<span class="wimplecf_threeline">Please copy the following  three (3) lines of code,
		 add those in  your wp-config.php file, and replace 
		 the placeholder values with your own 
		 ( for  AWS  Endpoint, AWS Access Key, and AWS Secret Access Key ).</span>' );

define( 'WIMPLECF_DEFAULT_PLACEHOLDER_ENDPOINT_ADD_FORM', 'AWS Endpoint' );
define( 'WIMPLECF_DEFAULT_PLACEHOLDER_ACCESS_KEY_ADD_FORM', 'AWS Access key (20 chars)' );
define( 'WIMPLECF_DEFAULT_PLACEHOLDER_SECRET_ACCESS_KEY_ADD_FORM', 'AWS Secret Access key (40 chars)' );

define( 'WIMPLECF_MSG_SENDGRID_ADD_FORM', 
		'<div class="wimplecf_steps">Steps:</div>
		   <div class="wimplecf_popClickInfoCntnr"><strong>a)</strong>
			<a href="#" class="wimplecf_popClickInfo">Steps for SendGrid email settings</a>
			<div>
				<a title="Close" href="#" class="wimplecf_popClose"></a>
				<strong>Steps for SendGrid email settings</strong>
				<p>Please do the following steps to complete the process.</p>
				<hr>
				<p><b>How to create API key</b></p>
				<ol>
					<li>You need to have an SendGrid account or create a new one.</li>
					<li>Log into your SendGrid account.</li>
					<li>Navigate to <strong>Settings</strong> on the left navigation bar, and then select <strong>API Keys</strong>.</li>
					<li>Click on <strong>Create API Key</strong>.</li>
					<li>Give your API key a name.</li>
					<li>Give permission through either <strong>Full Access</strong> or <strong>Restricted Access</strong> or <strong>Billing Access</strong>.</li>
					<li>Click <strong>Create & View</strong>.</li>
				</ol>
				<p><b>Sender Authentication process</b></p>
				<ol>
					<li>Click <strong>Sender Authentication</strong> in the left-side navigation bar under <strong>Settings</strong>.</li>
					<li>In the <strong>Sender Authentication</strong> page click the Verify a Single Sender button under <strong>Single Sender Verification</strong>.</li>
					<li>Now fill all mandatory fileds to create a sender from <strong>Create a Sender</strong> page where you need to specify your sender email ID. 
						Then clicking on <strong>Create</strong> button will send an email to your sender email ID.</li>
					<li>Go to your sender email account open the mail sent by SendGrid and click <strong>Verify Single Sender</strong> button to complete the verification process. </li>
				</ol>
			</div>
		</div>' );

define( 'WIMPLECF_MSG_SENDGRID_FOR_WINDOWS_ADD_FORM', 
		'<div class="wimplecf_popClickInfoCntnr wimplecf_certificate_assign"><strong>b)</strong>
			<a href="#" class="wimplecf_popClickInfo">Server configuration to send email for Windows users</a>
			<div>
				<a title="Close" href="#" class="wimplecf_popClose"></a>
				<strong>Steps to add a valid certificate to avoid cURL error</strong>
				<p>Please do the following steps to complete the process.</p>
				<hr>
				<ol>
					<li>Open https://curl.se/ca/cacert.pem</li>
					<li>Either copy entire page(certificate content) and save it as "cacert.pem", or save/locate the downloaded "cacert.pem" file on your computer.</li>
					<li>Open your php.ini file and insert or update the following line.<br />
						<code>curl.cainfo = "[pathtofile]cacert.pem"</code></li>
				</ol>
			</div>
		</div>' );
									
define( 'WIMPLECF_SENDGRID_INSTRUCTION_ADD_FORM', 
        '<span class="wimplecf_floatl"><strong>c)</strong></span>&nbsp;<span class="wimplecf_threeline wimplecf_floatl">Please copy the following line of code,
		 add it in  your wp-config.php file, and replace 
		 the placeholder values with your own 
		 ( for  SendGid API Key ).</span>' );
		 
		 
define( 'WIMPLECF_DEFAULT_PLACEHOLDER_SENDGRID_API_ADD_FORM', 'SendGrid API Key' );


//SPF and DKIM guide
define( 'WIMPLECF_MSG_SPF_DKIM_ADD_FORM', 
		'
		<div class="wimplecf_popClickInfoCntnr-box">
			<a href="#" class="wimplecf_popClickInfo">Email Authentication using SPF and DKIM</a>
			<div>
				<a title="Close" href="#" class="wimplecf_popClose"></a>
				<h3 class="top">Sender Policy Framework (SPF) and Domain Keys Identified Mail (DKIM) Settings</h3>
                <div class="pop-inerbox">
				<p><b>WimPle Contact Form plugin for WordPress</b> helps you send emails via <b>your own SMTP server, Amazon AWS SES</b> service, and <b>Twilio SendGrid</b> service. To address the rampant problems with spamming, email spoofing etc., various precautionary measures are being taken, which often block emails sent by legitimate senders - like you - to be blocked or filtered out as spam. Specifying the SPF and DKIM settings for the sender domains / services is either required or highly recommended for better delivery of the generated emails. </p>
                <p>DMARCLY (<a target="_blank" href="https://dmarcly.com">https://dmarcly.com</a>) provides a lot of helpful information about SPF, DKIM etc. and successful email delivery to the intended recipients. DMARCLY blog (<a target="_blank" href="https://dmarcly.com/blog">https://dmarcly.com/blog</a>) has many articles explaining the various topics and How-To guides on setting up SPF, DKIM for various email services / options.</p>
                <p>To authorize your choice of SMTP service, e.g., AWS SES or SendGrid, to send emails on behalf of you (from within your application), you should set up SPF and DKIM for that service, which involves a process also known as \'Email Domain Authentication.\'</p>
                <p>The Benefits of setting up SPF and DKIM are:</p>
			
				<ul>
					<li> The emails are more likely to reach the recipient\'s Inbox.</li>
					<li> The "sent from  amazonses.com" or "via SendGrid.net" message will not be shown in the email header any more, making it seem to come directly from your brand rather than through a 3rd party service, which makes the user more likely to open the email.</li>
				</ul>
                <p>Please refer to the following about SPF and DKIM as well as how to set up domain records for those.</p>
                
                <h3>SPF</h3>
                <p>Here is some basic information about SPF.</p>
                <p>Introduction to SPF: <a target="_blank" href="https://dmarcly.com/blog/introduction-to-spf">https://dmarcly.com/blog/introduction-to-spf</a></p>
                <p>What and How of SPF Record: <a target="_blank" href="https://dmarcly.com/blog/what-is-an-spf-record-and-how-does-it-work-spf-record-explained">https://dmarcly.com/blog/what-is-an-spf-record-and-how-does-it-work-spf-record-explained</a></p>
                <p>Guide to Setting up SPF: <a target="_blank" href="https://dmarcly.com/blog/how-to-set-up-sender-policy-framework-spf-the-complete-guide">https://dmarcly.com/blog/how-to-set-up-sender-policy-framework-spf-the-complete-guide</a></p>
                
                <strong>Amazon AWS SES</strong>
                <p>If we use subdomain.amazonses.com as the MAIL FROM domain then we don’t need to set any SPF record because Amazon has already published SPF record in amazonses.com. But if we use our own domain as MAIL FROM domain then we need to set a SPF record in our domain for AWS SES.</p>
                <p>For more details, please refer to <a target="_blank" href="https://dmarcly.com/blog/how-to-set-up-spf-and-dkim-for-amazon-ses">https://dmarcly.com/blog/how-to-set-up-spf-and-dkim-for-amazon-ses</a></p>
                <strong>Twilio SendGrid</strong>
                <p>To set up SPF at your domain, please refer the following link - </p>
                <p><a target="_blank" href="https://dmarcly.com/blog/how-to-set-up-spf-and-dkim-for-sendgrid">https://dmarcly.com/blog/how-to-set-up-spf-and-dkim-for-sendgrid</a></p>
                <strong>Adding SPF to Domain Record</strong>
                <p>Though it depends on and may differ between various domain registration services, in general you need to add a TXT record in your domain record.</p>
                <p>Type:&nbsp;TXT<br />
Hostname:&nbsp;&nbsp;@<br />
Destination:&nbsp;&nbsp;v=spf1 include:<mark>&lt;whatever you need to specify&gt;</mark> -all [or ~all]<br />
TTL:&nbsp;&nbsp;3600</p>
                <p><b>Note:</b> Replace the <mark>highlighted</mark> data above with your related mail service provider (like AWS SES, SendGrid etc.).</p>
                <h3>DKIM</h3>
                <p>DKIM FAQ: <a target="_blank" href="https://dmarcly.com/blog/dkim-faqs-frequently-asked-questions">https://dmarcly.com/blog/dkim-faqs-frequently-asked-questions</a></p>
                <strong>Amazon AWS SES</strong>
                <p>To setup DKIM for AWS SES at your domain please refer to the following link - <br />
                   <a target="_blank" href="https://docs.aws.amazon.com/ses/latest/dg/send-email-authentication-dkim-easy.html">https://docs.aws.amazon.com/ses/latest/dg/send-email-authentication-dkim-easy.html</a> 
                </p>
                <strong>Twilio SendGrid</strong>
                <p>To setup DKIM for SendGrid at your domain please refer to the following link -<br />
                   <a target="_blank" href="https://dmarcly.com/blog/how-to-set-up-spf-and-dkim-for-sendgrid">https://dmarcly.com/blog/how-to-set-up-spf-and-dkim-for-sendgrid</a> 
                </p>
                <strong>Adding DKIM to Domain Record</strong>
                <p>The exact steps for adding DKIM to your domain record might vary between the different domain registration services. You will have to either search for or ask your service provider for the details.
                </p>
                <h3>Verify SPF and DKIM Settings</h3>
                <p>There is a simple way to test whether the SPF and DKIM set properly at your domain. Simply send a test email from you mail account to <b>check-auth@verifier.port25.com.</b> You will get an immediate response to your mail account where you will find SPF and DKIM are properly set or not in your mail domain. </p>             
                <h3>Information About Some Common Email Services</h3>
                <p>Here are links to information on SPF and DKIM setup for some common email service providers, in case you use one of these for your emails. Otherwise, please search for or contact your email service provider for this information.</p>
                <strong>Microsoft 365 (often referred to as Office 365):</strong>
                <p><a target="_blank" href="https://dmarcly.com/blog/how-to-set-up-dmarc-dkim-and-spf-in-office-365-o365-the-complete-implementation-guide">https://dmarcly.com/blog/how-to-set-up-dmarc-dkim-and-spf-in-office-365-o365-the-complete-implementation-guide</a></p>
                <p><a target="_blank" href="https://social.technet.microsoft.com/wiki/contents/articles/34956.office-365-using-spf-dkim-and-dmarc-for-secure-messaging.aspx">https://social.technet.microsoft.com/wiki/contents/articles/34956.office-365-using-spf-dkim-and-dmarc-for-secure-messaging.aspx </a></p>
                <strong>Google Mail (Google WorkSpace):</strong>
                <p><a target="_blank" href="https://dmarcly.com/blog/spf-dkim-dmarc-set-up-guide-for-g-suite-gmail-for-business">https://dmarcly.com/blog/spf-dkim-dmarc-set-up-guide-for-g-suite-gmail-for-business</a></p>
                <p><a target="_blank" href="https://support.google.com/a/answer/180504">https://support.google.com/a/answer/180504 </a></p>
                <strong>RackSpace Email:</strong>
                <p><a target="_blank" href="https://docs.rackspace.com/support/how-to/create-an-spf-policy/">https://docs.rackspace.com/support/how-to/create-an-spf-policy/ </a></p>
                <strong>GoDaddy Email:</strong>
                <p><a target="_blank" href="https://in.godaddy.com/help/add-an-spf-record-19218">https://in.godaddy.com/help/add-an-spf-record-19218 </a></p>
                </div>
                
			</div>                                       
		</div>
		<span class="wimplecf_spf_dkim_tag_line">SPF and/or DKIM settings are either required / recommended for better delivery of generated emails.</span>' );

define( 'WIMPLECF_BUTTON_COPY_CODE_ADD_FORM', 'Copy Code' );

define( 'WIMPLECF_AWS_MSG_DEFINED_ADD_FORM', 
        'Above three lines are already added in wp-config.php file and the placeholder values are replaced.' );

define( 'WIMPLECF_OTHER_MSG_DEFINED_ADD_FORM', 
        'Above four lines are already added in wp-config.php file and the placeholder values are replaced.' );
		
define( 'WIMPLECF_SENDGRID_MSG_DEFINED_ADD_FORM', 
        'Above line is already added in wp-config.php file and the placeholder value is replaced.' );

define( 'WIMPLECF_NOTE_COPY_CODE_ADD_FORM', 
		'NOTE:<br />
		 If the above-mentioned lines of code are not added
		 to wp-config.php and/or the  placeholder (sample) 
		 values are not replaced with your actual values,
		 clicking on "Send Test Email" will not send an email
		 for verification of the email settings. As a result,
		 when the form is used on the live server, the data
		 from the form will not be sent via email as expected.' );

define( 'WIMPLECF_BUTTON_SEND_TEST_EMAIL_ADD_FORM', 'Send Test Email' );
define( 'WIMPLECF_BUTTON_YES_ADD_FORM', 'Yes' );
define( 'WIMPLECF_BUTTON_NO_ADD_FORM', 'No' );

define( 'WIMPLECF_MSG_NOTE_ADD_FORM', 
        'NOTE: The email generated from the contact form may not reach the intended recipients as that 
		 setup is not yet complete / verified.' );
												
												
define( 'WIMPLECF_VALIDATION_ERROR_NAME_BLANK_ADD_FORM', 
        'Please enter form name.' );
define( 'WIMPLECF_VALIDATION_ERROR_NAME_EXISTS_ADD_FORM', 
        'This form name already exists.' );
define( 'WIMPLECF_VALIDATION_ERROR_RECIPENT_EMAIL_ADD_FORM', 
        'Please enter valid recipient\'s email id.' );
define( 'WIMPLECF_VALIDATION_ERROR_SENDER_EMAIL_ADD_FORM', 
        'Please enter valid sender\'s email id.' );
define( 'WIMPLECF_VALIDATION_ERROR_SUBJECT_ADD_FORM', 
        'Please enter subject line which will be presented as the subject line for user\'s feedback email.' );
define( 'WIMPLECF_VALIDATION_ERROR_SMTP_SETTING_ADD_FORM', 
        'Please select your email sending service.' );
define( 'WIMPLECF_VALIDATION_ERROR_SERVER_OS_ADD_FORM', 
        'Please select your server\'s operating system.' );
define( 'WIMPLECF_VALIDATION_ERROR_SERVER_ADDRESS_ADD_FORM', 
        'Specify valid server address.' );
define( 'WIMPLECF_VALIDATION_ERROR_SERVER_PORT_ADD_FORM', 
        'Specify valid port number.' );
define( 'WIMPLECF_VALIDATION_ERROR_SMTP_USERNAME_ADD_FORM', 
        'Specify valid SMTP username.' );
define( 'WIMPLECF_VALIDATION_ERROR_SMTP_PASSWORD_ADD_FORM', 
        'Specify valid SMTP password.' );		
define( 'WIMPLECF_VALIDATION_ERROR_SMTP_ENDPOINT_ADD_FORM', 
        'Specify valid SMTP endpoint.' );	
define( 'WIMPLECF_VALIDATION_ERROR_ACCESS_KEY_ADD_FORM', 
        'Specify access key.' );	
define( 'WIMPLECF_VALIDATION_ERROR_SECRET_ACCESS_KEY_ADD_FORM', 
        'Specify secret access key.' );	
		
define( 'WIMPLECF_MSG_FORM_UPDATE_ADD_FORM', 
        'Clicking on the following button will update the current data / choices and proceed to the next page to edit the form layout.' );
define( 'WIMPLECF_MSG_FORM_SAVE_ADD_FORM', 
        'Clicking on the following button will save the current data / choices and proceed to the next page to define the form layout.' );


//form fields add/edit page strings

define( 'WIMPLECF_PAGE_HEADING_NEWFIELD_ADD_FORM_FIELD', 
        'Manage fields for ' );
		
define( 'WIMPLECF_PAGE_SUBHEADING1_ADD_FORM_FIELD', 
        'Basic Properties' );
define( 'WIMPLECF_PAGE_SUBHEADING2_ADD_FORM_FIELD', 
        'Messages' );
define( 'WIMPLECF_PAGE_SUBHEADING3_ADD_FORM_FIELD', 
        'Position' );
define( 'WIMPLECF_LABEL_FIELD_NAME_ADD_FORM_FIELD', 
        'Field Name' );
define( 'WIMPLECF_LABEL_FIELD_TYPE_ADD_FORM_FIELD', 
        'Field Type' );
define( 'WIMPLECF_LABEL_DATE_FORMAT_ADD_FORM_FIELD', 
        'Date Format' );

define( 'WIMPLECF_LABEL_OPTION_ADD_FORM_FIELD', 'Options' );
define( 'WIMPLECF_LABEL_NOTETEXT_ADD_FORM_FIELD', 'Note Text' );
define( 'WIMPLECF_LABEL_CHAR_LIMIT_ADD_FORM_FIELD', 'Char Limit' );
define( 'WIMPLECF_LABEL_CAPTCHA_ADD_FORM_FIELD', 'CAPTCHA Label' );
define( 'WIMPLECF_LABEL_CAPTCHA_LENGTH_ADD_FORM_FIELD', 'Char Length' );
define( 'WIMPLECF_LABEL_REQUIRED_ADD_FORM_FIELD', 'Mandatory' );
define( 'WIMPLECF_LABEL_EMAIL_REQUIRED_ADD_FORM_FIELD', 'Email Validation' );
define( 'WIMPLECF_LABEL_NUMERIC_ONLY_REQUIRED_ADD_FORM_FIELD', 'Numeric Only' );
define( 'WIMPLECF_LABEL_PROMPT_ADD_FORM_FIELD', 'Prompt' );
define( 'WIMPLECF_LABEL_HELP_TEXT_ADD_FORM_FIELD', 'Help Text' );
define( 'WIMPLECF_LABEL_ERROR_ADD_FORM_FIELD', 'Error' );

define( 'WIMPLECF_LABEL_FIELD_WIDTH_ADD_FORM_FIELD', 'Select Field Width' );
define( 'WIMPLECF_LABEL_SELECT_ROW_ADD_FORM_FIELD', 'Place Field: Select Row' );
define( 'WIMPLECF_LABEL_SELECT_COLOMN_FORM_FIELD', 'Place Field: Within Row' );


define( 'WIMPLECF_LABEL_REQUIRED_EMAIL_ADD_FORM_FIELD', 
        'Email Required (Provide valid email id)' );

define( 'WIMPLECF_LABEL_ERROR_MESSAGE_ADD_FORM_FIELD', 'Error Message:' );

define( 'WIMPLECF_LABEL_HELP_MESSAGE_ADD_FORM_FIELD', 'Help Message:' );

define( 'WIMPLECF_LABEL_DISPLAY_ORDER_ADD_FORM_FIELD', 'Display Order:' );
define( 'WIMPLECF_MSG_DISPLAY_ORDER_ADD_FORM_FIELD', 
        'By default in the order of adding the fields.' );

define( 'WIMPLECF_HEADING_FIELDS_LISTING_ADD_FORM_FIELD', 'Fields of this Form' );
define( 'WIMPLECF_LABEL_FIELD_NAME_FIELDS_LISTING_ADD_FORM_FIELD', 'Field Name' );
define( 'WIMPLECF_LABEL_FIELD_TYPE_FIELDS_LISTING_ADD_FORM_FIELD', 'Field Type' );
define( 'WIMPLECF_LABEL_MANDATORY_FIELDS_LISTING_ADD_FORM_FIELD', 'Mandatory' );
define( 'WIMPLECF_LABEL_DISPLAY_ORDER_FIELDS_LISTING_ADD_FORM_FIELD', 'Display Order' );
define( 'WIMPLECF_LABEL_ACTION_FIELDS_LISTING_ADD_FORM_FIELD', 'Actions' );

define( 'WIMPLECF_TEXT_FIELD_TYPE_SINGLELINE_ADD_FORM_FIELD', 'Single-line Text' );
define( 'WIMPLECF_TEXT_FIELD_TYPE_MULTILINE_ADD_FORM_FIELD', 'Multi-line Text' );
define( 'WIMPLECF_TEXT_FIELD_TYPE_DROPDOWNLIST_ADD_FORM_FIELD', 'Dropdown List' );
define( 'WIMPLECF_TEXT_FIELD_TYPE_RADIOBUTTON_ADD_FORM_FIELD', 'Radio Button' );
define( 'WIMPLECF_TEXT_FIELD_TYPE_CHECKBOX_ADD_FORM_FIELD', 'Checkbox' );

define( 'WIMPLECF_TEXT_MANDATORY_OPTIONAL_ADD_FORM_FIELD', 'Optional' );
define( 'WIMPLECF_TEXT_MANDATORY_REQUIRED_ADD_FORM_FIELD', 'Required' );
define( 'WIMPLECF_TEXT_MANDATORY_EMAIL_REQUIRED_ADD_FORM_FIELD', 'Email Required' );

define( 'WIMPLECF_RESULT_FIELDS_LISTING_ADD_FORM_FIELD', 'None.' );


define( 'WIMPLECF_VALIDATION_ERROR_NAME_BLANK_ADD_FORM_FIELD',
        'Please enter field name.' );
define( 'WIMPLECF_VALIDATION_ERROR_NAME_EXISTS_ADD_FORM_FIELD',
        'This field name already exists.' );
define( 'WIMPLECF_VALIDATION_ERROR_INPUTCHARLIMIT_ADD_FORM_FIELD',
        'You must specify character limit.' );
define( 'WIMPLECF_VALIDATION_ERROR_FIELDTYPE_EXISTS_ADD_FORM_FIELD',
        'CAPTCHA has already been added.' );
define( 'WIMPLECF_VALIDATION_ERROR_FIELD_OPTIONS_ADD_FORM_FIELD',
        'Enter the possible option names separated by pipe (|).' );
define( 'WIMPLECF_VALIDATION_ERROR_FIELD_NOTETEXT_ADD_FORM_FIELD',
        'This is a mandatory field.' );
define( 'WIMPLECF_VALIDATION_ERROR_FIELD_NOTETEXT_CHARLIMIT_ADD_FORM_FIELD',
        'Maximum 500 characters allowed.' );
define( 'WIMPLECF_VALIDATION_ERROR_FIELD_ERROR_ADD_FORM_FIELD',
        'Please enter error message to user in the frontend.' );
define( 'WIMPLECF_VALIDATION_ERROR_SORTORDER_ADD_FORM_FIELD',
        'Cannot keep this field blank or enter same display order which already exists.' );
define( 'WIMPLECF_STR_CHECK_DELETE_FIELD_ADD_FORM_FIELD', 'field_delete' );

define( 'WIMPLECF_DEFAULT_PLACEHOLDER_G_SITE_KEY_ADD_FORM_FIELD', 'Google Site Key' );
define( 'WIMPLECF_DEFAULT_PLACEHOLDER_G_SECRET_KEY_ADD_FORM_FIELD', 'Google Secret Key' );


//frontend form page strings

define( 'WIMPLECF_LABEL_VALIDATION_CODE_FORM', 'Security code' );
define( 'WIMPLECF_MSG_CAPTCHA_MATCH_FIRST_FORM', 'Enter above code' );
define( 'WIMPLECF_MSG_CAPTCHA_MATCH_LAST_FORM', 
        'To confirm that a person is filling this form, not a robot system.' );

define( 'WIMPLECF_VALIDATION_ERROR_INVALID_EMAIL_FORM', 
        'Invalid email id format.' );
define( 'WIMPLECF_VALIDATION_ERROR_CAPTCHA_CODE_FORM', 
        'The validation code does not match.' );

define( 'WIMPLECF_MSG_SUCCESS_SUBMIT_FIRST_FORM', 
        'Your Request has been sent successfully.' );

define( 'WIMPLECF_BUTTON_SUBMIT_FORM', 'Submit' );

define( 'WIMPLECF_MAIL_BODY_TEXT_FORM', 
        'User feedback from ' );


//form preview page strings

define( 'WIMPLECF_LABEL_VALIDATION_CODE_FORM_PREVIEW', 'Security code' );
define( 'WIMPLECF_MSG_CAPTCHA_MATCH_FIRST_FORM_PREVIEW', 'Enter above code' );
define( 'WIMPLECF_MSG_CAPTCHA_MATCH_LAST_FORM_PREVIEW',  
        'To confirm that a person is filling this form, not a robot system.' );
		
		
//Field add page Help text strings

define( 'WIMPLECF_HELPMSG_FIELD_GENERIC_INFORMATION', '<div class="popup_help_block">
                                		<h3>Field Name</h3>
                                    	<p>Name of the field within 50 characters.</p>
										</div>
                                    
                                    <div class="popup_help_block">
                                        <h3>Field Type</h3>
                                        <ol>
                                            <li><strong>Single-line Text:</strong> Single line of text. <br>Use for Name (Person / Company / Product / ...), Designation etc.</li>
                                            <li><strong>Multi-line Text:</strong> Multiple lines of text. <br>Use for Address, Description, Comments etc.</li>
                                            <li><strong>Dropdown List:</strong> List of options, of which choose one. <br> Use for Country, Category etc.</li>
											<li><strong>Multi-select Dropdown with Checkbox:</strong> List of options, of which choose one or more using checkbox. Use for Skill set, Hobbies etc.</li>
                                            <li><strong>Checkbox:</strong> Single option that can be either On / Off. <br>Use for \'I agree with ...\', GDPR related text acceptance etc.</li>
                                            <li><strong>Radio Button:</strong> 2+ options, only 1 can be selected. <br>Use for Food (Vegetarian / Non-vegetarian), Size (S / M / L / XL) etc.</li>
											<li><strong>Note:</strong> Informative read-only text message. Use it for description, explanation, privacy etc.</li>
											<li><strong>Date:</strong> Specify a date with the date-picker interface. Use it to specify any date (date of birth, event date etc.).</li>
											<li><strong>CAPTCHA:</strong> The custom CAPTCHA tries to confirm that a real person is filling the form to deter robot systems from making automated junk submissions through the form.</li>
											<li><strong>reCAPTCHA:</strong> Google reCAPTCHA is an industry standard for confirming that a real person is filling the form, which deters robot systems from making automated junk submissions.</li>
                                        </ol>
                                    </div>
                                    
                                    <div class="popup_help_block">
                                		<h3>Character Limit</h3>
                                    	<ol>
                                            <li>Enter the number (upper limit) of maximum characters allowed for this field, so that the user cannot type in more than that. That limit value will be indicated in the default placeholder prompt for the concerned field.</li>	
										</ol>
                                    </div>
									
									<div class="popup_help_block">
                                		<h3>Options</h3>
                                    	<p>Enter the possible option names separated by pipe (|). Example: Carb | Fat | Protein.</p>
                                    </div>
									
									<div class="popup_help_block">
                                		<h3>Note Text</h3>
                                    	<p>Enter any additional message(s) you want to show in the form.</p>
                                    </div>
									
									<div class="popup_help_block">
                                		<h3>Date Format and Upper Limit (year) </h3>
                                    	<ol>
                                            <li>Date Format: Select the date format you want to see and use in the date-picker control.</li>	
											<li>Upper Limit (year): Select a year from the list to set an upper limit for the date-picker\'s range.</li>	
										</ol>
                                    </div>
                                    
									<div class="popup_help_block">
                                		<h3>CAPTCHA Label and CAPTCHA Length </h3>
                                    	<ol>
                                            <li>CAPTCHA Label: Optional. Set this to show a label for the CAPTCHA in the frontend. </li>	
											<li>CAPTCHA Length: Choose the number of characters (6 or 8) .for the CAPTCHA. </li>	
										</ol>
                                    </div>
									
                                    <div class="popup_help_block">
                                        <h3>Check Boxes</h3>
                                        <ol>
                                            <li><strong>Mandatory:</strong> If checked then the field is considered to be mandatory.</li>
                                            <li><strong>Email Validation:</strong> If checked then the field is used for entering email address only.</li>
                                            <li><strong>Numeric Only:</strong> If checked then only numeric digits can be entered in the field.</li>
                                        </ol>
                                    </div>' );
									
define( 'WIMPLECF_HELPMSG_FIELD_MESSAGES', '<div class="popup_help_block">
												<h3>Prompt</h3>
												<p>Message to guide user in the frontend to enter required data for single line and multi-line text area.</p>
											</div>
											<div class="popup_help_block">
												<h3>Help Text</h3>
												<p>Message to guide user in the frontend to enter correct data for any type of field.</p>
											</div>
											<div class="popup_help_block">
												<h3>Error</h3>
												<p>Message to guide user in the frontend, if s/he leaves a mandatory field empty and/or enters an invalid email id (format).</p>
											</div>' );
									
define( 'WIMPLECF_HELPMSG_FIELD_ORIENTATION', '<div class="popup_help_block">
													<h3>Select Field Width</h3>
													<p>Select the required field width from available options to place it in a specific row.</p>
												</div>
												<div class="popup_help_block">
													<h3>Place Field: Select Row</h3>
													<p>Place the field at / before / after the selected row or at a new row.</p>
												</div>
												<div class="popup_help_block">
													<h3>Place Field: Within Row</h3>
													<p>Place the field before / after the selected column of a specific row. </p>
												</div>' );

?>
