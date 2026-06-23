/**
 * BLOCK: Genesis Blocks Button
 */

// Don't delete this import, as it's used in the Pricing Table block.
import './styles/style.scss';

/**
 * Internal dependencies
 */
import Edit from './components/edit';
import deprecated from './deprecated';

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
const { registerBlockType } = wp.blocks;

// Register the block
registerBlockType('genesis-blocks/gb-button', {
	apiVersion: 3,
	title: __('Button', 'genesis-blocks'),
	description: __('Add a customizable button.', 'genesis-blocks'),
	icon: 'admin-links',
	supports: { inserter: false },
	category: 'genesis-blocks',
	keywords: [
		__('button', 'genesis-blocks'),
		__('link', 'genesis-blocks'),
		__('genesis', 'genesis-blocks'),
	],
	edit: Edit,
	save: () => null,
	deprecated,
});
