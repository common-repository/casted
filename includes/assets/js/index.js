/**
 * External dependencies
 */
import { getCategories, setCategories } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import '../css/editor.scss';
import '../css/style.scss';

import castedLogo from '../img/casted_symbol_fullcolor.svg';

setCategories([
	...getCategories().filter(({ slug }) => slug !== 'casted'),
	// Add a Casted block category
	{
		slug: 'casted',
		title: __('Casted', 'casted'),
		icon: <img src={castedLogo} alt="Logo" style={{ height: '1rem' }} />,
	},
	{},
]);
