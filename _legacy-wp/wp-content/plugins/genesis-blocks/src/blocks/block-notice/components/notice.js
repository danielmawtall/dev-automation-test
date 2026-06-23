/**
 * Notice Box Wrapper
 */

// Setup the block
const { Component } = wp.element;

// Import block dependencies and components
import classnames from 'classnames';
import generateUniqueID from '../../../utils/helpers/generate-unique-id';

/**
 * Create a Notice wrapper Component
 */
export default class NoticeBox extends Component {
	render() {
		// Setup the attributes
		const {
			blockProps,
			attributes: {
				noticeTitle,
				noticeAlignment,
				noticeBackgroundColor,
				noticeTextColor,
				noticeFontSize,
				noticeDismiss,
			},
		} = this.props;

		// Generate a unique ID for the dismissible notice
		const blockID = generateUniqueID(noticeDismiss + noticeTitle);

		// Merge blockProps (editor tracking attrs + className) with the
		// block's own visual styles. blockProps is undefined in the save
		// path before useBlockProps.save() is called, so default to {}.
		const { className: blockPropsClassName, ...restBlockProps } = blockProps || {};

		return (
			<div
				{...restBlockProps}
				style={{
					color: noticeTextColor,
					textAlign: noticeAlignment,
					backgroundColor: noticeBackgroundColor,
				}}
				className={classnames(
					blockPropsClassName,
					noticeDismiss,
					'gb-font-size-' + noticeFontSize,
					'gb-block-notice'
				)}
				data-id={blockID}
			>
				{this.props.children}
			</div>
		);
	}
}
