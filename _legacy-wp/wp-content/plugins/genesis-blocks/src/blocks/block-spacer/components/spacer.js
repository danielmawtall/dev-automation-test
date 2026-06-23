/**
 * Button Wrapper
 */

// Setup the block
const { Component } = wp.element;

// Import block dependencies and components
import classnames from 'classnames';

/**
 * Create a Button wrapper Component
 */
export default class Spacer extends Component {
	render() {
		const {
			blockProps = {},
			attributes: {
				spacerDivider,
				spacerDividerStyle,
				spacerDividerColor,
				spacerDividerHeight,
			},
		} = this.props;

		return (
			<div
				{...blockProps}
				style={{ color: spacerDividerColor }}
				className={classnames(
					blockProps.className,
					'gb-block-spacer',
					spacerDividerStyle,
					{ 'gb-spacer-divider': spacerDivider },
					'gb-divider-size-' + spacerDividerHeight
				)}
			>
				{this.props.children}
			</div>
		);
	}
}
