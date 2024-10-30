import { useState } from '@wordpress/element';

import {
	ModalHeader,
	ListCard,
	EpisodeCard,
	CardAction,
	ModalBody,
	Search,
	CastedSpinner,
} from '../../base/components';

const SelectEpisode = (props) => {
	const {
		isLoading = true,
		show = {},
		episodes = [],
		showBack = false,
	} = props;

	const [searchTerm, setSearchTerm] = useState('');

	return (
		<>
			<ModalHeader
				showBack={showBack}
				backFunction={() => props.backFunction()}
				onClose={() => props.onClose()}
			>
				<h3>Add Clip - Select Episode</h3>
				<h4>Select the episode you would like to add a clip from.</h4>
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
													episode.thumbnail ? episode.thumbnail : show.thumbnail
												}
												episode={episode.episode}
												date={episode.createdAt}
											/>
											<CardAction
												id={episode.id}
												title={
													episode.clips !== null && episode.clips.length > 0
														? episode.clips.length + ' Clips'
														: 'No Clips'
												}
												disabled={
													episode.clips !== null && episode.clips.length < 1
												}
												onClick={() => {
													props.onSelect(episode);
												}}
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

export default SelectEpisode;
