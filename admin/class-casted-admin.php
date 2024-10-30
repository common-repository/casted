<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://casted.us
 * @since      1.0.0
 *
 * @package    Casted
 * @subpackage Casted/admin
 */

namespace Casted;

use Casted\Api\Auth as Auth;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Casted
 * @subpackage Casted/admin
 * @author     Casted Dev <dev@casted.us>
 */
class Casted_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $casted    The ID of this plugin.
	 */
	private $casted;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The settings page of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $page    The settings page of this plugin.
	 */
	private $page;

	/**
	 * The settings fields for this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $fields    The settings fields for this plugin.
	 */
	private $fields;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $casted       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $casted, $version ) {

		$this->casted = $casted;
		$this->version = $version;
		$this->page = 'casted-settings';
		$this->fields = array(
			'casted_access_token' => array(
				'id' => 'casted_access_token',
				'title' => 'CAT',
				'callback' => array( $this, 'casted_hidden_settings' ),
				'page' => $this->page,
				'section' => 'casted_section_authentication',
				'args' => array( 'name' => 'casted_access_token' )
			),
			'casted_refresh_token' => array(
				'id' => 'casted_refresh_token',
				'title' => 'CRT',
				'callback' => array( $this, 'casted_hidden_settings' ),
				'page' => $this->page,
				'section' => 'casted_section_authentication',
				'args' => array( 'name' => 'casted_refresh_token' )
			),
			'casted_auth_code' => array(
				'id' => 'casted_auth_code',
				'title' => 'CAC',
				'callback' => array( $this, 'casted_hidden_settings' ),
				'page' => $this->page,
				'section' => 'casted_section_authentication',
				'args' => array( 'name' => 'casted_auth_code' )
			),
			'casted_client_id' => array(
				'id' => 'casted_client_id',
				'title' => 'CCID',
				'callback' => array( $this, 'casted_hidden_settings' ),
				'page' => $this->page,
				'section' => 'casted_section_authentication',
				'args' => array( 'name' => 'casted_client_id' )
			),
			'casted_user_id' => array(
				'id' => 'casted_user_id',
				'title' => 'CUID',
				'callback' => array( $this, 'casted_hidden_settings' ),
				'page' => $this->page,
				'section' => 'casted_section_authentication',
				'args' => array( 'name' => 'casted_user_id' )
			),
			'casted_account_id' => array(
				'id' => 'casted_account_id',
				'title' => 'CAID',
				'callback' => array( $this, 'casted_hidden_settings' ),
				'page' => $this->page,
				'section' => 'casted_section_authentication',
				'args' => array( 'name' => 'casted_account_id' )
			),
		);

		add_action( 'admin_init', array( $this, 'casted_settings_init' ) );
		add_action( 'admin_menu', array( $this, 'casted_options_page' ) );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Casted_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Casted_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->casted, plugin_dir_url( __FILE__ ) . 'css/casted-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Casted_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Casted_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->casted, plugin_dir_url( __FILE__ ) . 'js/casted-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the Settings page for the admin area.
	 * 
	 * @since    1.0.0
	 */
	public function casted_settings_init() {
		register_setting( $this->page, 'casted_options' );

		add_settings_section(
			'casted_section_authentication',
			__( 'Authentication', 'casted' ),
			array( $this, 'casted_settings_auth_cb'),
			$this->page
		);

		add_settings_section(
			'casted_section_diagnostics',
			__( 'Need Help?', 'casted' ),
			array( $this, 'casted_settings_diag_cb'),
			$this->page
		);
	}

	public function casted_options_page() {
		$svg = file_get_contents( __DIR__ . '/../includes/assets/img/casted_symbol_fullcolor.svg' );

		add_menu_page(
			'Casted',
			'Casted',
			'manage_options',
			$this->page,
			array( $this, 'casted_options_page_html'),
			'data:image/svg+xml;base64,' . base64_encode($svg)
		);
		
		// check user capabilities
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Callback will append data to query string
		if( isset( $_GET ) && isset( $_GET['code'] ) && isset( $_GET['clientId'] ) && isset( $_GET['userId'] ) && isset( $_GET['accountId'] ) ) {
			$callbackData = array(
				'casted_auth_code' 	=> is_string( $_GET['code'] ) ? sanitize_text_field( $_GET['code'] ) : '',
				'casted_client_id' 	=> is_string( $_GET['clientId'] ) ? sanitize_text_field( $_GET['clientId'] ) : '',
				'casted_user_id' 	=> is_string( $_GET['userId'] ) ? sanitize_text_field( $_GET['userId'] ) : '',
				'casted_account_id' => is_string( $_GET['accountId'] ) ? sanitize_text_field( $_GET['accountId'] ) : ''
			);
			
			$this->casted_save_settings( $callbackData );
		}

		// Diagnostic email functionality
		if( isset( $_POST ) && isset( $_POST['send_diagnostics'] ) && $_POST['send_diagnostics'] === 'true' ) {
			$logged_in_user = wp_get_current_user();

			$subject = 'Casted WordPress Diagnostics - ' . get_site_url();
			$message = 'See attached log for details.';
			$attachments = array(CASTED_PLUGIN_PATH . '/diagnostics.txt');

			$mail_result = wp_mail('dev@casted.us', $subject, $message, '', $attachments);

			if($mail_result) { 
				add_settings_error( 'casted_messages', 'casted_message', __( 'Diagnostics sent to Casted', 'casted' ), 'success' );
			} else {
				add_settings_error( 'casted_messages', 'casted_message', __( 'Diagnostics failed to send to Caasted', 'casted' ), 'error' );
			}
		}
		
	}

	public function casted_hidden_settings( $args ) {
		$options = get_option( 'casted_options' );

		$field_value = isset($options[$args['name']]) ? $options[ $args['name'] ] : '';

		?>
		<input type="text" name="<?php echo esc_attr( $args['name'] ); ?>" value="<?php echo esc_attr( $field_value ); ?>" />
		<?php
	}

	public function casted_save_settings( $fields ) {
		$showError = false;
		$casted_diagnostics_log = CASTED_PLUGIN_PATH . '/diagnostics.txt';

		$message = date('Y/m/dTh:i:sa') . " - " . "Attempting connection to Casted. Client (" . esc_textarea( $fields['casted_client_id'] ) . ") Account (" . esc_textarea( $fields['casted_account_id'] ) . ")\n";
		error_log($message, 3, $casted_diagnostics_log);

		if( isset($fields) ) {
			$has_updates = false;
			$options = get_option( 'casted_options' );

			if(!$options){
				$options = array();
			}

			foreach( $fields as $field => $value ) {
				if( in_array( $field, array_keys($this->fields) ) ) {		
					$options[$field] = $value;

					if( !$has_updates ) {
						$has_updates = true;
					}
				}
			}

			if( $has_updates ) {
				$result = update_option( 'casted_options', $options );

				$authInstance = new Auth();
				
				if( is_string( $options['casted_auth_code'] ) && is_string( $options['casted_client_id'] ) ) {
					$refreshToken = $authInstance->exchangeAuthCode( sanitize_text_field( $options['casted_auth_code'] ), sanitize_text_field( $options['casted_client_id'] ) );
				}
				
				if( $refreshToken ) {
					$refreshed = $authInstance->refreshAccessToken();
					
					if( $refreshed ) {
						$message = date('Y/m/dTh:i:sa') . " - " . "Successful connection to Casted. Client (" . esc_textarea( $fields['casted_client_id'] ) . ") Account (" . esc_textarea( $fields['casted_account_id'] ) . ")\n";
						error_log($message, 3, $casted_diagnostics_log);

						wp_safe_redirect( admin_url( 'admin.php?page=casted-settings&settings-updated' ) );
					} else {
						$showError = true;
						$message = date('Y/m/dTh:i:sa') . " - " . "Failed connection to Casted. Access token did not refresh.\n";
						error_log($message, 3, $casted_diagnostics_log);
					}
				} else {
					$showError = true;
					$message = date('Y/m/dTh:i:sa') . " - " . "Failed connection to Casted. Refresh token invalid. (" . esc_textarea( $options['casted_auth_code'] ) . "CCID" . esc_textarea( $options['casted_client_id'] ) . ")\n";
					error_log($message, 3, $casted_diagnostics_log);
				}
			}
		}

		if( $showError ) {
			add_settings_error( 'casted_messages', 'casted_message', __( 'Connection with Casted Failed', 'casted' ), 'error' );
		}
	}

	public function casted_clear_settings() {
		$result = update_option( 'casted_options', array() ) ? 'Data cleared' : 'No data';

        $casted_diagnostics_log = CASTED_PLUGIN_PATH . '/diagnostics.txt';

        $message_date = date('Y/m/dTh:i:sa');

        $message = $message_date . " - " . "Disconnected from Casted: " . $result . "\n";

        error_log($message, 3, $casted_diagnostics_log);
	}

	public function casted_settings_auth_cb( $args ) {
		if( isset( $_POST ) && isset( $_POST['casted_access_token'] ) && isset( $_POST['send_diagnostics'] ) && $_POST['send_diagnostics'] === 'false' ){
			$this->casted_clear_settings();
		}

		$options = get_option( 'casted_options' );

		$refreshTokenExpired = false;
		
		if(isset($options['casted_auth_code']) && isset($options['casted_client_id'])) {

			$authInstance = new Auth();

			$refreshed = $authInstance->refreshAccessToken();

			if($refreshed === false) {
				$refreshTokenExpired = true;
			}
		} else {
			$refreshTokenExpired = true;
		}

		?>
		<div class="casted-auth-settings">
			<?php if( !isset($options['casted_access_token']) || $options['casted_access_token'] === '' || $refreshTokenExpired) { ?>
				<p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Please click the following button to connect with Casted in order to access your Podcast data.', 'casted' ); ?></p>
				<a  href="<?php echo CASTED_APP_BASE_URL;?>/login?callbackUrl=<?php echo urlencode( admin_url( 'admin.php?page=casted-settings', 'https' ) ); ?>"><button name="casted-connect" class="casted-button casted-button-green" type="button">Connect Casted Account</button></a>
			<?php } else { ?>
				<button name="casted-disconnect" id="casted-disconnect" class="casted-button casted-button-red" type="button">Disconnect Casted Account</button>
			<?php
			}

			foreach( $this->fields as $field ) {
				add_settings_field(
					$field['id'],
					$field['title'],
					$field['callback'],
					$field['page'],
					$field['section'],
					$field['args']
				);
			}
			?>
		</div>
		<?php
	}

	public function casted_settings_diag_cb( $args ) {
		?>
		<div class="casted-diag-settings">
			<p>If you're experiencing an issue with the Casted plugin, please contact <a href="mailto:support@casted.us">support@casted.us</a> with a detailed description of your issue.</p>
			<p>Click the button below to send a detailed log to Casted.</p>
			<input type="hidden" name="send_diagnostics" value="true" />
			<button name="casted-diagnostics" id="casted-diagnostics" class="button button-primary" type="submit">Send Diagnostics To Casted</button>
		</div>
		<?php
	}

	public function casted_options_page_html() {
		// add error/update messages
		
		// check if the user have submitted the settings
		// wordpress will add the "settings-updated" $_GET parameter to the url
		if ( isset( $_GET['settings-updated'] ) ) {
		// add settings saved message with the class of "updated"
			add_settings_error( 'casted_messages', 'casted_message', __( 'Successful Connection with Casted', 'casted' ), 'success' );
		}
		
		// show error/update messages
		settings_errors( 'casted_messages' );

		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form method="post" class="casted-settings-form" name="casted-settings-form">
			<?php
				// output security fields for the registered setting "wporg"
				settings_fields( $this->page );
				// output setting sections and their fields
				// (sections are registered for "wporg", each field is registered to a specific section)
				do_settings_sections( $this->page );
			?>
			</form>
		</div>
		<?php
	}

}
