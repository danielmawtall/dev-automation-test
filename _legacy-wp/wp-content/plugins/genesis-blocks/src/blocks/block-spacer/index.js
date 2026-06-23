/**
 * BLOCK: Spacer
 */

// Import block dependencies and components
import Edit from './components/edit';
import Save from './components/save';

// Import CSS
import './styles/style.scss';
import './styles/editor.scss';

// WordPress dependencies
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

// Register the block
registerBlockType('genesis-blocks/gb-spacer', {
	apiVersion: 3,
	title: __('Spacer', 'genesis-blocks'),
	description: __(
		'Add a spacer and divider between your blocks.',
		'genesis-blocks'
	),
	icon: 'image-flip-vertical',
	category: 'genesis-blocks',
	keywords: [
		__('spacer', 'genesis-blocks'),
		__('divider', 'genesis-blocks'),
		__('atomic', 'genesis-blocks'),
	],
	attributes: {
		spacerHeight: {
			type: 'number',
			default: 30,
		},
		spacerDivider: {
			type: 'boolean',
			default: false,
		},
		spacerDividerStyle: {
			type: 'string',
			default: 'gb-divider-solid',
		},
		spacerDividerColor: {
			type: 'string',
			default: '#ddd',
		},
		spacerDividerHeight: {
			type: 'number',
			default: 1,
		},
	},

	gb_settings_data: {
		gb_spacer_spacerHeight: {
			title: __('Spacer Height', 'genesis-blocks'),
		},
		gb_spacer_spacerDivider: {
			title: __('Add Divider', 'genesis-blocks'),
		},
		gb_spacer_spacerDividerStyle: {
			title: __('Divider Style', 'genesis-blocks'),
		},
		gb_spacer_spacerDividerHeight: {
			title: __('Divider Height', 'genesis-blocks'),
		},
		gb_spacer_dividerColor: {
			title: __('Divider Color', 'genesis-blocks'),
		},
	},

	// Render the block components
	edit: Edit,

	// Save the block markup
	save: Save,
});
