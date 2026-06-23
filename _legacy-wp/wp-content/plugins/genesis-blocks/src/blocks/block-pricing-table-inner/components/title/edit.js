// Import block dependencies and components
import classnames from 'classnames';
import Inspector from '../global/inspector';
import Title from './title';

const { __ } = wp.i18n;
const { compose } = wp.compose;
const { Component } = wp.element;

const { useBlockProps, withFontSizes, withColors } = wp.blockEditor;

class EditView extends Component {
	render() {
		// Setup the attributes
		const {
			attributes: {
				title,
				paddingTop,
				paddingRight,
				paddingBottom,
				paddingLeft,
			},
			setAttributes,
			fontSize,
			backgroundColor,
			textColor,
			blockProps,
		} = this.props;

		// Setup class names
		const editClassName = classnames({
			'gb-pricing-table-title': true,
			[fontSize.class]: fontSize.class,
			'has-text-color': textColor.color,
			'has-background': backgroundColor.color,
			[backgroundColor.class]: backgroundColor.class,
			[textColor.class]: textColor.class,
		});

		// Setup styles
		const editStyles = {
			fontSize: fontSize.size ? fontSize.size + 'px' : undefined,
			backgroundColor: backgroundColor.color,
			color: textColor.color,
			paddingTop: paddingTop ? paddingTop + 'px' : undefined,
			paddingRight: paddingRight ? paddingRight + 'px' : undefined,
			paddingBottom: paddingBottom ? paddingBottom + 'px' : undefined,
			paddingLeft: paddingLeft ? paddingLeft + 'px' : undefined,
		};

		return (
			<div {...blockProps}>
				{/* Show the block controls on focus. */}
				<Inspector {...this.props} />
				{/* Keep blockProps on the editor wrapper only so the nested
					title markup does not duplicate block metadata in the canvas. */}
				<Title
					key={
						'gb-pricing-table-inner-component-title-' +
						this.props.clientId
					}
					placeholder={__('Price Title', 'genesis-blocks')}
					title={title}
					onChange={(value) => setAttributes({ title: value })}
					styles={editStyles}
					className={editClassName ? editClassName : undefined}
				/>
			</div>
		);
	}
}

const EditWithBlockSupport = compose([
	withFontSizes('fontSize'),
	withColors('backgroundColor', { textColor: 'color' }),
])(EditView);

/* Wrapper required for Block API v3 */
export default function Edit(props) {
	const blockProps = useBlockProps();

	return <EditWithBlockSupport {...props} blockProps={blockProps} />;
}
