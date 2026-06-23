/**
 * BLOCK: Genesis Blocks Pricing Table
 */

// Import block dependencies and components
import Edit from './components/edit';
import Save from './components/save';

// Internationalization
const { __ } = wp.i18n;

// Register block
const { registerBlockType } = wp.blocks;

// Register the block
registerBlockType('genesis-blocks/gb-pricing', {
	apiVersion: 3,
	title: __('Pricing', 'genesis-blocks'),
	description: __('Add a pricing table.', 'genesis-blocks'),
	icon: 'cart',
	category: 'genesis-blocks',
	keywords: [
		__('pricing table', 'genesis-blocks'),
		__('shop', 'genesis-blocks'),
		__('purchase', 'genesis-blocks'),
	],
	attributes: {
		columns: {
			type: 'number',
			default: 2,
		},
		columnsGap: {
			type: 'number',
			default: 2,
		},
		align: {
			type: 'string',
		},
	},

	gb_settings_data: {
		gb_pricing_columns: {
			title: __('Pricing Columns', 'genesis-blocks'),
		},
		gb_pricing_columnsGap: {
			title: __('Pricing Columns Gap', 'genesis-blocks'),
		},
	},

	// Add alignment to the block wrapper
	getEditWrapperProps({ align }) {
		if (
			'left' === align ||
			'right' === align ||
			'full' === align ||
			'wide' === align
		) {
			return { 'data-align': align };
		}
	},

	/* Render the block in the editor. */
	edit: Edit,

	/* Save the block markup. */
	save: Save,
});
