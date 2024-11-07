<?php
if (!defined('PAS_PHPSESSIDFIX_MODULE_ID')) {
	require_once('prolog.php');
}
use \Bitrix\Main\Loader;
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

Loader::registerAutoLoadClasses(
	PAS_PHPSESSIDFIX_MODULE_ID,
	array(
		"Pas\PhpsessidFix\Event" => "lib/event.php",
	)
);