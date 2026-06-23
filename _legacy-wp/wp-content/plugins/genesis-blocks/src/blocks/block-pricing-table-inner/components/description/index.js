/**
 * BLOCK: Genesis Blocks Pricing Table - Features Component
 */

// Import block dependencies and components
import Edit from './edit';
import Save from './save';
import deprecated from './deprecated/deprecated';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

// Register the block
registerBlockType('genesis-blocks/gb-pricing-table-features', {
	apiVersion: 3,
	title: __('Product Features', 'genesis-blocks'),
	description: __(
		'Adds a product feature component with schema markup.',
		'genesis-blocks'
	),
	icon: 'cart',
	category: 'genesis-blocks',
	parent: ['genesis-blocks/gb-pricing-table'],
	supports: { inserter: false },
	keywords: [
		__('pricing table', 'genesis-blocks'),
		__('features', 'genesis-blocks'),
		__('shop', 'genesis-blocks'),
	],

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
