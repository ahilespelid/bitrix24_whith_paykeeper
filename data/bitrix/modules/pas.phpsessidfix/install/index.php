<?php

use Bitrix\Main\EventManager;
use Bitrix\Main\IO\File;
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Loader;
use \Bitrix\Main\Entity\Base;
use \Bitrix\Main\Application;
use Bitrix\Main\ModuleManager;
use Pas\PhpsessidFix;

Loc::loadMessages(__FILE__);

if (class_exists("pas_phpsessidfix")) {
    return;
}

class pas_phpsessidfix extends CModule
{
    var $MODULE_ID = 'pas.phpsessidfix';
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $PARTNER_NAME;
	var $PARTNER_URI;

    function __construct()
    {
        $arModuleVersion = array();
        include(__DIR__ . "/version.php");

        $this->exclusionAdminFiles = array(
            '..',
            '.',
            'menu.php',
            'operation_description.php',
            'task_description.php'
        );

        $this->MODULE_ID = 'pas.phpsessidfix';
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = Loc::getMessage("PAS_PHPSESSIDFIX_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("PAS_PHPSESSIDFIX_MODULE_DESCRIPTION");
        $this->PARTNER_NAME = Loc::getMessage("PAS_PHPSESSIDFIX_PARTNER_NAME");
        $this->PARTNER_URI = "https://aleksandrpanin.ru/";
    }

    public function GetPath($notDocumentRoot = false)
    {
        if ($notDocumentRoot) {
            $path = str_ireplace($_SERVER["DOCUMENT_ROOT"], '', str_ireplace('\\', '/', dirname(__DIR__)));

            return (preg_match('/\/(local|bitrix)\/modules.*/i', $path, $matches))
                ? $matches[0]
                : $path;
        } else {
            return dirname(__DIR__);
        }
    }

    public function isVersionD7()
    {
        $currentVersion = '';

        if (class_exists('\Bitrix\Main\ModuleManager') && method_exists('\Bitrix\Main\ModuleManager', 'getVersion')) {
            $currentVersion = ModuleManager::getVersion('main');
        } elseif (defined('SM_VERSION')) {
            $currentVersion = SM_VERSION;
        }

        return CheckVersion($currentVersion, '14.5.1');
    }

    function GetModuleRightList()
    {
        return array(
            'reference_id' => array('D', 'K', 'S', 'W'),
            'reference' => array(
                '[D] ' . Loc::getMessage('PAS_PHPSESSIDFIX_DENIED'),
                '[K] ' . Loc::getMessage('PAS_PHPSESSIDFIX_READ_COMPONENT'),
                '[S] ' . Loc::getMessage('PAS_PHPSESSIDFIX_WRITE_SETTING'),
                '[W] ' . Loc::getMessage('PAS_PHPSESSIDFIX_FULL'),
            )
        );
    }

    function InstallDB()
    {
        Loader::includeModule($this->MODULE_ID);

    }

    function UnInstallDB()
    {
        Loader::includeModule($this->MODULE_ID);
    }

    function InstallEvents()
    {
        $event = EventManager::getInstance();
        $event->registerEventHandler("main", "OnPageStart", $this->MODULE_ID, "\Pas\PhpsessidFix\Event", "OnPageStart", 900);
    }

    function UnInstallEvents()
    {
        $event = EventManager::getInstance();
        $event->unRegisterEventHandler("main", "OnPageStart", $this->MODULE_ID, "\Pas\PhpsessidFix\Event", "OnPageStart");
    }

    function InstallFiles()
    {
        if (\Bitrix\Main\IO\Directory::isDirectoryExists($path = $this->GetPath() . '/admin')) {
            if ($dir = opendir($path)) {
                while (false !== $item = readdir($dir)) {
                    if (in_array($item, $this->exclusionAdminFiles)) {
                        continue;
                    }

                    file_put_contents(
                        $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin/' . $this->MODULE_ID . '_' . $item,
                        '<' . '? require($_SERVER["DOCUMENT_ROOT"]."' . $this->GetPath(true) . '/admin/' . $item . '");?' . '>'
                    );
                }
                closedir($dir);
            }
        }

        return true;
    }

    function UnInstallFiles()
    {
        if (\Bitrix\Main\IO\Directory::isDirectoryExists($path = $this->GetPath() . '/admin')) {
            if ($dir = opendir($path)) {
                while (false !== $item = readdir($dir)) {
                    if (in_array($item, $this->exclusionAdminFiles)) {
                        continue;
                    }

                    File::deleteFile(
                        $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin/' . $this->MODULE_ID . '_' . $item
                    );
                }

                closedir($dir);
            }
        }

        return true;
    }

    function DoInstall()
    {
        global $APPLICATION;

        if ($this->isVersionD7()) {
            ModuleManager::registerModule($this->MODULE_ID);

            $this->InstallFiles();
            $this->InstallDB();
            $this->InstallEvents();


            if (!Option::get($this->MODULE_ID, 'pas_phpsessif_fix_active')) {
                Option::set($this->MODULE_ID, 'pas_phpsessif_fix_active', 'N');
            }
    
            if (!Option::get($this->MODULE_ID, 'pas_phpsessif_fix_use_log')) {
                Option::set($this->MODULE_ID, 'pas_phpsessif_fix_use_log', 'N');
            }
    
            if (!Option::get($this->MODULE_ID, 'pas_phpsessif_fix_www_actie')) {
                Option::set($this->MODULE_ID, 'pas_phpsessif_fix_www_actie', 'N');
            }


        } else {
            $APPLICATION->ThrowException(Loc::getMessage("PAS_PHPSESSIDFIX_INSTALL_ERROR_VERSION"));
        }

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage("PAS_PHPSESSIDFIX_INSTALL_TITLE"),
            $this->GetPath() . "/install/step.php"
        );
    }

    function DoUninstall()
    {
        global $APPLICATION;

        $context = Application::getInstance()->getContext();
        $request = $context->getRequest();

        $this->UnInstallDB();
        $this->UnInstallEvents();
        $this->UnInstallFiles();
        
        Option::delete($this->MODULE_ID);

        ModuleManager::unRegisterModule($this->MODULE_ID);

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage("PAS_PHPSESSIDFIX_UNINSTALL_TITLE"),
            $this->GetPath() . "/install/unstep2.php"
        );
    }
}

?>
