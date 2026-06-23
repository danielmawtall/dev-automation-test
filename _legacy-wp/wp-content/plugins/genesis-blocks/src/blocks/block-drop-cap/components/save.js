/**
 * Internal dependencies
 */
import DropCap from './dropcap';

/**
 * WordPress dependencies
 */
import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

export default function Save(props) {
	const blockProps = useBlockProps.save();

	// Save the block markup for the front end
	return (
		<DropCap {...props} blockProps={blockProps}>
			<div className="gb-drop-cap-text">
				<InnerBlocks.Content />
			</div>
		</DropCap>
	);
}
