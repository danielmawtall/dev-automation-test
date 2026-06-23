/**
 * Pricing Table Title Wrapper
 */

/**
 * Internal dependencies
 */
import classnames from 'classnames';

/**
 * WordPress dependencies
 */
import { RichText } from '@wordpress/block-editor';

export default function Title(props) {
	const {
		blockProps = {},
		className,
		placeholder,
		title,
		styles,
		onChange,
		isSave = false,
	} = props;

	// Save passes blockProps so this wrapper becomes the persisted block root.
	// Edit omits them and renders this inside the editor-only block wrapper.
	const rootClassName = classnames(blockProps.className, className);

	if (isSave) {
		return (
			<RichText.Content
				{...blockProps}
				tagName="div"
				itemProp="name"
				value={title}
				style={styles}
				className={rootClassName ? rootClassName : undefined}
			/>
		);
	}

	return (
		<RichText
			tagName="div"
			itemProp="name"
			placeholder={placeholder}
			value={title}
			onChange={onChange}
			style={styles}
			className={rootClassName ? rootClassName : undefined}
		/>
	);
}
