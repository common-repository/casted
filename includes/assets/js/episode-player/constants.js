/**
 * Block Constants
 *
 * Defines the constants used by the block
 */

/**
 * External dependencies
 */
import { __ } from '@wordpress/i18n';

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faMicrophone } from '@fortawesome/free-solid-svg-icons';

export const BLOCK_NAME = 'casted/episode-player';
export const BLOCK_TITLE = __('Episode Player', 'casted-episode-player');

export const BLOCK_ICON = <FontAwesomeIcon icon={faMicrophone} />;
export const BLOCK_DESCRIPTION = __(
	'Displays an episode player.',
	'casted-episode-player'
);
