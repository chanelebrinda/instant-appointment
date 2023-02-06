<?php


if(! function_exists('IATEN_reservation_script_enqueue')){   
    add_action('wp_enqueue_scripts', 'IATEN_reservation_script_enqueue', 100);

    function IATEN_reservation_script_enqueue(){
        wp_register_script(
            'WReservation_javascript_enqueue_handle0',
            IATEN_DIR_URL.'assets/frontend/js/script.js',
            ['jquery'],
            time()
         );

        wp_localize_script( 
            'WReservation_javascript_enqueue_handle0', 
            'WRservation_admin_client', 
            [
                'ajax_url'          =>  admin_url( 'admin-ajax.php' ),
                'data_var_1'        =>  "Hello, it's walk"
            ]
        );

        wp_enqueue_script('WReservation_javascript_enqueue_handle0');
    }
}

function IATEN_reservation_admin_scripts(){
    wp_register_script(
        'WReservation_javascript_admin',
        IATEN_DIR_URL.'assets/backend/js/scripts.js',
        ['jquery'],
        time()
    );
    wp_localize_script( 
        'WReservation_javascript_admin', 
        'WRservation_admin', 
        [
            'ajax_url'          =>  admin_url( 'admin-ajax.php' ),
            'data_var_1'        =>  "Hello, it's walk"
        ]
    );

    wp_enqueue_script('WReservation_javascript_admin');
}

add_action('admin_enqueue_scripts', 'IATEN_reservation_admin_scripts', 100);


/**
 * IATEN_reservation_javascript_enqueue
 * 
 * Allows to reference the javascript files used in the front-end
 * @return void
 */

if(! function_exists('IATEN_reservation_javascript_enqueue')){   
    add_action('wp_enqueue_scripts', 'IATEN_reservation_javascript_enqueue', 1000);

    function IATEN_reservation_javascript_enqueue(){
        wp_register_script(
            'WReservation_javascript_enqueue_handle',
            IATEN_DIR_URL.'assets/frontend/js/calandar.js',
            ['jquery'],
            time()
         );

        wp_localize_script( 
            'WReservation_javascript_enqueue_handle', 
            'WRservation_admin_client', 
            [
                'ajax_url'          =>  admin_url( 'admin-ajax.php' ),
                'data_var_1'        =>  "Hello, it's walk"
            ]
        );

        wp_enqueue_script('WReservation_javascript_enqueue_handle');
    }
}
  
/**
 * IATEN_enqueue_datepicker
 *
 * Allows you to reference jQuery files to be able to create the date selection calendar on the client area
 * @return void
 */

if(! function_exists('IATEN_enqueue_datepicker')){
    add_action( 'wp_enqueue_scripts', 'IATEN_enqueue_datepicker' );

    function IATEN_enqueue_datepicker() {
        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_register_style( 'jquery-ui', IATEN_DIR_URL.'assets/frontend/css/calandar.css',  );
        wp_enqueue_style( 'jquery-ui' );  
    }
}


function IATEN_font_awesome() {
    wp_register_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' );
    wp_enqueue_style( 'font-awesome' );
}
add_action( 'wp_enqueue_scripts', 'IATEN_font_awesome' ); 

/**
 * IATEN_reservation_frontend_events_css
 *
 * Allows you to reference the CSS files used to format the front-end
 * @return void
 */

if(! function_exists('IATEN_reservation_frontend_events_css')){
    add_action('wp_enqueue_scripts', 'IATEN_reservation_frontend_events_css', 100);
    
    function IATEN_reservation_frontend_events_css(){
        wp_enqueue_style(
            'WReservation_frontend_event_css_file',
            IATEN_DIR_URL.'assets/frontend/css/events.css', 
            [],
            time(),
            'all'
        );
    }
}

add_action( 'wp_enqueue_scripts', 'IATEN_enqueue_style_event_assets', 10 );
function IATEN_enqueue_style_event_assets(){
    if( is_singular( 'event' ) ){
        wp_enqueue_style( 'style-event', IATEN_DIR_URL.'assets/frontend/css/single-event.css' );
    }
}