/**
 * Block Save
 *
 * Defines the way in which the different attributes shouldbe combined into
 * the final markup, which is then serialized by the block editor into `post_content`.
 *
 * @param {Object} [attributes]			The available attributes and their corresponding values, as described by the attributes property when the block type was registered.
 */

const Save = ({ attributes }) => {
	const { quote = { text: 'This is an example of a quote.' } } = attributes;

	return (
		<div className="casted-episode-player">
			<blockquote>{quote.text}</blockquote>
		</div>
	);
};

export default Save;
