=== WIMPLE Contact Form ===
Contributors: SARANGSoft
Plugin URI: https://wordpress.org/plugins/wimple-contact-form
Author: SARANGSoft
Tags: Contact Form, Web Form, AWS SES, Twilio SendGrid, Ajax, reCAPTCHA, CAPTCHA, email from, email to, form, contact, feedback
Requires at least: 5.8
Tested up to: 6.4
Stable tag: trunk
License: GPLv2 or later

A flexible Web Form plug-in for WordPress to create Contact or any kind of forms for web sites and apps.


== DESCRIPTION ==

A flexible and super-easy Web Form plug-in for WordPress to create Contact form - or any kind of form - for web sites / apps and send the form data via email using AWS SES, Twillio SendGrid, or your own SMTP server / service.

Create web forms for -
1. Contact Us
2. Feedback
3. Technical / Product Support Query
4. Customer Complaint
5. General Inquiry
or whatever form you can think of.

* Simple UI to interactively design forms -- no code to define any field or its behavior.

* Select data types for fields from the most commonly used pre-defined set.

* Supported data types: Single-line Text, Multi-line Text, Dropdown List, Multi-select Dropdown with Checkbox, Radio Buttons, Checkbox, Date, Note, CAPTCHA, reCAPTCHA.

* Set custom help/hint and validation error messages to show for each field.

* Specify prompt for each single-line and multi-line text field.

* Place fields anywhere within the form as needed.

* Set or edit the size (width) and position of fields within a row or across rows.

* Add one or more field(s) in one row.

* Edit all the details -- type, messages, size, location -- for any field at any time.

* Delete a field or an entire row of field(s), and create a new one, if needed.

* Customize the auto-generated default HTML and CSS as per your choice (e.g., to match the web site / page).

* Receive auto-generated email with form data via your own SMTP server / service or AWS SES or Twilio SendGrid -- set up step-by-step using interactive UI, no coding needed.

* Completely clean code, with no script embedded.



== FEATURES ==

1. Create and manage any number of forms using the plug-in.

2. Use the same form or different forms for different web pages.

3. Use custom email id[s] (not necessarily admin email only) as From (sender) and To (recipient) address for the form.

4. Interactively create form from WP administrator backend -- add, remove, edit field values / options, place anywhere within form.

5. Use Google reCAPTCHA (or normal CAPTCHA) to resist automated spam submissions.

6. View the form in the right pane when it is being created; modify as needed and see that too.

7. Use any one of five ready-made themes to display form in the frontend, or customize the selected theme as needed.

8. Use default theme, so that the form uses site's theme for which it has been created.

9. Send form data via auto-generated email using your SMTP server / service (easy), or AWS SES (API Signature v4) or Twillio SendGrid for better deliverability. 



== INSTALLATION ==

1. Download and save 'wimple-contact-form' on your local drive. 

2. Extract 'wimple-contact-form'.

3. Upload the entire 'wimple-contact-form' folder into the '/wp-content/plugins/' directory.

4. Log into your WordPress Admin Panel. Click on Plugin in the left-pane menu list; you will find 'Wimple Contact Form'  menu in the right-panel.

5. Click on the 'Activate' button to install the plug-in.



== SCREENSHOTS ==

1. Site admin creates a form, sets basic properties, and chooses the preferred mail settings.
2. Blank form layout (in the right pane) before starting to define its field(s).
3. Add the first field (type 'Radio Button') and set its properties in the left pane. 
4. Upon adding the field, see immediate update in form layout in the right pane.
5. Add the second field 'Name' (type 'Single-line Text') and set its properties.
6. 'Name' field is made mandatory and placed on the second row.
7. Add the third field 'Phone Number' (type 'Single-line Text') with the 'Numeric Only' option.
8. 'Phone number' is added on the third row with 33% width.
9. Add the field 'Profession' (type 'Dropdown List') with its properties, including the permitted options separated by '|'.
10. 'Profession' with 33% width is placed to the right of 'Phone Number' on the third row.
11. Add 'Email' field (type 'Single-line Text') with its properties, including the 'Email Validation' option (will accept only valid email format input).
12. The 'Email' field is placed on the fourth row.
13. Add the 'Question' field (type 'Multi-line Text') with maximum 500 characters and place it on a new row.
14. After adding 'Question', the latest form layout is shown in the right pane.
15. Add a 'Checkbox' type field in a new (sixth) row.
16. In the right pane, the checkbox field appears at the bottom of the form.
17. Add 'Date of birth'(type 'Date') field, placed in between 'Phone number' and 'Profession' on the third row.
18. 'Date of birth' field is seen in between 'Phone number' and 'Profession' fields with a calendar date picker.
19. Adding 'reCAPTCHA' type field on a new row.
20. The 'reCAPTCHA' field appears below the 'Checkbox' type field.
21. Add a 'Note' type field (with rich text editor) to display any important information / notification.
22. A formatted text (read-only) is now placed on the last row of the form.
23. Use 'Edit' mode (hover mouse over field in right pane and click 'Edit' ) to change 'Name' field width from 100% to 50%.
24. The 'Name' field now takes half of its original width.
25. Edit the 'Email' field to put it to the right of 'Name' with 50% width.
26. The 'Email' field is now placed after 'Name' on the same (second) row.
27. In the right pane, hovering mouse over a row of field(s) shows 'Edit' and 'Delete' icons; an entire row can be deleted via the 'Delete' icon.
28. View the newly-created form (depending on existing page layout) as it will appear to the frontend user.



== HOW TO DISPLAY THE FORM TO THE USER (frontend) ==

* Copy the 'Shortcode' for the form from plug-in's admin backend.

* Use WordPress function 'do_shortcode()' with the above Shortcode in the PHP file for the required web page.

NOTE: You can use the same 'Shortcode' in multiple web pages.



== PRIVACY POLICY ==

As per the arrangement of the WIMPLE Web Form Plug-in, the site Admin needs to specify the following data.

1. Email settings for sending the auto-generated email with the form data from specified sender email id to recipient email id. There are three supported options, for each of which the Admin needs to provide the following information.
   * AWS-SES: Admin needs to provide:
     * AWS Endpoint
     * AWS account 'Access Key'
     * AWS account 'Secret Access Key'
   * SMTP server other than AWS-SES: Admin needs to provide:
     * SMTP Server Address
     * SMTP Server Port
     * Username
     * Password
   * SendGrid API: Admin needs to provide:
     * SendGrid API Key

2. Google reCAPTCHA setup to deter robot systems trying to make automated submissions. The Admin needs to provide the following information.
   * Google Site Key
   * Google Secret Key

NOTE: These are put in the code (wp-config.php) and stored on the server, where the plug-in is installed. These are used only to capture data from valid submissions and send emails with the captured form data. SARANGSoft does *NOT* get / have any access to these information.

The auto-generated emails with the form data from WIMPLE Web Form Plug-in via AWS SES (Simple Email Service) are sent using Signature version 4 for better security and deliverability.



== FREQUENTLY ASKED QUESTIONS (FAQ) ==

1. How to Display the form to the user (in frontend)?
a) Copy the 'Shortcode' for the form from plug-in's admin backend.
b) Use WordPress function 'do_shortcode()' with the above Shortcode in the PHP file for the required web page.

2. Can we use the same form in more than one page in user end (frontend)? 
Yes, you can use the same form ('Shortcode') in multiple web pages.

3. What theme is used by the plug-in?
There are five (5) built-in themes (color-oriented) with this plug-in. Select any one of those as per your needs, and then customize the CSS for selected theme as you see fit to suit your web site / page.



== Changelog ==
= 2.4 =
* Released in February 2024. *

* Support for 'Multi-select Dropdown with Checkbox' field type.

* Compatible with WP 5.8 to 6.4.

= 2.3 =
* Released in August 2023. *

* Compatible with WP 5.8 to 6.3.

= 2.3 =
* Released in May 2023. *

* Support for 'Twilio SendGrid' to send the auto-generated email with form data.

* Some user experience improvements.

* Compatible with WP 5.8 to 6.2.

= 2.2 =
* Released in December 2022. *

* Support for 'Google reCAPTCHA' - as well as normal CAPTCHA - field in the form.

* Some user experience improvements.

* Compatible with WP 5.7 to 6.1.1.

= 2.1 =
* Released in September 2022. *

* Support for 'Date' (many date formats) and 'Note' (with rich text) type fields.

* Support for positioning CAPTCHA anywhere within the form.

* Many user experience improvements.

* Compatible with WP 5.2 to 6.0.

= 2.0 =
* Released in February 2022. *

* Support for dynamic form creation using interactive UI. Each field can be placed anywhere within the form as needed. Makes form creation super easy and flexible without writing a single line of code.

* Compatible with WP 5.0 to 5.9.

= 1.2 =
* Released in January 2021. *

* Compatible with WP 5.6 maintaining backward compatibility.

= 1.1.0 =
* Released in September 2020. *

* Support for Amazon AWS SES API requests signed using Signature version 4 for sending auto-generated e-mails from the form. 
NOTE: AWS-SES API Sig-v3 expires on Sep 30, 2020, and Sig-v4 is the only option for SES API from Oct 1, 2020.

= 1.0.0 =
* Released in September 2020. *

