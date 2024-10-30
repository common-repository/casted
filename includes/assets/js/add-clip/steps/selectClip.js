import {
	ModalHeader,
	ListCard,
	ClipCard,
	CardAction,
	ModalBody,
	EpisodeCard,
	CastedSpinner,
} from '../../base/components';

import { useState, useEffect } from '@wordpress/element';

import { APP_BASE_URL } from '../../config';

const SelectClip = (props) => {
	const [currentClip, setCurrentClip] = useState({});
	const [audio, setAudio] = useState(null);
	const [play, setPlay] = useState(false);
	const [playingTimeout, setPlayingTimeout] = useState(0);

	const { isLoading, show, episode } = props;

	useEffect(() => {
		setAudio(new Audio(episode.hostedUrl));
	}, []);

	useEffect(() => {}, [currentClip]);

	useEffect(() => {
		if (audio && audio.currentTime >= currentClip.endTime) {
			audio.pause();
			setPlay(false);
		}
	}, [audio]);

	const onClipPlay = (clip) => {
		if (clip.id !== currentClip.id) {
			audio.currentTime = Math.round(clip.startTime);
			setCurrentClip(clip);
			createPlayingTimeout(clip.endTime);
		} else {
			if (!audio.paused) {
				audio.pause();
				setPlay(false);
				clearTimeout(playingTimeout);
			} else {
				if (audio.currentTime >= clip.endTime) {
					audio.currentTime = Math.round(clip.startTime);
				}
				createPlayingTimeout(clip.endTime);
			}
		}
	};

	const createPlayingTimeout = (endTime) => {
		clearTimeout(playingTimeout);

		const duration =
			(Math.round(endTime) - Math.round(audio.currentTime)) * 1000;

		audio.play();
		setPlay(true);

		setPlayingTimeout(
			setTimeout(() => {
				audio.pause();
				setPlay(false);
			}, duration)
		);
	};

	return (
		<>
			<ModalHeader
				showBack={true}
				backFunction={() => {
					audio.pause();
					props.backFunction();
				}}
				onClose={() => {
					audio.pause();
					props.onClose();
				}}
			>
				<EpisodeCard
					title={episode.name}
					thumbnail={
						episode.thumbnail ? episode.thumbnail : show.thumbnail
					}
					episode={episode.episode}
					date={episode.date}
				/>
			</ModalHeader>
			<ModalBody>
				{isLoading ? (
					<CastedSpinner />
				) : (
					<>
						<div className="casted-modal-clip-options">
							<div>Available Clips</div>
							<a
								target="_blank"
								href={`${APP_BASE_URL}/account/${show.accountId}/shows/${show.id}/episodes/${episode.id}/info`}
							>
								Want to create a new clip?
							</a>
						</div>
						{episode.clips &&
							episode.clips.map((clip) => (
								<ListCard key={clip.id}>
									<>
										<ClipCard
											clip={clip}
											isPlaying={
												play && clip.id === currentClip.id ? true : false
											}
											onPlay={() => onClipPlay(clip)}
										/>
										<CardAction
											id={clip.id}
											title="Add Clip"
											onClick={() => {
												audio.pause();
												setPlay(false);
												clearTimeout(playingTimeout);
												props.onSelect(clip);
											}}
											className="casted-card-action-green"
										/>
									</>
								</ListCard>
							))}
					</>
				)}
			</ModalBody>
		</>
	);
};

export default SelectClip;
