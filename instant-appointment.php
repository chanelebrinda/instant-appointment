<?php
/**
 * Plugin Name:       Instant Appointment
 * Plugin URI:        https://tenteeglobal.com/
 * Description:       WordPress reservation is a WordPress plugin for managing events, booking and making appointments
 * Version:           1.0.2
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Tentee Global
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       instant-appointment
 * Domain Path:       /lang
 */


namespace TenteeReservation\WordpressReservation;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Si nous ne sommes pas dans WordPress, Sortir.
}

define('IATEN_DIR_PATH', plugin_dir_path( __FILE__ ));
define('IATEN_DIR_URL', plugin_dir_url(__FILE__ ));

$DefaultImg = IATEN_DIR_URL.'assets/frontend/images/';	 
global $DefaultImg;


require IATEN_DIR_PATH.'vendor/autoload.php';

require IATEN_DIR_PATH.'src/functions/function.php';

require IATEN_DIR_PATH.'configs/texts.php';
require IATEN_DIR_PATH.'configs/globalVars.php';

require IATEN_DIR_PATH.'models/WReservation_manage_db.php';

require IATEN_DIR_PATH.'views/backend/Metabox.php';
require IATEN_DIR_PATH.'views/frontend/events.php';
require IATEN_DIR_PATH.'views/enqueue_scripts.php';

require IATEN_DIR_PATH.'src/frontend/construct_template.php';
require IATEN_DIR_PATH.'src/define_event.php';
require IATEN_DIR_PATH.'src/Reservation.php';
require IATEN_DIR_PATH.'src/backend/Metadata.php';
require IATEN_DIR_PATH.'src/frontend/load_template.php';
require IATEN_DIR_PATH.'src/frontend/function.php';

require IATEN_DIR_PATH.'src/backend/setting.php';

/**
 * Deactivation hook.
 */
register_deactivation_hook( __FILE__, function (){
	require IATEN_DIR_PATH.'models/WReservation_deactivation.php';
    // Clear the permalinks to remove our post type's rules from the database.
	flush_rewrite_rules();
} );

register_activation_hook( __FILE__, function(){
	require IATEN_DIR_PATH.'models/WReservation_activation.php';
	// 
    IATEN_reservation_plugin_db_install();
    // Clear the permalinks to remove our post type's rules from the database.
    flush_rewrite_rules();
} );


// register_uninstall_hook( __FILE__, function (){
// 	require IATEN_DIR_PATH.'models/WReservation_uninstall.php';
// 	if(! defined( 'WP_UNINSTALL_PLUGIN' )){
// 		wp_die();
// 	}
// 	IATEN_reservation_plugin_db_desinstall();
// 	flush_rewrite_rules();
// } );

class IATEN_load_language 
{
    public function __construct()
    {
    add_action('init', array($this, 'IATEN_load_my_transl'));
    }

     public function IATEN_load_my_transl()
    {
        load_plugin_textdomain('instant-appointment', FALSE, dirname(plugin_basename(__FILE__)).'/lang/');
    }
}

$zzzz = new IATEN_load_language;
