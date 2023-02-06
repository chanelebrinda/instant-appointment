<?php

global $WReservation_db_version;
$WReservation_db_version = '1.0';

/**
 * IATEN_reservation_plugin_db_install
 * 
 *Install all database table to storage all information about event and reservation
 * @global $wpbd : WordPress database access abstraction class.
 * @return void
 */

if(! function_exists('IATEN_reservation_plugin_db_install')){   
    function IATEN_reservation_plugin_db_install(){

        global $wpdb ;
        $charset_collate = $wpdb->get_charset_collate();
        $table_reservation = IATEN_RESERVATION_TABLE;
        $table_holidays = IATEN_HOLIDAYS;

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        $sql = "CREATE TABLE IF NOT EXISTS $table_reservation (
                client_id INT NOT NULL AUTO_INCREMENT,
                client_name VARCHAR(100) NOT NULL,
                client_email VARCHAR(500) DEFAULT '' NOT NULL, 
                post_event_slug VARCHAR(100) NOT NULL,
                participant_nb MEDIUMINT(9) DEFAULT 1 NOT NULL,
                begining_date VARCHAR(100) NOT NULL,
                begining_hour VARCHAR(100) NOT NULL,
                statut INT DEFAULT 0 NOT NULL, 
                PRIMARY KEY(client_id)
            )$charset_collate;
        "."CREATE TABLE IF NOT EXISTS $table_holidays (
            holidays VARCHAR(100) NOT NULL, 
            PRIMARY KEY(holidays)
        )$charset_collate;
        ";

        //statut 0: Waiting, 1 : done, 3 : cancel
        dbDelta($sql);
        // add_option('WReservation_db_version', $WReservation_db_version);
    }
}





