/**
 * Internal dependencies
 */
import Inspector from './inspector';
import Accordion from './accordion';

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { Component } = wp.element;
const { RichText, AlignmentToolbar, BlockControls, InnerBlocks, useBlockProps } =
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
			attributes: { accordionTitle, accordionAlignment, accordionFontSize },
			setAttributes,
		} = this.props;
		
		return (
			<Accordion
				key={'gb-accordion-' + this.props.clientId}
				{...this.props}
			>
				{/* Show the block alignment controls on focus*/}
				<BlockControls key="controls">
					<AlignmentToolbar
						value={accordionAlignment}
						onChange={(value) =>
							setAttributes({accordionAlignment: value})
						}
					/>
				</BlockControls>

				{/* Show the block controls on focus*/}
				<Inspector
					key={'gb-accordion-inspector-' + this.props.clientId}
					{...this.props}
				/>
					<RichText
						tagName="p"
						placeholder={__('Accordion Title', 'genesis-blocks')}
						value={accordionTitle}
						className="gb-accordion-title"
						onChange={(value) =>
							setAttributes({accordionTitle: value})
						}
					/>
	
					<div className="gb-accordion-text">
						<InnerBlocks />
					</div>
			</Accordion>
		);
	}
}
