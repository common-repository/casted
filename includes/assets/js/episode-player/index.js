/**
 * External dependencies
 */
import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import edit from './edit';
import save from './save';
import attributes from './attributes';
import {
	BLOCK_NAME,
	BLOCK_TITLE,
	BLOCK_ICON,
	BLOCK_DESCRIPTION,
} from './constants';

const blockSettings = {
	title: BLOCK_TITLE,
	icon: {
		src: BLOCK_ICON,
		foreground: '#23282D',
	},
	category: 'casted',
	keywords: [__('Casted', 'casted')],
	description: BLOCK_DESCRIPTION,
	supports: {
		align: ['wide', 'full'],
		html: false,
	},
	example: {
		attributes: {
			isPreview: true,
		},
	},
	attributes,
	edit,
	save,
};

/**
 * Register and run the "Episode Player" block.
 */
registerBlockType('casted/episode-player', {
	...blockSettings,
});
