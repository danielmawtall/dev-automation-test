/**
 * Pricing Block Wrapper
 */

// Setup the block
const { Component } = wp.element;

// Import block dependencies and components
import classnames from 'classnames';

/**
 * Create a Pricing wrapper Component
 */
export default class Pricing extends Component {
	render() {
		// Setup the attributes
		const {
			blockProps = {},
			className: wrapperClassName,
			// Gutenberg may evaluate save wrappers with partial props while it
			// extracts rich text values, so keep the wrapper tolerant here.
			attributes = {},
		} = this.props;
		const {
			columns = 2,
			align,
		} = attributes;

		// Save passes blockProps so this wrapper can become the block root.
		// Edit omits them and renders the pricing layout inside an editor wrapper.
		const className = classnames(
			blockProps.className,
			wrapperClassName,
			'gb-pricing-columns-' + columns,
			{
				['align' + align]: align,
			}
		);

		return (
			<div {...blockProps} className={className ? className : undefined}>
				{this.props.children}
			</div>
		);
	}
}
