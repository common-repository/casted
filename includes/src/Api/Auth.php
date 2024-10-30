<?php
/**
 * Initializes plugin api authentication.
 * 
 * @package Casted/Api 
 */

namespace Casted\Api;

defined( 'ABSPATH' ) || exit;

use Casted\Api\Api;

/**
 * Auth class
 */
class Auth {

    /** 
     * The base URL for Auth API calls
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $baseUrl    The base URL.
    */
    private $baseUrl;

    /** 
     * Access token to be sent with authenticated requests
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $accessToken    The access token for authenticated user.
    */
    private $accessToken;

    /** 
     * Refresh token to be sent when requesting a new access token
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $refreshToken    The refresh token for authenticated user.
    */
    private $refreshToken;

    /** 
     * Client Id provided on initial connection to Casted
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $clientId    The ID of authenticated client.
    */
    private $clientId;

    /** 
     * User Id provided on initial connection to Casted
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $userId    The ID of authenticated user
    */
    private $userId;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
    public function __construct() {
        $this->baseUrl = CASTED_AUTH_BASE_URL . '/auth/';

        $options = get_option( 'casted_options' );

        $this->accessToken = isset($options['casted_access_token']) ? $options['casted_access_token'] : '';
        $this->refreshToken = isset($options['casted_refresh_token']) ? $options['casted_refresh_token'] : '';
        $this->clientId = isset($options['casted_client_id']) ? $options['casted_client_id'] : '';
        $this->userId = isset($options['casted_user_id']) ? $options['casted_user_id'] : '';
    }

    /**
     * Exchanges confirmation code from Casted with auth and refresh tokens to perform API requests.
     * 
     * @param string $confirmationCode   Code received from callback from Casted.
     * @param string $clientId           Client Id received from callback from Casted.
     */
    public function exchangeAuthCode( $confirmationCode, $clientId ) {
        $data = array(
            'code'      => $confirmationCode,
            'clientId'  => $clientId
        );

        $result = Api::post( $this->baseUrl . 'authCode', $data );

        if( $result['statusCode'] === 200 ) {
            $response = json_decode($result['response']);

            if( $response->refresh_token !== '' ) {

                $options = get_option( 'casted_options' );

                $this->refreshToken = $options['casted_refresh_token'] = $response->refresh_token;

                update_option( 'casted_options', $options );

                return $response->refresh_token;
            }
        }

        return false;
    }

    /**
     * Refreshes access token to be used to authenticate Casted API requests
     */
    public function refreshAccessToken() {
        if($this->refreshToken && $this->clientId && $this->userId){
            $data = array(
                'refreshToken'  => $this->refreshToken,
                'cid'           => $this->clientId,
                'userId'        => $this->userId
            );
    
            $result = Api::get( $this->baseUrl . 'token', $data );
            
            if( $result['statusCode'] === 200 ) {
                $response = json_decode($result['response']);
    
                if( $response->accessToken !== '' ) {
    
                    $options = get_option( 'casted_options' );
    
                    $this->accessToken = $options['casted_access_token'] = $response->accessToken;
    
                    update_option( 'casted_options', $options );
    
                    return $response->accessToken;
                }
            }
        }

        $casted_diagnostics_log = CASTED_PLUGIN_PATH . '/diagnostics.txt';

        $message_date = date('Y/m/dTh:i:sa');
        $message = $message_date . " - Cannot refresh access token. Missing credentials.\n";

        error_log($message, 3, $casted_diagnostics_log);

        return false;
    }

    /**
     * Executes provided API call. If 401 occurs, attempts token refresh and retries to execute API call. Fails on second attempt.
     * 
     * @param string $apiMethod     API method to execute.
     * @param string $url           URL to be called.
     * @param mixed  $data          Data to be sent with request.
     */
    public function executeAuthedApiCall( $apiMethod, $url, $data ) {
        $result = Api::$apiMethod( $url, $data, $this->accessToken );

        if( $result['statusCode'] === 401 ) {

            $refreshedAccessToken = $this->refreshAccessToken();

            if( $refreshedAccessToken ) {
                return Api::$apiMethod( $url, $data, $refreshedAccessToken );
            }
        } else {
            return $result;
        }

        return false;
    }
}