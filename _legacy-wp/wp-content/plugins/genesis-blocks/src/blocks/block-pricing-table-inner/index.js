/**
 * BLOCK: Genesis Blocks Pricing Table InnerBlocks
 */

// Import block dependencies and components
import Edit from './components/edit';
import Save from './components/save';

// Import CSS
import './styles/style.scss';
import './styles/editor.scss';

// Internationalization
const { __ } = wp.i18n;

// Register block
const { registerBlockType } = wp.blocks;

// Register the block
registerBlockType('genesis-blocks/gb-pricing-table', {
	apiVersion: 3,
	title: __('Pricing Column', 'genesis-blocks'),
	description: __('Add a pricing column.', 'genesis-blocks'),
	icon: 'cart',
	category: 'genesis-blocks',
	parent: ['genesis-blocks/gb-pricing'],
	keywords: [
		__('pricing', 'genesis-blocks'),
		__('shop', 'genesis-blocks'),
		__('buy', 'genesis-blocks'),
	],
	attributes: {
		borderWidth: {
			type: 'number',
			default: 2,
		},
		borderColor: {
			type: 'string',
		},
		borderRadius: {
			type: 'number',
			default: 0,
		},
		backgroundColor: {
			type: 'string',
		},
		alignment: {
			type: 'string',
		},
		padding: {
			type: 'number',
		},
	},

	gb_settings_data: {
		gb_pricing_inner_padding: {
			title: __('Pricing Column Padding', 'genesis-blocks'),
		},
		gb_pricing_inner_borderWidth: {
			title: __('Pricing Column Border', 'genesis-blocks'),
		},
		gb_pricing_inner_borderRadius: {
			title: __('Pricing Column Border Radius', 'genesis-blocks'),
		},
		gb_pricing_inner_borderColor: {
			title: __('Pricing Column Border Color', 'genesis-blocks'),
		},
		gb_pricing_inner_colorSettings: {
			title: __('Pricing Column Background Color', 'genesis-blocks'),
		},
	},

	/* Render the block in the editor. */
	edit: Edit,

	/* Save the block markup. */
	save: Save,
});
