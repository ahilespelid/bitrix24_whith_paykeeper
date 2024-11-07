<?

	namespace Newsite\Hidecrmelements;

	class Events
	{

		public static function onProlog() {

			\CJSCore::RegisterExt('NSCrmHideExcessElements',
				array(
					'js' => [
						'/bitrix/js/newsite.hidecrmelements/NSCrmHideExcessElements.js',
					],
					'css' => [
						'/bitrix/js/newsite.hidecrmelements/NSCrmHideExcessElements.css',
					],
					'rel' => array(
						'jquery',
					),
				)
			);

			\CJSCore::Init('NSCrmHideExcessElements');

			$asset = \Bitrix\Main\Page\Asset::getInstance();
			$asset->addString('<script>BX.ready(function () {
								BX.NSCrmHideExcessElements.init();
							});</script>');
		}
	}
