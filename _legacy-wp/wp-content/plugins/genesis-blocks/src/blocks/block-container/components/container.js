/**
 * Container wrapper
 */

// Setup the block
const { Component } = wp.element;

// Import block dependencies and components
import classnames from 'classnames';

/**
 * Create a Button wrapper Component
 * It now accepts blockProps so the root element can use Block API v3.
 */
export default class Container extends Component {
	render() {
		// Setup the attributes
		const {
			attributes: {
				containerBackgroundColor,
				containerAlignment,
				containerPaddingTop,
				containerPaddingRight,
				containerPaddingBottom,
				containerPaddingLeft,
				containerMarginTop,
				containerMarginBottom,
				containerWidth,
				containerMaxWidth,
				containerImgURL,
				containerImgAlt,
				containerDimRatio,
			},
			blockProps = {},
		} = this.props;

		const styles = {
			backgroundColor: containerBackgroundColor
				? containerBackgroundColor
				: undefined,
			textAlign: containerAlignment ? containerAlignment : undefined,
			paddingLeft: containerPaddingLeft
				? `${containerPaddingLeft}%`
				: undefined,
			paddingRight: containerPaddingRight
				? `${containerPaddingRight}%`
				: undefined,
			paddingBottom: containerPaddingBottom
				? `${containerPaddingBottom}%`
				: undefined,
			paddingTop: containerPaddingTop
				? `${containerPaddingTop}%`
				: undefined,
			marginTop: containerMarginTop
				? `${containerMarginTop}%`
				: undefined,
			marginBottom: containerMarginBottom
				? `${containerMarginBottom}%`
				: undefined,
		};

		const className = classnames(
			blockProps.className,
			'gb-block-container',
			{
				['align' + containerWidth]: containerWidth,
			}
		);

		return (
			<div {...blockProps} style={styles} className={className}>
				<div className="gb-container-inside">
					{containerImgURL && !!containerImgURL.length && (
						<div className="gb-container-image-wrap">
							<img
								className={classnames(
									'gb-container-image',
									dimRatioToClass(containerDimRatio),
									{
										'has-background-dim':
											0 !== containerDimRatio,
									}
								)}
								src={containerImgURL}
								alt={containerImgAlt}
							/>
						</div>
					)}

					<div
						className="gb-container-content"
						style={{
							maxWidth: containerMaxWidth
								? `${containerMaxWidth}px`
								: undefined,
						}}
					>
						{this.props.children}
					</div>
				</div>
			</div>
		);
	}
}

function dimRatioToClass(ratio) {
	return 0 === ratio || 50 === ratio
		? null
		: `has-background-dim-${10 * Math.round(ratio / 10)}`;
}
