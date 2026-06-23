/**
 * Internal dependencies
 */
import Inspector from './inspector';
import Container from './container';

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { Component } = wp.element;
const { InnerBlocks, useBlockProps } = wp.blockEditor;

/* Wrapper required for Block API v3 */
export default function Edit(props) {
	const blockProps = useBlockProps();

	return <EditClass {...props} blockProps={blockProps} />;
}

class EditClass extends Component {
	render() {
		// Setup the attributes
		const { setAttributes, blockProps, ...containerProps } = this.props;

		return (
			<div {...blockProps}>
				{/* Show the block controls on focus*/}
				<Inspector
					key={'gb-container-inspector-' + this.props.clientId}
					{...{ setAttributes, ...this.props }}
				/>

				{/* Show the container markup in the editor*/}
				<Container
					key={'gb-container-' + this.props.clientId}
					{...containerProps}
				>
					<InnerBlocks />
				</Container>
			</div>
		);
	}
}
