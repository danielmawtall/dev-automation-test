/**
 * Column wrapper component.
 */

/**
 * WordPress dependencies.
 */
const { Component } = wp.element;

/**
 * Components and dependencies.
 */
import classnames from 'classnames';
import BackgroundImageClasses from './../../../utils/components/background-image/classes';
import BackgroundImageStyles from './../../../utils/components/background-image/styles';

/**
 * Create a Columns wrapper Component.
 */
export default class Columns extends Component {
	render() {
		// Gutenberg can evaluate this shared wrapper with partial props while it
		// extracts block content, so keep the attribute bag defensive here.
		const { attributes = {}, blockProps = {} } = this.props;

		/* Setup the background color class. */
		let backgroundColorClass;

		if (attributes.customBackgroundColor) {
			backgroundColorClass = 'gb-has-custom-background-color';
		} else {
			backgroundColorClass = attributes.backgroundColor
				? 'has-' + attributes.backgroundColor + '-background-color'
				: null;
		}

		/* Setup the text color class. */
		let textColorClass;

		if (attributes.customTextColor) {
			textColorClass = 'gb-has-custom-text-color';
		} else {
			textColorClass = attributes.textColor
				? 'has-' + attributes.textColor + '-color'
				: null;
		}

			/* Setup the wrapper classes. */
			// Save passes blockProps so this wrapper becomes the persisted block root.
			// Edit omits them and renders this inside the editor-only block wrapper.
			const className = classnames(
				[
					blockProps.className,
					attributes.columns
						? 'gb-layout-columns-' + attributes.columns
						: null,
					attributes.layout,
					...BackgroundImageClasses(attributes),
					backgroundColorClass,
					textColorClass,
					attributes.columnMaxWidth && attributes.centerColumns
						? 'gb-columns-center'
						: null,
				],
				{
					['align' + attributes.align]: attributes.align,
				}
			);

		/* Setup the margin styles. */
		let marginValue;

		if (attributes.marginSync) {
			marginValue = {
				marginTop:
					0 < attributes.margin
						? attributes.margin + attributes.marginUnit
						: null,
				marginBottom:
					0 < attributes.margin
						? attributes.margin + attributes.marginUnit
						: null,
			};
		} else {
			marginValue = {
				marginTop:
					0 < attributes.marginTop
						? attributes.marginTop + attributes.marginUnit
						: null,
				marginBottom:
					0 < attributes.marginBottom
						? attributes.marginBottom + attributes.marginUnit
						: null,
			};
		}

		/* Setup the padding styles. */
		let paddingValue;

		if (attributes.paddingSync) {
			paddingValue = {
				padding:
					0 < attributes.padding
						? attributes.padding + attributes.paddingUnit
						: null,
			};
		} else {
			paddingValue = {
				paddingTop:
					0 < attributes.paddingTop
						? attributes.paddingTop + attributes.paddingUnit
						: null,
				paddingRight:
					0 < attributes.paddingRight
						? attributes.paddingRight + attributes.paddingUnit
						: null,
				paddingBottom:
					0 < attributes.paddingBottom
						? attributes.paddingBottom + attributes.paddingUnit
						: null,
				paddingLeft:
					0 < attributes.paddingLeft
						? attributes.paddingLeft + attributes.paddingUnit
						: null,
			};
		}

		/* Misc styles. */
		const styles = {
			backgroundColor: this.props.backgroundColorValue
				? this.props.backgroundColorValue
				: null,
			color: this.props.textColorValue ? this.props.textColorValue : null,
			...BackgroundImageStyles(attributes),
		};

		return (
			<div
				{...blockProps}
				className={className ? className : undefined}
				style={Object.assign(marginValue, paddingValue, styles)}
			>
				{this.props.children}
			</div>
		);
	}
}
