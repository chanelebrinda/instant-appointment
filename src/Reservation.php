<?php

add_action('admin_menu',  'IATEN_settings_pages');  
 function IATEN_settings_pages(){

    add_submenu_page(
        "edit.php?post_type=event",
        __('All Reservations','instant-appointment'),
        __('All Reservations', 'instant-appointment'),
        'manage_options',
        'all_reservations', 
        'IATEN_settings_pages_markup'
    );

}

add_action('wp_ajax_holidays_create', 'IATEN_reservation_create_holidays');
if(!function_exists('IATEN_reservation_create_holidays')){
    function IATEN_reservation_create_holidays()
    {   
        $succes ='0';
        $date = sanitize_text_field($_POST["date"]);
        if(IATEN_reservation_plugin_add_holidays($date))
            $succes ='1';
        wp_die($succes);
    }
}


add_action('wp_ajax_holidays_delete', 'IATEN_reservation_delete_holidays');
if(!function_exists('IATEN_reservation_delete_holidays')){
    function IATEN_reservation_delete_holidays()
    {
        $succes ='0';
        $date = sanitize_text_field($_POST["date"]); 
        IATEN_reservation_plugin_delete_holidays($date);  
        $succes ='1';
        
        wp_die($date);   
    }
}

add_action('wp_ajax_reservation_update', 'IATEN_reservation_reservation_update_callback');

if(! function_exists('IATEN_reservation_reservation_update_callback')){
    
    function IATEN_reservation_reservation_update_callback(){
        $succes = "false"; 
        if (isset($_POST["client_id"])){
            $id =  stripslashes_deep(sanitize_text_field($_POST["client_id"]));
            $name = stripslashes_deep(sanitize_text_field($_POST["client_name"]));
            $email = stripslashes_deep(sanitize_email($_POST["client_email"]));
            $date = stripslashes_deep(sanitize_text_field($_POST["begining_date"]));
            $hour = stripslashes_deep(sanitize_text_field($_POST["begining_hour"]));
            $participant = stripslashes_deep(sanitize_text_field($_POST["participant_nb"]));
            $reservation = IATEN_reservation_plugin_db_update($id, $date, $hour, $participant);
            if($reservation){
                $options = get_option( 'wreservation_event_options' );
                if (isset($options['edit_mail_content'])){
                    $mail_message = $options['edit_mail_content'];
                    $mail_subjet = $options['edit_mail_title'];
                    $message = IATEN_fetch_message($name, $date, $hour, $mail_message);
                    if( wp_mail($email, $mail_subjet, $message)){
                        $succes = "true";
                    }
                }
            }  
        }
        wp_die($succes);
    }
}

 function IATEN_settings_pages_markup(){
    
    if (!current_user_can('manage_options')) {
        return; // Ne pas executer se script si l'utilisateur courant n'est pas abilité.
    }

    ?>
        <div class="wrap">
            <h1><?php echo esc_html_e(get_admin_page_title());?></h1>
            <p><?php echo esc_html_e("List of all reservations", 'instant-appointment');?></p>
            <div id='calendar'></div>
            <table class="widefat">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Date Time</th>
                        <th>Participant</th>
                        <td></td>
                        <td></td>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Event</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Date Time</th>
                        <th>Participant</th>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
                <tbody>
                <?php
                     $current_events = IATEN_reservation_plugin_db_get_reservation();
                     foreach($current_events as $event){
                       
                        $title =  get_post($event->post_event_slug)->post_title;
                        $id = $event->client_id;
                        $name = $event->client_name;
                        $email = $event->client_email;
                        $date = $event->begining_date;
                        $hour = $event->begining_hour;
                        $participant_nb = $event->participant_nb;
              

                        ?>   
                        <tr>
                            <td><?php echo esc_html($title) ?></td>
                            <td><?php echo esc_html( $name) ?></td>
                            <td><?php echo esc_html($email)  ?></td>
                            <td> <input type="date" value="<?php echo esc_attr( $date) ?>" id = "<?php echo esc_attr( $id) ?>date" onchange="save_change('<?php echo esc_js( $id) ?>')" ><?php echo esc_html(" at ")?> <input type="time" value="<?php echo esc_attr( $hour) ?>" id = "<?php echo esc_attr( $id) ?>hour"  onchange="save_change('<?php echo esc_js( $id )?>')"></td>
                            <td> <input type="number" value="<?php echo esc_attr( $participant_nb) ?>" min="1" id = "<?php echo esc_attr( $id) ?>participant" onchange="save_change('<?php echo esc_js( $id )?>')" ></td>
                            <td><a href="edit.php?post_type=event&page=all_reservations&delete=<?php echo esc_attr($id)?>" class="button-secondary">Delete</a></td>
                            <td><a href="#" class="button-primary" id="<?php echo esc_attr( $id )?>" onclick="update_reservation('<?php echo esc_js( $id) ?>','<?php echo esc_js( $id) ?>date','<?php echo esc_js( $id) ?>hour' ,'<?php echo esc_js( $id) ?>participant', '<?php echo esc_js( $name) ?>', '<?php echo esc_js( $email) ?>')">Change</a></td>
                        </tr> 
                    <?php 
                     }

                ?>
                    
                </tbody>
            </table>
            <div class="tablenav">
                <div class="tablenav-pages">
                    <span class="displaying-num">Displaying 1-20 of 69</span>
                    <span class="page-numbers current">1</span>
                    <a href="#" class="page-numbers">2</a>
                    <a href="#" class="page-numbers">3</a>
                    <a href="#" class="page-numbers">4</a>
                    <a href="#" class="next page-numbers">&raquo;</a>
                </div>
            </div>
        </div>

        
    <?php
}
