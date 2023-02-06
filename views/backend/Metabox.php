<?php
 
/**
 * IATEN_reservation_event_metabox_registering
 *
 * registration of the different metaboxes
 * @return void
 */

 if(! function_exists('IATEN_reservation_event_metabox_registering')){
    add_action( 'admin_init', 'IATEN_reservation_event_metabox_registering');
    
    function IATEN_reservation_event_metabox_registering(){
            
        add_meta_box(
            'short_description_id', 
            __('Short Description','instant-appointment'), 
            'IATEN_reservation_event_short_description', 
            'event',
            'normal'
        );
         add_meta_box(
             'details_id', 
             __('Event Details','instant-appointment'), 
             'IATEN_reservation_event_details_metabox', 
             'event',
             'normal'
         );

         add_meta_box(
            'opendays_id', 
            __('Event Planning', 'instant-appointment'), 
            'IATEN_reservation_weekly_hours_metabox', 
            'event',
            'normal'
        );

        // add_meta_box(
        //     'no_weekly_planning', 
        //     'Event Planning', 
        //     'WReservation_event_planning_metabox', 
        //     'event',
        //     'normal'
        // );
     }
 }

 
/**
 * IATEN_reservation_event_short_description
 *
 * Creation of short description metabox view elements
 * @global post : post being processed
 * @param $post
 * @return void
 */
 if(! function_exists('IATEN_reservation_event_short_description')){     
     function IATEN_reservation_event_short_description(){
        global $post;
        $custom = get_post_custom($post->ID);
        $description = isset($custom['event_short_description'][0])? $custom['event_short_description'][0] : "";
        ?>
            <div class="wrap">
                <textarea name="event_short_description" id="event_short_description" placeholder = "Please add some description here (maximum 150)" required cols="120" style="max-width:100%;"  cols="120" rows="2"><?php  
                    if ("" != $description) 
                        echo esc_html($description);
                 ?></textarea>
            </div>
       <?php
     }
 }

/**
 * IATEN_reservation_event_details_metabox
 * 
 * Creating Event Details Metabox View Items
 * @global post : post being processed
 * @param $post
 * @return void
 */

 if(! function_exists('IATEN_reservation_event_details_metabox')){        

    function IATEN_reservation_event_details_metabox(){
        global $post;

        $custom = get_post_custom($post->ID);
        $price = isset($custom['event_price'][0])? esc_attr($custom['event_price'][0]) : 0;
        $b_day = isset($custom['event_begining_day'][0])? esc_attr($custom['event_begining_day'][0]): "";
        $e_day = isset($custom['event_ending_day'][0])? esc_attr($custom['event_ending_day'][0]): "" ;
        $lim_p = isset($custom['event_limit_participants'][0])? esc_attr($custom['event_limit_participants'][0]): 1;
        $locat = isset($custom['event_location'][0])? esc_attr($custom['event_location'][0]) : '';
        $adres = isset($custom['event_adress'][0])? esc_attr($custom['event_adress'][0] ): '';
        $durat = isset($custom['session_duration'][0])? esc_attr($custom['session_duration'][0]) : 30;
        $lim_d = isset($custom['limit_date_schedule'][0])? esc_attr($custom['limit_date_schedule'][0]) : 7;
        $lim_be = isset($custom['time_before_session'][0])? esc_attr($custom['time_before_session'][0]) : 0;
        $lim_af = isset($custom['time_after_session'][0])? esc_attr($custom['time_after_session'][0] ): 0;
        $repeat = isset($custom['is_repeat_event'][0])? esc_attr($custom['is_repeat_event'][0]) : 'No repeat';
        ?>

        <table>
            <tr>
                <td>
                    <div class="wrap" >
                        <table class="form-table">
                            <tr>
                                <th scope="row"><label for="star_day"><?php esc_html_e("Start at * :",'instant-appointment') ?></label></th>
                                <td><input type="date"  id = "event_begining_day" name = "event_begining_day" required value = "<?php esc_html_e($b_day) ?>" ></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="end_day"><?php esc_html_e("End at : ",'instant-appointment') ?></label></th>
                                <td><input type="date" id = "event_ending_day" name = "event_ending_day" value = "<?php esc_html_e($e_day) ?>" ></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="limit_part"><?php esc_html_e("Maximum participants * :",'instant-appointment') ?></label></th>
                                <td><input type="number" id = "event_limit_participants" name = "event_limit_participants" required value = "<?php esc_html_e($lim_p) ?>" ><label for="limit_part"> par séance</label></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="limit_sched" ><?php esc_html_e("User can make reservation * : ",'instant-appointment') ?></label></th>
                                <td><input type="number" id = "limit_date_schedule"  name = "limit_date_schedule" required value = "<?php esc_html_e($lim_d) ?>" ><label for="limit_sched"> jours dans le future</label></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="price"><?php esc_html_e("Price * :",'instant-appointment') ?></label></th>
                                <td><input type="number" id = "event_price" name = "event_price" required value = "<?php esc_html_e($price) ?>" ><label for="event_price"> <?php IATEN_CURRENCY_NAME." (".IATEN_CURRENCY_SYMBOL.")" ?></label></td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td>
                    <div class="wrap">
                        <table class="form-table">
                            <tr>
                                <th scope="row"><label for=""> <?php esc_html_e("Type * :",'instant-appointment'); ?></label></th>
                                <td>
                                    <select name="event_location" id="event_location" required>
                                        <option value=""  > <?php esc_html_e("Select ...",'instant-appointment')?></option>
                                        <option value="In person"  <?php selected( esc_html($locat), "In person" );?> ><?php esc_html_e("In Person",'instant-appointment') ?></option>
                                        <option value="Phone" <?php selected( esc_html($locat), "Phone" );?> ><?php esc_html_e("In Phone",'instant-appointment') ?></option>
                                        <option value="Google Meet" <?php selected( esc_html($locat), "Google Meet" );?> ><?php esc_html_e("On Google Meet",'instant-appointment') ?></option>
                                        <option value="Zoom" <?php selected( esc_html($locat), "Zoom" );?> ><?php esc_html_e("On Zoom",'instant-appointment') ?></option>
                                        <option value="Ms Teams" <?php selected( esc_html($locat), "Ms Teams" );?> ><?php esc_html_e("On MS Teams",'instant-appointment') ?></option>
                                        <option value="Webex" <?php selected( esc_html($locat), "Webex" );?> ><?php esc_html_e("On Webex",'instant-appointment') ?></option>
                                        <option value="Goto Meeting" <?php selected( esc_html($locat), "Goto Meeting" );?> ><?php esc_html_e("On Goto Meeting",'instant-appointment') ?></option>
                                        <option value="Ask invite" <?php selected( esc_html($locat), "Ask invite" );?> ><?php esc_html_e("On Task Invite",'instant-appointment') ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="event_adress"> <?php esc_html_e("Adress * : ",'instant-appointment') ?></label></th>
                                <td><input type="text" id = "event_adress" required name = "event_adress" value = "<?php esc_html_e($adres) ?>" ><label for="event_adress"><?php esc_html_e("Place, Phone number or URL",'instant-appointment') ?></label></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="session_duration"> <?php esc_html_e("Session Duration * :",'instant-appointment') ?></label></th>
                                <td><input type="number" id = "session_duration" name = "session_duration" required value = "<?php esc_html_e($durat) ?>" <?php if($repeat != "Every week") echo esc_html("disabled")?>><label for="session_duration"> <?php esc_html_e("Minutes",'instant-appointment') ?> </label></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="time_before_session" ><?php esc_html_e("Previous * :",'instant-appointment') ?></label></th>
                                <td><input type="number" id = "time_before_session"  name = "time_before_session" required value = "<?php esc_html_e($lim_be) ?>" <?php if($repeat != "Every week") echo esc_html("disabled")?>><label for="time_before_session" > <?php esc_html_e("Minute(s) before session",'instant-appointment') ?></label></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="time_after_session" ><?php esc_html_e("Previous * :",'instant-appointment') ?></label></th>
                                <td><input type="number" id = "time_after_session"  name = "time_after_session" required value = "<?php esc_html_e($lim_af) ?>" <?php if($repeat != "Every week") echo esc_html("disabled")?> ><label for="time_after_session"> <?php esc_html_e("Minute(s) after session",'instant-appointment') ?></label></td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="wrap">
                        <table class="form-table">
                            <tr>
                                <th scope="row"><label for="is_repeat_event"><?php esc_html_e("Repetition type * :",'instant-appointment') ?> </label></th>
                                <td><input type="radio"  id = "no_repeat" name = "is_repeat_event" value = "No repeat"  <?php checked( esc_html($repeat), "No repeat" );?> onclick="change_event_planning()">  <?php esc_html_e("One day",'instant-appointment') ?> </td>
                                <td><input type="radio"  id = "weekly_repeat" name = "is_repeat_event" value = "Every week" <?php checked( esc_html($repeat), "Every week" );?> onclick="change_event_planning()"> <?php esc_html_e("Weekly",'instant-appointment') ?></td>
                                <td><input type="radio"  id = "monthly_repeat" name = "is_repeat_event" value = "Every month" <?php checked( esc_html($repeat), "Every month" );?> onclick="change_event_planning()"> <?php esc_html_e("Monthly",'instant-appointment') ?></td>
                                <td><input type="radio"  id = "anualy_repeat" name = "is_repeat_event" value = "Every year" <?php checked( esc_html($repeat), "Every year" );?> onclick="change_event_planning()"> <?php esc_html_e("anualy",'instant-appointment') ?></td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>

        <?php
    }
}

/**
 * IATEN_reservation_weekly_hours_metabox
 * 
 * Creation of view elements to select working days, opening and closing times, and break times
 * @global post : post being processed
 * @param IATEN_WEEK_DAYS the constant tab for the 7 days of the week
 * @param $post
 * @return void
 */
if(! function_exists('IATEN_reservation_weekly_hours_metabox')){
    function IATEN_reservation_weekly_hours_metabox(){
        global $post;  
        $custom = get_post_custom($post->ID);
        $start_at = isset($custom['event_starting_hour'][0])? esc_attr_e($custom['event_starting_hour'][0]) : "09:00";
        $pause_start_at = isset($custom['event_starting_pause'][0])? esc_attr_e($custom['event_starting_pause'][0]) : "12:00";
        $pause_end_at = isset($custom['event_ending_pause'][0])? esc_attr_e($custom['event_ending_pause'][0]) : "13:00";
        $end_at = isset($custom['event_ending_hour'][0])? esc_attr_e($custom['event_ending_hour'][0]) : "17:00";
     
        $custom = get_post_custom($post->ID);
        ?>

        <table id= "WR_weekly_planning" class="form-table" style = "display :<?php 
            $repeat = isset($custom['is_repeat_event'][0])?$custom['is_repeat_event'][0] : 'No repeat'; 
            if($repeat == "Every week"){
                echo esc_html("block"); 
            }else{
                echo esc_html("none");
            }
        ?>;" >

            <thead>
                <td colspan="2"><?php esc_html_e("Planning working day",'instant-appointment') ?></td>
                <th><?php esc_html_e("Pause",'instant-appointment') ?></th>
                <th><?php esc_html_e("Open days",'instant-appointment') ?></th>
            </thead>
            <?php
                foreach(IATEN_WEEK_DAYS as $day ){
                    $is_open = isset($custom[$day.'_is_open'][0])? esc_attr($custom[$day.'_is_open'][0]) : "none";
                    $start_at = isset($custom[$day.'_start_at'][0])? esc_attr($custom[$day.'_start_at'][0]) : "09:00";
                    $end_at = isset($custom[$day.'_end_at'][0])? esc_attr($custom[$day.'_end_at'][0]) : "17:00" ;
                    $pause_start_at = isset($custom[$day.'_pause_start_at'][0])? esc_attr($custom[$day.'_pause_start_at'][0]) : "12:00";
                    $pause_end_at = isset($custom[$day.'_pause_end_at'][0])? esc_attr($custom[$day.'_pause_end_at'][0]) : "13:00";
                    IATEN_loop_days_weekly_hours($day, $is_open, $start_at, $end_at, $pause_start_at , $pause_end_at);
                }
            ?>
        </table>

        <table id= "WR_no_weekly_planning" class="form-table" style = "display :<?php 
            $repeat = isset($custom['is_repeat_event'][0])? esc_attr_e($custom['is_repeat_event'][0] ): 'No repeat'; 
            if($repeat == "Every week"){
                echo esc_html("none"); 
            }else{
                echo esc_html("block");
            }
        ?>;" >
            <tr>
                <th scope="row">
                    <label for="event_starting_hour"> <?php esc_html_e("Start time ",'instant-appointment') ?></label>
                </th>
                <td><input type="time" name="event_starting_hour" id="event_starting_hour" value="<?php esc_html_e($start_at )?>" required></td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="event_starting_pause"> <?php esc_html_e("Start of the break",'instant-appointment') ?></label>
                </th>
                <td><input type="time" name="event_starting_pause" id="event_starting_pause" value="<?php esc_html_e($pause_start_at) ?>" required></td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="event_ending_pause"> <?php esc_html_e("End of the break",'instant-appointment') ?></label>
                </th>
                <td><input type="time" name="event_ending_pause" id="event_ending_pause" value="<?php esc_html_e($pause_end_at) ?>" required></td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="event_ending_hour"> <?php esc_html_e("End time",'instant-appointment') ?></label>
                </th>
                <td><input type="time" name="event_ending_hour" id="event_ending_hour" value="<?php esc_html_e($end_at) ?>" required></td>
            </tr>
        </table>
        <?php
    }
}


/**
 * IATEN_loop_days_weekly_hours
 * 
 *function that allows you to create the list of working and non-working days of the week, opening and closing times and break times for each.
 * @param  mixed $day : some day in the week.
 * @param  mixed $is_open : Value of the checkbox, it allows to know if the day is active or not.
 * @param  mixed $start_at : Opening time of the day.
 * @param  mixed $end_at : Closing time of the day.
 * @param  mixed $pause_start_at : time at which the break begins.
 * @param  mixed $pause_end_at : time at which the break ends.
 * @return void
 */
if(! function_exists('IATEN_loop_days_weekly_hours')){    
    function IATEN_loop_days_weekly_hours($day, $is_open, $start_at, $end_at, $pause_start_at, $pause_end_at ){
      ?>
        <tr>
            <th>
                <label for="<?php esc_attr_e($day)?>_is_open_label"><?php esc_attr_e($day) ?> : </label>
            </th>
            <td>
                <input type="time" name="<?php esc_attr_e($day) ?>_start_at" id="<?php  esc_attr_e($day) ?>_start_at"    value = "<?php esc_attr_e($start_at) ?>">
                <input type="time" name="<?php  esc_attr_e($day) ?>_end_at" id="<?php  esc_attr_e($day) ?>_end_at"   value = "<?php esc_attr_e($end_at) ?>" >
            </td>
            <td> 
                <input type="time" name="<?php esc_attr_e($day) ?>_pause_start_at" id="<?php esc_attr_e($day) ?>_pause_start_at"  value = "<?php esc_attr_e($pause_start_at)  ?>" >
                <input type="time" name="<?php esc_attr_e($day) ?>_pause_end_at" id="<?php esc_attr_e($day) ?>_pause_end_at"  value = "<?php esc_attr_e($pause_end_at) ?>" >
            </td>
            <td>
                <input type="checkbox" name ="<?php esc_attr_e($day) ?>_is_open" id="<?php esc_attr_e($day) ?>_is_open" value = "<?php esc_attr_e($day) ?>_is_open" <?php checked( esc_attr($is_open),  esc_attr($day) ."_is_open" ) ?> >
            </td>
        </tr>
     <?php
    }
}

/**
 * IATEN_reservation_event_featured_image
 * 
 *allows you to retrieve the featured image of an event, otherwise the first image of the content, otherwise keep an image defined by default
 * @global post : post being processed
 * @param $post
 * @return void
 */
if(! function_exists('IATEN_reservation_event_featured_image')){    
    function IATEN_reservation_event_featured_image() {
        global $DefaultImg;
        global $post;
        $first_img = '';
        if ( has_post_thumbnail()) {
            $first_img = wp_get_attachment_image_src( get_post_thumbnail_id());
        }else { 
            ob_start();
            ob_end_clean();
            $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
            $first_img = (!empty($matches [1][0]))? $matches [1][0] : $first_img;

            if(empty($first_img)){ 
                // if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
                //     $first_img = "https://";   
                // else  
                //     $first_img = "http://";   
                // $first_img.= $_SERVER['HTTP_HOST'];    
                // $first_img .= "/wp-content/plugins/instant-appointment/assets/frontend/images/default.png";
                $first_img = $DefaultImg;    
                $first_img .= "default.png";
            }
        }
        return $first_img;
    }
}
