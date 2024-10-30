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

import {
	CastedError,
	CastedModal,
	SelectShow,
	EditorWrapper,
} from '../base/components';

import { SelectEpisode } from './steps';
import { SelectClip } from './steps';
import { PodcastsAPI, EpisodesAPI } from '../api';

import { useState, useEffect } from '@wordpress/element';
import Save from './save';

const Editor = ({ attributes, setAttributes }) => {
	const { show, episode, clip } = attributes;

	const [shows, setShows] = useState([]);
	const [episodes, setEpisodes] = useState([]);

	const [isLoading, setIsLoading] = useState(true);

	const [showError, setShowError] = useState(false);

	const getCastedShows = async () => {
		const data = await PodcastsAPI.getPodcasts();

		if (data?.status === 200) {
			setShowError(false);
			setShows(data.response);
		} else {
			setShowError(true);
		}

		setIsLoading(false);
	};

	const getCastedShowEpisodes = async (showId) => {
		const data = await PodcastsAPI.getPodcastEpisodes(showId);

		if (data?.status === 200) {
			setShowError(false);
			setEpisodes(data.response);
		} else {
			setShowError(true);
		}

		setIsLoading(false);
	};

	useEffect(() => {
		setIsLoading(true);
		getCastedShows();
	}, []);

	useEffect(() => {
		if (attributes?.show?.id) {
			setIsLoading(true);
			getCastedShowEpisodes(attributes.show.id);
		}
	}, [attributes.show]);

	// Modal Functionality
	const [isOpen, setOpen] = useState(false);
	const openModal = () => setOpen(true);
	const closeModal = () => setOpen(false);
	const [currentStep, setCurrentStep] = useState(1);

	// Handlers
	const onEditClick = () => {
		if (!isOpen) {
			openModal();

			let newStep = 1;

			if (show.id) {
				newStep++;

				if (episodes.length === 0) {
					getCastedShowEpisodes(show.id);
				}
			}

			if (clip.id) {
				newStep++;
			}

			setCurrentStep(newStep);
		}
	};

	const onSelectShow = (show) => {
		setAttributes({
			show: {
				id: show.id,
				accountId: show.accountId,
				title: show.title,
				slug: show.slug,
				thumbnail: show.thumbnail,
				customDomain: show.customDomain,
			},
			showPreview: true,
		});
		setCurrentStep(2);
	};

	const onSelectEpisode = (episode) => {
		setAttributes({
			...attributes,
			episode: episode,
			showPreview: true,
		});
		setCurrentStep(3);
	};

	const onSelectClip = (clip) => {
		setAttributes({
			...attributes,
			clip: clip,
			showPreview: false,
		});
		closeModal();
	};

	const renderCurrentStep = (step) => {
		switch (step) {
			case 1:
				return (
					<SelectShow
						isLoading={isLoading}
						onClose={() => closeModal()}
						shows={shows}
						onSelect={(show) => onSelectShow(show)}
					/>
				);
			case 2:
				return (
					<SelectEpisode
						isLoading={isLoading}
						showBack={shows.length > 1 ? true : false}
						backFunction={() => setCurrentStep(1)}
						onClose={() => closeModal()}
						show={show}
						episodes={episodes}
						onSelect={(episode) => onSelectEpisode(episode)}
					/>
				);
			case 3:
				return (
					<SelectClip
						isLoading={isLoading}
						backFunction={() => setCurrentStep(2)}
						onClose={() => closeModal()}
						show={show}
						episode={episode}
						onSelect={(clip) => onSelectClip(clip)}
					/>
				);

			default:
				return (
					<SelectShow
						isLoading={isLoading}
						onClose={() => closeModal()}
						shows={shows}
						onSelect={onSelectShow}
					/>
				);
		}
	};

	return (
		<EditorWrapper
			title="Casted Clip"
			disableEdit={showError}
			onEditClick={() => onEditClick()}
		>
			{showError ? (
				<CastedError />
			) : (
				isOpen && <CastedModal>{renderCurrentStep(currentStep)}</CastedModal>
			)}

			<Save attributes={attributes} />
		</EditorWrapper>
	);
};

export default Editor;
