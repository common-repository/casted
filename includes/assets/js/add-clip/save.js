/**
 * Block Save
 *
 * Defines the way in which the different attributes should be combined into
 * the final markup, which is then serialized by the block editor into `post_content`.
 *
 * @param {Object} [attributes]			The available attributes and their corresponding values, as described by the attributes property when the block type was registered.
 */

import { LANDING_BASE_URL } from '../config';

const Save = ({ attributes }) => {
	const { show, episode, clip, preview, showPreview } = attributes;
	const domain =
		show.customDomain !== null && show.customDomain !== ''
			? `https://${show.customDomain}`
			: LANDING_BASE_URL;

	const renderSave = (data) => {
		window.addEventListener(
			'message',
			function (message) {
				// Ensure event is coming from Casted
				if (message.origin === data.domain) {
					if (message.data.event) {
						// Handle events
						if (message.data.event === 'castedSizeUpdate') {
							document.getElementById(
								`casted-clip-player-${data.clip.slug}`
							).height = message.data.payload.height;
						}
					}
				}
			},
			false
		);

		return (
			<div className="casted-clip-player">
				<iframe
					id={`casted-clip-player-${data.clip.slug}`}
					width="100%"
					scrolling="no"
					style={{ border: 'none' }}
					src={`${data.domain}/player/${data.clip.slug}`}
				></iframe>
				<script type="text/javascript">{`
					window.addEventListener("message", function(message){
						// Ensure event is coming from Casted
						if(message.origin === "${data.domain}" ) {
							if( message.data.event) {
								// Handle events
								if(message.data.event === "castedSizeUpdate") {
									document.getElementById('casted-clip-player-${data.clip.slug}').height = message.data.payload.height
								}
							}
						}
					}, false)
				`}</script>
			</div>
		);
	};

	if (showPreview) {
		return renderSave(preview);
	} else {
		return renderSave({
			show: show,
			episode: episode,
			clip: clip,
			domain: domain,
		});
	}
};

export default Save;
