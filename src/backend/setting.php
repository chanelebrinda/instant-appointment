<?php
// Creation of the setting sebmenu

/**
 * IATEN_reservation_add_settings_menu
 *
 * allows to include the Event Settings page in the options pages
 * @return void
 */
if(! function_exists('IATEN_reservation_add_settings_menu')){
    add_action( 'admin_menu', 'IATEN_reservation_add_settings_menu' );
    function IATEN_reservation_add_settings_menu() {
        add_options_page( 
            'WReservation Settings', 
            'Event Settings', 
            'manage_options',
            'WReservation_Setting', 
            'IATEN_reservation_add_settings_option_page' 
        );

        add_submenu_page(
            "edit.php?post_type=event",
            __('Event Settings', IATEN_MENU_SLUG),
            __('Event Settings', IATEN_MENU_SLUG),
            'manage_options',
            'WReservation_Setting2', 
            'IATEN_reservation_add_settings_option_page'
        );
    } 
}

/**
 * IATEN_reservation_add_settings_option_page
 * 
 * Add the event setting submenu in the general settings
 * @return void
 */

if(! function_exists('IATEN_reservation_add_settings_option_page')){    
    function IATEN_reservation_add_settings_option_page() {
    ?>
        <div class="wrap">
            <h2>Events General Settings</h2>
            <form action="options.php" method="post">
                <?php 
                settings_fields( 'wreservation_event_options' );
                do_settings_sections( 'event_setting' );
                submit_button( 'Save Changes', 'primary' ); 
                ?>
            </form>
        </div>
    <?php
    }
}

/**
 * IATEN_reservation_add_settings_plugin_admin_init
 * 
 * allows you to register the different sections and fields of the event settings page.
 * @return void
 */
if(! function_exists('IATEN_reservation_add_settings_plugin_admin_init')){
    add_action( 'admin_init', 'IATEN_reservation_add_settings_plugin_admin_init' );
    
    function IATEN_reservation_add_settings_plugin_admin_init(){
        $args = array(
            'type' => 'string', 
            'sanitize_callback' => 'IATEN_WReservation_add_settings_plugin_validate_options',
            'default' => NULL
        );
    
        register_setting( 'wreservation_event_options', 'wreservation_event_options', $args );
    
    // Create a setting section for Curency config
        add_settings_section( 
            'Event_Currency_Setup', 
            __('Currency Setup',  'instant-appointment'),
            'IATEN_Curency_setup_section_text', 
            'event_setting' 
        );
     
    // Create our settings field for currency name
        add_settings_field( 
            'currency_plugin_name', 
            __('Currency Name :',  'instant-appointment'),
            'IATEN_currency_plugin_name_callback', 
            'event_setting', 
            'Event_Currency_Setup' 
        );
    
    // Create our settings field for currency symbol
        add_settings_field( 
            'currency_plugin_symbole', 
            __('Currency Symbol :',  'instant-appointment'),
            'IATEN_currency_plugin_symbole_callback', 
            'event_setting', 
            'Event_Currency_Setup' 
        );
    
    // Create our settings section to allow apis and gutenberg
        add_settings_section( 
            'Event_Option_Setup', 
            __('Advanced Options', 'instant-appointment'),
            'IATEN_advanced_option_setup_section_text', 
            'event_setting' 
        );

    // Create our settings field to allow apis
        add_settings_field( 
            'apis_plugin_apis', 
            __('Allow APIs :',  'instant-appointment'),
            'IATEN_api_plugin_symbole_callback', 
            'event_setting', 
            'Event_Option_Setup' 
        );

    // Create our settings field to allow gutenberg
        add_settings_field( 
            'Gutenberg_plugin_editor', 
           __('Allow Gutenberg Editor :', 'instant-appointment'),
            'IATEN_Gutenberg_plugin_symbole_callback', 
            'event_setting', 
            'Event_Option_Setup' 
        );

        add_settings_section( 
            'Event_Success_Email_Setup', 
            __('Success Booking Email Message', 'instant-appointment'),
            'IATEN_success_email_setup_section_text', 
            'event_setting' 
        );

        add_settings_field( 
            'Success_Email_Title', 
            __('Title :', 'instant-appointment'),
            'IATEN_success_email_title_callback', 
            'event_setting', 
            'Event_Success_Email_Setup' 
        );

        add_settings_field( 
            'Success_Email_Content', 
            __('Content :', 'instant-appointment'),
            'IATEN_success_email_content_callback', 
            'event_setting', 
            'Event_Success_Email_Setup' 
        );

        add_settings_section( 
            'Event_Cancel_Email_Setup', 
            __('Cancel Booking Email Message', 'instant-appointment'),
            'cancel_email_setup_section_text', 
            'event_setting' 
        );

        add_settings_field( 
            'Cancel_Email_Title', 
            __('Title :',  'instant-appointment'),
            'IATEN_cancel_email_title_text', 
            'event_setting', 
            'Event_Cancel_Email_Setup' 
        );

        add_settings_field( 
            'Cancel_Email_Content', 
            __('Content :',  'instant-appointment'),
            'IATEN_cancel_email_content_text', 
            'event_setting', 
            'Event_Cancel_Email_Setup' 
        );

         //
        add_settings_section( 
            'Event_Edit_Email_Setup', 
            __('Edit Booking Email Message', 'instant-appointment'),
            'IATEN_Edit_email_setup_section_text', 
            'event_setting' 
        );

        add_settings_field( 
            'Edit_Email_Title', 
            __('Title :',  'instant-appointment'),
            'IATEN_Edit_email_title_text', 
            'event_setting', 
            'Event_Edit_Email_Setup' 
        );

        add_settings_field( 
            'Edit_Email_Content', 
            __('Content :', 'instant-appointment'),
            'IATEN_Edit_email_content_text', 
            'event_setting', 
            'Event_Edit_Email_Setup' 
        );  

        // Holidays setting section
        add_settings_section( 
            'Event_Edit_Holidays', 
            __('Manage Holidays', 'instant-appointment'),
            'IATEN_manage_Event_Holidays', 
            'event_setting' 
        );

        add_settings_field( 
            'Event_Diplay_Holidays', 
            __('Current holidays :', 'instant-appointment'),
            'IATEN_get_Current_Holidays', 
            'event_setting', 
            'Event_Edit_Holidays' 
        );

        add_settings_field( 
            'Event_Add_Holidays', 
            __('Add more',  'instant-appointment'),
            'IATEN_add_new_holiday', 
            'event_setting', 
            'Event_Edit_Holidays' 
        ); 
    }
}

//********************************************************************* */
// Affichage des jours fériés                                           //
//********************************************************************* */

if(! function_exists('IATEN_add_new_holiday')){    
    function IATEN_add_new_holiday() {
        _e( '<input type="date" name="" id="holiday_selected">
            <btn onclick ="add_holidays()" class = "button-secondary">');
        _e( 'Adds', 'instant-appointment');
        _e('</btn>');
    }
}

//********************************************************************* */
// Affichage des jours fériés                                           //
//********************************************************************* */

if(! function_exists('IATEN_get_Current_Holidays')){    
    function IATEN_get_Current_Holidays() {
        $query = IATEN_reservation_plugin_db_holidays();
        $iaten_content = "<ul>";
        foreach ($query as $key => $value) {
            $day = $value->holidays;
            $iaten_content .= __('
            <li>
                <input type="date" name="" value= "'.$day.'" disabled>
                <btn class = "button-secondary" onclick = "delete_holidays(\''.$day.'\')">').
                __('Delete', 'instant-appointment').
                __('</btn>
            </li>');
        }
        $iaten_content .= "</ul>";
        echo $iaten_content;
    }
}

//********************************************************************* */
// Création de la section des jours fériés                              //
//********************************************************************* */
 
if(! function_exists('IATEN_manage_Event_Holidays')){    
    function IATEN_manage_Event_Holidays() {
        echo "<p>";
        _e("Let's configure your holidays planning", 'instant-appointment');
        echo "</p>";
    }
}

//********************************************************************* */
// Definition du titre de la section des emails automatique             //
//********************************************************************* */

if(! function_exists('IATEN_Edit_email_title_text')){    
    function IATEN_Edit_email_title_text() {
        $options = get_option( 'wreservation_event_options' );
        $title = __('Appointment rescheduled', 'instant-appointment');
    
        if( isset( $options['edit_mail_title']) ) {
            $title = esc_html( $options['edit_mail_title']);
        }
        echo "<input id='wreservation_event_options_edit_mail_title' name='wreservation_event_options[edit_mail_title]'
        type='text' value='" .$title . "'/> ";
    }
}

//********************************************************************* */
//  //
//********************************************************************* */

if(! function_exists('IATEN_Edit_email_content_text')){    
    function IATEN_Edit_email_content_text() {
        $options = get_option( 'wreservation_event_options' );
        $content = 'Dear [name] we have to inform you that your reservation has been change from the [date] to [hour] !
        Sincerely, tenteeglobal.com';
    
        if( isset( $options['edit_mail_content']) ) {
            $content = esc_html( $options['edit_mail_content']);
        }
        echo "<textarea name='wreservation_event_options[edit_mail_content]' id='wreservation_event_options_edit_mail_content' cols='30' rows='10'>" . esc_attr( $content ) . "</textarea>";
    }
}

//********************************************************************* */
//          //
//********************************************************************* */


if(! function_exists('IATEN_Edit_email_setup_section_text')){    
    function IATEN_Edit_email_setup_section_text() {
        echo '<p>';
        esc_html_e('Configure the default message for booking and appointment edition alerts!','instant-appointment');
        echo '</p>';
    }
}

//********************************************************************* */
//          //
//********************************************************************* */


if(! function_exists('IATEN_cancel_email_content_text')){    
    function IATEN_cancel_email_content_text() {
        $options = get_option( 'wreservation_event_options' );
        $content = 'Dear [name] we have to inform you that your reservation from [date] to [hour] has been cancelled !
        Sincerely, tenteeglobal.com';
    
        if( isset( $options['cancel_mail_content']) ) {
            $content = esc_html( $options['cancel_mail_content']);
        }    
        echo "<textarea name='wreservation_event_options[cancel_mail_content]' id='wreservation_event_options_cancel_mail_content' cols='30' rows='10'>" . esc_attr( $content ) . "</textarea>";
    }
}

//********************************************************************* */
//          //
//********************************************************************* */

if(! function_exists('IATEN_cancel_email_title_text')){    
    function IATEN_cancel_email_title_text() {
        $options = get_option( 'wreservation_event_options' );
        $title = 'cancellation of your reservation';
    
        if( isset( $options['cancel_mail_title']) ) {
            $title = esc_html( $options['cancel_mail_title']);
        }
        echo "<input id='wreservation_event_options_cancel_mail_title' name='wreservation_event_options[cancel_mail_title]'
        type='text' value='" .  esc_attr_e( $title ) . "'/> ";
    }
}

//********************************************************************* */
//  //
//********************************************************************* */

if(! function_exists('IATEN_cancel_email_setup_section_text')){    
    function IATEN_cancel_email_setup_section_text() {
        echo '<p>';
        esc_html_e('Configure the default message for booking and appointment cancellation alerts!','instant-appointment');
        echo '<p>';
    }
}

//********************************************************************* */
// //
//********************************************************************* */

if(! function_exists('IATEN_success_email_content_callback')){    
    function IATEN_success_email_content_callback() {
        $options = get_option( 'wreservation_event_options' );
        $content = 'Dear [name] we are happy to inform you that your reservation from [date] to [hour] has been validated. We are waiting for you !
        Sincerely, tenteeglobal.com';
        if( isset( $options['success_mail_content']) ) {
            $content = esc_html( $options['success_mail_content']);
        }
        echo "<textarea name='wreservation_event_options[success_mail_content]' id='wreservation_event_options_success_mail_content' cols='30' rows='10'>" . esc_attr( $content ) . "</textarea>";
    }
}

//********************************************************************* */
//          //
//********************************************************************* */

if(! function_exists('IATEN_success_email_title_callback')){    
    function IATEN_success_email_title_callback() {
        $options = get_option( 'wreservation_event_options' );
        $title = 'Successful booking';
        if( isset( $options['success_mail_title']) ) {
            $title = esc_html( $options['success_email_title']);
        }
        echo "<input id='wreservation_event_options_success_email_title' name='wreservation_event_options[success_email_title]'
        type='text' value='" . esc_attr_e( $title ) . "'/> ";
    }
}

//********************************************************************* */
//          //
//********************************************************************* */

if(! function_exists('IATEN_success_email_setup_section_text')){    
    function IATEN_success_email_setup_section_text() {
        echo '<p>';
        esc_html_e('Configure the default message for reservation and appointment alerts!','instant-appointment');
        echo '<p>';
    }
}


/**
 * IATEN_Gutenberg_plugin_symbole_callback
 *
 * Creating a view to allow use of the gutenberg editor.
 * @return void
 */
if(! function_exists('IATEN_Gutenberg_plugin_symbole_callback')){    

    function IATEN_Gutenberg_plugin_symbole_callback() {
        $options = get_option( 'wreservation_event_options' );
        $iaten_check = 'unchecked';
        
        if( isset( $options["gutenberg" ] ) ) {
            $iaten_check = 'checked';
        }
        echo "<input type='checkbox' id='wreservation_event_options_gutenberg' name='wreservation_event_options[gutenberg]' value='checked' ".$iaten_check."/>"; 
        esc_html_e('Use the Guntenberg editor to manage your events','instant-appointment');
        echo "<span></span>";
    }  
}

/**
 * IATEN_api_plugin_symbole_callback
 * 
 * Creation of a view for the apis permissions validation field
 * @return void
 */
if(! function_exists('IATEN_api_plugin_symbole_callback')){    
    function IATEN_api_plugin_symbole_callback() {
        $options = get_option( 'wreservation_event_options' );
        $iaten_check = 'unchecked';
        
        if( isset( $options["apis" ] ) ) {
            $iaten_check = 'checked';
        }
        echo "<input type='checkbox' id='wreservation_event_options_apis' name='wreservation_event_options[apis]' value='c' ".$iaten_check."/> ";
        esc_html_e('Allow APIs to access your events.', 'instant-appointment');
        echo "<span></span>";
    }
}

/**
 * IATEN_advanced_option_setup_section_text
 * 
 * set apis and gutenberg options section message
 * @return void
 */
if(! function_exists('IATEN_advanced_option_setup_section_text')){    
    function IATEN_advanced_option_setup_section_text() {
        echo '<p>';
        esc_html_e('Configure default advanced options.','instant-appointment');
        echo '</p>';
    }
}

/**
 * IATEN_currency_plugin_symbole_callbackxa
 * 
 * Fields to configure the currency symbol.
 * @return void
 */
if(! function_exists('IATEN_currency_plugin_symbole_callback')){    
    function IATEN_currency_plugin_symbole_callback() {
        $options = get_option( 'wreservation_event_options' );
        $symbole = '$';
    
        if( isset( $options['symbole']) ) {
            $symbole = esc_html( $options['symbole']);
        }
        echo "<input id='wreservation_event_options_symbole' name='wreservation_event_options[symbole]'
        type='text' value='" . esc_attr_e( $symbole ) . "'/> ";
    }
}

/**
 * IATEN_Curency_setup_section_text
 *
 * set currency section message
 * @return void
 */
if(! function_exists('IATEN_Curency_setup_section_text')){    
    function IATEN_Curency_setup_section_text() {
        echo '<p>';
        esc_html_e('Configure default currency options.','instant-appointment');
        echo '</p>';
    }
}

/**
 * IATEN_currency_plugin_name_callback
 *
 * Fields to configure the currency name
 * @return void
 */
if(! function_exists('IATEN_currency_plugin_name_callback')){    
    function IATEN_currency_plugin_name_callback() {
        $options = get_option( 'wreservation_event_options' );
        $name = 'Dollar';
    
        if( isset( $options['name']) ) {
            $name = esc_html( $options['name']);
        }
        echo "<input id='wreservation_event_options_name' name='wreservation_event_options[name]'
        type='text' value='" . esc_attr_e( $name ) . "'/> ";
    }
}

/**
 * IATEN_WReservation_add_settings_plugin_validate_options
 * 
 * Takes fields as parameters (input), performs processing (Verification) and returns their value.
 * @param  mixed $input
 * @return mixed $input
 */
if(! function_exists('IATEN_WReservation_add_settings_plugin_validate_options')){    
    function IATEN_WReservation_add_settings_plugin_validate_options( $input ) {

        # Write some code here... 
        return $input;
    }
}