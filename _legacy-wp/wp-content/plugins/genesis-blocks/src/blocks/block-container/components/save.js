/**
 * WordPress dependencies
 */
import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

/**
 * Internal dependencies
 */
import Container from './container';

export default function Save(props) {
	const blockProps = useBlockProps.save();

	// Save the block markup for the front end
	return (
		<Container {...props} blockProps={blockProps}>
			<InnerBlocks.Content />
		</Container>
	);
}
