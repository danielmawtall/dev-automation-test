/**
 * BLOCK: Genesis Blocks Call-To-Action
 */

/**
 * Internal dependencies
 */
import Edit from './components/edit';
import deprecated from './deprecated/deprecated';

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
const { registerBlockType } = wp.blocks;

// Register the block
registerBlockType('genesis-blocks/gb-cta', {
	apiVersion: 3,
	title: __('Call To Action', 'genesis-blocks'),
	description: __(
		'Add a call to action section with a title, text, and a button.',
		'genesis-blocks'
	),
	icon: 'megaphone',
	category: 'genesis-blocks',
	keywords: [
		__('call to action', 'genesis-blocks'),
		__('cta', 'genesis-blocks'),
		__('atomic', 'genesis-blocks'),
	],
	edit: Edit,
	save: () => null,
	deprecated,
});
