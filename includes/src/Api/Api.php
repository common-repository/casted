<?php
/**
 * Initializes plugin api.
 * 
 * @package Casted/Api 
 */

namespace Casted\Api;

defined( 'ABSPATH' ) || exit;

/**
 * Api class
 */
class Api {

    /**
     * Performs request using WordPress HTTP API
     * 
     * @param string $method        Method to be used in request.
     * @param string $url           Full URL where request will be sent.
     * @param mixed  $data          Data to be sent with request. If false, no data will be sent.
     * @param string $bearerToken   Bearer token to be sent with request for authorization. If false, no authorization will be used.
     */
    private static function call( $method, $url, $data, $bearerToken ) {
        $args = array();
        $headers = array();

        if( $bearerToken ){
            $headers['Authorization'] = 'Bearer ' . $bearerToken;
        }

        switch( $method ) {
            case 'POST':
                if( $data ) {
                    $headers['Content-Type'] = 'application/json';
					$args['body'] = json_encode($data);
                }

				$args['headers'] = $headers;

				$response = wp_remote_post( $url, $args );
                break;
            default:
                if( $data ) {
                    $url = sanitize_url($url . '?' . http_build_query( $data ));
                }

				$args = array(
					'headers' => $headers
				);

				$response = wp_remote_get( $url, $args );
                break; 
        }

        $httpStatus = wp_remote_retrieve_response_code( $response );

        $result = array(
            'statusCode'    => $httpStatus,
            'response'      => wp_remote_retrieve_body( $response )
        );

        $casted_diagnostics_log = CASTED_PLUGIN_PATH . '/diagnostics.txt';

        $message_date = date('Y/m/dTh:i:sa');

        $message = $message_date . " - " . $method . " (" . $httpStatus . ") " . $url . "\n";

        error_log($message, 3, $casted_diagnostics_log);

        return $result;
    }

    /**
     * Performs a GET request
     * 
     * @param string $method        Method to be used in request.
     * @param string $url           Full URL where request will be sent.
     * @param mixed  $data          Optional. Data to be sent with request.
     * @param string $bearerToken   Optional. Bearer token to be sent with request for authorization.
     */
    public static function get( $url, $data = false, $bearerToken = false ) {
        return Api::call( 'GET', $url, $data, $bearerToken );
    }

    /**
     * Performs a POST request
     * 
     * @param string $method        Method to be used in request.
     * @param string $url           Full URL where request will be sent.
     * @param mixed  $data          Optional. Data to be sent with request.
     * @param string $bearerToken   Optional. Bearer token to be sent with request for authorization.
     */
    public static function post( $url, $data = false, $bearerToken = false ) {
        return Api::call( 'POST', $url, $data, $bearerToken );
    }
}