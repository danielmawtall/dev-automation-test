/**
 * Internal dependencies
 */
import classnames from 'classnames';
import Inspector from './inspector';
import PricingTable from './pricing';
import memoize from 'memize';
import _times from 'lodash/times';

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { Component } = wp.element;
const { BlockControls, BlockAlignmentToolbar, InnerBlocks, useBlockProps } = wp.blockEditor;
const { dispatch } = wp.data;

// Set allowed blocks and media
const ALLOWED_BLOCKS = ['genesis-blocks/gb-pricing-table'];

// Get the pricing template
const getPricingTemplate = memoize((columns) => {
	return _times(columns, () => ['genesis-blocks/gb-pricing-table']);
});

/* Wrapper required for Block API v3 */
export default function Edit(props) {
	const blockProps = useBlockProps();

	return <EditClass {...props} blockProps={blockProps} />;
}

class EditClass extends Component {
	componentDidUpdate(prevProps) {
		if (this.props.attributes.columns !== prevProps.attributes.columns) {
			dispatch('core/block-editor').synchronizeTemplate();
		}
	}

	render() {
		// Setup the attributes
		const {
			attributes,
			setAttributes,
			blockProps,
			...pricingTableProps
		} = this.props;
		const { columns, columnsGap, align } = attributes;

		return (
			<div {...blockProps}>
				{/* Show the alignment toolbar on focus*/}
				<BlockControls key="controls">
					<BlockAlignmentToolbar
						value={align}
						onChange={(align) => setAttributes({ align })}
						controls={['center', 'wide', 'full']}
					/>
				</BlockControls>

				{/* Show the block controls on focus*/}
				<Inspector
					key={'gb-pricing-table-inspector-' + this.props.clientId}
					{...{ setAttributes, ...this.props }}
				/>

				{/* Keep blockProps on the editor wrapper only so the nested
					pricing layout does not duplicate block metadata in the canvas. */}
				<PricingTable
					key={'gb-pricing-table-' + this.props.clientId}
					// Keep the full attribute bag on the shared wrapper so the
					// pricing column layout classes react to sidebar changes.
					attributes={attributes}
					{...pricingTableProps}
				>
					<div
						className={classnames(
							'gb-pricing-table-wrap-admin',
							'gb-block-pricing-table-gap-' + columnsGap
						)}
					>
						<InnerBlocks
							template={getPricingTemplate(columns)}
							templateLock="all"
							allowedBlocks={ALLOWED_BLOCKS}
						/>
					</div>
				</PricingTable>
			</div>
		);
	}
}
