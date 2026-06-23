/**
 * Profile Box Wrapper
 */

/* Setup the block */
const { Component } = wp.element;

/* Import block dependencies and components */
import classnames from 'classnames';

/* Create a profile box wrapper Component */
export default class ProfileBox extends Component {
	render() {
		const {
			blockProps = {},
			attributes: {
				profileAlignment,
				profileImgURL,
				profileFontSize,
				profileBackgroundColor,
				profileTextColor,
				profileAvatarShape,
			},
		} = this.props;

		return (
			<div
				{...blockProps}
				style={{
					backgroundColor: profileBackgroundColor,
					color: profileTextColor,
				}}
				className={classnames(
					blockProps.className,
					profileAlignment,
					profileAvatarShape,
					{ 'gb-has-avatar': profileImgURL },
					'gb-font-size-' + profileFontSize,
					'gb-block-profile',
					'gb-profile-columns'
				)}
			>
				{this.props.children}
			</div>
		);
	}
}
