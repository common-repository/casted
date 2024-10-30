const getPodcasts = async () => {
	let returnData;

	try {
		returnData = await await wp
			.apiFetch({ path: `casted/v1/podcasts` })
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

const getPodcast = async (podcastId) => {
	let returnData;

	try {
		returnData = await wp
			.apiFetch({ path: `casted/v1/podcasts/${podcastId}` })
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

const getPodcastEpisodes = async (podcastId) => {
	let returnData;

	try {
		returnData = await wp
			.apiFetch({ path: `casted/v1/podcasts/${podcastId}/episodes` })
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

export default { getPodcasts, getPodcast, getPodcastEpisodes };
