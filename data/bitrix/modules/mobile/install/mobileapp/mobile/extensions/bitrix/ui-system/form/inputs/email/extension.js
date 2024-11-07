/**
 * @module ui-system/form/inputs/email
 */
jn.define('ui-system/form/inputs/email', (require, exports, module) => {
	const { EmailFieldClass } = require('layout/ui/fields/email');
	const { PropTypes } = require('utils/validation');
	const { getDomainImageUri, getEmailServiceName, defaultImageName, isValidEmail } = require('utils/email');
	const { InputClass, InputSize, InputMode, InputDesign, Icon } = require('ui-system/form/inputs/input');
	const { InputDomainIconPlace } = require('ui-system/form/inputs/email/src/domain-icon-place-enum');

	/**
	 * @typedef {InputProps} EmailInputProps
	 * @property {boolean} [validation]
	 * @property {InputDomainIconPlace} [domainIconPlace]
	 *
	 * @class EmailInputClass
	 */
	class EmailInputClass extends InputClass
	{
		getStateObject(props)
		{
			const state = super.getStateObject(props);
			const shouldRenderDomain = Boolean(this.getDomainIconPlace());

			if (shouldRenderDomain)
			{
				state.emailService = this.getEmailServiceName(props.value);
			}

			return state;
		}

		getValidationErrorMessage()
		{
			return EmailFieldClass.getValidationErrorMessage();
		}

		getLeftContent()
		{
			return this.getDomainIconPlace()?.isLeft()
				? this.getDomainContent(super.getLeftContent())
				: super.getLeftContent();
		}

		getRightContent()
		{
			return this.getDomainIconPlace()?.isRight()
				? this.getDomainContent(super.getRightContent())
				: super.getRightContent();
		}

		rightStickContent()
		{
			return this.getDomainIconPlace()?.isRightStick()
				? this.getDomainContent(super.getRightStickContent())
				: super.getRightStickContent();
		}

		getDomainContent(content)
		{
			const defaultContent = content || Icon.MAIL;
			const shouldRenderDomain = Boolean(this.getDomainIconPlace());

			if (!shouldRenderDomain)
			{
				return defaultContent;
			}

			const { emailService } = this.state;

			if (emailService === defaultImageName)
			{
				return defaultContent;
			}

			return this.renderDomainIcon(emailService);
		}

		renderDomainIcon(service)
		{
			const size = this.getIconSize();

			return Image({
				style: {
					width: size,
					height: size,
				},
				uri: getDomainImageUri({ service }),
				resizeMode: 'contain',
			});
		}

		handleOnChangeText(value)
		{
			const emailService = this.getEmailServiceName(value);
			const { emailService: prevEmailService } = this.state;

			if (emailService === prevEmailService)
			{
				super.handleOnChangeText(value);
			}
			else
			{
				this.setCurrentValue(value);
				this.setState(
					{ emailService },
					() => {
						this.handleOnChange(value);
					},
				);
			}
		}

		/**
		 * @returns {InputDomainIconPlace}
		 */
		getDomainIconPlace()
		{
			const { domainIconPlace } = this.props;

			return domainIconPlace;
		}

		getFieldProps()
		{
			return {
				...super.getFieldProps(),
				keyboardType: 'email-address',
				autoCapitalize: 'none',
			};
		}

		isValid()
		{
			const { validation } = this.props;

			if (validation)
			{
				return isValidEmail(this.getValue()) && super.isValid();
			}

			return super.isValid();
		}

		getEmailServiceName(email)
		{
			return getEmailServiceName(email);
		}
	}

	EmailInputClass.defaultProps = {
		...InputClass.defaultProps,
		validation: false,
	};

	EmailInputClass.propTypes = {
		...InputClass.propTypes,
		validation: PropTypes.bool,
		domainIconPlace: PropTypes.instanceOf(InputDomainIconPlace),
		onChange: PropTypes.func,
	};

	module.exports = {
		/**
		 * @param {EmailInputProps} props
		 * @returns {EmailInputClass}
		 */
		EmailInput: (props) => new EmailInputClass(props),
		InputSize,
		InputMode,
		InputDesign,
		InputDomainIconPlace,
		Icon,
	};
});
