<?php
/** @var $APPLICATION */

use Bitrix\Main\Config\Configuration;
use \Bitrix\Main\Localization\Loc;

if (!check_bitrix_sessid()) {
    return;
}

Loc::loadMessages($_SERVER["DOCUMENT_ROOT"] . BX_ROOT . "/modules/main/admin/module_admin.php");

#работа с .settings.php
$install_count = Configuration::getInstance()->get('academy_module_d7');

$cache_type = Configuration::getInstance()->get('cache');
#работа с .settings.php

if ($ex = $APPLICATION->GetException()) {
    CAdminMessage::ShowMessage(array(
        "TYPE" => "ERROR",
        "MESSAGE" => Loc::getMessage("MOD_INST_ERR"),
        "DETAILS" => $ex->GetString(),
        "HTML" => true,
    ));
} else {
    CAdminMessage::ShowNote(Loc::getMessage("MOD_INST_OK"));
}

#работа с .settings.php
/*echo CAdminMessage::ShowMessage(array("MESSAGE"=>Loc::getMessage("ACADEMY_D7_INSTALL_COUNT").$install_count['install'],"TYPE"=>"OK"));

if(!$cache_type['type'] || $cache_type['type']=='none')
	echo CAdminMessage::ShowMessage(array("MESSAGE"=>Loc::getMessage("ACADEMY_D7_NO_CACHE"),"TYPE"=>"ERROR"));*/
#работа с .settings.php
?>
<form action="<?= $APPLICATION->GetCurPage(); ?>">
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
    <input type="submit" name="" value="<?= Loc::getMessage("MOD_BACK"); ?>">
<form>
