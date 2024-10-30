const getEpisode = async (episodeId) => {
	let returnData;

	try {
		returnData = await wp
			.apiFetch({ path: `casted/v1/episodes/${episodeId}` })
			.then((response) => {
				if (response) {
					return response;
				}
				throw new Error('Casted Authentication Error');
			})
			.catch((err) => {
				throw new Error('Casted Authentication Error');
			});
	} catch (e) {
		console.error(e);
	}

	return returnData;
};

const getEpisodeClips = async (episodeId) => {
	let returnData;

	try {
		returnData = await wp
			.apiFetch({ path: `casted/v1/episodes/${episodeId}/clips` })
			.then((response) => {
				if (response) {
					return response;
				}
				throw new Error('Casted Authentication Error');
			})
			.catch((err) => {
				throw new Error('Casted Authentication Error');
			});
	} catch (e) {
		console.error(e);
	}

	return returnData;
};

const getEpisodeTranscript = async (episodeId) => {
	let returnData;

	try {
		returnData = await wp
			.apiFetch({ path: `casted/v1/episodes/${episodeId}/transcript` })
			.then((response) => {
				if (response) {
					return response;
				}
				throw new Error('Casted Authentication Error');
			})
			.catch((err) => {
				throw new Error('Casted Authentication Error');
			});
	} catch (e) {
		console.error(e);
	}

	return returnData;
};

export default { getEpisode, getEpisodeClips, getEpisodeTranscript };
