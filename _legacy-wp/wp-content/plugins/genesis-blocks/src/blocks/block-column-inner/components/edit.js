/**
 * Internal dependencies
 */
import Inspector from './inspector';
import Column from './column';

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { compose } = wp.compose;
const { Component, Fragment } = wp.element;
const { ToolbarGroup } = wp.components;
const { AlignmentToolbar, BlockControls, InnerBlocks, useBlockProps, withColors } =
	wp.blockEditor;

class EditView extends Component {
	render() {
		const {
			attributes,
			backgroundColor,
			blockProps,
			setAttributes,
			textColor,
			...columnProps
		} = this.props;

		const toolbarControls = [
			{
				icon: 'arrow-up-alt2',
				title: __('Vertical Align Top', 'genesis-blocks'),
				isActive: 'top' === attributes.columnVerticalAlignment,
				onClick: () =>
					setAttributes({ columnVerticalAlignment: 'top' }),
			},
			{
				icon: 'minus',
				title: __('Vertical Align Middle', 'genesis-blocks'),
				isActive: 'center' === attributes.columnVerticalAlignment,
				onClick: () =>
					setAttributes({ columnVerticalAlignment: 'center' }),
			},
			{
				icon: 'arrow-down-alt2',
				title: __('Vertical Align Bottom', 'genesis-blocks'),
				isActive: 'bottom' === attributes.columnVerticalAlignment,
				onClick: () =>
					setAttributes({ columnVerticalAlignment: 'bottom' }),
			},
		];

		return (
			<Fragment>
				<BlockControls key="controls">
					<AlignmentToolbar
						value={attributes.textAlign}
						onChange={(value) => {
							setAttributes({ textAlign: value });
						}}
					/>
					<ToolbarGroup controls={toolbarControls} />
				</BlockControls>
				<Inspector {...this.props} key="inspector" />
				{/* Let the shared Column wrapper own the Block API v3 root so the
					inner paragraph remains directly clickable in the editor. */}
				<Column
					blockProps={blockProps}
					/* Pass through the live color value to the Column component. */
					backgroundColorValue={backgroundColor.color}
					textColorValue={textColor.color}
					{...columnProps}
					attributes={attributes}
					key="column"
				>
					<InnerBlocks
						template={[['core/paragraph']]}
						templateLock={false}
						templateInsertUpdatesSelection={false}
					/>
				</Column>
			</Fragment>
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
