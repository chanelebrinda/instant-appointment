<?php
add_action( 'init', 'IATEN_reservation_event_metadata_registering');

if(! function_exists('IATEN_reservation_event_metadata_registering')){
    function IATEN_reservation_event_metadata_registering(){

        register_post_meta( 'event', 'event_price', [
            'type'              =>  'string',
            'description'       =>  'Price of one session for one personne in event', 
            'single'            =>  true,
            'show_in_rest'      =>  IATEN_ALLOW_APIS,
            'sanitize_callback' => function( $value ) {
                return wp_strip_all_tags( $value );
            },
            //'auth_callback'     =>  true
        ] );

        register_post_meta( 'event', 'event_short_description', [
            'type'              =>  'string',
            'description'       =>  'short description of the event', 
            'single'            =>  true,
            'show_in_rest'      =>  IATEN_ALLOW_APIS,
            'sanitize_callback' => function( $value ) {
                return wp_strip_all_tags( $value );
            },
            //'auth_callback'     =>  true
        ] );

        register_post_meta( 'event', 'event_color', [
            'type'              =>  'string',
            'description'       =>  'Background color', 
            'single'            =>  true,
            'show_in_rest'      =>  IATEN_ALLOW_APIS,
            'sanitize_callback' => function( $value ) {
                return wp_strip_all_tags( $value );
            },
            //'auth_callback'     =>  true
        ] );


        
        register_post_meta( 'event', 'event_begining_day', [
            'type'              =>  'string',
            'description'       =>  'The number of the day in the week you want to start an event (0 to 6)', 
            'single'            =>  true,
            'show_in_rest'      =>  IATEN_ALLOW_APIS,
            'sanitize_callback' => function( $value ) {
                return wp_strip_all_tags( $value );
            },
            //'auth_callback'     =>  true
        ] );

        register_post_meta( 'event', 'event_ending_day', [
            'type'              =>  'string',
            'description'       =>  'The number of the day in the week you want to close an event (0 to 6)', 
            'single'            =>  true,
            'show_in_rest'      =>  IATEN_ALLOW_APIS,
            'sanitize_callback' => function( $value ) {
                return wp_strip_all_tags( $value );
            },
            //'auth_callback'     =>  true
        ] );

        register_post_meta( 'event', 'event_limit_participants', [
            'type'              =>  'integer',
            'description'       =>  'Number of maximum user allowed to participate in one session of the event', 
            'single'            =>  true,
            'show_in_rest'      =>  IATEN_ALLOW_APIS,
            'sanitize_callback' => function( $value ) {
                return wp_strip_all_tags( $value );
            },
            //'auth_callback'     =>  true
        ] );

        register_post_meta( 'event', 'event_location', [
            'type'              =>  'boolean',
            'description'       =>  'True if is in person an false if is an internet event', 
            'single'            =>  true,
            'show_in_rest'      =>  IATEN_ALLOW_APIS,
            'sanitize_callback' => function( $value ) {
                return wp_strip_all_tags( $value );
            },
            //'auth_callback'     =>  true
        ] );

        register_post_meta( 'event', 'event_adress', [
            'type'              =>  'string',
            'description'       =>  'Location or URL', 
            'single'            =>  true,
            'show_in_rest'      =>  IATEN_ALLOW_APIS,
            'sanitize_callback' => function( $value ) {
                return wp_strip_all_tags( $value );
            },
            //'auth_callback'     =>  true
        ] );

        register_post_meta( 'event', 'is_repeat_event', [
            'type'              =>  'string',
            'description'       =>  'is reapet Weekly, Monthly, Annualy or None ?', 
            'single'            =>  true,
            'show_in_rest'      =>  IATEN_ALLOW_APIS,
            'sanitize_callback' => function( $value ) {
                return wp_strip_all_tags( $value );
            },
            //'auth_callback'     =>  true
        ] );

        register_post_meta( 'event', 'limit_date_schedule', [
            'type'              =>  'integer',
            'description'       =>  'limit date on the future invite can schedule', 
            'single'            =>  true,
            'show_in_rest'      =>  IATEN_ALLOW_APIS,
            'sanitize_callback' => function( $value ) {
                return wp_strip_all_tags( $value );
            },
            //'auth_callback'     =>  true
        ] );

        register_post_meta( 'event', 'session_duration', [
            'type'              =>  'integer',
            'description'       =>  'duration in minute of one session of this event', 
            'single'            =>  true,
            'show_in_rest'      =>  IATEN_ALLOW_APIS,
            'sanitize_callback' => function( $value ) {
                return wp_strip_all_tags( $value );
            },
            //'auth_callback'     =>  true
        ] );

        register_post_meta( 'event', 'time_before_session', [
            'type'              =>  'integer',
            'description'       =>  'duration in minute of margin before session of this event', 
            'single'            =>  true,
            'show_in_rest'      =>  IATEN_ALLOW_APIS,
            'sanitize_callback' => function( $value ) {
                return wp_strip_all_tags( $value );
            },
            //'auth_callback'     =>  true
        ] );

        register_post_meta( 'event', 'time_after_session', [
            'type'              =>  'integer',
            'description'       =>  'duration in minute of margin after session of this event', 
            'single'            =>  true,
            'show_in_rest'      =>  IATEN_ALLOW_APIS,
            'sanitize_callback' => function( $value ) {
                return wp_strip_all_tags( $value );
            },
            //'auth_callback'     =>  true
        ] );

        foreach(IATEN_WEEK_DAYS as $day ){

            register_post_meta( 'event', $day.'_start_at', [
                'type'              =>  'string',
                'description'       =>  $day.' started work at', 
                'single'            =>  true,
                'show_in_rest'      =>  IATEN_ALLOW_APIS,
                'sanitize_callback' => function( $value ) {
                    return wp_strip_all_tags( $value );
                },
                //'auth_callback'     =>  true
            ] );

            register_post_meta( 'event', $day.'_is_open', [
                'type'              =>  'string',
                'description'       =>  $day.' started work at', 
                'single'            =>  true,
                'show_in_rest'      =>  IATEN_ALLOW_APIS,
                'sanitize_callback' => function( $value ) {
                    return wp_strip_all_tags( $value );
                },
                //'auth_callback'     =>  true
            ] );

            register_post_meta( 'event', $day.'_end_at', [
                'type'              =>  'string',
                'description'       =>  $day.' end work at', 
                'single'            =>  true,
                'show_in_rest'      =>  IATEN_ALLOW_APIS,
                'sanitize_callback' => function( $value ) {
                    return wp_strip_all_tags( $value );
                },
                //'auth_callback'     =>  true
            ] );

            register_post_meta( 'event', $day.'_pause_start_at', [
                'type'              =>  'string',
                'description'       =>  $day.' pause start at', 
                'single'            =>  true,
                'show_in_rest'      =>  IATEN_ALLOW_APIS,
                'sanitize_callback' => function( $value ) {
                    return wp_strip_all_tags( $value );
                },
                //'auth_callback'     =>  true
            ] );

            register_post_meta( 'event', $day.'_pause_end_at', [
                'type'              =>  'string',
                'description'       =>  $day.' pause end at', 
                'single'            =>  true,
                'show_in_rest'      =>  IATEN_ALLOW_APIS,
                'sanitize_callback' => function( $value ) {
                    return wp_strip_all_tags( $value );
                },
                //'auth_callback'     =>  true
            ] );
        }

        // Données du formulaire de planing des evenements à repetition non hebdomadaires

        register_post_meta( 'event', 'event_ending_hour', [
            'type'              =>  'string',
            'description'       =>  '', 
            'single'            =>  true,
            'show_in_rest'      =>  IATEN_ALLOW_APIS,
            'sanitize_callback' => function( $value ) {
                return wp_strip_all_tags( $value );
            },
            //'auth_callback'     =>  true
        ] );

        register_post_meta( 'event', 'event_ending_pause', [
            'type'              =>  'string',
            'description'       =>  '', 
            'single'            =>  true,
            'show_in_rest'      =>  IATEN_ALLOW_APIS,
            'sanitize_callback' => function( $value ) {
                return wp_strip_all_tags( $value );
            },
            //'auth_callback'     =>  true
        ] );

        register_post_meta( 'event', 'event_starting_pause', [
            'type'              =>  'string',
            'description'       =>  '', 
            'single'            =>  true,
            'show_in_rest'      =>  IATEN_ALLOW_APIS,
            'sanitize_callback' => function( $value ) {
                return wp_strip_all_tags( $value );
            },
            //'auth_callback'     =>  true
        ] );

        register_post_meta( 'event', 'event_starting_hour', [
            'type'              =>  'string',
            'description'       =>  '', 
            'single'            =>  true,
            'show_in_rest'      =>  IATEN_ALLOW_APIS,
            'sanitize_callback' => function( $value ) {
                return wp_strip_all_tags( $value );
            },
            //'auth_callback'     =>  true
        ] );
    }
}

add_action( 'save_post', 'IATEN_reservation_event_update_metadata');

if(! function_exists('IATEN_reservation_event_update_metadata')){
    function IATEN_reservation_event_update_metadata(){
        global $post;
        if(defined('DOING_AUTOSAVE')&&DOING_AUTOSAVE){
            return;
        }
        if(isset($_POST['event_short_description']))
            update_post_meta( $post->ID, 'event_short_description', sanitize_text_field($_POST['event_short_description']));
        if(isset($_POST['event_price']))
            update_post_meta( $post->ID, 'event_price', sanitize_text_field($_POST['event_price']));
        if(isset($_POST['event_begining_day']))
            update_post_meta( $post->ID, 'event_begining_day', sanitize_text_field($_POST['event_begining_day']) );
        if(isset($_POST['event_ending_day']))
            update_post_meta( $post->ID, 'event_ending_day', sanitize_text_field($_POST['event_ending_day']) );
        if(isset($_POST['event_limit_participants']))
            update_post_meta( $post->ID, 'event_limit_participants', sanitize_text_field($_POST['event_limit_participants']) );
        if(isset($_POST['limit_date_schedule']))
            update_post_meta( $post->ID, 'limit_date_schedule', sanitize_text_field($_POST['limit_date_schedule']) );
        if(isset($_POST['event_location']))
            update_post_meta( $post->ID, 'event_location', sanitize_text_field($_POST['event_location']) );
        if(isset($_POST['event_adress']))
            update_post_meta( $post->ID, 'event_adress', sanitize_text_field($_POST['event_adress']) );
        if(isset($_POST['session_duration']))
            update_post_meta( $post->ID, 'session_duration', sanitize_text_field($_POST['session_duration']) );
        if(isset($_POST['time_before_session']))
            update_post_meta( $post->ID, 'time_before_session', sanitize_text_field($_POST['time_before_session']) );
        if(isset($_POST['time_after_session']))
            update_post_meta( $post->ID, 'time_after_session', sanitize_text_field($_POST['time_after_session']) );
        if(isset($_POST['is_repeat_event']))
            update_post_meta( $post->ID, 'is_repeat_event', sanitize_text_field($_POST['is_repeat_event']) );

        foreach(IATEN_WEEK_DAYS as $day ){

            if(isset($_POST[$day.'_start_at']))
                update_post_meta( $post->ID, $day.'_start_at', sanitize_text_field($_POST[$day.'_start_at']) );
            if(isset($_POST[$day.'_is_open']))
                update_post_meta( $post->ID, $day.'_is_open', sanitize_text_field(isset($_POST[$day.'_is_open'])?$_POST[$day.'_is_open']:'none') );
            if(isset($_POST[$day.'_end_at']))
                update_post_meta( $post->ID, $day.'_end_at', sanitize_text_field($_POST[$day.'_end_at']) );
            if(isset($_POST[$day.'_pause_start_at']))
                update_post_meta( $post->ID, $day.'_pause_start_at', sanitize_text_field($_POST[$day.'_pause_start_at']) );
            if(isset($_POST[$day.'_pause_end_at']))
                update_post_meta( $post->ID, $day.'_pause_end_at', sanitize_text_field($_POST[$day.'_pause_end_at']) );
            }

        if(isset($_POST['event_starting_hour']))
            update_post_meta( $post->ID, 'event_starting_hour', sanitize_text_field($_POST['event_starting_hour']) );
        if(isset($_POST['event_starting_pause']))
            update_post_meta( $post->ID, 'event_starting_pause', sanitize_text_field($_POST['event_starting_pause']) );
        if(isset($_POST['event_ending_pause']))
            update_post_meta( $post->ID, 'event_ending_pause', sanitize_text_field($_POST['event_ending_pause']) );
        if(isset($_POST['event_ending_hour']))
            update_post_meta( $post->ID, 'event_ending_hour', sanitize_text_field($_POST['event_ending_hour']) );

        }
    }

