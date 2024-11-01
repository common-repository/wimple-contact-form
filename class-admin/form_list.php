<?php
#######################################################################################
# Plugin Name: WIMPLE Contact Form                                                	  #
# Author: SARANGSoft (Email: wp-contact@sarangsoft.com, Web: https://sarangsoft.com)  #
# File Name: form_list.php															  #
# Purpose: Display all forms and perform form delete function.                        #
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

<div class="wimplecf_wrap">

<?php
global $wpdb;

$wimplecf_status_value = '0';

wp_enqueue_style( 'my_css_dsslider', 
                   esc_url( 
				       plugins_url( 'class-admin/css/form_list.css', 
									 WIMPLECF_PLUGIN ) ) );

include( plugin_dir_path( WIMPLECF_PLUGIN ) . 'class-admin/include/form_display.php');

require_once WIMPLECF_PLUGIN_LANGUAGE_DIR . '/string_setting.php';

$wimplecf_newcontact_url  = 'admin.php?page=newcontactform';
$wimplecf_listcontact_url = 'admin.php?page=wimplecontactform';
$wimplecf_demo_url        = 'admin.php?page=formpreview';
?>

<div class="wimplecf_header">
    <div class="wimplecf_new_form">
        <h2>
            <?php echo esc_html__( WIMPLECF_PAGE_HEADING_FORM_LIST, 'wimple-contact-form' ); ?> 
            <a class="wimplecf_add-new-h2" 
			   href="<?php echo esc_url( $wimplecf_newcontact_url ); ?>">
                <?php echo esc_html__( WIMPLECF_BUTTON_ADDNEW, 'wimple-form-contact' ); ?>
            </a>
        </h2>
    </div>
    <div class="wimplecf_logo">
        <?php echo '<img src="'.esc_url( plugins_url( 'class-admin/images/plugin_logo.png', WIMPLECF_PLUGIN ) ). '">';?>
    </div>
</div>

<!-- form grid start -->
<table class="wimplecf_wp-list-table widefat fixed pages">
    <thead>
            <tr class="wimplecf_top_headings">
            <th class="wimplecf_width1">
				<?php echo esc_html__( WIMPLECF_LABEL_FORMNAME_FORM_LIST, 'wimple-contact-form' );?>
			</th>
            <th class="wimplecf_width2">
				<?php echo esc_html__( WIMPLECF_LABEL_SHORTCODE_FORM_LIST, 'wimple-contact-form' );?>
			</th>
            <th class="wimplecf_width3">
				<?php echo esc_html__( WIMPLECF_LABEL_CONTACT_EMAIL_FORM_LIST, 'wimple-contact-form' );?>
			</th>
            <th class="wimplecf_width4">
				<?php echo esc_html__( WIMPLECF_LABEL_STATUS_FORM_LIST, 'wimple-contact-form' );?>
			</th>
            <th class="wimplecf_width5">
				<?php echo esc_html__( WIMPLECF_LABEL_ACTION_FORM_LIST, 'wimple-contact-form' );?>
			</th>
        </tr>
    </thead>
    <tfoot>
	<?php 
    if ( count( $wimplecf_form_list ) > 0 ) 
    {
        for ( $i = 0; $i < count( $wimplecf_form_list ); $i++ ) 
        {
            $wimplecf_form_ids 		 = $wimplecf_form_list[$i]->id; 
            $wimplecf_form_name 	 = $wimplecf_form_list[$i]->name; 
            $wimplecf_form_status 	 = $wimplecf_form_list[$i]->status;
            $wimplecf_form_shortcode = $wimplecf_form_list[$i]->shortcode;
            $wimplecf_form_mail_to 	 = $wimplecf_form_list[$i]->mail_to;
    ?>
        <tr>
            <th class = "wimplecf_width1" title = "<?php echo esc_attr( $wimplecf_form_name );?>">
				<?php echo esc_html( $wimplecf_form_name ); ?>
			</th>
            <th class = "wimplecf_width2">
				<?php echo esc_html( $wimplecf_form_shortcode ); ?>
			</th>
            <th class = "wimplecf_width3">
				<?php echo esc_html( $wimplecf_form_mail_to ); ?>
			</th>
            <th class ="wimplecf_width4" title = "" >
                <?php 
				if ( $wimplecf_form_status == $wimplecf_status_value )
                {
					echo esc_html__( WIMPLECF_STATUS_INACTIVE, 'wimple-contact-form' );
                }
				else 
				{
					echo esc_html__( WIMPLECF_STATUS_ACTIVE, 'wimple-contact-form' );
				}                          
                ?>
            </th>
            <th class = "wimplecf_width5">
                <a style = "margin-right: 3px;" 
				   href = "<?php echo esc_url( $wimplecf_newcontact_url.'&edit_id='.$wimplecf_form_ids.'&status=edit' );?>">
					<?php echo esc_html__( WIMPLECF_BUTTON_EDIT, 'wimple-contact-form' );?>
                </a> |
                <a onclick = "return confirm( 'Do you want to delete this form?' )" title = "Delete" 
                   href = "<?php echo esc_url( $wimplecf_listcontact_url.'&form_id='.$wimplecf_form_ids.'&status=form_delete' ); ?>">
					<?php echo esc_html__( WIMPLECF_BUTTON_DELETE, 'wimple-contact-form' );?>
                </a>
            </th>
        </tr>
    <?php
        }
    }
	else 
    {
	?>
        <tr>
            <th width = "100%" style = "float: left;">
				<?php echo esc_html__( WIMPLECF_MSG_NO_FORM_FORM_LIST, 'wimple-contact-form' );?>
			</th>
        </tr>
    <?php
	}
	?>
	</tfoot>    
</table>
</div>
