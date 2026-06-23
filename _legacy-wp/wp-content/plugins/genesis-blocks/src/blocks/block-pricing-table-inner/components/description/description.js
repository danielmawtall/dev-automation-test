/**
 * Pricing Table Features Wrapper
 */

/**
 * Internal dependencies
 */
import classnames from 'classnames';

export default function Description(props) {
	const { blockProps = {}, className, children } = props;

	// Save passes blockProps so this wrapper becomes the persisted block root.
	// Edit omits them and renders this inside the editor-only block wrapper.
	const rootClassName = classnames(blockProps.className, className);

	return (
		<div
			{...blockProps}
			className={rootClassName ? rootClassName : undefined}
			itemProp="description"
		>
			{children}
		</div>
	);
}
