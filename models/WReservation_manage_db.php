<?php
 /**
 * IATEN_reservation_plugin_db_insert
 *
 * Insert data on a table 
 * @param  mixed $name
 * @param  mixed $email
 * @param  mixed $event_slug
 * @param  mixed $date
 * @param  mixed $hour
 * @param  mixed $participant
 * @param  mixed $description
 * @param  mixed $statut
 * @global $wpbd : WordPress database access abstraction class.
 * @return void
 */

if(! function_exists('IATEN_reservation_plugin_db_insert')){        
    function IATEN_reservation_plugin_db_insert($name, $email, $event_slug, $date, $hour, $participant){
        global $wpdb ;
        $table_reservation = IATEN_RESERVATION_TABLE;

        $wpdb->insert($table_reservation, 
            array(
                'client_name'               =>  $name,
                'client_email'              =>  $email,
                'post_event_slug'           =>  $event_slug,
                'begining_date'             =>  $date,
                'begining_hour'             =>  $hour, 
                'participant_nb'            =>  $participant,
            )
        );
    }
}

 /**
 * IATEN_reservation_plugin_db_update
 *
 * Update data on a table 
 * @param  mixed $name
 * @param  mixed $email
 * @param  mixed $event_slug
 * @param  mixed $date
 * @param  mixed $hour
 * @param  mixed $participant
 * @param  mixed $description
 * @param  mixed $statut
 * @global $wpbd : WordPress database access abstraction class.
 * @return void
 */
if(! function_exists('IATEN_reservation_plugin_db_update')){        
    function IATEN_reservation_plugin_db_update($id, $date, $hour, $participant){
        global $wpdb ;
        $table_reservation = IATEN_RESERVATION_TABLE;
        $data = array(
            'begining_date'             =>  $date,
            'begining_hour'             =>  $hour, 
            'participant_nb'            =>  $participant
        );
        $where = array(
            'client_id'               =>  $id
        );
        return $wpdb->update( $table_reservation, $data, $where);
    }
}

//********************************************************************* */
// Supprime une reservation dans la base de donnée                      //
//********************************************************************* */

if(! function_exists('IATEN_reservation_plugin_db_delete')){        
    function IATEN_reservation_plugin_db_delete($id){
        global $wpdb ;
        $table_reservation = IATEN_RESERVATION_TABLE;
        $wpdb->delete( $table_reservation, array( 'client_id' => $id ) );
    }
}
//******************************** FIN ******************************* */

//********************************************************************* */
// Retoune les crénaux horaire indisponible sur un évènement par date   //
//********************************************************************* */

function IATEN_reservation_plugin_db_get_creno_by_date($id, $attr){
    global $wpdb ;
    $table_reservation = IATEN_RESERVATION_TABLE;
    $results = $wpdb->get_results( "SELECT begining_hour FROM $table_reservation WHERE begining_date = '$attr' AND post_event_slug = '$id'" );
    return $results;
}
//******************************** FIN ******************************* */

//********************************************************************* */
// Calcul et retourne le nombre de participants sur un crénaux horaire  //
//********************************************************************* */

function IATEN_reservation_plugin_db_get_creno_participant($id, $attr, $hour){
    global $wpdb ;
    $result = 0;
    $table_reservation = IATEN_RESERVATION_TABLE;
    $request = $wpdb->get_results( "SELECT * FROM $table_reservation WHERE begining_date = '$attr' AND begining_hour = '$hour' AND  post_event_slug = '$id'" );
    foreach ($request as $value){
        $result += intval($value->participant_nb);
    }
    return $result;
}
//******************************** FIN ******************************* */

//********************************************************************* */
// Calcul et retourne le nombre de participants sur un  évènement       //
//********************************************************************* */

function IATEN_reservation_plugin_db_get_participant($id){
    global $wpdb ;
    $result = 0;
    $table_reservation = IATEN_RESERVATION_TABLE;
    $request = $wpdb->get_results( "SELECT * FROM $table_reservation WHERE post_event_slug = '$id'" );
    foreach ($request as $value){
        $result += intval($value->participant_nb);
    }
    return $result;
}
//******************************** FIN ******************************* */

//********************************************************************* */
// Retoune les crénaux horaire indisponible sur un évènement            //
//********************************************************************* */

function IATEN_reservation_plugin_db_get_reservation(){
    global $wpdb ;
    $table_reservation = IATEN_RESERVATION_TABLE;
    $results = $wpdb->get_results( "SELECT * FROM $table_reservation ORDER BY begining_date ASC" );
    return $results;
}
//******************************** FIN ******************************* */


//********************************************************************* */
// Calcul et retourne le nombre de participants sur un crénaux horaire  //
//********************************************************************* */

function IATEN_reservation_plugin_db_get_by_id($id){
    global $wpdb ;
    $table_reservation = IATEN_RESERVATION_TABLE;
    $results = $wpdb->get_results( "SELECT * FROM $table_reservation WHERE client_id = $id " );
    return $results;
}
//******************************** FIN ******************************* */


//********************************************************************* */
// Retourne les jours fériés                                            //
//********************************************************************* */

function IATEN_reservation_plugin_db_holidays(){
    global $wpdb ;
    $table_holidays = IATEN_HOLIDAYS;
    $results = $wpdb->get_results( "SELECT holidays FROM $table_holidays" );
    return $results;
}
//******************************** FIN ******************************* */


//********************************************************************* */
// Supprime un jour férié                                               //
//********************************************************************* */

if(! function_exists('IATEN_reservation_plugin_delete_holidays')){        
    function IATEN_reservation_plugin_delete_holidays($date){
        global $wpdb ;
        $table_holidays = IATEN_HOLIDAYS;

        $wpdb->delete( $table_holidays, array( 'holidays' => $date) );
    }
}
//******************************** FIN ******************************* */

//********************************************************************* */
// Ajouter un jour férié                                                //
//********************************************************************* */

if(! function_exists('IATEN_reservation_plugin_add_holidays')){        
    function IATEN_reservation_plugin_add_holidays($date){
        global $wpdb ;
        $table_holidays = IATEN_HOLIDAYS;

        $wpdb->insert($table_holidays, 
            array(
                'holidays'               =>  $date
            )
        );
    }
}
//******************************** FIN ******************************* */
