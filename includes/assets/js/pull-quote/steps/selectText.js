import { useState } from '@wordpress/element';

import {
	CardAction,
	EpisodeCard,
	QuoteCard,
	List,
	ListCard,
	ModalBody,
	ModalHeader,
	Search,
	Tabs,
	Transcript,
} from '../../base/components';

const SelectText = (props) => {
	const { isLoading = true, episode, clips, transcript, selectedQuote } = props;

	const [activeTab, setActiveTab] = useState(1);
	const [activeClip, setActiveClip] = useState(0);

	const tabs = [
		{
			id: 1,
			text: 'Suggested Quotes',
			info: 'This is some sample text.',
		},
		{
			id: 2,
			text: 'Episode Transcript',
			info: 'This is some sample text.',
		},
	];

	const onTabSelect = (id) => {
		setActiveTab(id);
	};

	return (
		<>
			<ModalHeader
				showBack={true}
				backFunction={() => props.backFunction()}
				onClose={() => props.onClose()}
			>
				<EpisodeCard
					title={episode.name}
					thumbnail={episode.thumbnail}
					episode={episode.episode}
					date={episode.date}
				/>
			</ModalHeader>
			<ModalBody>
				{isLoading ? (
					<div>Loading...</div>
				) : (
					<>
						<Tabs
							tabs={tabs}
							activeTab={activeTab}
							onSelect={(id) => onTabSelect(id)}
						></Tabs>
						{activeTab === 1 ? (
							<List>
								{clips.length > 0 &&
									clips.map((clip) => (
										<ListCard key={clip.id} vertical={true}>
											<QuoteCard
												clip={clip}
												activeClip={activeClip}
												selectedQuote={selectedQuote}
												onSelectActiveQuote={(id) => setActiveQuote(id)}
												onSelectQuote={() => props.onSelect()}
											/>
										</ListCard>
									))}
							</List>
						) : (
							<List>
								{transcript && <Transcript transcript={transcript} />}
							</List>
						)}
					</>
				)}
			</ModalBody>
		</>
	);
};

export default SelectText;
