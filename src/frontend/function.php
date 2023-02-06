<?php
$text = __("Not define", 'instant-appointment');
function IATEN_getEventAdress($idPost)
{
    $val = get_post_meta($idPost, 'event_adress', true);
    if (empty($val)) {
        return $text;
    }else{
        return $val;
    }
}

function IATEN_getEventEndingDay($idPost)
{
    $val = get_post_meta($idPost, 'event_ending_day', true);
    if (empty($val)) {
        return $text;
    }else{
        return $val;
    }
}