import {
	CardAction,
	EpisodeCard,
	List,
	ListCard,
	ModalBody,
	ModalHeader,
	Search,
} from '../../base/components';

const SelectEpisode = (props) => {
	const { isLoading = true, episodes = [], showBack = false } = props;

	return (
		<>
			<ModalHeader
				showBack={showBack}
				backFunction={() => props.backFunction()}
				onClose={() => props.onClose()}
			>
				<h3>Pull Quote - Select Episode</h3>
				<h4>Select the episode you would like to pull a quote from.</h4>
			</ModalHeader>
			<ModalBody>
				{isLoading ? (
					<div>Loading...</div>
				) : (
					<>
						<Search />
						<List>
							{episodes.length > 0 &&
								episodes.map((episode) => (
									<ListCard key={episode.id}>
										<>
											<EpisodeCard
												title={episode.name}
												thumbnail={episode.thumbnail}
												episode={episode.episode}
												date={episode.createdAt}
											/>
											<CardAction
												id={episode.id}
												title="Select Episode"
												onClick={() => {
													props.onSelect(episode);
												}}
											/>
										</>
									</ListCard>
								))}
						</List>
					</>
				)}
			</ModalBody>
		</>
	);
};

export default SelectEpisode;
