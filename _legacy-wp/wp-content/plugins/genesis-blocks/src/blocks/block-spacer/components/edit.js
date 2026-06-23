/**
 * Internal dependencies
 */
import classnames from 'classnames';
import Inspector from './inspector';
import Spacer from './spacer';
import { Resizable } from 're-resizable';

/**
 * WordPress dependencies
 */
// Internationalization
const { __ } = wp.i18n;

// Extend component
const { Component } = wp.element;

// Register editor components
const { useBlockProps } = wp.blockEditor;

/* Wrapper required for Block API v3 */
export default function Edit(props) {
	const blockProps = useBlockProps();

	return <EditClass {...props} blockProps={blockProps} />;
}

class EditClass extends Component {
	render() {
		// Setup the attributes
		const {
			attributes: { spacerHeight, spacerDividerColor },
			className,
			setAttributes,
			toggleSelection,
		} = this.props;

		return (
			<Spacer
				key={'gb-spacer-editor-' + this.props.clientId}
				{...this.props}
			>
				{/* Show the block controls on focus*/}
				<Inspector
					key={'gb-spacer-inspector-' + this.props.clientId}
					{...this.props}
				/>
					<Resizable
						className={classnames(className, 'gb-spacer-handle')}
						style={{
							color: spacerDividerColor,
						}}
						size={{
							width: '100%',
							height: spacerHeight,
						}}
						minWidth={'100%'}
						maxWidth={'100%'}
						minHeight={'100%'}
						handleClasses={{
							bottomLeft: 'gb-spacer-control__resize-handle',
						}}
						enable={{
							top: false,
							right: false,
							bottom: true,
							left: false,
							topRight: false,
							bottomRight: false,
							bottomLeft: true,
							topLeft: false,
						}}
						onResizeStart={() => {
							toggleSelection(false);
						}}
						onResizeStop={(event, direction, elt, delta) => {
							setAttributes({
								spacerHeight: parseInt(
									spacerHeight + delta.height,
									10
								),
							});
							toggleSelection(true);
						}}
					></Resizable>
			</Spacer>
		);
	}
}
