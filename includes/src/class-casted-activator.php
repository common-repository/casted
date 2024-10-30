<?php

/**
 * Fired during plugin activation
 *
 * @link       http://casted.us
 * @since      1.0.0
 *
 * @package    Casted
 * @subpackage Casted/includes
 */

namespace Casted;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Casted
 * @subpackage Casted/includes
 * @author     Casted Dev <dev@casted.us>
 */
class Casted_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		$casted_diagnostics_log = CASTED_PLUGIN_PATH . '/diagnostics.txt';

		$message_date = date('Y/m/dTh:i:sa');
		
		$message = $message_date . " - " . "Activating Casted Plugin.\n";
        error_log($message, 3, $casted_diagnostics_log);
	}

}
