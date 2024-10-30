/**
 * Select Show component
 */

/**
 * Internal Dependencies
 */
import { Grid, GridCard, ModalBody, ModalHeader, CastedSpinner } from '..';

const SelectShow = (props) => {
	const { isLoading = true, showBack = false, shows = [] } = props;

	const fillerShows = [];

	for (let x = 0; x < 4 - (shows.length % 4); x++) {
		fillerShows.push(<GridCard key={`filler-${x}`} filler={true} />);
	}

	return (
		<>
			<ModalHeader
				showBack={showBack}
				backFunction={() => props.backFunction()}
				onClose={() => props.onClose()}
			>
				<h3>Select Show</h3>
				<h4>Select the show you would like to add content from.</h4>
			</ModalHeader>
			<ModalBody>
				{isLoading ? (
					<CastedSpinner />
				) : (
					<Grid>
						{shows &&
							shows.map((show) => (
								<GridCard
									key={show.id}
									showId={show.id}
									showSlug={show.slug}
									showName={show.title}
									showThumbnail={show.thumbnail}
									onSelect={() => props.onSelect(show)}
								/>
							))}
						{fillerShows}
					</Grid>
				)}
			</ModalBody>
		</>
	);
};

export default SelectShow;
