/**
 * Pricing Table Subtitle Wrapper
 */

/**
 * Internal dependencies
 */
import classnames from 'classnames';

/**
 * WordPress dependencies
 */
import { RichText } from '@wordpress/block-editor';

export default function Subtitle(props) {
	const {
		blockProps = {},
		className,
		placeholder,
		subtitle,
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
				value={subtitle}
				style={styles}
				className={rootClassName ? rootClassName : undefined}
			/>
		);
	}

	return (
		<RichText
			tagName="div"
			placeholder={placeholder}
			value={subtitle}
			onChange={onChange}
			style={styles}
			className={rootClassName ? rootClassName : undefined}
		/>
	);
}
