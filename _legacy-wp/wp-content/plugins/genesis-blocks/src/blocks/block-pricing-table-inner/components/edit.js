/**
 * Internal dependencies
 */
import Inspector from './inspector';
import PricingTable from './pricing-table';

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { Component } = wp.element;
const { InnerBlocks, AlignmentToolbar, BlockControls, useBlockProps } =
	wp.blockEditor;

const ALLOWED_BLOCKS = [
	// Allow the registered features child block name in the pricing table.
	'genesis-blocks/gb-pricing-table-features',
	'genesis-blocks/gb-pricing-table-price',
	'genesis-blocks/gb-pricing-table-subtitle',
	'genesis-blocks/gb-pricing-table-title',
	'genesis-blocks/gb-pricing-table-button',
	'core/paragraph',
	'core/image',
	'core/html',
	'core/shortcode',
];

// Preserve the legacy starter content while moving the block to the v3
// wrapper pattern used by newer blocks.
const DEFAULT_TEMPLATE = [
	[
		'genesis-blocks/gb-pricing-table-title',
		{
			title: '<strong>Price Title</strong>',
			fontSize: 'medium',
			paddingTop: 30,
			paddingRight: 20,
			paddingBottom: 10,
			paddingLeft: 20,
		},
	],
	[
		'genesis-blocks/gb-pricing-table-subtitle',
		{
			subtitle: 'Price Subtitle Description',
			customFontSize: 20,
			paddingTop: 10,
			paddingRight: 20,
			paddingBottom: 10,
			paddingLeft: 20,
		},
	],
	[
		'genesis-blocks/gb-pricing-table-price',
		{
			price: '49',
			currency: '$',
			customFontSize: 60,
			term: '/mo',
			paddingTop: 10,
			paddingRight: 20,
			paddingBottom: 10,
			paddingLeft: 20,
		},
	],
	[
		'genesis-blocks/gb-pricing-table-features',
		{},
		[
			[
				'core/list',
				{
					// Keep the legacy features class on the generated list so the
					// existing pricing table list styles still apply.
					className: 'gb-pricing-table-features',
					style: {
						spacing: {
							padding: {
								top: 15,
								bottom: 15,
								left: 20,
								right: 20,
							},
						},
						typography: {
							fontSize: 20,
						},
					},
				},
				[
					[
						'core/list-item',
						{
							content: __('Product Feature One', 'genesis-blocks'),
						},
					],
					[
						'core/list-item',
						{
							content: __('Product Feature Two', 'genesis-blocks'),
						},
					],
					[
						'core/list-item',
						{
							content: __('Product Feature Three', 'genesis-blocks'),
						},
					],
				],
			],
		],
	],
	[
		'genesis-blocks/gb-pricing-table-button',
		{
			buttonText: 'Buy Now',
			buttonBackgroundColor: '#272c30',
			paddingTop: 15,
			paddingRight: 20,
			paddingBottom: 35,
			paddingLeft: 20,
		},
	],
];

/* Wrapper required for Block API v3 */
export default function Edit(props) {
	const blockProps = useBlockProps();

	return <EditClass {...props} blockProps={blockProps} />;
}

class EditClass extends Component {
	render() {
		// Setup the attributes
		const {
			attributes: { alignment },
			setAttributes,
			blockProps,
			...pricingTableProps
		} = this.props;

		return (
			<div {...blockProps}>
				{/* Show the alignment toolbar on focus. */}
				<BlockControls key="controls">
					<AlignmentToolbar
						value={alignment}
						onChange={(nextAlign) => {
							setAttributes({ alignment: nextAlign });
						}}
					/>
				</BlockControls>

				{/* Show the block controls on focus. */}
				<Inspector
					key={'gb-pricing-table-inner-inspector-' + this.props.clientId}
					{...{ setAttributes, ...this.props }}
				/>

				{/* Keep blockProps on the editor wrapper only so the nested
					pricing column does not duplicate block metadata in the canvas. */}
				<PricingTable
					key={'gb-pricing-table-inner-' + this.props.clientId}
					{...pricingTableProps}
				>
					<InnerBlocks
						template={DEFAULT_TEMPLATE}
						templateLock={false}
						allowedBlocks={ALLOWED_BLOCKS}
						templateInsertUpdatesSelection={false}
					/>
				</PricingTable>
			</div>
		);
	}
}
