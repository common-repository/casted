<?php
/**
 * Initializes Blog API.
 * 
 * @package Casted/Api 
 */

namespace Casted\Api;

defined( 'ABSPATH' ) || exit;

use Casted\Api\Auth as Auth;
use WP_REST_RESPONSE;
use WP_ERROR;

/**
 * Blog class
 */
class Blog {

    /** 
     * The class instance
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      mixed    $instance    The class instance.
    */
    private static $instance;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
    public function __construct() {
        // Silence is golden
    }

    /**
     * Initialize Blog API endpoints
     */
    public function init() {
        add_action( 'rest_api_init', array( $this, 'registerRestRoutes' ) );
    }

    /** 
     * Creates singleton for Blog class if one doesn't exist
    */
    public static function getInstance() {
        if( self::$instance === null ) {
            self::$instance = new Blog();
        }

        return self::$instance;
    }

    /** 
     * Registers REST routes with WP REST API
    */
    public function registerRestRoutes() {
        register_rest_route( 'casted/v1', 'blog/', array(
            'methods' => 'GET',
            'callback' => array( $this, 'getBlog' )
        ) );
        register_rest_route( 'casted/v1', 'blog/posts/', array(
            'methods' => 'GET',
            'callback' => array( $this, 'getBlogPosts' )
        ) );
    }

    /**
     * Retreives blog data
     */
    public function getBlog() {
        $options = get_option( 'casted_options' );

        if( !isset( $options['casted_account_id'] ) ) {
            //WordPress is not authenticated with Casted
            return new WP_Error( 'error', 'Site not authorized with Casted', array( 'status' => 401 ) );
        }

        $blogArr = array(
            'name' => get_bloginfo('name'),
            'url' => get_bloginfo('url')
        );

        return new WP_REST_Response(
            array(
                'status' => 200,
                'response' => $blogArr
            )
        );
    }

    /**
     * Retreives blog post data
     */
    public function getBlogPosts() {
        $options = get_option( 'casted_options' );

        if( !isset( $options['casted_account_id'] ) ) {
            //WordPress is not authenticated with Casted
            return new WP_Error( 'error', 'Site not authorized with Casted', array( 'status' => 401 ) );
        }

        $args = array(
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'post_type' => 'post',
            'orderby' => 'post_date'
        );

        $blogPosts = get_posts( $args );

        $filteredPosts = [];

        foreach($blogPosts as $blogPost) {
            $filteredPosts[] = array(
                'id' => $blogPost->ID,
                'post_type' => $blogPost->post_type,
                'post_date_gmt' => $blogPost->post_date_gmt,
                'post_modified_gmt' => $blogPost->post_modified_gmt,
                'post_title' => $blogPost->post_title,
                'post_url' => get_permalink($blogPost->ID),
                'post_content_cleaned' => wp_strip_all_tags($blogPost->post_content)
            );
        }

        return new WP_REST_Response(
            array(
                'status' => 200,
                'response' => $filteredPosts
            )
        );
    }
}