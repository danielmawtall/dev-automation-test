/**
 * Internal dependencies
 */
import NoticeBox from './notice';
import icons from './icons';

/**
 * WordPress dependencies
 */
import { RichText, InnerBlocks, useBlockProps } from '@wordpress/block-editor';
import DismissButton from './button';

export default function Save(props) {
	const blockProps = useBlockProps.save();

	// Setup the attributes
	const {
		noticeTitle,
		noticeBackgroundColor,
		noticeTitleColor,
		noticeDismiss,
	} = props.attributes;

	// Save the block markup for the front end
	return (
		<NoticeBox {...props} blockProps={blockProps}>
			{noticeDismiss && 'gb-dismissable' === noticeDismiss && (
				<DismissButton {...props}>{icons.dismiss}</DismissButton>
			)}

			{noticeTitle && (
				<div
					className="gb-notice-title"
					style={{
						color: noticeTitleColor,
					}}
				>
					<RichText.Content tagName="p" value={noticeTitle} />
				</div>
			)}

			<div
				className="gb-notice-text"
				style={{
					borderColor: noticeBackgroundColor,
				}}
			>
				<InnerBlocks.Content />
			</div>
		</NoticeBox>
	);
}