var NSCrmHideExcessElements = BX.namespace('NSCrmHideExcessElements');

// ����������� ������������� �� ������� ��������
NSCrmHideExcessElements.init = function () {

	// ������� �������� ��������
	BX.addCustomEvent('oniminit', function () {
		setTimeout(function () {
			var page = $('.bx-layout-inner-inner-top-row')
			if (page.length) {
				NSCrmHideExcessElements.hideInvoice({page})
			}
		})
	})

	// ������� �������� ������� ������
	BX.addCustomEvent('sidepanel.slider:onopencomplete', function (data) {
		if (data.slider && data.slider.iframe) {
			$(data.slider.iframe.contentDocument).ready(function () {
				var countIterations = 0
				var timeout = setInterval(function () {
					++countIterations
					var panel = $(data.slider.iframe.contentDocument.body)
					if (panel.children().length || countIterations > 50) {
						clearInterval(timeout)
						NSCrmHideExcessElements.hideInvoice({panel})
					}
				}, 100)
			})
		}
	})
};

// ��������� ��� ����� ��������
NSCrmHideExcessElements.hideInvoice = function ({panel, page}) {
	var btn = null

	if (page) {
		btn = page.find('button[id^=\'toolbar_deal_details_\'][id$=\'_convert_label\']')
	}

	if (panel) {
		btn = panel.find('button[id^=\'toolbar_deal_details_\'][id$=\'_convert_label\']')
	}

	var btnWrap = btn.closest('.ui-btn-split')
	btnWrap.hide()
};