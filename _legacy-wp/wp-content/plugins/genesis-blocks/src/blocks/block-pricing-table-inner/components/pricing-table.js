/**
 * Pricing Table Inner Block Wrapper
 */

// Setup the block
const { Component } = wp.element;

// Import block dependencies and components
import classnames from 'classnames';

/**
 * Create a pricing column wrapper component.
 */
export default class PricingTable extends Component {
	render() {
		// Gutenberg can evaluate save wrappers with partial props while it
		// extracts editor data, so keep the attribute bag defensive here.
		const {
			blockProps = {},
			className: wrapperClassName,
			attributes = {},
		} = this.props;
		const {
			borderWidth = 2,
			borderColor,
			borderRadius = 0,
			backgroundColor,
			padding,
			alignment,
		} = attributes;

		const styles = {
			borderWidth: borderWidth ? borderWidth : undefined,
			borderStyle: 0 < borderWidth ? 'solid' : undefined,
			borderColor: borderColor ? borderColor : undefined,
			borderRadius: borderRadius ? borderRadius : undefined,
			backgroundColor: backgroundColor ? backgroundColor : undefined,
			padding: padding ? `${padding}%` : undefined,
		};

		// Save passes blockProps so this wrapper can become the persisted root.
		// Edit omits them and renders the visual layout inside an editor wrapper.
		const className = classnames(
			blockProps.className,
			wrapperClassName,
			alignment
				? `gb-block-pricing-table-${alignment}`
				: 'gb-block-pricing-table-center',
			'gb-block-pricing-table'
		);

		return (
			<div
				{...blockProps}
				className={className}
				itemScope
				itemType="http://schema.org/Product"
			>
				<div className="gb-block-pricing-table-inside" style={styles}>
					{this.props.children}
				</div>
			</div>
		);
	}
}
