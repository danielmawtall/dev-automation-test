/**
 * Internal dependencies
 */
import Description from './description';

/**
 * WordPress dependencies
 */
import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

const ALLOWED_BLOCKS = ['core/list'];

/* Wrapper required for Block API v3 */
export default function Edit() {
	const blockProps = useBlockProps();

	return (
		<div {...blockProps}>
			{/* Keep blockProps on the editor wrapper only so the nested features
				markup does not duplicate block metadata in the canvas. */}
			<Description>
				<InnerBlocks allowedBlocks={ALLOWED_BLOCKS} />
			</Description>
		</div>
	);
}
