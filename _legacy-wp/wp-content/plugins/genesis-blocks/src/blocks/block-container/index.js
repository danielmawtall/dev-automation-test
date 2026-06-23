/**
 * BLOCK: Genesis Blocks Container
 */

// Import block dependencies and components
import Edit from './components/edit';
import Save from './components/save';

// Deprecated components
import deprecated from './deprecated/deprecated';

// Import CSS
import './styles/style.scss';
import './styles/editor.scss';

// Internationalization
const { __ } = wp.i18n;

// Register block
const { registerBlockType } = wp.blocks;

const blockAttributes = {
	containerPaddingTop: {
		type: 'number',
	},
	containerPaddingRight: {
		type: 'number',
	},
	containerPaddingBottom: {
		type: 'number',
	},
	containerPaddingLeft: {
		type: 'number',
	},
	containerMarginTop: {
		type: 'number',
	},
	containerMarginBottom: {
		type: 'number',
	},
	containerWidth: {
		type: 'string',
	},
	containerMaxWidth: {
		type: 'number',
	},
	containerBackgroundColor: {
		type: 'string',
	},
	containerImgURL: {
		type: 'string',
		source: 'attribute',
		attribute: 'src',
		selector: 'img',
	},
	containerImgID: {
		type: 'number',
	},
	containerImgAlt: {
		type: 'string',
		source: 'attribute',
		attribute: 'alt',
		selector: 'img',
	},
	containerDimRatio: {
		type: 'number',
		default: 50,
	},
};

// Register the block
registerBlockType('genesis-blocks/gb-container', {
	apiVersion: 3,
	title: __('Container', 'genesis-blocks'),
	description: __(
		'Add a container block to wrap several blocks in a parent container.',
		'genesis-blocks'
	),
	icon: 'editor-table',
	category: 'genesis-blocks',
	keywords: [
		__('container', 'genesis-blocks'),
		__('section', 'genesis-blocks'),
		__('genesis', 'genesis-blocks'),
	],

	supports: {
		align: ['center', 'wide', 'full'],
		html: false,
	},

	attributes: blockAttributes,

	gb_settings_data: {
		gb_container_containerOptions: {
			title: __('Container Options', 'genesis-blocks'),
		},
		gb_container_backgroundOptions: {
			title: __('Background Options', 'genesis-blocks'),
		},
	},
	
	getEditWrapperProps({ containerWidth }) {
		if (
			'center' === containerWidth ||
			'wide' === containerWidth ||
			'full' === containerWidth
		) {
			return { 'data-align': containerWidth };
		}
	},

	/* Render the block in the editor. */
	edit: Edit,

	/* Save the block markup. */
	save: Save,

	deprecated,
});
