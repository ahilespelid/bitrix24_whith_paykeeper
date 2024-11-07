/**
 * @module ui-system/blocks/avatar
 */
jn.define('ui-system/blocks/avatar', (require, exports, module) => {
	const { Type } = require('type');
	const { Component, Corner, Color } = require('tokens');
	const { withCurrentDomain } = require('utils/url');
	const { SafeImage } = require('layout/ui/safe-image');
	const { makeLibraryImagePath } = require('asset-manager');
	const { PureComponent } = require('layout/pure-component');
	const { UserLetters } = require('layout/ui/user/empty-avatar');
	const { AccentGradient } = require('ui-system/blocks/avatar/src/accent-gradient-enum');
	const { reduxConnect } = require('ui-system/blocks/avatar/src/redux-connect');
	const isIOS = Application.getPlatform() === 'ios';

	/**
	 * 	@typedef AvatarProps
	 * 	@property {string} testId
	 * 	@property {string | number} id
	 * 	@property {number} [size]
	 * 	@property {string} [name]
	 * 	@property {string} [uri]
	 * 	@property {boolean} [rounded]
	 * 	@property {boolean} [hexagon]
	 * 	@property {boolean} [accent]
	 * 	@property {AccentGradient} [accentGradient]
	 * 	@property {Array} [accentGradientColors]
	 * 	@property {boolean} [useLetterImage]
	 * 	@property {boolean} [withRedux]
	 * 	@property {Object} [style]
	 * 	@property {Function} [onClick]
	 *
	 * @class Avatar
	 */
	class Avatar extends PureComponent
	{
		render()
		{
			const { style = {} } = this.props;
			const size = this.getSize();

			return View(
				{
					testId: this.getTestId(),
					style: {
						...style,
						width: size,
						height: size,
						borderRadius: this.getBorderRadius(),
					},
					onClick: this.handleOnClick,
				},
				this.isAccent()
					? this.renderAccent()
					: this.renderImage({
						style: this.getImageStyle(),
					}),
			);
		}

		renderAccent()
		{
			const imageSize = this.getImageSize();
			const center = this.getSize() / 2 - imageSize / 2;
			const thickness = (this.getSize() - imageSize) / 2;

			return View(
				{
					style: {
						flex: 1,
						position: 'relative',
					},
				},
				Image({
					style: {
						flex: 1,
					},
					svg: {
						content: this.getAccentSvg(thickness),
					},
				}),
				this.renderAccentBackground({ thickness, imageSize }),
				this.renderImage({
					style: {
						borderRadius: this.getBorderRadius(),
						width: imageSize,
						height: imageSize,
					},
					wrapperStyle: {
						position: 'absolute',
						top: center,
						left: center,
					},
				}),
			);
		}

		renderAccentBackground({ thickness, imageSize })
		{
			const { background } = this.props;

			if (!isIOS)
			{
				return null;
			}

			const size = imageSize + thickness;
			const center = (size - imageSize) / 2;

			return View({
				style: {
					position: 'absolute',
					top: center,
					left: center,
					width: size,
					height: size,
					borderRadius: this.getBorderRadius(),
					backgroundColor: Color.resolve(background, Color.bgSecondary).toHex(),
				},
			});
		}

		renderImage(params)
		{
			return SafeImage({
				uri: this.getUri(),
				renderPlaceholder: this.renderPlaceholder(),
				...params,
			});
		}

		renderPlaceholder()
		{
			const { useLetterImage } = this.props;
			const userName = this.getUserName();

			return Type.isStringFilled(userName) && useLetterImage
				? UserLetters({
					name: userName,
					id: this.getUserId(),
					size: this.getImageSize(),
					style: this.getImageStyle(),
				})
				: Image({
					style: this.getImageStyle(),
					svg: {
						uri: this.getEmptyAvatar(),
					},
				});
		}

		handleOnClick = () => {
			const { onClick } = this.props;

			if (onClick)
			{
				onClick();
			}
		};

		getEmptyAvatar()
		{
			return makeLibraryImagePath('person.svg', 'empty-avatar');
		}

		getUserId()
		{
			const { id } = this.props;

			return id;
		}

		getUserName()
		{
			const { name } = this.props;

			return name;
		}

		getTestId()
		{
			const { testId } = this.props;

			return testId;
		}

		getImageSize()
		{
			return this.isAccent() ? this.getSize() / 1.2 : this.getSize();
		}

		getSize()
		{
			const { size } = this.props;

			return size;
		}

		getImageStyle()
		{
			const size = this.getImageSize();

			return {
				width: size,
				height: size,
				borderRadius: this.getBorderRadius(),
			};
		}

		getUri()
		{
			const { uri } = this.props;

			return uri ? encodeURI(withCurrentDomain(uri)) : null;
		}

		isRounded()
		{
			const { rounded } = this.props;

			return Boolean(rounded);
		}

		isHexagon()
		{
			const { hexagon } = this.props;

			return Boolean(hexagon);
		}

		isAccent()
		{
			const { accent } = this.props;

			return Boolean(accent);
		}

		getBorderRadius()
		{
			if (this.isRounded())
			{
				return Component.elementAccentCorner.toNumber();
			}

			const size = this.getSize();

			if (size <= 27)
			{
				return Corner.XS.toNumber();
			}

			if (size <= 47)
			{
				return Corner.S.toNumber();
			}

			if (size <= 83)
			{
				return Corner.M.toNumber();
			}

			return Corner.L.toNumber();
		}

		getAccentSvg(thickness)
		{
			const size = this.getSize();
			const radius = this.getBorderRadius();

			return `
				<svg xmlns="http://www.w3.org/2000/svg" width="${size}" height="${size}" viewBox="0 0 ${size} ${size}" fill="none">
				  <path fill-rule="evenodd" clip-rule="evenodd" d="${this.calculateAccentPath(
				size,
				radius,
				thickness,
			)}" fill="url(#paint0_linear_21791_154432)"/>
				  <defs>
					<linearGradient id="paint0_linear_21791_154432" x1="8.47059" y1="10" x2="51.4509" y2="58.2313" gradientUnits="userSpaceOnUse">
						${this.generateAccentLinearGradient()}
					</linearGradient>
				  </defs>
				</svg>
			`;
		}

		generateAccentLinearGradient()
		{
			const { accentGradientColors, accentGradient } = this.props;

			const colors = Array.isArray(accentGradientColors)
				? accentGradientColors
				: AccentGradient.resolve(accentGradient, AccentGradient.GREEN).getValue();

			return colors.map((color, index) => {
				const offset = index > 0 ? `offset="${index / (colors.length - 1)}"` : '';

				return `<stop ${offset} stop-color="${color}"/>`;
			}).join('\n');
		}

		calculateAccentPath(size, radius, thickness)
		{
			const outerRadius = radius;
			const innerRadius = radius - thickness;
			const innerOffset = thickness;

			return `
				M${outerRadius},0
				H${size - outerRadius}
				C${size - outerRadius / 2},0 ${size},${outerRadius / 2} ${size},${outerRadius}
				V${size - outerRadius}
				C${size},${size - outerRadius / 2} ${size - outerRadius / 2},${size} ${size - outerRadius},${size}
				H${outerRadius}
				C${outerRadius / 2},${size} 0,${size - outerRadius / 2} 0,${size - outerRadius}
				V${outerRadius}
				C0,${outerRadius / 2} ${outerRadius / 2},0 ${outerRadius},0
				Z
				M${innerOffset + innerRadius},${innerOffset}
				H${size - innerOffset - innerRadius}
				C${size - innerOffset - innerRadius / 2},${innerOffset} ${size - innerOffset},${innerOffset + innerRadius / 2} ${size - innerOffset},${innerOffset + innerRadius}
				V${size - innerOffset - innerRadius}
				C${size - innerOffset},${size - innerOffset - innerRadius / 2} ${size - innerOffset - innerRadius / 2},${size - innerOffset} ${size - innerOffset - innerRadius},${size - innerOffset}
				H${innerOffset + innerRadius}
				C${innerOffset + innerRadius / 2},${size - innerOffset} ${innerOffset},${size - innerOffset - innerRadius / 2} ${innerOffset},${size - innerOffset - innerRadius}
				V${innerOffset + innerRadius}
				C${innerOffset},${innerOffset + innerRadius / 2} ${innerOffset + innerRadius / 2},${innerOffset} ${innerOffset + innerRadius},${innerOffset}
				Z
			`;
		}
	}

	Avatar.defaultProps = {
		size: 32,
		accent: false,
		rounded: true,
		hexagon: false,
		withRedux: false,
		useLetterImage: true,
	};

	Avatar.propTypes = {
		testId: PropTypes.string.isRequired,
		id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
		size: PropTypes.number,
		name: PropTypes.string,
		uri: PropTypes.string,
		rounded: PropTypes.bool,
		hexagon: PropTypes.bool,
		accent: PropTypes.bool,
		accentGradient: PropTypes.instanceOf(AccentGradient),
		accentGradientColors: PropTypes.arrayOf(PropTypes.string),
		withRedux: PropTypes.bool,
		useLetterImage: PropTypes.bool,
		style: PropTypes.object,
		onClick: PropTypes.func,
	};

	module.exports = {
		/**
		 * @param {AvatarProps} props
		 */
		Avatar: (props) => {
			if (props.withRedux)
			{
				return reduxConnect(Avatar)(props);
			}

			return new Avatar(props);
		},
		AccentGradient,
	};
});
