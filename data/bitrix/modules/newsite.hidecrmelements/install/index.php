<?

includeModuleLangFile(__FILE__);

$strPath2Lang = str_replace("\\", "/", __FILE__);
$strPath2Lang = substr($strPath2Lang, 0, strlen($strPath2Lang) - strlen("/install/index.php"));

if (!defined("NSHIDECRMELEMENTS_MODULE_DIR_PATH")) {
	require_once $strPath2Lang . "/include.php";
}

if (class_exists(str_replace(".", "_", NSHIDECRMELEMENTS_MODULE_NAME))) {
	return;
}

Class newsite_hidecrmelements extends CModule
{

	var $MODULE_ID = 'newsite.hidecrmelements';
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_GROUP_RIGHTS = "Y";


    function __construct()
    {
        $arModuleVersion = array();
        include(dirname(__FILE__) . "/version.php");

        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

        $this->MODULE_NAME = \Bitrix\Main\Localization\Loc::getMessage('NSHIDECRMELEMENTS_MODULE_NAME');
        $this->MODULE_DESCRIPTION = \Bitrix\Main\Localization\Loc::getMessage('NSHIDECRMELEMENTS_MODULE_DESCRIPTION');

        $this->PARTNER_NAME = 'newsite';
        $this->PARTNER_URI = 'https://newsite.by/';
    }

	function DoInstall()
	{
		global $APPLICATION;

		$this->InstallFiles();
		$this->InstallDB();
		$GLOBALS["errors"] = $this->errors;
		$GLOBALS['APPLICATION']->includeAdminFile(
			getMessage('NSHIDECRMELEMENTS_MODULE_NAME_INSTALL'),
			$_SERVER['DOCUMENT_ROOT']. NSHIDECRMELEMENTS_MODULE_DIR_PATH . '/install/step1.php'
		);

	}

	function DoUninstall()
	{
		global $APPLICATION;

        $this->UnInstallDB();
        $this->UnInstallFiles();
        $GLOBALS["errors"] = $this->errors;

		LocalRedirect($APPLICATION->GetCurPage());
	}

	function InstallDB()
	{
		global $DB, $APPLICATION;

		RegisterModuleDependences("main", "OnProlog", NSHIDECRMELEMENTS_MODULE_NAME, "\\Newsite\\Hidecrmelements\\Events", "onProlog");
		RegisterModule(NSHIDECRMELEMENTS_MODULE_NAME);

		return true;
	}

	function UnInstallDB($arParams = array())
	{
		CModule::IncludeModule($this->MODULE_ID);

		global $DB, $APPLICATION;

		$this->errors = false;

		UnRegisterModuleDependences("main", "OnProlog", NSHIDECRMELEMENTS_MODULE_NAME, "\\Newsite\\Hidecrmelements\\Events", "onProlog");
		UnRegisterModule(NSHIDECRMELEMENTS_MODULE_NAME);

        return true;
	}

	function InstallFiles()
	{
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"] . NSHIDECRMELEMENTS_MODULE_DIR_PATH . "install/files", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/js/newsite.hidecrmelements/", true, true);
		return true;
	}

	function UnInstallFiles()
	{
		DeleteDirFiles($_SERVER["DOCUMENT_ROOT"] . NSHIDECRMELEMENTS_MODULE_DIR_PATH . "install/files", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/js/newsite.hidecrmelements/");
		return true;
	}
}
