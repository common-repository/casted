/**
 * Search component
 */

/**
 * External Dependencies
 */
import { TextControl } from '@wordpress/components';

const Search = (props) => {
	const { searchTerm } = props;

	return (
		<TextControl
			className="casted-search-input"
			placeholder="Search for Episodes"
			onChange={(value) => props.onSearch(value.toLowerCase())}
			value={searchTerm}
		/>
	);
};

export default Search;
