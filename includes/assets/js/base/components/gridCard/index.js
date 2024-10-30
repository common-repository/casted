/**
 * Grid Card component
 */

const GridCard = (props) => {
	const { showId, showSlug, showName, showThumbnail, filler = false } = props;

	return filler ? (
		<div className="casted-grid-card casted-grid-card-filler"></div>
	) : (
		<div className="casted-grid-card" onClick={() => props.onSelect(showSlug)}>
			<img src={showThumbnail} />
			<h5>{showName}</h5>
		</div>
	);
};

export default GridCard;
