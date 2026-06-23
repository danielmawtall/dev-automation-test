/**
 * Internal dependencies
 */
import Spacer from './spacer';

/**
 * WordPress dependencies
 */
import { useBlockProps } from '@wordpress/block-editor';

export default function Save(props) {
	const blockProps = useBlockProps.save();

	// Setup the attributes
	const { spacerHeight } = props.attributes;

	// Save the block markup for the front end
	return (
		<Spacer {...props} blockProps={blockProps}>
			<hr
				style={{
					height: spacerHeight ? spacerHeight + 'px' : undefined,
				}}
			></hr>
		</Spacer>
	);
}
