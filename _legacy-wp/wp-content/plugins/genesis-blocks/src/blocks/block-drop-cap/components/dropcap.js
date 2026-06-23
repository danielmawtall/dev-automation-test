// Setup the block
const { Component } = wp.element;

// Import block dependencies and components
import classnames from 'classnames';

/**
 * Create a drop cap wrapper Component
 */
export default class DropCap extends Component {
	render() {
		const {
			blockProps = {},
			attributes: {
				dropCapAlignment,
				dropCapTextColor,
				dropCapFontSize,
				dropCapStyle,
			},
		} = this.props;

		return (
			<div
				{...blockProps}
				style={{
					color: dropCapTextColor,
					textAlign: dropCapAlignment,
				}}
				className={classnames(
					blockProps.className,
					dropCapStyle,
					'gb-font-size-' + dropCapFontSize,
					'gb-block-drop-cap'
				)}
			>
				{this.props.children}
			</div>
		);
	}
}
