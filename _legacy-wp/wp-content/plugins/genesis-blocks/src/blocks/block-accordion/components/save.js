// Import block dependencies and components
import Accordion from './accordion';

/**
 * WordPress dependencies
 */
const { Component } = wp.element;
const { RichText, InnerBlocks, useBlockProps } = wp.blockEditor;

export default class Save extends Component {
	render() {
		const blockProps = useBlockProps.save();

		return (
			<Accordion {...this.props} blockProps={blockProps}>
				<details open={this.props.attributes.accordionOpen}>
					<summary className="gb-accordion-title">
						<RichText.Content
							value={this.props.attributes.accordionTitle}
						/>
					</summary>
					<div className="gb-accordion-text">
						<InnerBlocks.Content />
					</div>
				</details>
			</Accordion>
		);
	}
}
