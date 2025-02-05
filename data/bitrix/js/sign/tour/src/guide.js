import { Text, Type, Dom } from 'main.core';
import { Guide as UiGuide } from 'ui.tour';
import { Backend } from './backend';
import { Popup, type PopupOptions } from 'main.popup';

type GuideOption = {
	id: ?string;
	steps: Array<StepOption>,
	adjustPopupPosition?: (popup: Popup) => void,
	popupOptions?: {
		...popupOptions,
		centerAngle?: boolean,
	},
	...
};

type StepOption = {
	id: null | string,
	events: null | {
		onShow: ?Function,
		onClose: ?Function,
	},
	...
};

export class Guide extends UiGuide
{
	static #isAllTourDisabled: Promise<boolean>;

	#isIdAutoGenerated: boolean;
	#autogeneratedIdPrefix: string = 'sign-tour-guide-';
	#backend: Backend = new Backend();
	#popupOptions: ?PopupOptions;
	#adjustPopupPosition: (popup: Popup) => {};

	constructor(options: GuideOption)
	{
		const { popupOptions, ...guideOptions } = options;
		super(guideOptions);
		if (Type.isStringFilled(options.id))
		{
			this.setId(options.id);
			this.#isIdAutoGenerated = false;
		}
		else
		{
			this.setId(this.#autogeneratedIdPrefix + Text.getRandom(14));
			this.#isIdAutoGenerated = true;
		}

		if (Type.isFunction(options.adjustPopupPosition))
		{
			this.#adjustPopupPosition = options.adjustPopupPosition;
		}

		if (Type.isUndefined(Guide.#isAllTourDisabled))
		{
			Guide.#isAllTourDisabled = this.#backend.isAllToursDisabled();
		}
		if (popupOptions)
		{
			this.setPopupOptions(popupOptions);
		}
	}

	setPopupOptions(popupOptions: PopupOptions): void
	{
		const { autoHide, width, className } = popupOptions;
		const popup = this.getPopup();
		if (width)
		{
			popup.setWidth(width);
		}
		if (autoHide)
		{
			popup.setAutoHide(autoHide);
		}
		if (className)
		{
			Dom.addClass(popup.getPopupContainer(), className);
		}

		this.#popupOptions = popupOptions;
	}

	#adjustPopupWithCenterAngle(): void
	{
		const popup = this.getPopup();
		const { angleArrowElement } = popup;
		const { offsetWidth: popupWidth } = popup.getPopupContainer();
		const shiftX = popupWidth / 2 - angleArrowElement.offsetWidth / 2 - angleArrowElement.offsetLeft;
		const offsetLeft = Popup.getOption('angleLeftOffset') - shiftX;
		popup.setOffset( { offsetLeft });
		popup.adjustPosition();
		popup.setAngle({ offset: shiftX });
	}

	save(): void
	{
		this.#backend.saveVisit(this.getId());
	}

	async start(): Promise<void>
	{
		const isDisabled = await Guide.#isAllTourDisabled;
		if (isDisabled)
		{
			return;
		}

		super.start();
		if (this.#adjustPopupPosition)
		{
			this.#adjustPopupPosition(this.getPopup());
		}
		else if (this.#popupOptions?.centerAngle)
		{
			this.#adjustPopupWithCenterAngle();
		}
	}

	async startOnce(): Promise<void>
	{
		if (this.#isIdAutoGenerated)
		{
			throw new Error("Cant start guide once if id autogenerated. Set id in constructor");
		}
		if (!this.getAutoSave())
		{
			throw new Error("Cant start guide once if guide is not auto saved");
		}

		const [{ lastVisitDate }, isTourDisabled] = await Promise.all([
			this.#backend.getLastVisitDate(this.getId()),
			Guide.#isAllTourDisabled,
		]);
		if (!isTourDisabled && Type.isNull(lastVisitDate))
		{
			this.start();
		}
	}
}
