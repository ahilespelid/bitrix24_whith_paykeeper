
; /* Start:"a:4:{s:4:"full";s:62:"/local/components/wg/crmpayment/WGCrmPayment.js?17304743475699";s:6:"source";s:47:"/local/components/wg/crmpayment/WGCrmPayment.js";s:3:"min";s:0:"";s:3:"map";s:0:"";}"*/
BX.namespace('WGCrmPayment')

BX.WGCrmPayment = {


	init: function (params) {
		var currentWindow = top.window;
		if (top.BX.SidePanel && top.BX.SidePanel.Instance && top.BX.SidePanel.Instance.getTopSlider()) {
			currentWindow = top.BX.SidePanel.Instance.getTopSlider().getWindow();
			panel = top.BX.SidePanel.Instance.getTopSlider().iframe.contentDocument.body;
		
			const observer = new MutationObserver(() => {
				PaymentHref = $(panel).find('#popup-window-content-payment-documents-create-document-action'); 
				TryToFound = $(panel).find('#wg-custom-pay'); 

				if (PaymentHref.length > 0 && TryToFound.length == 0){
					innerWrapper = $(PaymentHref[0]).find('.menu-popup-items');
					var delimiter = BX.create("span",
						{
							props: { className: "popup-window-delimiter-section main-buttons-submenu-delimiter main-buttons-submenu-item main-buttons-manage", 
									 draggable: false, 
									 id: "wg-custom-pay-delimiter"},
							children: [
								BX.create("span",
								{
									props: { className: "popup-window-delimiter-text"},
									html: "Расширения"
								})
							]
						}
					);

					var item = BX.create("span",
						{
							props: { className: "menu-popup-item menu-popup-no-icon"},
							children: [
								BX.create("span",
								{
									props: { className: "menu-popup-item-text", id: "wg-custom-pay"},
									html: "Оплата по ссылке"
								})
							]
						}
					);
					
					BX.bind(item, 'click', BX.delegate(function()
					{
						if(BX.Crm.EntityEditor !== undefined) {
							el = BX.Crm.EntityEditor.defaultInstance;
							if (/deal_/.test(el._id)) {
								   editor = el //BX.Crm.EntityEditor.get(el._id);
								   //editor.reload();
								   //editor.refreshLayout();
								   console.log('CRMPayment runComponentAction');
								   
								   var request = BX.ajax.runComponentAction('wg:crmpayment' , 'savePayment', {
									   mode: "ajax",
									   data: {
										   entityId: el._entityId
									   }
								});
									request.then(function(response){
									   console.log('ajax', response.data['fields']);
										if (response.data['result'] == false) {
											   BX.UI.Notification.Center.notify({
												   content: response.data['errors'][0],
												   autoHideDelay: 5000
										});
									}
										editor.refreshLayout();
										if (response.data['fields']) {
											BX.UI.Notification.Center.notify({
												category: "wg-custompay",
						 						content: `Создана оплата №${response.data['fields']['accountNumber']} на&nbsp;сумму ${response.data['fields']['sum']}<br>Ссылка на&nbsp;оплату в&nbsp;таймлайн.`,
											    autoHideDelay: 10000,
												actions: [{
												   title: "Обновить сделку",
												   events: {
														click: function(event, balloon, action) {
															balloon.close();
															slider = top.BX.SidePanel.Instance.getTopSlider();
															if (slider) slider.reload();
													   	} 
												  	} 
											   	}]
											});
										}
									});
							}
						}
					}, this));
					
					BX.bind(item, "mousedown", function(event)
					{
						BX.PreventDefault(event);
					});

					innerWrapper.children().last().after(delimiter);
					innerWrapper.children().last().after(item);
				} 
				
			});
			observer.observe(panel, {
	  			subtree: true,
	  			childList: true,
			});
		
			/*	
			BX.addCustomEvent(currentWindow,'PaymentDocuments.EntityEditor:changeDocuments', function (event) {
				panel = top.BX.SidePanel.Instance.getTopSlider().iframe.contentDocument.body;
				BX.WGCrmPayment.showPayButton(panel);
			});
			*/
		}
	},


	showPayButton: function (panel) {
		var btn = null
	
		if ($(panel).find('#crmpayment-btn').length == 0 ) {
	
			//Ищем кнопку "Принять оплату"
			innerWrapper = $(panel).find('.crm-entity-widget-content-block-inner-pay-button');
			//Скрываем "Добавить оплату" в нижней части блока
			//addPaymentHref = $(panel).find('#popup-window-content-payment-documents-create-document-action'); //.css( "visibility", "hidden" );
			
			
			var a = BX.create("button",
				{
					props: { className: "ui-btn ui-btn-sm ui-btn-primary ui-btn-icon-tariff", id: "crmpayment-btn"},
					text : '',
					style: {'margin-left': 'auto'},
					attrs : {type: 'button'}
				}
			);
			
			BX.bind(a, 'click', BX.delegate(function()
			{
				if(BX.Crm.EntityEditor !== undefined) {
					el = BX.Crm.EntityEditor.defaultInstance;
					if (/deal_/.test(el._id)) {
						   editor = el //BX.Crm.EntityEditor.get(el._id);
						   //editor.reload();
						   //editor.refreshLayout();
						   console.log('CRMPayment runComponentAction');
						   
						   var request = BX.ajax.runComponentAction('wg:crmpayment' , 'savePayment', {
							   mode: "ajax",
							   data: {
								   entityId: el._entityId
							   }
						});
							request.then(function(response){
							   console.log('ajax', response.data['fields']);
							   	if (response.data['result'] == false) {
							   		BX.UI.Notification.Center.notify({
								   		content: response.data['errors'][0]
							   		});
								}
							   editor.refreshLayout();
						});
						   
					}
				}
			}, this));
			
			BX.bind(a, "mousedown", function(event)
			{
				BX.PreventDefault(event);
			});
			
			innerWrapper.before(a);
	}
	}	
}
	

/* End */
;
; /* Start:"a:4:{s:4:"full";s:82:"/bitrix/components/bitrix/app.placement/templates/menu/script.min.js?1728999452580";s:6:"source";s:64:"/bitrix/components/bitrix/app.placement/templates/menu/script.js";s:3:"min";s:0:"";s:3:"map";s:0:"";}"*/
(function(){BX.namespace("BX.rest");if(!!BX.rest.PlacementMenu){return}BX.rest.PlacementMenu=function(e){BX.rest.PlacementMenu.superclass.constructor.apply(this,arguments)};BX.extend(BX.rest.PlacementMenu,BX.rest.Placement);BX.rest.PlacementMenu.prototype.load=function(e,t,n,a){this.initializeInterface(a);BX.rest.AppLayout.openApplication(t,n,{PLACEMENT_ID:e,PLACEMENT:this.param.placement})};BX.rest.PlacementMenu.prototype.initializeInterface=function(e){var t=top.BX.rest.AppLayout.initializePlacement(this.param.placement);t.prototype.reloadData=function(t,n){e();n()}}})();
/* End */
;; /* /local/components/wg/crmpayment/WGCrmPayment.js?17304743475699*/
; /* /bitrix/components/bitrix/app.placement/templates/menu/script.min.js?1728999452580*/
