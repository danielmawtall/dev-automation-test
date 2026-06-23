/**
 * BLOCK: Genesis Blocks Pricing Table - Button Component
 */

// Import block dependencies and components
import Edit from './edit';
import Save from './save';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

// Register the block
registerBlockType('genesis-blocks/gb-pricing-table-button', {
	apiVersion: 3,
	title: __('Product Button', 'genesis-blocks'),
	description: __('Adds a product button component.', 'genesis-blocks'),
	icon: 'cart',
	category: 'genesis-blocks',
	parent: ['genesis-blocks/gb-pricing-table'],
	keywords: [
		__('pricing table', 'genesis-blocks'),
		__('subtitle', 'genesis-blocks'),
		__('shop', 'genesis-blocks'),
	],

	attributes: {
		buttonText: {
			type: 'string',
		},
		buttonUrl: {
			type: 'string',
			source: 'attribute',
			selector: 'a',
			attribute: 'href',
		},
		buttonAlignment: {
			type: 'string',
		},
		buttonBackgroundColor: {
			type: 'string',
			default: '#3373dc',
		},
		buttonTextColor: {
			type: 'string',
			default: '#ffffff',
		},
		buttonSize: {
			type: 'string',
			default: 'gb-button-size-medium',
		},
		buttonShape: {
			type: 'string',
			default: 'gb-button-shape-rounded',
		},
		buttonTarget: {
			type: 'boolean',
			default: false,
		},
		fontSize: {
			type: 'string',
		},
		customFontSize: {
			type: 'number',
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
});
