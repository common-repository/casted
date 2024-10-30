<?php
/**
 * Example Block block
 * 
 * @package Casted
 */

namespace Casted\Blocks\BlockTypes;

defined( 'ABSPATH' ) || exit;

use Casted\Blocks\Assets;

/**
 * Episode Player class
 */
class EpisodePlayer extends AbstractBlock {
    /**
     * Block name
     * 
     * @var string
     */
    protected $block_name = 'episode-player';

    /**
     * Registers the block type with WordPress
     */
    public function register_block_type() {
        return register_block_type(
            $this->namespace . '/' . $this->block_name,
            array(
                'render_callback' => array( $this, 'render' ),
                'editor_script'   => 'casted-' . $this->block_name,
                'editor_style'    => 'casted-block-editor',
                'style'           => [ 'casted-block-style' ],
            )
        );
    }

    /**
     * Render the block on the frontend
     * 
     * @param array   $attributes Block attributes. Default empty array
     * @param string  $content    Block content. Default empty string
     * @return string Rendered block type output
     */
    public function render( $attributes = array(), $content = '' ) {
        $block_attributes = is_a( $attributes, '\WP_Block' ) ? $attributes->attributes : $attributes;

        $this->enqueue_assets( $block_attributes );

        return $this->inject_html_data_attributes( $content, $block_attributes );
    }
}
