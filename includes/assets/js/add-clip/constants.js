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
import { faCut } from '@fortawesome/free-solid-svg-icons';

export const BLOCK_NAME = 'casted/add-clip';
export const BLOCK_TITLE = __('Add Clip', 'casted-add-clip');

export const BLOCK_ICON = <FontAwesomeIcon icon={faCut} />;
export const BLOCK_DESCRIPTION = __(
	'Displays an add clip block.',
	'casted-add-clip'
);
