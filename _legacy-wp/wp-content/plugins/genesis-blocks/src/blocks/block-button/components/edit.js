/**
 * Internal dependencies
 */
import { useDispatch, useSelect } from '@wordpress/data';
import { useEffect } from '@wordpress/element';

import createButton from '../deprecated/create-button';

export default function Edit({ attributes, clientId }) {
	const { replaceBlocks, replaceInnerBlocks } =
		useDispatch('core/block-editor');
	const { getBlock, getBlockParents } = useSelect((select) =>
		select('core/block-editor')
	);

	useEffect(() => {
		const parentId = getBlockParents(clientId, true)?.[0];
		const hasParent = !!parentId;

		// Replace this GB Button block with the Core Button block.
		if (hasParent) {
			replaceInnerBlocks(
				parentId,
				getBlock(parentId).innerBlocks?.map((block) => {
					return block.clientId === clientId
						? createButton(attributes)
						: block;
				})
			);
		} else {
			replaceBlocks(clientId, createButton(attributes));
		}
	}, [clientId]); // eslint-disable-line react-hooks/exhaustive-deps

	return null;
}
