/**
 * Internal dependencies
 */
import classnames from 'classnames';
import Inspector from './inspector';
import DropCap from './dropcap';

/**
 * WordPress dependencies
 */
// Internationalization
const { __ } = wp.i18n;

// Extend component
const { Component } = wp.element;

// Register editor components
const { AlignmentToolbar, BlockControls, InnerBlocks, useBlockProps } =
	wp.blockEditor;

/* Wrapper required for Block API v3 */
export default function Edit(props) {
	const blockProps = useBlockProps();

	return <EditClass {...props} blockProps={blockProps} />;
}

class EditClass extends Component {
	render() {
		// Setup the attributes
		const {
			attributes: { dropCapAlignment, dropCapFontSize },
		} = this.props;

		return (
			<DropCap key={'gb-drop-cap-' + this.props.clientId} {...this.props}>
				{/* Show the alignment toolbar on focus*/}
				<BlockControls key="controls">
					<AlignmentToolbar
						value={dropCapAlignment}
						onChange={(value) =>
							this.props.setAttributes({ dropCapAlignment: value })
						}
					/>
				</BlockControls>

				{/*Show the block controls on focus*/}
				<Inspector
					key={'gb-drop-cap-inspector-' + this.props.clientId}
					{...this.props}
				/>
					<div
						className={classnames(
							'gb-drop-cap-text',
							'gb-font-size-' + dropCapFontSize
						)}
					>
						<InnerBlocks allowedBlocks={['core/paragraph']} />
					</div>
			</DropCap>
		);
	}
}