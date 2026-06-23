/**
 * Internal dependencies
 */
import classnames from 'classnames';
import PricingButton from './button';

/**
 * WordPress dependencies
 */
import {
	getColorClassName,
	RichText,
	useBlockProps,
} from '@wordpress/block-editor';

export default function Save(props) {
	const blockProps = useBlockProps.save();

	// Gutenberg can evaluate save with partial props while it extracts editor
	// data, so keep the attribute bag defensive here.
	const { attributes = {} } = props;
	const {
		backgroundColor,
		customBackgroundColor,
		paddingTop = 10,
		paddingRight = 20,
		paddingBottom = 10,
		paddingLeft = 20,
		buttonText,
		buttonUrl,
		buttonBackgroundColor = '#3373dc',
		buttonTextColor = '#ffffff',
		buttonSize = 'gb-button-size-medium',
		buttonShape = 'gb-button-shape-rounded',
		buttonTarget = false,
	} = attributes;

	const backgroundClass = getColorClassName(
		'background-color',
		backgroundColor
	);

	// Recreate the saved classnames from stored attribute values.
	const className = classnames({
		'has-background': backgroundColor || customBackgroundColor,
		'gb-pricing-table-button': true,
		[backgroundClass]: backgroundClass,
	});

	const styles = {
		backgroundColor: backgroundClass
			? undefined
			: customBackgroundColor,
		paddingTop: paddingTop ? `${paddingTop}px` : undefined,
		paddingRight: paddingRight ? `${paddingRight}px` : undefined,
		paddingBottom: paddingBottom ? `${paddingBottom}px` : undefined,
		paddingLeft: paddingLeft ? `${paddingLeft}px` : undefined,
	};

	// Save passes blockProps into the visual wrapper because it becomes the
	// persisted block root on the front end.
	return (
		<PricingButton
			attributes={attributes}
			blockProps={blockProps}
			className={className ? className : undefined}
			styles={styles}
		>
			{buttonText && (
				<a
					href={buttonUrl}
					target={buttonTarget ? '_blank' : null}
					rel={buttonTarget ? 'noopener noreferrer' : null}
					className={classnames(
						'gb-button',
						buttonShape,
						buttonSize
					)}
					style={{
						color: buttonTextColor,
						backgroundColor: buttonBackgroundColor,
					}}
				>
					<RichText.Content value={buttonText} />
				</a>
			)}
		</PricingButton>
	);
}
