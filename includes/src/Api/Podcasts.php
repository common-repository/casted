<?php
/**
 * Initializes Podcasts API.
 * 
 * @package Casted/Api 
 */

namespace Casted\Api;

defined( 'ABSPATH' ) || exit;

use Casted\Api\Auth as Auth;
use WP_REST_RESPONSE;
use WP_ERROR;

/**
 * Podcasts class
 */
class Podcasts {

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
        $this->baseUrl = CASTED_API_BASE_URL . '/api/v1/podcasts/';
    }

    /**
     * Initialize Podcasts API endpoints
     */
    public function init() {
        add_action( 'rest_api_init', array( $this, 'registerRestRoutes' ) );
    }

    /** 
     * Creates singleton for Podcasts class if one doesn't exist
    */
    public static function getInstance() {
        if( self::$instance === null ) {
            self::$instance = new Podcasts();
        }

        return self::$instance;
    }

    /** 
     * Registers REST routes with WP REST API
    */
    public function registerRestRoutes() {
        register_rest_route( 'casted/v1', 'podcasts/', array(
            'methods' => 'GET',
            'callback' => array( $this, 'getPodcasts' )
        ) );
        register_rest_route( 'casted/v1', 'podcasts/(?P<id>.+)/episodes', array(
            'methods' => 'GET',
            'callback' => array( $this, 'getPodcastEpisodes' )
        ) );
        register_rest_route( 'casted/v1', 'podcasts/(?P<id>.+)/', array(
            'methods' => 'GET',
            'callback' => array( $this, 'getPodcast' )
        ) );
    }

    /**
     * Retreives podcasts for current authed account
     */
    public function getPodcasts() {
        $options = get_option( 'casted_options' );

        if( !isset( $options['casted_account_id'] ) || !is_string( $options['casted_account_id'] ) ) {
            // WordPress is not authenticated with Casted
            return new WP_Error( 'error', 'User not authorized.', array( 'status' => 401) );
        }

        $url = sanitize_url(CASTED_API_BASE_URL . '/api/v1/accounts/' . $options['casted_account_id'] . '/podcasts');

        $result = $this->authInstance->executeAuthedApiCall( 'get', $url, false  );

        if( $result['statusCode'] === 200 ) {
            return new WP_REST_Response(
                array(
                    'status' => $result['statusCode'],
                    'response' => json_decode($result['response'])
                )
            );
        }

        return new WP_Error( 'error', 'Error occurred while retrieving podcasts.', array( 'status' => $result['statusCode'] ) );
    }

    /**
     * Retreives podcast data for provided podcast ID
     * 
     * @param mixed $data   Contains ID for podcast to return.
     */
    public function getPodcast( $data ) {
        if($data['id'] && is_string( $data['id'] ) && $data['id'] !== 'undefined'){
            $url = sanitize_url($this->baseUrl . $data['id']);
    
            $result = $this->authInstance->executeAuthedApiCall( 'get', $url, false  );
    
            if( $result['statusCode'] === 200 ) {
                return new WP_REST_Response(
                    array(
                        'status' => $result['statusCode'],
                        'response' => json_decode($result['response'])
                    )
                );
            }
    
            return new WP_Error( 'error', 'Error occurred while retrieving podcast.', array( 'status' => $result['statusCode'] ) );
        }
    
        return new WP_Error( 'error', 'Error occurred while retrieving podcast. No podcast ID specified.', array( 'status' => 400 ) );
    }

    /**
     * Retreives episodes for provided podcast ID
     * 
     * @param mixed $data   Contains ID for podcast to return.
     */
    public function getPodcastEpisodes( $data ) {
        if($data['id'] && is_string( $data['id'] ) && $data['id'] !== 'undefined'){
            $url = sanitize_url($this->baseUrl . $data['id'] . '/episodes?includeClips=true');

            $result = $this->authInstance->executeAuthedApiCall( 'get', $url, false  );

            if( $result['statusCode'] === 200 ) {
                return new WP_REST_Response(
                    array(
                        'status' => $result['statusCode'],
                        'response' => json_decode($result['response'])
                    )
                );
            }

            return new WP_Error( 'error', 'Error occurred while retrieving podcast episodes.', array( 'status' => $result['statusCode'] ) );
        }
    
        return new WP_Error( 'error', 'Error occurred while retrieving podcast. No podcast ID specified.', array( 'status' => 400 ) );
    }
}