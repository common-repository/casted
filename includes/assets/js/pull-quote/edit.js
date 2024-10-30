/**
 * Block Editor
 *
 * Defines the structure of the block in the context of the editor.
 * This represents what the editor will render when the block is used.
 *
 * @param {Object} [attributes]			The available attributes and their corresponding values, as described by the attributes property when the block type was registered.
 * @param {Function} [setAttributes]	Allows the block to update individual attributes based on user interactions
 * @param {string} [className]			The class name for the wrapper element.
 * @param {boolean} [isSelected]		Communicates whether the block is currently selected.
 */

import { useState, useEffect } from '@wordpress/element';

import { PodcastsAPI, EpisodesAPI } from '../api';

import { CastedModal } from '../base/components';
import { SelectEpisode, SelectShow, SelectText } from './steps';
import Save from './save';

const Editor = ({ attributes, setAttributes, className, isSelected }) => {
	const { show = {}, episode = {}, selectedQuote = 0, quote = {} } = attributes;

	const [shows, setShows] = useState([]);
	const [episodes, setEpisodes] = useState([]);
	const [clips, setClips] = useState([]);
	const [transcript, setTranscript] = useState({});

	const [isLoading, setIsLoading] = useState(true);

	const getCastedShows = async () => {
		const data = await PodcastsAPI.getPodcasts();

		setShows(data);

		if (data.length === 1) {
			setCurrentStep(2);
		}

		setIsLoading(false);
	};

	const getCastedShowEpisodes = async (showId) => {
		const data = await PodcastsAPI.getPodcastEpisodes(showId);

		setEpisodes(data);
		setIsLoading(false);
	};

	const getCastedEpisodeClips = async (episodeId) => {
		const data = await EpisodesAPI.getEpisodeClips(episodeId);

		setClips(data);
		setIsLoading(false);
	};

	const getCastedEpisodeTranscript = async (episodeId) => {
		const data = await EpisodesAPI.getEpisodeTranscript(episodeId);

		setTranscript(data);
		setIsLoading(false);
	};

	useEffect(() => {
		setIsLoading(true);
		getCastedShows();
	}, []);

	useEffect(() => {
		if (attributes.show) {
			setIsLoading(true);
			getCastedShowEpisodes(attributes.show.id);
		}
	}, [attributes.show]);

	useEffect(() => {
		if (attributes.episode) {
			setIsLoading(true);
			getCastedEpisodeClips(attributes.episode.id);
			getCastedEpisodeTranscript(attributes.episode.id);
		}
	}, [attributes.episode]);

	// Modal Functionality
	const [isOpen, setOpen] = useState(true);
	const openModal = () => setOpen(true);
	const closeModal = () => setOpen(false);
	const [currentStep, setCurrentStep] = useState(1);

	// Opens Modal when user clicks on block
	useEffect(() => {
		if (isSelected && !isOpen) {
			openModal();

			let newStep = 1;

			if (show !== {}) {
				newStep++;

				if (episode !== {}) {
					newStep++;
				}
			}

			setCurrentStep(newStep);
		}
	}, [isSelected]);

	// Handlers
	const onSelectShow = (show) => {
		setAttributes({
			show: show,
		});
		setCurrentStep(2);
	};

	const onSelectEpisode = (episode) => {
		setAttributes({
			...attributes,
			episode: episode,
		});
		setCurrentStep(3);
	};

	const onSelectQuote = (quote) => {
		setAttributes({
			...attributes,
			quote: quote,
		});
		closeModal();
	};

	const onSelectTranscript = (id) => {
		setAttributes({
			...attributes,
			transcriptId: id,
		});
		closeModal();
	};

	const renderCurrentStep = (step) => {
		switch (step) {
			case 1:
				return (
					<SelectShow
						isLoading={isLoading}
						shows={shows}
						onSelect={onSelectShow}
						onClose={() => closeModal()}
					/>
				);
			case 2:
				return (
					<SelectEpisode
						isLoading={isLoading}
						showBack={shows.length > 1 ? true : false}
						backFunction={() => setCurrentStep(1)}
						onClose={() => closeModal()}
						episodes={episodes}
						onSelect={onSelectEpisode}
					/>
				);
			case 3:
				return (
					<SelectText
						isLoading={isLoading}
						showBack={true}
						backFunction={() => setCurrentStep(2)}
						onClose={() => closeModal()}
						episode={episode}
						clips={clips}
						transcript={transcript}
						selectedQuote={selectedQuote}
						onSelectQuote={onSelectQuote}
						onSelectTranscript={onSelectTranscript}
					/>
				);
			default:
				return (
					<SelectShow
						isLoading={isLoading}
						shows={shows}
						onSelect={onSelectShow}
						onClose={() => closeModal()}
					/>
				);
		}
	};

	return (
		<>
			{isOpen && <CastedModal>{renderCurrentStep(currentStep)}</CastedModal>}
			<Save attributes={attributes} />
		</>
	);
};

export default Editor;
