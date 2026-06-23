/**
 * Testimonial Block Wrapper
 */

// Setup the block
const { Component } = wp.element;

// Import block dependencies and components
import classnames from 'classnames';

/**
 * Create a Testimonial wrapper Component
 */
export default class Testimonial extends Component {
	render() {
		// Setup the attributes
		const {
			blockProps = {},
			attributes: {
				testimonialImgURL,
				testimonialBackgroundColor,
				testimonialTextColor,
				testimonialFontSize,
				testimonialCiteAlign,
			},
		} = this.props;

		return (
			<div
				{...blockProps}
				style={{
					backgroundColor: testimonialBackgroundColor
						? testimonialBackgroundColor
						: '#f2f2f2',
					color: testimonialTextColor
						? testimonialTextColor
						: '#32373c',
				}}
				className={classnames(
					blockProps.className,
					testimonialCiteAlign,
					{ 'gb-has-avatar': testimonialImgURL },
					'gb-font-size-' + testimonialFontSize,
					'gb-block-testimonial'
				)}
			>
				{this.props.children}
			</div>
		);
	}
}
