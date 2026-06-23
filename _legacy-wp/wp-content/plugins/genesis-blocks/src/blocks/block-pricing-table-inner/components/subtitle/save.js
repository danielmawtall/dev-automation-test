/**
 * Internal dependencies
 */
import classnames from 'classnames';
import Subtitle from './subtitle';

/**
 * WordPress dependencies
 */
import {
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
		subtitle,
		fontSize,
		customFontSize,
		backgroundColor,
		textColor,
		customBackgroundColor,
		customTextColor,
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

	const className = classnames({
		'has-background': backgroundColor || customBackgroundColor,
		'gb-pricing-table-subtitle': true,
		[fontSizeClass]: fontSizeClass,
		[textClass]: textClass,
		[backgroundClass]: backgroundClass,
	});

	const styles = {
		fontSize: fontSizeClass ? undefined : customFontSize,
		backgroundColor: backgroundClass
			? undefined
			: customBackgroundColor,
		color: textClass ? undefined : customTextColor,
		paddingTop: paddingTop ? `${paddingTop}px` : undefined,
		paddingRight: paddingRight ? `${paddingRight}px` : undefined,
		paddingBottom: paddingBottom ? `${paddingBottom}px` : undefined,
		paddingLeft: paddingLeft ? `${paddingLeft}px` : undefined,
	};

	// Save passes blockProps into the visual wrapper because it becomes the
	// persisted block root on the front end.
	return (
		<Subtitle
			{...props}
			blockProps={blockProps}
			subtitle={subtitle}
			styles={styles}
			className={className ? className : undefined}
			isSave={true}
		/>
	);
}
