/**
 * BLOCK: Genesis Blocks Pricing Table - Price Component
 */

// Import block dependencies and components
import Edit from './edit';
import Save from './save';

import deprecated from './deprecated/deprecated';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

// Register the block
registerBlockType('genesis-blocks/gb-pricing-table-price', {
	apiVersion: 3,
	title: __('Product Price', 'genesis-blocks'),
	description: __(
		'Adds a product price component with schema markup.',
		'genesis-blocks'
	),
	icon: 'cart',
	category: 'genesis-blocks',
	parent: ['genesis-blocks/gb-pricing-table'],
	keywords: [
		__('pricing table', 'genesis-blocks'),
		__('price', 'genesis-blocks'),
		__('shop', 'genesis-blocks'),
	],

	attributes: {
		price: {
			type: 'string',
		},
		currency: {
			type: 'string',
		},
		fontSize: {
			type: 'string',
		},
		customFontSize: {
			type: 'number',
			default: 60,
		},
		textColor: {
			type: 'string',
		},
		customTextColor: {
			type: 'string',
		},
		backgroundColor: {
			type: 'string',
		},
		customBackgroundColor: {
			type: 'string',
		},
		term: {
			type: 'string',
		},
		showTerm: {
			type: 'boolean',
			default: true,
		},
		showCurrency: {
			type: 'boolean',
			default: true,
		},
		paddingTop: {
			type: 'number',
			default: 10,
		},
		paddingRight: {
			type: 'number',
			default: 20,
		},
		paddingBottom: {
			type: 'number',
			default: 10,
		},
		paddingLeft: {
			type: 'number',
			default: 20,
		},
	},

	/* Render the block in the editor. */
	edit: (props) => {
		return <Edit {...props} />;
	},

	/* Save the block markup. */
	save: (props) => {
		return <Save {...props} />;
	},

	deprecated,
});
