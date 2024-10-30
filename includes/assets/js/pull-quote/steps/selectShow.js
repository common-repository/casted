import { Grid, GridCard, ModalBody, ModalHeader } from '../../base/components';

const SelectShow = (props) => {
	const { isLoading = true, shows = [] } = props;

	const fillerShows = [];

	for (let x = 0; x < 4 - (shows.length % 4); x++) {
		fillerShows.push(<GridCard key={`filler-${x}`} filler={true} />);
	}

	return (
		<>
			<ModalHeader showBack={false} onClose={() => props.onClose()}>
				<h3>Select Show</h3>
				<h4>Select the show you would like to add content from.</h4>
			</ModalHeader>
			<ModalBody>
				{isLoading ? (
					<div>Loading...</div>
				) : (
					<Grid>
						{shows.length > 0 &&
							shows.map((show) => (
								<GridCard
									key={show.id}
									showId={show.id}
									showSlug={show.slug}
									showName={show.name}
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
