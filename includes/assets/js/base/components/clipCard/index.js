/**
 * Clip Card component
 */

/**
 * External Dependencies
 */
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faPlay, faPause } from '@fortawesome/free-solid-svg-icons';

const ClipCard = (props) => {
	const { clip, isPlaying } = props;

	const { name, endTime, startTime } = clip;

	const totalSeconds = endTime - startTime;
	const minutes = Math.floor(totalSeconds / 60);
	const seconds = Math.floor(totalSeconds - minutes * 60);
	const duration = minutes + ':' + ('0' + seconds).slice(-2);

	return (
		<div className="casted-clip-content">
			<div className="casted-clip-img" onClick={() => props.onPlay()}>
				{isPlaying ? (
					<FontAwesomeIcon icon={faPause} className="casted-clip-play" />
				) : (
					<FontAwesomeIcon icon={faPlay} className="casted-clip-play" />
				)}
			</div>
			<div className="casted-clip-info">
				{name && <h4 className="casted-clip-title">{name}</h4>}

				<div className="casted-clip-details">
					{duration && (
						<span className="casted-clip-number">{duration} MIN</span>
					)}
				</div>
			</div>
		</div>
	);
};

export default ClipCard;
