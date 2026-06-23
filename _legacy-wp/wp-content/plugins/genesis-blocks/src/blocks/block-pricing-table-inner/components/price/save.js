/**
 * Internal dependencies
 */
import classnames from 'classnames';
import Price from './price';

/**
 * WordPress dependencies
 */
import {
	RichText,
	getColorClassName,
	getFontSizeClass,
	useBlockProps,
} from '@wordpress/block-editor';

export default function Save(props) {
	const blockProps = useBlockProps.save();

	// Gutenberg can evaluate save with partial props while it extracts editor
	// data, so keep the attribute bag defensive here.
	const { attributes = {} } = props;
	const {
		price,
		currency,
		fontSize,
		customFontSize = 60,
		backgroundColor,
		textColor,
		customBackgroundColor,
		customTextColor,
		term,
		showTerm = true,
		showCurrency = true,
		paddingTop = 10,
		paddingRight = 20,
		paddingBottom = 10,
		paddingLeft = 20,
	} = attributes;

	// Recreate the saved classnames from stored attribute values.
	const fontSizeClass = getFontSizeClass(fontSize);
	const textClass = getColorClassName('color', textColor);
	const backgroundClass = getColorClassName(
		'background-color',
		backgroundColor
	);

	const wrapperClassName = classnames({
		'has-background': backgroundColor || customBackgroundColor,
		'gb-pricing-table-price-wrap': true,
		[textClass]: textClass,
		[backgroundClass]: backgroundClass,
		'gb-pricing-has-currency': showCurrency && currency,
	});

	const priceClassName = classnames({
		'gb-pricing-table-price': true,
		[fontSizeClass]: fontSizeClass,
	});

	const wrapperStyles = {
		backgroundColor: backgroundClass
			? undefined
			: customBackgroundColor,
		color: textClass ? undefined : customTextColor,
		paddingTop: paddingTop ? `${paddingTop}px` : undefined,
		paddingRight: paddingRight ? `${paddingRight}px` : undefined,
		paddingBottom: paddingBottom ? `${paddingBottom}px` : undefined,
		paddingLeft: paddingLeft ? `${paddingLeft}px` : undefined,
	};

	const priceStyles = {
		fontSize: fontSizeClass ? undefined : customFontSize,
	};

	const computedFontSize = fontSizeClass ? undefined : customFontSize;
	const currencySize = Math.floor(computedFontSize / 2.5);
	const currencyStyles = {
		fontSize: computedFontSize ? `${currencySize}px` : undefined,
	};

	const termSize = Math.floor(computedFontSize / 2.5);
	const termStyles = {
		fontSize: computedFontSize ? `${termSize}px` : undefined,
	};

	// Save passes blockProps into the visual wrapper because it becomes the
	// persisted block root on the front end.
	return (
		<Price
			{...props}
			blockProps={blockProps}
			wrapperClassName={wrapperClassName}
			wrapperStyles={wrapperStyles}
		>
			{currency && showCurrency && (
				<RichText.Content
					tagName="span"
					itemProp="priceCurrency"
					value={currency}
					className="gb-pricing-table-currency"
					style={currencyStyles}
				/>
			)}
			<RichText.Content
				tagName="div"
				itemProp="price"
				value={price}
				className={priceClassName ? priceClassName : undefined}
				style={priceStyles}
			/>
			{term && showTerm && (
				<RichText.Content
					tagName="span"
					value={term}
					className="gb-pricing-table-term"
					style={termStyles}
				/>
			)}
		</Price>
	);
}
