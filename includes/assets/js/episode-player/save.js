/**
 * Block Save
 *
 * Defines the way in which the different attributes shouldbe combined into
 * the final markup, which is then serialized by the block editor into `post_content`.
 *
 * @param {Object} [attributes]			The available attributes and their corresponding values, as described by the attributes property when the block type was registered.
 */

import { LANDING_BASE_URL } from '../config';

const Save = ({ attributes }) => {
	const { show, episode, preview, showPreview } = attributes;
	const domain =
		show.customDomain !== null && show.customDomain !== ''
			? `https://${show.customDomain}`
			: LANDING_BASE_URL;

	const renderSave = (data) => {
		window.addEventListener(
			'message',
			function (message) {
				// Ensure event is coming from Casted
				if (message.origin === domain) {
					if (message.data.event) {
						// Handle events
						if (message.data.event === 'castedSizeUpdate') {
							var casted_episode_player = document.getElementById(
								`casted-episode-player-${data.episode.slug}`
							);

							if (casted_episode_player) {
								casted_episode_player.height = message.data.payload.height;
							}
						}
					}
				}
			},
			false
		);

		return (
			<div className="casted-episode-player">
				<iframe
					id={`casted-episode-player-${data.episode.slug}`}
					width="100%"
					scrolling="no"
					style={{ border: 'none' }}
					src={`${data.domain}/player/${data.episode.slug}`}
				></iframe>
				<script type="text/javascript">{`
					window.addEventListener("message", function(message){
						// Ensure event is coming from Casted
						if(message.origin === "${data.domain}" ) {
							if( message.data.event) {
								// Handle events
								if(message.data.event === "castedSizeUpdate") {
									var casted_episode_player = document.getElementById('casted-episode-player-${data.episode.slug}');
									
									if(casted_episode_player) {
										casted_episode_player.height = message.data.payload.height;
									}
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
			domain: domain,
		});
	}
};

export default Save;
