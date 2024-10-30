<?php
/**
 * Initializes block assets.
 * 
 * @package Casted/Blocks 
 */

namespace Casted\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Assets class
 */
class Assets {

    /**
     * Inintialize class features on init
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'register_assets' ) );
    }

    /**
     * Register block scripts & styles
     */
    public static function register_assets() {
        self::register_style( 'casted-block-editor', plugins_url( self::get_block_asset_build_path( 'blocks', 'css' ), __DIR__ ), array( 'wp-edit-blocks' ) );
        self::register_style( 'casted-block-style', plugins_url( self::get_block_asset_build_path( 'style-blocks', 'css' ), __DIR__ ) );

        // Shared libraries and components across all blocks
        self::register_script( 'casted-blocks', plugins_url( self::get_block_asset_build_path( 'blocks' ), __DIR__ ), [], false );

        // Individual blocks
		$block_dependencies = array( 'casted-blocks' );
        
        self::register_script( 'casted-add-clip', plugins_url( self::get_block_asset_build_path( 'add-clip' ), __DIR__ ), $block_dependencies );
        self::register_script( 'casted-episode-player', plugins_url( self::get_block_asset_build_path( 'episode-player' ), __DIR__ ), $block_dependencies );
        self::register_script( 'casted-pull-quote', plugins_url( self::get_block_asset_build_path( 'pull-quote' ), __DIR__ ), $block_dependencies );
    }

    /**
     * Registers a script according to `wp_register_script`, additionally loading the translations for the file
     * 
     * @param string $handle       Name of the script. Should be unique.
     * @param string $src          Full URL of the script, or path of the script relative to the WordPress root directory.
     * @param array  $dependencies Optional. An array of registered script handles this script depends on. Default empty array.
     * @param bool   $has_il8n     Optional. Whether to add a script translation call to this file. Default `true`.
     */
    protected static function register_script( $handle, $src, $dependencies = [], $has_il8n = true ) {
        $relative_src = str_replace( plugins_url( '/', __DIR__ ), '', $src );
        $asset_path   = dirname( __DIR__ ) . '/' . str_replace( '.js', '.asset.php', $relative_src );

        if( file_exists( $asset_path ) ) {
            $asset        = require $asset_path;
            $dependencies = isset( $asset['dependencies'] ) ? array_merge( $asset['dependencies'], $dependencies ) : $dependencies;
            $version      = !empty( $asset['version'] ) ? $asset['version'] : self::get_file_version( $relative_src );
        } else {
            $version = '1.0';
        }

        wp_register_script( $handle, $src, $dependencies, $version, true );
    }

	/**
	 * Registers a style according to `wp_register_style`
	 *
	 * @param string $handle Name of the stylesheet. Should be unique.
	 * @param string $src    Full URL of the stylesheet, or path of the stylesheet relative to the WordPress root directory.
	 * @param array  $deps   Optional. An array of registered stylesheet handles this stylesheet depends on. Default empty array.
	 * @param string $media  Optional. The media for which this stylesheet has been defined. Default 'all'. Accepts media types like
	 *                       'all', 'print' and 'screen', or media queries like '(orientation: portrait)' and '(max-width: 640px)'.
	 */
	protected static function register_style( $handle, $src, $deps = [], $media = 'all' ) {
		$filename = str_replace( plugins_url( '/', __DIR__ ), '', $src );
		wp_register_style( $handle, $src, $deps, '1.0', $media );
	}

	/**
	 * Returns the appropriate asset path for loading either legacy builds or
	 * current builds.
	 *
	 * @param   string $filename  Filename for asset path (without extension).
	 * @param   string $type      File type (.css or .js).
	 *
	 * @return  string             The generated path.
	 */
	protected static function get_block_asset_build_path( $filename, $type = 'js' ) {
		global $wp_version;
		return "../build/$filename.$type";
	}
}
