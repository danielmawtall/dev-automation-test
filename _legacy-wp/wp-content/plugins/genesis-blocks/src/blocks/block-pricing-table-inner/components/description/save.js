/**
 * Internal dependencies
 */
import Description from './description';

/**
 * WordPress dependencies
 */
import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

export default function Save(props) {
	const blockProps = useBlockProps.save();

	// Save passes blockProps into the visual wrapper because it becomes the
	// persisted block root on the front end.
	return (
		<Description {...props} blockProps={blockProps}>
			<InnerBlocks.Content />
		</Description>
	);
}
