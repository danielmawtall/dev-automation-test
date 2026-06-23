/**
 * Internal dependencies
 */
import classnames from 'classnames';
import Inspector from './inspector';
import DismissButton from './button';
import icons from './icons';
import NoticeBox from './notice';

/**
 * WordPress dependencies
 */
// Internationalization
const { __ } = wp.i18n;

// Extend component
const { Component } = wp.element;

// Register editor components
const { RichText, AlignmentToolbar, BlockControls, InnerBlocks, useBlockProps } =
	wp.blockEditor;

/* Wrapper required for Block API v3 */
export default function Edit(props) {
	const blockProps = useBlockProps();

	return <EditClass {...props} blockProps={blockProps} />;
}

class EditClass extends Component {
	render() {
		// Setup the attributes
		const {
			attributes: {
				noticeTitle,
				noticeAlignment,
				noticeBackgroundColor,
				noticeTitleColor,
				noticeDismiss,
			},
			setAttributes,
		} = this.props;

		return (
			<NoticeBox
				key={'gb-notice-noticebox-' + this.props.clientId}
				{...this.props}
			>
				{/*Show the alignment toolbar on focus*/}
				<BlockControls key="controls">
					<AlignmentToolbar
						value={noticeAlignment}
						onChange={(value) =>
							setAttributes({ noticeAlignment: value })
						}
					/>
				</BlockControls>

				{/*Show the block controls on focus*/}
				<Inspector
					key={'gb-notice-inspector-' + this.props.clientId}
					{...{ setAttributes, ...this.props }}
				/>

				{
					// Check if the notice is dismissible and output the button
					noticeDismiss && 'gb-dismissable' === noticeDismiss && (
						<DismissButton {...this.props}>
							{icons.dismiss}
						</DismissButton>
					)
				}

				<RichText
					tagName="p"
					placeholder={__('Notice Title', 'genesis-blocks')}
					value={noticeTitle}
					className={classnames('gb-notice-title')}
					style={{
						color: noticeTitleColor,
					}}
					onChange={(value) => setAttributes({ noticeTitle: value })}
				/>

				<div
					className="gb-notice-text"
					style={{
						borderColor: noticeBackgroundColor,
					}}
				>
					<InnerBlocks />
				</div>
			</NoticeBox>
		);
	}
}
