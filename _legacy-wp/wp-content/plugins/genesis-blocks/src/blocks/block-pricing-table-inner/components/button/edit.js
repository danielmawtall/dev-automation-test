// Import block dependencies and components
import classnames from 'classnames';
import Inspector from './inspector';
import PricingButton from './button';

const { __ } = wp.i18n;
const { compose } = wp.compose;
const { Component } = wp.element;

const { RichText, useBlockProps, withFontSizes, withColors, URLInput } =
	wp.blockEditor;

const { Button, Dashicon, Icon } = wp.components;

class EditView extends Component {
	render() {
		// Setup the attributes
		const {
			attributes: {
				paddingTop,
				paddingRight,
				paddingBottom,
				paddingLeft,
				buttonText,
				buttonUrl,
				buttonAlignment,
				buttonBackgroundColor,
				buttonTextColor,
				buttonSize,
				buttonShape,
				buttonTarget,
			},
			isSelected,
			setAttributes,
			backgroundColor,
			blockProps,
		} = this.props;

		// Setup class names
		const editClassName = classnames({
			'gb-pricing-table-button': true,
		});

		// Setup styles
		const editStyles = {
			backgroundColor: backgroundColor.color,
			paddingTop: paddingTop ? paddingTop + 'px' : undefined,
			paddingRight: paddingRight ? paddingRight + 'px' : undefined,
			paddingBottom: paddingBottom ? paddingBottom + 'px' : undefined,
			paddingLeft: paddingLeft ? paddingLeft + 'px' : undefined,
		};

		return (
			<div {...blockProps}>
				{/* Show the block controls on focus. */}
				<Inspector {...this.props} />
				{/* Keep blockProps on the editor wrapper only so the nested
					button markup does not duplicate block metadata in the canvas. */}
				<PricingButton
					attributes={this.props.attributes}
					className={editClassName ? editClassName : undefined}
					styles={editStyles}
				>
					<RichText
						tagName="span"
						placeholder={__('Button text…', 'genesis-blocks')}
						value={buttonText}
						allowedFormats={[]}
						className={classnames(
							'gb-button',
							buttonShape,
							buttonSize
						)}
						style={{
							color: buttonTextColor,
							backgroundColor: buttonBackgroundColor,
						}}
						onChange={(value) =>
							setAttributes({ buttonText: value })
						}
					/>
				</PricingButton>
				{isSelected && (
					<form
						key="form-link"
						className={`blocks-button__inline-link gb-button-${buttonAlignment}`}
						onSubmit={(event) => event.preventDefault()}
						style={{
							textAlign: buttonAlignment,
						}}
					>
						<Dashicon icon={'admin-links'} />
						<URLInput
							className="button-url"
							value={buttonUrl}
							onChange={(value) =>
								setAttributes({ buttonUrl: value })
							}
							__nextHasNoMarginBottom
						/>
						<Button
							label={__('Apply', 'genesis-blocks')}
							type="submit"
						>
							<Icon icon="editor-break" />
						</Button>
					</form>
				)}
			</div>
		);
	}
}

const EditWithBlockSupport = compose([
	withFontSizes('fontSize'),
	withColors('backgroundColor', { textColor: 'color' }),
])(EditView);

/* Wrapper required for Block API v3 */
export default function Edit(props) {
	const blockProps = useBlockProps();

	return <EditWithBlockSupport {...props} blockProps={blockProps} />;
}
