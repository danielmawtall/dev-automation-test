/**
 * BLOCK: Genesis Blocks Drop Cap
 */

// Import block dependencies and components
import Edit from './components/edit';
import Save from './components/save';

// Import CSS
import './styles/style.scss';
import './styles/editor.scss';

import deprecated from './deprecated/deprecated';

// Internationalization
const { __ } = wp.i18n;

// Register block
const { registerBlockType } = wp.blocks;

// Register the block
registerBlockType('genesis-blocks/gb-drop-cap', {
	apiVersion: 3,
	title: __('Drop Cap', 'genesis-blocks'),
	description: __(
		'Add a styled drop cap to the beginning of your paragraph.',
		'genesis-blocks'
	),
	icon: 'format-quote',
	category: 'genesis-blocks',
	keywords: [
		__('drop cap', 'genesis-blocks'),
		__('quote', 'genesis-blocks'),
		__('genesis', 'genesis-blocks'),
	],
	attributes: {
		dropCapAlignment: {
			type: 'string',
		},
		dropCapBackgroundColor: {
			type: 'string',
			default: '#f2f2f2',
		},
		dropCapTextColor: {
			type: 'string',
			default: '#32373c',
		},
		dropCapFontSize: {
			type: 'number',
			default: 3,
		},
		dropCapStyle: {
			type: 'string',
			default: 'drop-cap-letter',
		},
	},
	gb_settings_data: {
		gb_dropcap_dropCapFontSize: {
			title: __('Drop Cap Size', 'genesis-blocks'),
		},
		gb_dropcap_dropCapStyle: {
			title: __('Drop Cap Style', 'genesis-blocks'),
		},
	},

	// Render the block components
	edit: Edit,

	// Save the block markup
	save: Save,
	deprecated,
});
