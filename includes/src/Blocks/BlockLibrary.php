<?php
/**
 * Initialize blocks in Wordpress
 * 
 * @package Casted/Blocks
 */

namespace Casted\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * BlockLibrary class
 */
class BlockLibrary {

    /**
     * Initialize block library features
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'register_blocks' ) );
    }

    /**
     * Register blocks, hooking up assets and render functions as needed
     */
    public static function register_blocks() {
        global $wp_version;
        $blocks = [
            'AddClip',
            'EpisodePlayer',
            'PullQuote'
        ];

        foreach( $blocks as $class ) {
            $class    = __NAMESPACE__ . '\\BlockTypes\\' . $class;
            $instance = new $class();
            $instance->register_block_type();
        }
    }
}

