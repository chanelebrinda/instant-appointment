<?php
/**
 * IATEN_reservation_plugin_db_desinstall
 * 
 * desinstall all database table to storage all information about event and reservation
 * @global $wpbd : WordPress database access abstraction class.
 * @return void
 */

if(! function_exists('IATEN_reservation_plugin_db_desinstall')){    
    function IATEN_reservation_plugin_db_desinstall(){
        global $wpdb ;
        $table_reservation = IATEN_RESERVATION_TABLE;
        $sql = "DROP TABLE IF EXISTS $table_reservation CASCADE;";
        $wpdb->query($sql);
    }
}