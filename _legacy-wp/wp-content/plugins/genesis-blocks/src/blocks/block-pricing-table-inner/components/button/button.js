/**
 * Pricing Table Button Wrapper
 */

/**
 * Internal dependencies
 */
import classnames from 'classnames';
import CustomButton from './../../../block-button/components/button';

export default function PricingButton(props) {
	const {
		attributes = {},
		blockProps = {},
		className,
		children,
		styles,
	} = props;

	// Save passes blockProps so this wrapper becomes the persisted block root.
	// Edit omits them and renders this inside the editor-only block wrapper.
	const rootClassName = classnames(blockProps.className, className);

	return (
		<div
			{...blockProps}
			className={rootClassName ? rootClassName : undefined}
			style={styles}
		>
			<CustomButton attributes={attributes}>{children}</CustomButton>
		</div>
	);
}
