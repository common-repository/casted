<?php

/**
 * Autoloads all needed classes for the plugin
 *
 * @link       http://casted.us
 * @since      1.0.0
 *
 * @package    Casted
 * @subpackage Casted/includes
 */

namespace Casted;

use Casted\Blocks\Assets as BlockAssets;
use Casted\Blocks\BlockLibrary as BlockLibrary;
use Casted\Api\Podcasts as Podcasts;
use Casted\Api\Episodes as Episodes;
use Casted\Api\Blog as Blog;

/**
 * Autoloads all needed classes for the plugin
 *
 * Maintain a list of all classes that are used throughout
 * the plugin.
 *
 * @package    Casted
 * @subpackage Casted/includes
 * @author     Casted Dev <dev@casted.us>
 */
class Casted_AutoLoader {

	/**
	 * The array of classes used within the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $classes    The classes autoloaded when the plugin loads.
	 */
	protected $classes;

	/**
	 * The name of the base directory.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $baseDir    The name of the base directory.
	 */
	protected $baseDir;

	/**
	 * Initialize the collection used to maintain the classes.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

        $this->baseDir = dirname(__DIR__);

		$this->classes = array(
            'Casted\\Blocks\\BlockLibrary' => array(
                'version' => '1.0',
                'path'    => $this->baseDir . '/src/Blocks/BlockLibrary.php'
			),
			'Api' => array(
				'version' => '1.0',
				'path'	  => $this->baseDir . '/src/Api/Api.php'
			),
			'Auth' => array(
				'version' => '1.0',
				'path'	  => $this->baseDir . '/src/Api/Auth.php'
			),
			'Podcasts' => array(
				'version' => '1.0',
				'path'	  => $this->baseDir . '/src/Api/Podcasts.php'
			),
			'Episodes' => array(
				'version' => '1.0',
				'path'	  => $this->baseDir . '/src/Api/Episodes.php'
			),
			'Blog' => array(
				'version' => '1.0',
				'path'	  => $this->baseDir . '/src/Api/Blog.php'
			),
            'Assets' => array(
                'version' => '1.0',
                'path'    => $this->baseDir . '/src/Blocks/Assets.php'
            ),
            'AbstractBlock' => array(
                'version' => '1.0',
                'path'    => $this->baseDir . '/src/Blocks/BlockTypes/AbstractBlock.php'
            ),
			'AddClip' => array(
                'version' => '1.0',
                'path'    => $this->baseDir . '/src/Blocks/BlockTypes/AddClip.php'
            ),
			'EpisodePlayer' => array(
                'version' => '1.0',
                'path'    => $this->baseDir . '/src/Blocks/BlockTypes/EpisodePlayer.php'
            ),
			'PullQuote' => array(
                'version' => '1.0',
                'path'    => $this->baseDir . '/src/Blocks/BlockTypes/PullQuote.php'
            ),
        );
    }
    
	/**
	 * Initialize the classes specified in $classes.
	 *
	 * @since    1.0.0
	 */
    public function init() {
        if( $this->classes && count($this->classes) > 0 ) {
            foreach( $this->classes as $class ) {
                require_once($class['path']);
            }

			BlockAssets::init();
			BlockLibrary::init();
			
			$podcastsInstance = Podcasts::getInstance();
			$podcastsInstance->init();
			
			$episodesInstance = Episodes::getInstance();
			$episodesInstance->init();

			$blogInstance = Blog::getInstance();
			$blogInstance->init();
        }
    }

}
