<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://casted.us
 * @since      1.0.0
 *
 * @package    Casted
 * @subpackage Casted/includes
 */

namespace Casted;

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Casted
 * @subpackage Casted/includes
 * @author     Casted Dev <dev@casted.us>
 */
class Casted_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		$result = update_option( 'casted_options', array() ) ? 'Data cleared' : 'No data';

        $casted_diagnostics_log = CASTED_PLUGIN_PATH . '/diagnostics.txt';

        $message_date = date('Y/m/dTh:i:sa');

		$message = $message_date . " - " . "Disconnected from Casted: " . $result . "\n";
		$message .= $message_date . " - " . "Deactivating Casted Plugin.\n";

        error_log($message, 3, $casted_diagnostics_log);
	}

}
