/**
 * External dependencies.
 */
import classnames from 'classnames';
import Columns from './column-wrap';
import icons from './icons';
import Inspector from './inspector';
import columnLayouts from './column-layouts';
import memoize from 'memize';
import map from 'lodash/map';
import _times from 'lodash/times';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;
const { Component, Fragment } = wp.element;
const { compose } = wp.compose;
const {
	BlockControls,
	BlockAlignmentToolbar,
	InnerBlocks,
	useBlockProps,
	withColors,
} = wp.blockEditor;
const {
	Placeholder,
	Button,
	__experimentalToggleGroupControl: ToggleGroupControl,
	__experimentalToggleGroupControlOption: ToggleGroupControlOption,
} = wp.components;

/* Set allowed blocks and media. */
const ALLOWED_BLOCKS = ['genesis-blocks/gb-column'];

/* Get the column template. */
const getLayoutTemplate = memoize((columns) => {
	return _times(columns, () => ['genesis-blocks/gb-column']);
});

class EditView extends Component {
	constructor() {
		super(...arguments);

		this.state = {
			selectLayout: true,
		};
	}

	render() {
		const {
			attributes,
			backgroundColor,
			blockProps,
			setAttributes,
			textColor,
			...columnProps
		} = this.props;

		let selectedRows = 1;

		if (attributes.columns) {
			selectedRows = parseInt(attributes.columns.toString().split('-'));
		}

		const columnOptions = [
			{
				name: __('1 Column', 'genesis-blocks'),
				key: 'one-column',
				columns: 1,
				icon: icons.oneEqual,
			},
			{
				name: __('2 Columns', 'genesis-blocks'),
				key: 'two-column',
				columns: 2,
				icon: icons.twoEqual,
			},
			{
				name: __('3 Columns', 'genesis-blocks'),
				key: 'three-column',
				columns: 3,
				icon: icons.threeEqual,
			},
			{
				name: __('4 Columns', 'genesis-blocks'),
				key: 'four-column',
				columns: 4,
				icon: icons.fourEqual,
			},
			{
				name: __('5 Columns', 'genesis-blocks'),
				key: 'five-column',
				columns: 5,
				icon: icons.fiveEqual,
			},
			{
				name: __('6 Columns', 'genesis-blocks'),
				key: 'six-column',
				columns: 6,
				icon: icons.sixEqual,
			},
		];

		/* Show the layout placeholder. */
		if (!attributes.layout && this.state.selectLayout) {
			return (
				<div {...blockProps}>
					<Placeholder
						key="placeholder"
						icon="editor-table"
						label={
							attributes.columns
								? __('Column Layout', 'genesis-blocks')
								: __('Column Number', 'genesis-blocks')
						}
						instructions={
							attributes.columns
								? __(
										'Select a layout for this column.',
										'genesis-blocks'
									)
								: __(
										'Select the number of columns for this layout.',
										'genesis-blocks'
									)
						}
						className={'gb-column-selector-placeholder'}
					>
						{!attributes.columns ? (
							<ToggleGroupControl
								__next40pxDefaultSize
								__nextHasNoMarginBottom
								label={__(
									'Select Row Columns',
									'genesis-blocks'
								)}
								value={String(attributes.columns || '')}
								onChange={(value) => {
									const columns = parseInt(value);
									setAttributes({
										columns,
										layout:
											1 === columns ||
											5 === columns ||
											6 === columns
												? columnOptions.find(
														(opt) =>
															opt.columns ===
															columns
													).key
												: null,
									});

									if (1 === columns) {
										this.setState({
											selectLayout: false,
										});
									}
								}}
								isBlock
								className="gb-column-selector-group"
							>
								{map(
									columnOptions,
									({ name, key, icon, columns }) => (
										<ToggleGroupControlOption
											key={key}
											value={String(columns)}
											label={name}
											aria-label={name}
										>
											{icon}
										</ToggleGroupControlOption>
									)
								)}
							</ToggleGroupControl>
						) : (
							<Fragment>
								<ToggleGroupControl
									__nextHasNoMarginBottom
									label={__(
										'Select Column Layout',
										'genesis-blocks'
									)}
									value={attributes.layout || ''}
									onChange={(layout) => {
										setAttributes({ layout });
										this.setState({
											selectLayout: false,
										});
									}}
									isBlock
									className="gb-column-selector-group"
								>
									{map(
										columnLayouts[selectedRows],
										({ name, key, icon }) => (
											<ToggleGroupControlOption
												key={key}
												value={key}
												label={name}
												aria-label={name}
											>
												{icon}
											</ToggleGroupControlOption>
										)
									)}
								</ToggleGroupControl>
								<Button
									className="gb-column-selector-button-back"
									onClick={() => {
										setAttributes({
											columns: null,
										});
										this.setState({ selectLayout: true });
									}}
								>
									{__(
										'Return to Column Selection',
										'genesis-blocks'
									)}
								</Button>
							</Fragment>
						)}
					</Placeholder>
				</div>
			);
		}

		return (
			<div {...blockProps}>
				<BlockControls key="controls">
					<BlockAlignmentToolbar
						value={attributes.align}
						onChange={(align) => setAttributes({ align })}
						controls={['center', 'wide', 'full']}
					/>
				</BlockControls>
				<Inspector {...this.props} key="inspector" />
				{/* Keep blockProps on the editor wrapper only so the visual
					columns container does not duplicate block metadata in the canvas. */}
				<Columns
					// Keep the full attribute bag on the shared wrapper so the
					// selected layout classes react to the chosen column count.
					attributes={attributes}
					{...columnProps}
					/* Pass through the live color value to the Columns component. */
					backgroundColorValue={backgroundColor.color}
					textColorValue={textColor.color}
					key="columns"
				>
					<div
						className={classnames(
							'gb-layout-column-wrap-admin',
							'gb-block-layout-column-gap-' + attributes.columnsGap,
							attributes.responsiveToggle
								? 'gb-is-responsive-column'
								: null
						)}
						style={{
							maxWidth: attributes.columnMaxWidth
								? attributes.columnMaxWidth
								: null,
						}}
					>
						<InnerBlocks
							template={getLayoutTemplate(attributes.columns)}
							templateLock="all"
							allowedBlocks={ALLOWED_BLOCKS}
						/>
					</div>
				</Columns>
			</div>
		);
	}
}

const EditWithBlockSupport = compose([
	withColors('backgroundColor', { textColor: 'color' }),
])(EditView);

/* Wrapper required for Block API v3 */
export default function Edit(props) {
	const blockProps = useBlockProps();

	return <EditWithBlockSupport {...props} blockProps={blockProps} />;
}
