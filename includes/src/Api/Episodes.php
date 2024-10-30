<?php
/**
 * Initializes Episodes API.
 * 
 * @package Casted/Api 
 */

namespace Casted\Api;

defined( 'ABSPATH' ) || exit;

use Casted\Api\Auth as Auth;
use WP_REST_RESPONSE;
use WP_ERROR;

/**
 * Episodes class
 */
class Episodes {

    /** 
     * The class instance
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      mixed    $instance    The class instance.
    */
    private static $instance;

    /** 
     * The base URL for Podcast API calls
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $baseUrl    The base URL.
    */
    private $baseUrl;

    /** 
     * The Auth class instance used to make API calls
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      mixed    $authInstance    The Auth class instance.
    */
    private $authInstance;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
    public function __construct() {
        $this->authInstance = new Auth();
        $this->baseUrl = CASTED_API_BASE_URL . '/api/v1/episodes/';
    }

    /**
     * Initialize Episodes API endpoints
     */
    public function init() {
        add_action( 'rest_api_init', array( $this, 'registerRestRoutes' ) );
    }

    /** 
     * Creates singleton for Episodes class if one doesn't exist
    */
    public static function getInstance() {
        if( self::$instance === null ) {
            self::$instance = new Episodes();
        }

        return self::$instance;
    }

    /** 
     * Registers REST routes with WP REST API
    */
    public function registerRestRoutes() {
        register_rest_route( 'casted/v1', 'episodes/(?P<id>.+)', array(
            'methods' => 'GET',
            'callback' => array( $this, 'getEpisode' )
        ) );
        register_rest_route( 'casted/v1', 'episodes/(?P<id>.+)/clips', array(
            'methods' => 'GET',
            'callback' => array( $this, 'getEpisodeClips' )
        ) );
        register_rest_route( 'casted/v1', 'episodes/(?P<id>.+)/transcript', array(
            'methods' => 'GET',
            'callback' => array( $this, 'getEpisodeTranscript' )
        ) );
    }

    /**
     * Retreives episode data for provided episode ID
     * 
     * @param mixed $data   Contains ID for episode data to return.
     */
    public static function getEpisode( $data ) {
        if($data['id'] && is_string( $data['id'] ) && $data['id'] !== 'undefined') {
            $url = sanitize_url($this->baseUrl . $data['id'] . '?includeClips=true');

            $result = $this->authInstance->executeAuthedApiCall( 'get', $url, false  );

            if( $result['statusCode'] === 200 ) {
                return new WP_REST_Response(
                    array(
                        'status' => $result['statusCode'],
                        'response' => json_decode($result['response'])
                    )
                );
            }

            return new WP_Error( 'error', 'Error occurred while retrieving episode.', array( 'status' => $result['statusCode'] ) );
        }
    
        return new WP_Error( 'error', 'Error occurred while retrieving episode. No episode ID specified.', array( 'status' => 400 ) );
    }

    /**
     * Retreives episodes for provided podcast ID
     * 
     * @param mixed $data   Contains ID for podcast data to return.
     */
    public static function getEpisodeClips( $data ) {
        if($data['id'] && is_string( $data['id'] ) && $data['id'] !== 'undefined') {
            $url = sanitize_url($this->baseUrl . $data['id'] . '/clips');

            $result = $this->authInstance->executeAuthedApiCall( 'get', $url, false  );

            if( $result['statusCode'] === 200 ) {
                return new WP_REST_Response(
                    array(
                        'status' => $result['statusCode'],
                        'response' => json_decode($result['response'])
                    )
                );
            }

            return new WP_Error( 'error', 'Error occurred while retrieving episode clips.', array( 'status' => $result['statusCode'] ) );
        }
    
        return new WP_Error( 'error', 'Error occurred while retrieving episode. No episode ID specified.', array( 'status' => 400 ) );
    }

    /**
     * Retreives transcript for provided podcast ID
     * 
     * @param mixed $data   Contains ID for podcast data to return.
     */
    public static function getEpisodeTranscript( $data ) {
        if($data['id'] && is_string( $data['id'] ) && $data['id'] !== 'undefined') {
            $url = sanitize_url($this->baseUrl . $data['id'] . '/transcript');

            $result = $this->authInstance->executeAuthedApiCall( 'get', $url, false  );

            if( $result['statusCode'] === 200 ) {
                return new WP_REST_Response(
                    array(
                        'status' => $result['statusCode'],
                        'response' => json_decode($result['response'])
                    )
                );
            }

            return new WP_Error( 'error', 'Error occurred while retrieving episode transcript.', array( 'status' => $result['statusCode'] ) );
        }
    
        return new WP_Error( 'error', 'Error occurred while retrieving episode. No episode ID specified.', array( 'status' => 400 ) );
    }
}