<?php

/**
 * IATEN_reservation_load_event_template
 *
 * allows to redirect the display of an event to a page configured in 'single_template'.
 * @param  mixed $template
 * @return void
 */
if(! function_exists('IATEN_reservation_load_event_template')){  
    add_filter('single_template', 'IATEN_reservation_load_event_template');

    function IATEN_reservation_load_event_template($template){
        global $post;
        if('event' === $post->post_type){
            return IATEN_DIR_PATH.'views/frontend/single-event.php';
        }
        return $template;
    }
}
