/**
 * Pricing Table Price Wrapper
 */

// Setup the block
const { Component } = wp.element;

// Import block dependencies and components
import classnames from 'classnames';

/**
 * Create a shared wrapper for the pricing price block.
 */
export default class Price extends Component {
	render() {
		const {
			blockProps = {},
			className,
			wrapperClassName,
			wrapperStyles,
		} = this.props;

		// Save passes blockProps so this wrapper becomes the persisted block root.
		// Edit omits them and renders the visual layout inside an editor wrapper.
		const rootClassName = classnames(
			blockProps.className,
			className,
			wrapperClassName
		);

		return (
			<div
				{...blockProps}
				className={rootClassName ? rootClassName : undefined}
				style={wrapperStyles}
			>
				<div itemProp="offers" itemScope itemType="http://schema.org/Offer">
					{this.props.children}
				</div>
			</div>
		);
	}
}
