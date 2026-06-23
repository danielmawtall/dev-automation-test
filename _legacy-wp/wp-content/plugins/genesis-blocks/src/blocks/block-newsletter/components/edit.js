/**
 * External dependencies
 */
import classnames from 'classnames';

/**
 * Internal dependencies
 */
import Inspector from './inspector';
import NewsletterContainer from './newsletter';
import CustomButton from './../../block-button/components/button';

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { compose, withInstanceId } = wp.compose;
const { RichText, useBlockProps, withColors } = wp.blockEditor;
const { Fragment, Component } = wp.element;
const { TextControl, withFallbackStyles } = wp.components;

/* Apply fallback styles. */
const applyFallbackStyles = withFallbackStyles((node, ownProps) => {
	const { backgroundColor, textColor, buttonBackgroundColor } =
		ownProps.attributes;
	const editableNode = node.querySelector('[contenteditable="true"]');
	const computedStyles = editableNode ? getComputedStyle(editableNode) : null;
	return {
		fallbackBackgroundColor:
			backgroundColor || !computedStyles
				? undefined
				: computedStyles.backgroundColor,
		fallbackTextColor:
			textColor || !computedStyles ? undefined : computedStyles.color,
		fallbackButtonBackgroundColor:
			buttonBackgroundColor || !computedStyles
				? undefined
				: computedStyles.buttonBackgroundColor,
	};
});

class EditClass extends Component {
	constructor() {
		super(...arguments);

		// Keep the email field interactive in the editor without persisting the
		// typed preview value as a block attribute.
		this.state = {
			previewEmailAddress: '',
		};

		this.props.setAttributes({ instanceId: this.props.instanceId });
	}

	render() {
		const { blockProps } = this.props;
		const newsletterProps = { ...this.props };

		const {
			attributes,
			isSelected,
			setAttributes,
			buttonBackgroundColor,
			buttonTextColor,
		} = this.props;

		const apiKeyDefined =
			genesis_blocks_newsletter_block_vars.mailingListProviders.mailchimp
				.api_key_defined;

		/* Setup button background color class */
		let buttonBackgroundColorClass;

		if (attributes.customButtonBackgroundColor) {
			buttonBackgroundColorClass = 'gb-has-custom-background-color';
		} else {
			buttonBackgroundColorClass = attributes.buttonBackgroundColor
				? `has-${attributes.buttonBackgroundColor}-background-color`
				: null;
		}

		/* Setup button text color class */
		let buttonTextColorClass;

		if (attributes.customButtonTextColor) {
			buttonTextColorClass = 'gb-has-custom-text-color';
		} else {
			buttonTextColorClass = attributes.buttonTextColor
				? 'has-' + attributes.buttonTextColor + '-color'
				: null;
		}

		return (
			<div {...blockProps}>
				<Inspector
					key={'gb-newsletter-inspector-' + this.props.clientId}
					{...{ setAttributes, ...this.props }}
				/>
				{/* Keep blockProps on the outer editor wrapper only so the visual
					newsletter form does not duplicate block metadata in the canvas. */}
				<NewsletterContainer
					key={'gb-newsletter-container-' + this.props.clientId}
					{...newsletterProps}
					className={undefined}
				>
					{!apiKeyDefined && (
						<Fragment>
							<div className="gb-newsletter-notice">
								{__(
									'You must define your newsletter provider API keys to use this block.',
									'genesis-blocks'
								)}
								<p>
									<a
										href={
											genesis_blocks_newsletter_block_vars.plugin_settings_page_url
										}
										target="_blank"
										rel="noopener noreferrer"
									>
										{__(
											'Configure your settings',
											'genesis-blocks'
										)}
									</a>
								</p>
							</div>
						</Fragment>
					)}
					{apiKeyDefined && (
						<Fragment>
							<RichText
								tagName="span"
								className="gb-block-newsletter-label"
								allowedFormats={[]}
								value={attributes.emailInputLabel}
								onChange={(value) =>
									this.props.setAttributes({
										emailInputLabel: value,
									})
								}
							/>

							<TextControl
								__next40pxDefaultSize
								__nextHasNoMarginBottom
								name="gb-newsletter-email-address"
								type="email"
								value={this.state.previewEmailAddress}
								// This field is only a visual preview inside the editor, so
								// keep its typed value in local component state instead of
								// saving it to block attributes.
								onChange={(previewEmailAddress) =>
									this.setState({ previewEmailAddress })
								}
							/>

							<div className={classnames('gb-block-button')}>
								<CustomButton {...this.props}>
									<RichText
										tagName="span"
										placeholder={__(
											'Button text…',
											'genesis-blocks'
										)}
										value={attributes.buttonText}
										allowedFormats={[]}
										className={classnames(
											'gb-button',
											attributes.buttonClass,
											attributes.buttonShape,
											attributes.buttonSize,
											buttonBackgroundColorClass,
											buttonTextColorClass,
											{
												'has-background':
													attributes.buttonBackgroundColor ||
													attributes.customButtonBackgroundColor,
												'has-text-color':
													attributes.buttonTextColor ||
													attributes.customButtonTextColor,
											}
										)}
										style={{
											backgroundColor:
												buttonBackgroundColor.color,
											color: buttonTextColor.color,
										}}
										onChange={(value) =>
											this.props.setAttributes({
												buttonText: value,
											})
										}
									/>
								</CustomButton>
								{isSelected && (
									<form
										key="form-link"
										className={`blocks-button__inline-link gb-button-${attributes.buttonAlignment}`}
										onSubmit={(event) =>
											event.preventDefault()
										}
										style={{
											textAlign:
												attributes.buttonAlignment,
										}}
									></form>
								)}
							</div>
						</Fragment>
					)}
				</NewsletterContainer>
			</div>
		);
	}
}

const EditWithBlockSupport = compose([
	applyFallbackStyles,
	withColors(
		'backgroundColor',
		{ textColor: 'color' },
		{ buttonBackgroundColor: 'background-color' },
		{ buttonTextColor: 'color' }
	),
])(withInstanceId(EditClass));

/* Wrapper required for Block API v3 */
export default function Edit(props) {
	const blockProps = useBlockProps();

	return <EditWithBlockSupport {...props} blockProps={blockProps} />;
}
