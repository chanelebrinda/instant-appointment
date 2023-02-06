<?php

 /**
 * IATEN_reservation_calandar_script_callback
 *
 * Fetch and process ajax data from calendar and return processed data
 * @link wp-content\plugins\instant-appointment\assets\frontend\js\calandar.js js file that sends and receives responses
 * @return void
 */

// Permet de calculer et retourner le nombre de participant sur un crénaux

add_action('wp_ajax_crenaux_participant', 'IATEN_reservation_crenaux_participant_callback');
add_action('wp_ajax_nopriv_crenaux_participant', 'IATEN_reservation_crenaux_participant_callback');

if(! function_exists('IATEN_reservation_crenaux_participant_callback')){
    
    function IATEN_reservation_crenaux_participant_callback(){
        $succes = "01";
        if (isset($_POST["event_id"])){
            $id = sanitize_text_field($_POST["event_id"]);
            $date = sanitize_text_field($_POST["selected_date"]);
            $hour = sanitize_text_field($_POST["selected_hour"]);
            $maximum_participant = get_post_meta($id, 'event_limit_participants', true);
            
            $request = IATEN_reservation_plugin_db_get_creno_participant($id, $date, $hour);
            $succes = intval($maximum_participant) - intval($request);
        }
        wp_die($succes);
    }
}

add_action('wp_ajax_crenaux_simple_participant', 'IATEN_reservation_crenaux_simple_participant_callback');
add_action('wp_ajax_nopriv_crenaux_simple_participant', 'IATEN_reservation_crenaux_simple_participant_callback');

if(! function_exists('IATEN_reservation_crenaux_simple_participant_callback')){
    
    function IATEN_reservation_crenaux_simple_participant_callback(){
        $succes = "01";
        if (isset($_POST["event_id"])){
            $id = sanitize_text_field($_POST["event_id"]);
            $maximum_participant = get_post_meta($id, 'event_limit_participants', true);
            
            $request = IATEN_reservation_plugin_db_get_participant($id);
            $succes = intval($maximum_participant) - intval($request);
        }
        wp_die($succes);
    }
}


add_action('wp_ajax_event_simple_reservation', 'IATEN_ajax_event_simple_reservation_callback');
add_action('wp_ajax_nopriv_event_simple_reservation', 'IATEN_ajax_event_simple_reservation_callback');

if(! function_exists('IATEN_ajax_event_simple_reservation_callback')){
    
    function IATEN_ajax_event_simple_reservation_callback(){
        $succes = "Mail not sent"; 
        if (isset($_POST["client_name"])){
            $name = sanitize_text_field($_POST["client_name"]);
            $email= sanitize_text_field($_POST["client_email"]);
            $id = sanitize_text_field($_POST["post_event_slug"]);
            $date = get_post_meta($id, 'event_starting_hour', true);
            $hour = get_post_meta($id, 'event_begining_day', true);
            $participant = sanitize_text_field($_POST["participant_nb"]);
            $maximum_participant = get_post_meta($id, 'event_limit_participants', true);
            
            $request = IATEN_reservation_plugin_db_get_creno_participant($id, $date, $hour);
            $val = intval($maximum_participant) - intval($request);
            if($val >= 0 ) {
                IATEN_reservation_plugin_db_insert($name, $email, $id, $date, $hour, $participant);
                $options = get_option( 'wreservation_event_options' );
                if (isset($options['success_mail_content'])){
                    $mail_message = $options['success_mail_content'];
                    $mail_subjet = $options['success_email_title'];
                    $message = IATEN_fetch_message($name, $date, $hour, $mail_message);
                    if( wp_mail($email, $mail_subjet, $message)){+
                        $succes = "E-Mail sent";
                    }
                }
            }
        }
        wp_die($succes);
    }
}


add_action('wp_ajax_event_reservation', 'IATEN_reservation_event_reservation_callback');
add_action('wp_ajax_nopriv_event_reservation', 'IATEN_reservation_event_reservation_callback');

if(! function_exists('IATEN_reservation_event_reservation_callback')){
    
    function IATEN_reservation_event_reservation_callback(){
        $succes = "Mail not sent"; 
        if (isset($_POST["client_name"])){
            $name = sanitize_text_field($_POST["client_name"]);
            $email= sanitize_text_field($_POST["client_email"]);
            $id = sanitize_text_field($_POST["post_event_slug"]);
            $date = sanitize_text_field($_POST["begining_date"]);
            $hour = sanitize_text_field($_POST["begining_hour"]);
            $participant =sanitize_text_field( $_POST["participant_nb"]);
            $maximum_participant = get_post_meta($id, 'event_limit_participants', true);
            
            $request = IATEN_reservation_plugin_db_get_creno_participant($id, $date, $hour);
            $val = intval($maximum_participant) - intval($request);
            if($val >= 0 ) {
                IATEN_reservation_plugin_db_insert($name, $email, $id, $date, $hour, $participant);
                $options = get_option( 'wreservation_event_options' );
                if (isset($options['success_mail_content'])){
                    $mail_message = $options['success_mail_content'];
                    $mail_subjet = $options['success_email_title'];
                    $message = IATEN_fetch_message($name, $date, $hour, $mail_message);
                    if( wp_mail($email, $mail_subjet, $message)){
                        $succes = "E-Mail sent";
                    }
                }
            }
        }
        wp_die($succes);
    }
}

add_action( 'plugins_loaded', 'IATEN_reservation_cancel_reservation_callback' );
if(! function_exists('IATEN_reservation_cancel_reservation_callback')){
    
    function IATEN_reservation_cancel_reservation_callback(){
        if(isset($_GET['delete'])){
            $succes = "Mail not sent"; 
            $id=sanitize_text_field($_GET['delete']);
            $events = IATEN_reservation_plugin_db_get_by_id($id);
            
            if(!empty($events)){
                foreach($events as $event){
                    $name = $event->client_name;
                    $date = $event->begining_date;
                    $hour = $event->begining_hour;
                    $email = $event->client_email;
                }
                
                $options = get_option( 'wreservation_event_options' );
                if (isset($options['cancel_mail_title'])){
                    $mail_message = $options['cancel_mail_content'];
                    $mail_subjet = $options['cancel_mail_title'];
                    $message = IATEN_fetch_message($name, $date, $hour, $mail_message);
                    if( wp_mail($email, $mail_subjet, $message)){
                        $succes = "E-Mail sent";
                    }
                }
                IATEN_reservation_plugin_db_delete($id);
            }
        }
    }
}


if(! function_exists('IATEN_reservation_calandar_script_callback')){    
    add_action('wp_ajax_event_crenaux', 'IATEN_reservation_calandar_script_callback');
    add_action('wp_ajax_nopriv_event_crenaux', 'IATEN_reservation_calandar_script_callback');

    function IATEN_reservation_calandar_script_callback(){
        $week = IATEN_WEEK_DAYS;
        if(isset($_POST['selected_date'])):
            $date = sanitize_text_field($_POST['selected_date']);
            $idDay = intval(sanitize_text_field($_POST['idDayOfWeek']));
            $day = $week[$idDay];
            $idPost = sanitize_text_field($_POST["event_id"]);
            $beginig_date = get_post_meta($idPost, 'event_begining_day', true);
            $limit_reservation_day = get_post_meta($idPost, 'limit_date_schedule', true);
            $is_open = get_post_meta($idPost, $day.'_is_open', true);
            $today = date('Y-m-d');
            $maximum_participant = get_post_meta($idPost, 'event_limit_participants', true);
            
            $holidays = array();
            $request = IATEN_reservation_plugin_db_holidays();
            foreach ($request as $key => $value) {
                array_push($holidays, $value->holidays);
            }

            $limit_reservation_date = date('Y-m-d', strtotime($today. '+'. $limit_reservation_day.' days'));

            $crenaux = array();
           
            if (in_array($date, $holidays)) : 
                array_push($crenaux, ["Error"=>__("Not available at this because of holiday",'instant-appointment')]);
            else:
                if ($beginig_date > $date) : 
                    array_push($crenaux, ["Error"=>__("Not available yet. This event started at ",'instant-appointment'). date('l jS F Y', strtotime($beginig_date))]);
                else:
                    if($date > $limit_reservation_date ):
                        array_push($crenaux, ["Error"=>__("You can only book a maximum of ",'instant-appointment').$limit_reservation_day. __("days in the future from Today",'instant-appointment')]);
                    else:
                        if($is_open == "none" || empty($is_open)):
                            array_push($crenaux, ["Error"=>__("This event is not available on", 'instant-appointment'). $day__(", please try another day.",'instant-appointment')]);
                    
                        else:

                                $start_at =DateTime::createFromFormat("H:i", get_post_meta($idPost, $day.'_start_at', true));
                                $end_at =DateTime::createFromFormat("H:i", get_post_meta($idPost, $day.'_end_at', true));
                                $pause_start_at = DateTime::createFromFormat("H:i",get_post_meta($idPost, $day.'_pause_start_at', true));
                                $pause_end_at =DateTime::createFromFormat("H:i", get_post_meta($idPost, $day.'_pause_end_at', true));
                                
                                $duration = intval(get_post_meta($idPost, 'session_duration', true));
                                $time_before = intval(get_post_meta($idPost, 'time_before_session', true));
                                $time_after = intval(get_post_meta($idPost, 'time_after_session', true));

                                // A slot is occupied if it has already been reserved by someone
                                $occuped_creno = IATEN_reservation_plugin_db_get_creno_by_date(strval($idPost), $date);
                                $start_at0 =DateTime::createFromFormat("H:i", get_post_meta($idPost, $day.'_start_at', true));
                                $count = 0;

                                //************************************************************ */
                                //                Pour retirer le dernier crenaux              // 
                                // 
                                // $pause_start_at->sub(new DateInterval('PT'.$duration.'M'));
                                // $pause_start_at->sub(new DateInterval('PT'.$time_before.'M'));
                                // $end_at->sub(new DateInterval('PT'.$duration.'M'));
                                // $end_at->sub(new DateInterval('PT'.$time_before.'M'));
                                //************************************************************ */
                                
                                // $start_at1 = $start_at;
                                // $start_at1->add(new DateInterval('PT'.$time_after.'M'));

                                while($start_at->format("H:i") < $pause_start_at->format("H:i") && $start_at->format("H:i") >= $start_at0->format("H:i")){
                                    $start_at->add(new DateInterval('PT'.$time_before.'M'));   
                                    $crenaux_start = $start_at->format("H:i") ;
                                    $start_at->add(new DateInterval('PT'.$duration.'M'));
                                    $start_at->add(new DateInterval('PT'.$time_after.'M'));  
                                    // $start_at1 = $start_at;
                                    // $start_at1->add(new DateInterval('PT'.$duration.'M'));

                                    if($start_at->format("H:i") <= $pause_start_at->format("H:i")):
                                        array_push($crenaux, $crenaux_start);
                                    endif;
                                }

                                $count = 0;

                                

                                while($pause_end_at->format("H:i") < $end_at->format("H:i") && $pause_end_at->format("H:i") >= $start_at0->format("H:i")){  
                                    $pause_end_at->add(new DateInterval('PT'.$time_before.'M'));   
                                    $crenaux_start = $pause_end_at->format("H:i") ;
                                    $pause_end_at->add(new DateInterval('PT'.$duration.'M'));
                                    $pause_end_at->add(new DateInterval('PT'.$time_after.'M'));
                                    
                                    if($pause_end_at->format("H:i") < $end_at->format("H:i")  ):
                                        array_push($crenaux, $crenaux_start);
                                    endif;
                                }

                                // On elimine les crénaux dont le nombre maximum de participant est atteint sur les reservation

                                $to_remove = array();
                                foreach($occuped_creno as $value){
                                    $selected_crenaux= date_format(date_create( $value->begining_hour), 'H:i');
                                    $count = IATEN_reservation_plugin_db_get_creno_participant($idPost, $date, $selected_crenaux);
                                    
                                    if(intval($maximum_participant) <= intval($count))
                                        array_push($to_remove, date_format(date_create( $value->begining_hour), 'H:i'));
                                }
                                $crenaux_final = array_values(array_diff($crenaux, $to_remove));
                                $crenaux = $crenaux_final;

                                $session_price = get_post_meta($idPost, 'event_price', true); 

                        endif;

                    endif;
                endif;
            endif;
        else:
            array_push($crenaux, ["Error"=>__("Some error occure, please contact some administrator.",'instant-appointment')]);

        endif;
        wp_die(json_encode($crenaux));
    }

    
}



