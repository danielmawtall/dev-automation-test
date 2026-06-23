const { __ } = wp.i18n;
const { Fragment } = wp.element;
const { RangeControl } = wp.components;

export default function Margin(props) {
	const {
		// Margin top props
		marginTop,
		marginTopLabel,
		marginTopMin,
		marginTopMax,
		marginEnableTop,
		onChangeMarginTop = () => {},

		// Margin right props
		marginRight,
		marginRightLabel,
		marginRightMin,
		marginRightMax,
		marginEnableRight,
		onChangeMarginRight = () => {},

		// Margin bottom props
		marginBottom,
		marginBottomLabel,
		marginBottomMin,
		marginBottomMax,
		marginEnableBottom,
		onChangeMarginBottom = () => {},

		// Margin left props
		marginLeft,
		marginLeftLabel,
		marginLeftMin,
		marginLeftMax,
		marginEnableLeft,
		onChangeMarginLeft = () => {},

		// Margin vertical props
		marginVertical,
		marginVerticalLabel,
		marginEnableVertical,
		marginVerticalMin,
		marginVerticalMax,
		onChangeMarginVertical = () => {},

		// Margin horizontal props
		marginHorizontal,
		marginHorizontalLabel,
		marginEnableHorizontal,
		marginHorizontalMin,
		marginHorizontalMax,
		onChangeMarginHorizontal = () => {},
	} = props;

	const rangeProps = {
		__next40pxDefaultSize: true,
		__nextHasNoMarginBottom: true,
	};

	return (
		<Fragment>
			{marginEnableTop && (
				<RangeControl
					{...rangeProps}
					label={
						marginTopLabel
							? marginTopLabel
							: __('Margin Top', 'genesis-blocks')
					}
					value={marginTop}
					min={marginTopMin}
					max={marginTopMax}
					onChange={onChangeMarginTop}
				/>
			)}
			{marginEnableRight && (
				<RangeControl
					{...rangeProps}
					label={
						marginRightLabel
							? marginRightLabel
							: __('Margin Right', 'genesis-blocks')
					}
					value={marginRight}
					min={marginRightMin}
					max={marginRightMax}
					onChange={onChangeMarginRight}
				/>
			)}
			{marginEnableBottom && (
				<RangeControl
					{...rangeProps}
					label={
						marginBottomLabel
							? marginBottomLabel
							: __('Margin Bottom', 'genesis-blocks')
					}
					value={marginBottom}
					min={marginBottomMin}
					max={marginBottomMax}
					onChange={onChangeMarginBottom}
				/>
			)}
			{marginEnableLeft && (
				<RangeControl
					{...rangeProps}
					label={
						marginLeftLabel
							? marginLeftLabel
							: __('Margin Left', 'genesis-blocks')
					}
					value={marginLeft}
					min={marginLeftMin}
					max={marginLeftMax}
					onChange={onChangeMarginLeft}
				/>
			)}
			{marginEnableVertical && (
				<RangeControl
					{...rangeProps}
					label={
						marginVerticalLabel
							? marginVerticalLabel
							: __('Margin Vertical', 'genesis-blocks')
					}
					value={marginVertical}
					min={marginVerticalMin}
					max={marginVerticalMax}
					onChange={onChangeMarginVertical}
				/>
			)}
			{marginEnableHorizontal && (
				<RangeControl
					{...rangeProps}
					label={
						marginHorizontalLabel
							? marginHorizontalLabel
							: __('Margin Horizontal', 'genesis-blocks')
					}
					value={marginHorizontal}
					min={marginHorizontalMin}
					max={marginHorizontalMax}
					onChange={onChangeMarginHorizontal}
				/>
			)}
		</Fragment>
	);
}
