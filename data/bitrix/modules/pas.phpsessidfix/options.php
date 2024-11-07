<?php
include 'prolog.php';

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Loader;

global $APPLICATION;

Loc::loadMessages($_SERVER["DOCUMENT_ROOT"] . BX_ROOT . "/modules/main/options.php");
Loc::loadMessages(__FILE__);

Loader::includeModule(PAS_PHPSESSIDFIX_MODULE_ID);

$module_id = PAS_PHPSESSIDFIX_MODULE_ID;
$request = \Bitrix\Main\HttpApplication::getInstance()->getContext()->getRequest();

$RIGHT = $APPLICATION->GetGroupRight(PAS_PHPSESSIDFIX_MODULE_ID);

if ($RIGHT >= "S") {
    $aTabs = array(
        array(
            "DIV" => "main",
            "TAB" => Loc::getMessage("PAS_PHPSESSIDFIX_OPT_TAB"),
            "ICON" => "subscribe_settings",
            "TITLE" => Loc::getMessage("PAS_PHPSESSIDFIX_OPT_TITLE"),
            "OPTIONS" => array(
                
                array(
                    PAS_PHPSESSIDFIX_OPTION_USE,
                    Loc::getMessage("PAS_PHPSESSIDFIX_OPT_USE"),
                    '',
                    array('checkbox')
                ),
                
                array(
                    PAS_PHPSESSIDFIX_OPTION_DOMAIN,
                    Loc::getMessage("PAS_PHPSESSIDFIX_OPT_DOMAIN"),
                    '',
                    array('text')
                ),
                
                array(
                    PAS_PHPSESSIDFIX_OPTION_WWW_ACTIVE,
                    Loc::getMessage("PAS_PHPSESSIDFIX_OPT_WWW_ACTIVE"),
                    '',
                    array('checkbox')
                ),
                
                array(
                    PAS_PHPSESSIDFIX_OPTION_USE_LOG,
                    Loc::getMessage("PAS_PHPSESSIDFIX_OPT_USE_LOG"),
                    '',
                    array('checkbox')
                ),



            ),
        ),
        array(
            "DIV" => "edit2",
            "TAB" => Loc::getMessage("MAIN_TAB_RIGHTS"),
            "ICON" => "subscribe_settings",
            "TITLE" => Loc::getMessage("MAIN_TAB_TITLE_RIGHTS")
        ),
    );

    //Обработка
    if ($request->isPost() && $request['Update'] && check_bitrix_sessid()) {
        foreach ($aTabs as $aTab) {
            foreach ($aTab['OPTIONS'] as $arOption) {
                if (!is_array($arOption)) {
                    continue;
                }

                if ($arOption['note']) {
                    continue;
                }

                $optionName = $arOption[0];
                $optionValue = $request->getPost($optionName);

                Option::set(
                    PAS_PHPSESSIDFIX_MODULE_ID,
                    $optionName,
                    is_array($optionName) ? implode(',', $optionValue) : $optionValue
                );
            }
        }
    }

    $tabControl = new CAdminTabControl("tabControl", $aTabs);

    $tabControl->Begin(); ?>
    <form method="POST"
          action="<?= $APPLICATION->GetCurPage() ?>?mid=<?= urlencode(PAS_PHPSESSIDFIX_MODULE_ID) ?>&amp;lang=<?= LANGUAGE_ID ?>">
        <?php
        foreach ($aTabs as $aTab):
            if ($aTab['OPTIONS']):
                $tabControl->BeginNextTab();
                __AdmSettingsDrawList(PAS_PHPSESSIDFIX_MODULE_ID, $aTab['OPTIONS']);
            endif;
        endforeach;

        $tabControl->BeginNextTab();

        require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/admin/group_rights.php");

        $tabControl->Buttons();
        ?>
        <input type="submit" name="Update" value="<?= Loc::getMessage('MAIN_SAVE') ?>">
        <input type="reset" name="reset" value="<?= Loc::getMessage('MAIN_RESET') ?>">
        <?= bitrix_sessid_post() ?>
    </form>

    <div class="adm-info-message-wrap">
        <div class="adm-info-message"><?= Loc::getMessage("PAS_PHPSESSIDFIX_OPT_NOTE") ?></div>
    </div>


    <?php
    $tabControl->End();
} // end right check
