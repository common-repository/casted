import { useState } from '@wordpress/element';

import {
	CardAction,
	EpisodeCard,
	List,
	ListCard,
	ModalBody,
	ModalHeader,
	Search,
	CastedSpinner,
} from '../../base/components';

const SelectEpisode = (props) => {
	const {
		isLoading = true,
		showBack = false,
		show = {},
		episodes = [],
	} = props;

	const [searchTerm, setSearchTerm] = useState('');

	return (
		<>
			<ModalHeader
				showBack={showBack}
				backFunction={() => props.backFunction()}
				onClose={() => props.onClose()}
			>
				<h3>Episode Player - Select Episode</h3>
				<h4>Select the episode you would like to insert into your blog.</h4>
			</ModalHeader>
			<ModalBody>
				{isLoading ? (
					<CastedSpinner />
				) : (
					<>
						<Search
							searchTerm={searchTerm}
							onSearch={(term) => setSearchTerm(term)}
						/>
						<List>
							{episodes &&
								episodes
									.filter((episode) => {
										if (
											episode.publicStatus === 'published' &&
											(searchTerm === '' ||
												episode.name.toLowerCase().indexOf(searchTerm) !== -1)
										) {
											return true;
										}
										return false;
									})
									.map((episode) => (
										<ListCard key={episode.id}>
											<>
												<EpisodeCard
													title={episode.name}
													thumbnail={
														episode.thumbnail
															? episode.thumbnail
															: show.thumbnail
													}
													episode={episode.episode}
													date={episode.date}
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
