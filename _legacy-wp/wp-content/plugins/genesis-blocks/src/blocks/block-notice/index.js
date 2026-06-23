/**
 * BLOCK: Notice
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
registerBlockType('genesis-blocks/gb-notice', {
	apiVersion: 3,
	title: __('Notice', 'genesis-blocks'),
	description: __('Add a stylized text notice.', 'genesis-blocks'),
	icon: 'format-aside',
	category: 'genesis-blocks',
	keywords: [
		__('notice', 'genesis-blocks'),
		__('message', 'genesis-blocks'),
		__('atomic', 'genesis-blocks'),
	],
	attributes: {
		noticeTitle: {
			type: 'string',
			selector: '.gb-notice-title',
		},
		noticeAlignment: {
			type: 'string',
		},
		noticeBackgroundColor: {
			type: 'string',
			default: '#00d1b2',
		},
		noticeTextColor: {
			type: 'string',
			default: '#32373c',
		},
		noticeTitleColor: {
			type: 'string',
			default: '#fff',
		},
		noticeFontSize: {
			type: 'number',
			default: 18,
		},
		noticeDismiss: {
			type: 'string',
			default: '',
		},
	},

	gb_settings_data: {
		gb_notice_noticeFontSize: {
			title: __('Font Size', 'genesis-blocks'),
		},
		gb_notice_noticeDismiss: {
			title: __('Notice Display', 'genesis-blocks'),
		},
		gb_notice_colorSettings: {
			title: __('Notice Color', 'genesis-blocks'),
		},
	},

	// Render the block components
	edit: Edit,

	// Save the block markup
	save: Save,

	deprecated,
});
