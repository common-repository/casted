/**
 * Block Constants
 *
 * Defines the constants used by the block
 */

/**
 * External dependencies
 */
import { __ } from '@wordpress/i18n';
import { Icon } from '@wordpress/components';

export const BLOCK_NAME = 'casted/pull-quote';
export const BLOCK_TITLE = __('Pull Quote', 'casted-pull-quote');

export const BLOCK_ICON = <Icon icon="screenoptions" />;
export const BLOCK_DESCRIPTION = __(
	'Pulls a quote from the episode transcription.',
	'casted-pull-quote'
);
