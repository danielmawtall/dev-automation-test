/**
 * Edit component.
 */

/**
 * Import dependencies.
 */
import LayoutModal from './layout/layout-modal';
import { LayoutsContext } from './layouts-provider';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;
const { Placeholder } = wp.components;
const { Component } = wp.element;
const { BlockControls, BlockAlignmentToolbar, useBlockProps } = wp.blockEditor;

/* Wrapper required for Block API v3 */
export default function Edit(props) {
	const blockProps = useBlockProps();

	return <EditView {...props} blockProps={blockProps} />;
}

class EditView extends Component {
	render() {
		const { attributes, setAttributes, clientId, blockProps } = this.props;

		return (
			<div {...blockProps}>
				{/* Keep the placeholder modal inside the editor wrapper so the
					layout inserter satisfies the Block API v3 root contract. */}
				<BlockControls key="controls">
					<BlockAlignmentToolbar
						value={attributes.align}
						onChange={(align) => setAttributes({ align })}
						controls={[]}
					/>
				</BlockControls>
				<Placeholder
					key="placeholder"
					label={__('Layout Selector', 'genesis-blocks')}
					instructions={__(
						'Launch the layout library to browse pre-designed sections.',
						'genesis-blocks'
					)}
					className={'gb-layout-selector-placeholder'}
					icon="layout"
				>
					<LayoutsContext.Consumer
						key={'layouts-context-provider-' + clientId}
					>
						{(context) => (
							<LayoutModal
								clientId={clientId}
								context={context}
							/>
						)}
					</LayoutsContext.Consumer>
				</Placeholder>
			</div>
		);
	}
}
