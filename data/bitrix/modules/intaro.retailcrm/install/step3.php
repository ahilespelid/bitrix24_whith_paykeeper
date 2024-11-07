<?php

use Intaro\RetailCrm\Component\Constants;
use RetailCrm\ApiClient;

/** @var $APPLICATION */

if (!check_bitrix_sessid()) {
    return;
}

IncludeModuleLangFile(__FILE__);

$api_host = COption::GetOptionString(Constants::MODULE_ID, Constants::CRM_API_HOST_OPTION, 0);
$api_key = COption::GetOptionString(Constants::MODULE_ID, Constants::CRM_API_KEY_OPTION, 0);
$arResult['arSites'] = RCrmActions::getSitesList();

$RETAIL_CRM_API = new ApiClient($api_host, $api_key);
COption::SetOptionString(Constants::MODULE_ID, Constants::CRM_API_HOST_OPTION, $api_host);
COption::SetOptionString(Constants::MODULE_ID, Constants::CRM_API_KEY_OPTION, $api_key);

if (count($arResult['arSites']) === 1) {
    COption::SetOptionString(Constants::MODULE_ID, Constants::CRM_SITES_LIST, serialize([]));
}

if (!isset($arResult['bitrixOrderTypesList'])) {
    $arResult['bitrixOrderTypesList'] = RCrmActions::OrderTypesList($arResult['arSites']);
    $arResult['arProp'] = RCrmActions::OrderPropsList();
    $arResult['locationProp'] = RCrmActions::getLocationProps();
    $arResult['ORDER_PROPS'] = unserialize(COption::GetOptionString(Constants::MODULE_ID, Constants::CRM_ORDER_PROPS, 0));
}

if (!isset($arResult['LEGAL_DETAILS'])) {
    $arResult['LEGAL_DETAILS'] = unserialize(COption::GetOptionString(Constants::MODULE_ID, Constants::CRM_LEGAL_DETAILS, 0));
}

if (!isset($arResult['CONTRAGENT_TYPES'])) {
    $arResult['CONTRAGENT_TYPES'] = unserialize(COption::GetOptionString(Constants::MODULE_ID, Constants::CRM_CONTRAGENT_TYPE, 0));

    if ($arResult['CONTRAGENT_TYPES'] === false) {
        foreach ($arResult['contragentType'] as $crmContrAgentType) {
            if ($crmContrAgentType['ID'] === 'individual') {
                $arResult['CONTRAGENT_TYPES']['1'] = 'individual';
            }

            if ($crmContrAgentType['ID'] === 'legal-entity') {
                $arResult['CONTRAGENT_TYPES']['2'] = 'legal-entity';
            }
        }
    }
}

if (isset($arResult['ORDER_PROPS'])) {
    $defaultOrderProps = $arResult['ORDER_PROPS'];
} else {
    $defaultOrderProps = [
        1 => [
            'fio'   => 'FIO',
            'index' => 'ZIP',
            'text'  => 'ADDRESS',
            'phone' => 'PHONE',
            'email' => 'EMAIL',
        ],
        2 => [
            'fio'   => 'CONTACT_PERSON',
            'index' => 'ZIP',
            'text'  => 'ADDRESS',
            'phone' => 'PHONE',
            'email' => 'EMAIL',
        ],
    ];
}
?>

<?php CJSCore::Init(['jquery']);?>

<script type="text/javascript">
    function updateAddressList()
    {
        splitName = $(this).attr('name').split('-');
        orderType = splitName[2];

        if (parseInt($(this).val()) === 1) {
            let locationElement = document.getElementById('locationElement-' + orderType);
            let replacedSelect = document.getElementsByName('order-prop-text-' + orderType);
            let replacedElement = replacedSelect[0].parentNode.parentNode;
            let addedLocation = locationElement.cloneNode(true);

            addedLocation.querySelector(`select`).setAttribute("name", 'order-prop-text-' + orderType);
            addedLocation.removeAttribute("hidden");
            addedLocation.removeAttribute("id");
            replacedElement.replaceWith(addedLocation);

            $('tr.address-detail-' + orderType).show('slow');

        } else if (parseInt($(this).val()) === 0) {
            let locationElement = document.getElementById('textAddressElement-' + orderType);
            let replacedSelect = document.getElementsByName('order-prop-text-' + orderType);
            let replacedElement = replacedSelect[0].parentNode.parentNode;
            let addedLocation = locationElement.cloneNode(true);

            addedLocation.querySelector(`select`).setAttribute("name", 'order-prop-text-' + orderType);
            addedLocation.removeAttribute("hidden");
            addedLocation.removeAttribute("id");
            replacedElement.replaceWith(addedLocation);

            $('tr.address-detail-' + orderType).hide('slow');
        }
    }

    $(document).ready(function() {
        const individual = $("[name='contragent-type-1']").val();
        const legalEntity = $("[name='contragent-type-2']").val();
        $('input:checked[name^="address-detail-"]').each(updateAddressList);

        if (legalEntity !== 'individual') {
            $('tr.legal-detail-2').each(function(){
                if($(this).hasClass(legalEntity)){
                    $(this).show();
                    $('.legal-detail-title-2').show();
                }
            });
        }

        if (individual !== 'individual') {
            $('tr.legal-detail-1').each(function(){
                if($(this).hasClass(individual)){
                    $(this).show();
                    $('.legal-detail-title-1').show();
                }
            });
        }

        $('input[name^="address-detail-"]').change(updateAddressList);
        
        $('tr.contragent-type select').change(function(){
            const splitName      = $(this).attr('name').split('-');
            const contragentType = $(this).val();
            const orderType = splitName[2];
            let legalDetailOrderType = $('tr.legal-detail-' + orderType);
            
            legalDetailOrderType.hide();
            $('.legal-detail-title-' + orderType).hide();

            legalDetailOrderType.each(function(){
                if($(this).hasClass(contragentType)){
                    $(this).show();
                    $('.legal-detail-title-' + orderType).show();
                }
            });
        });
     });
</script>

<div class="adm-detail-content-item-block">
<form action="<?= $APPLICATION->GetCurPage() ?>" method="POST">
    <?= bitrix_sessid_post()?>
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
    <input type="hidden" name="id" value="intaro.retailcrm">
    <input type="hidden" name="install" value="Y">
    <input type="hidden" name="step" value="4">
    <input type="hidden" name="continue" value="3">

    <table class="adm-detail-content-table edit-table" id="edit1_edit_table">
        <tbody>
            <tr class="heading">
                <td colspan="2"><b><?= GetMessage('STEP_NAME')?></b></td>
            </tr>
            <tr class="heading">
                <td colspan="2"><b><?= GetMessage('ORDER_PROPS')?></b></td>
            </tr>
            <tr align="center">
                <td colspan="2"><b><?= GetMessage('INFO_2')?></b></td>
            </tr>
            <?php foreach($arResult['bitrixOrderTypesList'] as $bitrixOrderType): ?>
            <tr class="heading">
                <td colspan="2"><b><?= GetMessage('ORDER_TYPE_INFO') . ' ' . $bitrixOrderType['NAME']?></b></td>
            </tr>
            <tr class="contragent-type">
                <td width="50%" class="adm-detail-content-cell-l">
                    <?= GetMessage('CONTRAGENT_TYPE')?>
                </td>
                <td width="50%" class="adm-detail-content-cell-r">
                    <select name="contragent-type-<?= $bitrixOrderType['ID']?>" class="typeselect">
                        <?php foreach ($arResult['contragentType'] as $contragentType): ?>
                        <option value="<?= $contragentType['ID']; ?>"
                            <?=
                            (isset($arResult['CONTRAGENT_TYPES'][$bitrixOrderType['ID']])
                                && $arResult['CONTRAGENT_TYPES'][$bitrixOrderType['ID']] == $contragentType['ID']) ?
                                'selected'
                                : ''
                             ?>
                        >
                            <?= $contragentType['NAME']?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            
            <?php $countProps = 0; foreach($arResult['orderProps'] as $orderProp): ?>
            <?php if($orderProp['ID'] === 'text'): ?>
            <tr class="heading">
                <td colspan="2" style="background-color: transparent;">
                    <b>
                        <label>
                            <input class="addr" type="radio" name="address-detail-<?= $bitrixOrderType['ID']?>" value="0"
                                <?= (is_array($defaultOrderProps[$bitrixOrderType['ID']]) && count($defaultOrderProps[$bitrixOrderType['ID']]) < 6) ? 'checked' : '' ?>>
                            <?= GetMessage('ADDRESS_SHORT')?>
                        </label>
                        <label>
                            <input class="addr" type="radio" name="address-detail-<?= $bitrixOrderType['ID']?>" value="1"
                                <?= (is_array($defaultOrderProps[$bitrixOrderType['ID']]) && count($defaultOrderProps[$bitrixOrderType['ID']]) > 5) ? 'checked' : '' ?>>
                            <?= GetMessage('ADDRESS_FULL')?>
                        </label>
                    </b>
                </td>
            </tr>
            <?php endif; ?>
            
            <tr <?= ($countProps > 3) ? 'class="address-detail-' . $bitrixOrderType['ID'] . '"' : ''?>
            <?= (is_array($defaultOrderProps[$bitrixOrderType['ID']] && ($countProps > 3) && (count($defaultOrderProps[$bitrixOrderType['ID']]) < 6)))
                ? 'style="display:none;"'
                : ''
            ?>
            >
                <td width="50%" class="adm-detail-content-cell-l" name="<?= $orderProp['ID']?>">
                    <?= $orderProp['NAME']; ?>
                </td>
                <td width="50%" class="adm-detail-content-cell-r">
                    <select name="order-prop-<?= $orderProp['ID'] . '-' . $bitrixOrderType['ID']?>" class="typeselect">
                        <option value=""></option>              
                        <?php foreach ($arResult['arProp'][$bitrixOrderType['ID']] as $arProp): ?>
                        <option value="<?= $arProp['CODE']?>"
                            <?= ($defaultOrderProps[$bitrixOrderType['ID']][$orderProp['ID']] === $arProp['CODE'])
                                ? 'selected'
                                : '' ?>
                        >
                            <?= $arProp['NAME']?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <?php $countProps++; endforeach; ?>

            <tr id="<?php echo 'locationElement-' . $bitrixOrderType['ID']; ?>" hidden="hidden">
                <td class="adm-detail-content-cell-l" width="50%" name="text"><?php echo GetMessage('LOCATION_LABEL'); ?></td>
                <td class="adm-detail-content-cell-r" width="50%">
                    <select class="typeselect">
                        <option value=""></option>
                        <?php foreach ($arResult['locationProp'][$bitrixOrderType['ID']] as $arProp): ?>
                            <option value="<?php echo $arProp['CODE']; ?>"
                                <?php if ($defaultOrderProps[$bitrixOrderType['ID']]['text'] === $arProp['CODE']) {
                                    echo 'selected';
                                } ?>
                            >
                                <?php echo $arProp['NAME'];?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </td>
            </tr>
            <tr id="<?php echo 'textAddressElement-' . $bitrixOrderType['ID']; ?>" hidden="hidden">
                <td class="adm-detail-content-cell-l" width="50%" name="text"><?php echo GetMessage('TEXT_ADDRESS_LABEL'); ?></td>
                <td class="adm-detail-content-cell-r" width="50%">
                    <select class="typeselect">
                        <option value=""></option>
                        <?php foreach ($arResult['arProp'][$bitrixOrderType['ID']] as $arProp): ?>
                            <option value="<?php echo $arProp['CODE']; ?>"
                                <?php if ($defaultOrderProps[$bitrixOrderType['ID']]['text'] === $arProp['CODE']) {
                                    echo 'selected';
                                } ?>
                            >
                                <?php echo $arProp['NAME']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr class="heading legal-detail-title-<?= $bitrixOrderType['ID']?>" style="display:none">
                <td colspan="2" style="background-color: transparent;">
                    <b>
                        <?= GetMessage('ORDER_LEGAL_INFO'); ?>
                    </b>
                </td>
            </tr>

            <?php foreach($arResult['legalDetails'] as $legalDetails): ?>
            <tr class="legal-detail-<?= $bitrixOrderType['ID']?> <?php foreach($legalDetails['GROUP'] as $gr) echo $gr . ' ';?>" style="display:none">
                <td width="50%" class="adm-detail-content-cell-l">
                    <?= $legalDetails['NAME']; ?>
                </td>
                <td width="50%" class="adm-detail-content-cell-r">
                    <select name="legal-detail-<?= $legalDetails['ID'] . '-' . $bitrixOrderType['ID']?>" class="typeselect">
                        <option value=""></option>              
                        <?php foreach ($arResult['arProp'][$bitrixOrderType['ID']] as $arProp): ?>
                        <option value="<?= $arProp['CODE']?>"
                            <?= (isset($arResult['LEGAL_DETAILS'][$bitrixOrderType['ID']][$legalDetails['ID']])
                                && $arResult['LEGAL_DETAILS'][$bitrixOrderType['ID']][$legalDetails['ID']] === $arProp['CODE'])
                                ? 'selected' : ''
                            ?>
                        >
                            <?= $arProp['NAME']?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>   
            <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br />
    <div style="padding: 1px 13px 2px; height:28px;">
        <div align="right" style="float:right; width:50%; position:relative;">
            <input type="submit" name="inst" value="<?= GetMessage('MOD_NEXT_STEP')?>" class="adm-btn-save">
        </div>
        <div align="left" style="float:right; width:50%; position:relative; visible: none;">
            <input type="submit" name="back" value="<?= GetMessage('MOD_PREV_STEP')?>" class="adm-btn-save">
        </div>
    </div>
</form>
</div>
