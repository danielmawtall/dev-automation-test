/**
 * Internal dependencies
 */
// Import block dependencies and components
import classnames from 'classnames';
import PricingTable from './pricing';

/**
 * WordPress dependencies
 */
import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

export default function Save(props) {
	const blockProps = useBlockProps.save();

	// Gutenberg can call save with partial props during editor extraction, so
	// default the attribute bag instead of assuming it is always present.
	const { attributes = {} } = props;
	const { columnsGap = 2 } = attributes;

	// Set up the classes
	const className = classnames([
		'gb-pricing-table-wrap',
		'gb-block-pricing-table-gap-' + columnsGap,
	]);

	// Save passes blockProps into the visual wrapper because it becomes
	// the persisted block root on the front end.
	// Save the block markup for the front end
	return (
		<PricingTable {...props} blockProps={blockProps}>
			<div className={className ? className : undefined}>
				<InnerBlocks.Content />
			</div>
		</PricingTable>
	);
}
