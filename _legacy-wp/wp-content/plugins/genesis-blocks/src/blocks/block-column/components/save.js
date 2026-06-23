/**
 * External dependencies.
 */
import classnames from 'classnames';
import Columns from './column-wrap';

/**
 * WordPress dependencies.
 */
import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

export default function Save(props) {
	const blockProps = useBlockProps.save();

	// Gutenberg can evaluate save with partial props while it extracts editor
	// data, so keep the attribute bag defensive here.
	const { attributes = {}, ...saveProps } = props;

	const className = classnames([
		'gb-layout-column-wrap',
		'gb-block-layout-column-gap-' + attributes.columnsGap,
		attributes.responsiveToggle ? 'gb-is-responsive-column' : null,
	]);

	// Save passes blockProps into the visual wrapper because it becomes the
	// persisted block root on the front end.
	return (
		<Columns
			{...saveProps}
			// Keep the full attribute bag on the shared wrapper so the saved
			// layout classes match the selected column configuration.
			attributes={attributes}
			blockProps={blockProps}
			/* Pass through the color attributes to the Columns component. */
			backgroundColorValue={
				attributes.backgroundColor
					? null
					: attributes.customBackgroundColor
			}
			textColorValue={
				attributes.textColor ? null : attributes.customTextColor
			}
		>
			<div
				className={className ? className : undefined}
				style={{
					maxWidth: attributes.columnMaxWidth
						? attributes.columnMaxWidth
						: null,
				}}
			>
				<InnerBlocks.Content />
			</div>
		</Columns>
	);
}
