<?php

global $wpdb;
global $WReservation_db_version;
$WReservation_db_version = '1.0';

$options = get_option( 'wreservation_event_options' ); 

$apis = false;
if( isset( $options["apis" ] ) ) {
    $apis = true;
}

$symbole = '$';
if( isset( $options['symbole']) ) {
    $symbole = esc_html( $options['symbole']);
}

$name = 'Dollar';
if( isset( $options['name']) ) {
    $name = esc_html( $options['name']);
}

$gutenberg = false; 
if( isset( $options["gutenberg" ] ) ) {
    $gutenberg = true;
}

define("IATEN_CHARSET", $wpdb->get_charset_collate());

define("IATEN_RESERVATION_TABLE", $wpdb->prefix.'WReservation');
define("IATEN_HOLIDAYS", $wpdb->prefix.'WHolidays');

define("IATEN_CURRENCY_NAME", $name);
define("IATEN_CURRENCY_SYMBOL", $symbole);
define("IATEN_ALLOW_GUTENBERG", $gutenberg);
define("IATEN_ALLOW_APIS", $apis);
