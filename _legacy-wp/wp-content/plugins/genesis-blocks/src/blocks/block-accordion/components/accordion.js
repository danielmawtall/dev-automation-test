/**
 * Accordion Wrapper
 */

// Setup the block
const { Component } = wp.element;

// Import block dependencies and components
import classnames from 'classnames';

/**
 * Create a Accordion wrapper Component
 */
export default class Accordion extends Component {
	render() {
		// Setup the attributes
		const {
			blockProps = {},
			attributes: { accordionAlignment, accordionFontSize },
		} = this.props;
		
		return (
			<div
				{...blockProps}
				className={classnames(
					blockProps.className,
					accordionAlignment
						? 'gb-align-' + accordionAlignment
						: undefined,
					'gb-block-accordion',
					accordionFontSize
						? 'gb-font-size-' + accordionFontSize
						: null
				)}
			>
				{this.props.children}
			</div>
		);
	}
}
