/**
 * Internal dependencies.
 */
import Column from './column';

/**
 * WordPress dependencies.
 */
import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

export default function Save(props) {
	const blockProps = useBlockProps.save();

	// Gutenberg can evaluate save with partial props while it extracts editor
	// data, so keep the attribute bag defensive here.
	const { attributes = {}, ...saveProps } = props;

	return (
		<Column
			{...saveProps}
			attributes={attributes}
			blockProps={blockProps}
			/* Pass through the color attributes to the Column component. */
			backgroundColorValue={
				attributes.backgroundColor ? null : attributes.customBackgroundColor
			}
			textColorValue={
				attributes.textColor ? null : attributes.customTextColor
			}
		>
			<InnerBlocks.Content />
		</Column>
	);
}
