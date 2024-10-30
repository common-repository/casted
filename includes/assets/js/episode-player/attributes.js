/**
 * Block Attributes
 *
 * Defines the attributes their types for use by the block
 */

export const blockAttributes = {
	show: {
		type: 'object',
		default: {
			accountId: 5,
			slug: 'The-Casted-Podcast-52134',
			customDomain: 'podcast.casted.us',
		},
	},
	episode: {
		type: 'object',
		default: { slug: 'cee2a13f' },
	},
	preview: {
		type: 'object',
		default: {
			show: {
				accountId: 5,
				slug: 'The-Casted-Podcast-52134',
			},
			episode: {
				slug: 'cee2a13f',
			},
			domain: 'https://podcast.casted.us',
		},
	},
	showPreview: {
		type: 'boolean',
		default: true,
	},
};

export default blockAttributes;
