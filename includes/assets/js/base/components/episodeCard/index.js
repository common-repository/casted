/**
 * Episode Card component
 */

/**
 * Internal Dependencies
 */
import { formatDate } from '../../utils';

const EpisodeCard = (props) => {
	const { thumbnail, title, episode, date } = props;

	return (
		<div className="casted-episode-content">
			<img className="casted-episode-img" src={thumbnail} />

			<div className="casted-episode-info">
				{title && <h4 className="casted-episode-title">{title}</h4>}

				<div className="casted-episode-details">
					{episode && (
						<span className="casted-episode-number">Episode {episode}</span>
					)}
					{date && (
						<span className="casted-episode-publish-date">
							{' '}
							| {formatDate(date, '.')}
						</span>
					)}
				</div>
			</div>
		</div>
	);
};

export default EpisodeCard;
