<?php

/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2024 Bitrix
 */

use Bitrix\Main;
use Bitrix\Main\Session\Legacy\HealerEarlySessionStart;
use Bitrix\Main\DI\ServiceLocator;

require_once __DIR__ . "/start.php";

$application = Main\HttpApplication::getInstance();
$application->initializeExtendedKernel([
	"get" => $_GET,
	"post" => $_POST,
	"files" => $_FILES,
	"cookie" => $_COOKIE,
	"server" => $_SERVER,
	"env" => $_ENV
]);

if (class_exists('\Dev\Main\Migrator\ModuleUpdater'))
{
	\Dev\Main\Migrator\ModuleUpdater::checkUpdates('main', __DIR__);
}

if (!Main\ModuleManager::isModuleInstalled('bitrix24'))
{
	// wwall rules
	(new Main\Security\W\WWall)->handle();

	$application->addBackgroundJob([
		Main\Security\W\WWall::class, 'refreshRules'
	]);

	// vendor security notifications
	$application->addBackgroundJob([
		Main\Security\Notifications\VendorNotifier::class, 'refreshNotifications'
	]);
}

if (defined('SITE_ID'))
{
	define('LANG', SITE_ID);
}

$context = $application->getContext();
$context->initializeCulture(defined('LANG') ? LANG : null, defined('LANGUAGE_ID') ? LANGUAGE_ID : null);

// needs to be after culture initialization
$application->start();

// Register main's services
ServiceLocator::getInstance()->registerByModuleSettings('main');

// constants for compatibility
$culture = $context->getCulture();
define('SITE_CHARSET', $culture->getCharset());
define('FORMAT_DATE', $culture->getFormatDate());
define('FORMAT_DATETIME', $culture->getFormatDatetime());
define('LANG_CHARSET', SITE_CHARSET);

$site = $context->getSiteObject();
if (!defined('LANG'))
{
	define('LANG', ($site ? $site->getLid() : $context->getLanguage()));
}
define('SITE_DIR', ($site ? $site->getDir() : ''));
if (!defined('SITE_SERVER_NAME'))
{
	define('SITE_SERVER_NAME', ($site ? $site->getServerName() : ''));
}
define('LANG_DIR', SITE_DIR);

if (!defined('LANGUAGE_ID'))
{
	define('LANGUAGE_ID', $context->getLanguage());
}
define('LANG_ADMIN_LID', LANGUAGE_ID);

if (!defined('SITE_ID'))
{
	define('SITE_ID', LANG);
}

/** @global $lang */
$lang = $context->getLanguage();

//define global application object
$GLOBALS["APPLICATION"] = new CMain;

if (!defined("POST_FORM_ACTION_URI"))
{
	define("POST_FORM_ACTION_URI", htmlspecialcharsbx(GetRequestUri()));
}

$GLOBALS["MESS"] = [];
$GLOBALS["ALL_LANG_FILES"] = [];
IncludeModuleLangFile(__DIR__."/tools.php");
IncludeModuleLangFile(__FILE__);

error_reporting(COption::GetOptionInt("main", "error_reporting", E_COMPILE_ERROR | E_ERROR | E_CORE_ERROR | E_PARSE) & ~E_STRICT & ~E_DEPRECATED & ~E_WARNING & ~E_NOTICE);

if (!defined("BX_COMP_MANAGED_CACHE") && COption::GetOptionString("main", "component_managed_cache_on", "Y") != "N")
{
	define("BX_COMP_MANAGED_CACHE", true);
}

// global functions
require_once __DIR__ . "/filter_tools.php";

/*ZDUyZmZZTA3MWY3Y2E4YjhjMjgxMThlZjg1ZTAwNmM1YjVjZTg=*/$GLOBALS['_____2084831905']= array(base64_decode(''.'R2V0TW'.'9kdWxlRX'.'ZlbnRz'),base64_decode('RXhlY3'.'V'.'0ZU1vZHV'.'sZUV2'.'ZW'.'50RXg'.'='),base64_decode('V3JpdGVGa'.'W5hbE1lc3N'.'hZ2U='));$GLOBALS['____1697610014']= array(base64_decode('ZGVm'.'aW'.'5l'),base64_decode('YmF'.'z'.'ZTY0X2'.'RlY29'.'kZ'.'Q=='),base64_decode('dW5zZ'.'X'.'J'.'pY'.'Wxp'.'em'.'U='),base64_decode('a'.'XNfYXJ'.'y'.'YXk='),base64_decode('a'.'W5fYXJyYXk='),base64_decode(''.'c2'.'VyaWFsa'.'Xp'.'l'),base64_decode('YmFzZTY'.'0'.'X2'.'V'.'uY2'.'9k'.'ZQ=='),base64_decode('bWt0aW1'.'l'),base64_decode('ZGF0ZQ='.'='),base64_decode('ZGF'.'0'.'ZQ=='),base64_decode('c3R'.'ybGVu'),base64_decode(''.'b'.'Wt0a'.'W1l'),base64_decode('ZGF'.'0ZQ=='),base64_decode('ZGF'.'0ZQ='.'='),base64_decode('bWV0a'.'G9kX2V4aXN0'.'cw=='),base64_decode('Y2F'.'sbF91c2'.'VyX2Z1bmN'.'f'.'Y'.'XJ'.'yYX'.'k='),base64_decode('c3RybGV'.'u'),base64_decode('c2VyaW'.'Fsa'.'X'.'pl'),base64_decode('YmFzZTY0X2'.'VuY'.'29'.'kZQ'.'='.'='),base64_decode('c3RybG'.'Vu'),base64_decode('aX'.'NfYXJyY'.'X'.'k='),base64_decode('c'.'2Vy'.'aWFsa'.'Xpl'),base64_decode('YmFzZT'.'Y0'.'X'.'2VuY29kZQ'.'=='),base64_decode('c2Vya'.'WFsaXpl'),base64_decode('Y'.'mFzZ'.'TY0X2V'.'uY2'.'9kZ'.'Q=='),base64_decode(''.'aXNfYXJyY'.'Xk='),base64_decode('aX'.'NfYXJyYX'.'k='),base64_decode('aW5f'.'YXJyYXk='),base64_decode('aW5f'.'YXJy'.'YXk='),base64_decode('bW'.'t0aW'.'1l'),base64_decode(''.'ZGF0ZQ'.'=='),base64_decode('ZGF'.'0ZQ=='),base64_decode('ZG'.'F0ZQ'.'='.'='),base64_decode('bWt0aW'.'1l'),base64_decode('ZGF'.'0ZQ='.'='),base64_decode('ZGF0ZQ='.'='),base64_decode('aW5fYX'.'J'.'yYX'.'k='),base64_decode(''.'c'.'2V'.'yaWFs'.'a'.'Xpl'),base64_decode(''.'YmFzZTY0'.'X2VuY29kZQ=='),base64_decode(''.'aW50dm'.'Fs'),base64_decode('dGltZQ'.'='.'='),base64_decode('ZmlsZ'.'V9l'.'eGlzdH'.'M'.'='),base64_decode('c3RyX3JlcGx'.'hY2U='),base64_decode(''.'Y2x'.'h'.'c3Nf'.'Z'.'Xh'.'pc3Rz'),base64_decode('ZGVmaW5l'),base64_decode(''.'c3Ryc'.'mV'.'2'),base64_decode('c3Ry'.'dG9'.'1cHB'.'l'.'cg=='),base64_decode('c3Bya'.'W5'.'0Zg=='),base64_decode('c'.'3ByaW50Zg=='),base64_decode(''.'c3Vic'.'3Ry'),base64_decode(''.'c3'.'RycmV'.'2'),base64_decode('YmF'.'z'.'ZTY'.'0X2RlY29k'.'ZQ='.'='),base64_decode('c3Vic3Ry'),base64_decode(''.'c3Ryb'.'GVu'),base64_decode(''.'c3Ryb'.'GVu'),base64_decode('Y2hy'),base64_decode('b3Jk'),base64_decode('b3'.'Jk'),base64_decode('bWt0aW1l'),base64_decode(''.'aW5'.'0dmFs'),base64_decode('aW50dmFs'),base64_decode('a'.'W50dm'.'F'.'s'),base64_decode('a3NvcnQ'.'='),base64_decode('c3Vic3Ry'),base64_decode('aW1wbG'.'9kZQ=='),base64_decode('ZGVmaW5lZA=='),base64_decode(''.'Ym'.'F'.'z'.'ZTY0X2'.'RlY'.'29k'.'ZQ='.'='),base64_decode('Y29u'.'c3RhbnQ='),base64_decode(''.'c3RycmV2'),base64_decode('c3ByaW'.'50'.'Zg=='),base64_decode(''.'c3RybGV'.'u'),base64_decode(''.'c3R'.'ybGVu'),base64_decode('Y'.'2hy'),base64_decode('b3Jk'),base64_decode('b'.'3Jk'),base64_decode('bWt0'.'aW1l'),base64_decode('aW50dm'.'Fs'),base64_decode('a'.'W50dm'.'Fs'),base64_decode('a'.'W50dm'.'F'.'s'),base64_decode('c3Vic'.'3Ry'),base64_decode('c3Vic3Ry'),base64_decode('ZGVm'.'a'.'W5lZA=='),base64_decode('c3RycmV2'),base64_decode('c3'.'Ry'.'dG9'.'1cH'.'B'.'lcg=='),base64_decode('dGltZ'.'Q=='),base64_decode('bWt0aW1l'),base64_decode('bWt0aW1l'),base64_decode('ZGF'.'0Z'.'Q=='),base64_decode('Z'.'GF0ZQ=='),base64_decode('ZGVm'.'aW5l'),base64_decode(''.'Z'.'GVmaW5l'));if(!function_exists(__NAMESPACE__.'\\___1957532197')){function ___1957532197($_1567990874){static $_819482876= false; if($_819482876 == false) $_819482876=array('SU5'.'UU'.'kFORV'.'RfR'.'U'.'RJVE'.'lPTg==',''.'WQ==','bW'.'F'.'pbg='.'=','fmNwZl9tYXBfdmFs'.'dWU=','','','YWxsb'.'3dl'.'ZF9'.'jb'.'G'.'Fzc2Vz','ZQ==','Zg'.'='.'=','ZQ==','Rg='.'=','WA'.'==','Zg='.'=','bWFpbg==','fmNwZl'.'9tY'.'XBfdmFsdWU=',''.'UG'.'9ydGFs',''.'Rg'.'='.'=','ZQ'.'==','ZQ==','WA==','R'.'g'.'==','RA='.'=','RA==',''.'b'.'Q='.'=','ZA='.'=','WQ='.'=','Zg==','Zg==','Z'.'g==','Zg'.'==','U'.'G9y'.'dGFs','Rg==','ZQ==',''.'ZQ='.'=','WA==','R'.'g='.'=','RA==',''.'RA='.'=','b'.'Q==',''.'ZA==','W'.'Q'.'==','bWF'.'p'.'bg==','T2'.'4=','U2V0dGl'.'uZ3NDaGFuZ2U=','Z'.'g'.'==','Zg==','Zg==','Zg'.'='.'=','bWF'.'pb'.'g==','f'.'mNwZl9tYXBf'.'dmFsdWU=','ZQ==','ZQ='.'=','RA==',''.'ZQ==','ZQ==','Zg'.'==',''.'Z'.'g==','Zg'.'==','ZQ==','b'.'WFpbg='.'=','fm'.'N'.'wZ'.'l9tYXBfd'.'m'.'FsdWU'.'=','ZQ'.'==','Zg==','Z'.'g==','Zg==','Zg==','bWFpbg'.'==','fm'.'N'.'wZl9tYXBfdmFsdW'.'U=','Z'.'Q==','Z'.'g'.'==','UG9ydGFs','UG'.'9ydGFs','ZQ'.'==',''.'ZQ==','U'.'G9ydGFs','Rg'.'='.'=','WA==','Rg='.'=','R'.'A==','ZQ'.'='.'=','ZQ'.'==','RA='.'=','bQ='.'=','ZA==','WQ='.'=','Z'.'Q'.'='.'=','WA==','ZQ='.'=','R'.'g==','Z'.'Q='.'=',''.'R'.'A==','Zg==',''.'ZQ'.'==',''.'RA'.'==','ZQ='.'=',''.'bQ'.'==','ZA==','WQ==','Z'.'g==','Zg'.'='.'=','Zg==','Zg==',''.'Zg==','Zg'.'==','Z'.'g='.'=','Zg==','b'.'WFpbg'.'==','fmN'.'wZ'.'l'.'9tYXBfdmFsdWU=','ZQ'.'==','ZQ==','UG9'.'ydGFs','R'.'g==',''.'WA'.'==','VFlQ'.'RQ==','REFU'.'RQ==','RkVB'.'V'.'F'.'V'.'SRVM'.'=',''.'RVhQS'.'VJFRA='.'=','VF'.'lQR'.'Q==','RA==','VFJ'.'Z'.'X'.'0RBWVN'.'fQ'.'09VTlQ'.'=','REF'.'U'.'RQ'.'==','VF'.'J'.'ZX'.'0'.'R'.'BWVNfQ09VTlQ=',''.'R'.'VhQSVJFRA==','RkVBVFVSRVM'.'=','Z'.'g==','Z'.'g='.'=','RE9'.'DVU1FTlRfUk9P'.'VA==','L2J'.'pdHJp'.'eC9tb2R1b'.'G'.'Vz'.'Lw==','L2l'.'uc3RhbGwvaW5kZ'.'Xg'.'ucGhw',''.'L'.'g'.'='.'=','Xw==','c2'.'VhcmN'.'o','T'.'g==','','',''.'QUNUSVZF','W'.'Q='.'=','c'.'29'.'jaWFs'.'bmV0'.'d29yaw='.'=','YW'.'xsb3'.'d'.'fZnJpZWxkcw='.'=','WQ==',''.'SUQ=',''.'c29'.'ja'.'WFsbmV0d29yaw==',''.'YW'.'xsb3dfZn'.'JpZW'.'xkcw==','S'.'UQ'.'=',''.'c'.'29j'.'aWFsbmV0'.'d29yaw='.'=','YWxsb3'.'df'.'ZnJpZWx'.'k'.'c'.'w==',''.'Tg==','','','Q'.'U'.'N'.'USVZF','WQ='.'=','c29jaWFsbmV0d29yaw==','YWx'.'s'.'b3'.'dfbWljcm9ib'.'G9nX'.'3VzZXI=','WQ==','SUQ=','c29jaWFsbmV0d29y'.'aw==','YWxsb3dfbW'.'ljc'.'m9ibG9n'.'X3VzZ'.'XI=','S'.'U'.'Q=','c29jaWFsbmV0'.'d'.'2'.'9yaw==','YWxs'.'b3d'.'fbWljcm9ibG9n'.'X3VzZ'.'XI=',''.'c2'.'9jaWFs'.'bmV0d29y'.'aw='.'=','YWxsb3df'.'bWljcm9i'.'bG9nX'.'2dyb'.'3'.'Vw','WQ'.'='.'=','SU'.'Q=',''.'c'.'29j'.'aW'.'Fs'.'bmV'.'0d29y'.'aw'.'==','Y'.'Wxsb'.'3dfbWlj'.'c'.'m9ibG9'.'nX2dyb3'.'V'.'w','S'.'UQ=','c29jaW'.'Fs'.'b'.'mV0d2'.'9ya'.'w='.'=','YWx'.'s'.'b3dfbWljcm9ibG9nX2'.'d'.'y'.'b'.'3Vw',''.'Tg='.'=','','','QUNU'.'SVZF','WQ='.'=','c29'.'jaWFsbm'.'V'.'0d'.'29yaw='.'=',''.'YWxsb3d'.'fZml'.'sZX'.'NfdX'.'Nl'.'cg==','W'.'Q==','SUQ=','c29j'.'aWFsbm'.'V0d'.'29yaw==','YWxsb3dfZ'.'ml'.'s'.'ZXNfdXNlcg==','S'.'UQ=','c29'.'ja'.'WFsbmV0d29yaw==',''.'YWxsb3dfZmlsZXNfd'.'XNlcg='.'=','Tg==','','','QU'.'NUSVZF','WQ'.'==','c29'.'j'.'a'.'WFsbmV0d29ya'.'w==','YWx'.'sb3d'.'fY'.'m'.'xvZ'.'191'.'c2Vy',''.'WQ==','SUQ=','c'.'2'.'9jaWFsbm'.'V0d'.'29yaw'.'==',''.'YWx'.'sb3df'.'Ymxv'.'Z191'.'c2'.'Vy','S'.'UQ'.'=','c29jaWF'.'sbmV0d'.'29'.'ya'.'w='.'=','YW'.'x'.'sb3dfYm'.'xvZ191c'.'2V'.'y','Tg='.'=','','',''.'QUNUSV'.'ZF','W'.'Q==','c29jaWF'.'sb'.'mV0'.'d29yaw==','YWxsb3dfc'.'G'.'hv'.'dG9f'.'dXN'.'lc'.'g==','WQ==',''.'SUQ=','c29jaWF'.'sbmV0d'.'29y'.'aw==','YWxsb3'.'df'.'cGhvd'.'G'.'9'.'fdXN'.'lcg'.'==','SU'.'Q=',''.'c29j'.'aWFsbmV0d'.'29ya'.'w'.'==','YWx'.'s'.'b3dfcGh'.'vdG9fdXN'.'lcg==','Tg'.'==','','','QUNUSVZ'.'F','WQ==','c29j'.'aWFsb'.'mV0d'.'29yaw==','Y'.'Wxsb3d'.'fZm'.'9'.'ydW1'.'fdXNl'.'cg==',''.'WQ==',''.'SU'.'Q'.'=','c29'.'jaWFsbmV'.'0d2'.'9'.'yaw'.'==','YWxs'.'b3dfZm9ydW1fdXNlcg==',''.'SUQ=',''.'c29jaWFsb'.'mV0d29yaw==','Y'.'Wx'.'sb3df'.'Zm9yd'.'W1fd'.'XNlcg==','Tg'.'==','','','QUNUS'.'VZF','W'.'Q='.'=','c29jaWFsbmV0d29y'.'a'.'w'.'='.'=','Y'.'Wx'.'sb3'.'d'.'f'.'dG'.'Fza'.'3N'.'fd'.'X'.'Nlcg='.'=',''.'WQ'.'==','S'.'UQ=','c'.'2'.'9jaWFsbmV'.'0'.'d2'.'9y'.'a'.'w==','YWxsb'.'3df'.'dGFza3'.'NfdXNl'.'cg='.'=','SU'.'Q=','c29jaWFsbmV0'.'d29yaw'.'==','YWxsb'.'3d'.'fdGFz'.'a'.'3Nf'.'dXNl'.'c'.'g==','c'.'29jaWF'.'sbmV'.'0d2'.'9yaw='.'=','YWxsb3dfd'.'G'.'F'.'za3NfZ'.'3JvdXA=','WQ==','SUQ=','c2'.'9'.'j'.'aWFsbmV0d'.'29'.'yaw==','Y'.'Wx'.'s'.'b3dfdGF'.'za3Nf'.'Z3Jv'.'dX'.'A=','SUQ=','c'.'29j'.'a'.'WFsb'.'mV0d29y'.'aw==','YWxsb3dfdGF'.'za3N'.'fZ'.'3'.'Jv'.'dXA=',''.'dGF'.'z'.'a3M=','Tg==','','','QUNUSVZF','WQ='.'=',''.'c29jaW'.'Fsb'.'mV0'.'d2'.'9'.'yaw==','YWxsb3dfY2FsZW5kYX'.'Jf'.'d'.'XNlcg==','WQ='.'=','S'.'UQ=','c29'.'j'.'a'.'WF'.'s'.'bmV'.'0d29'.'y'.'aw==','YWxsb3dfY2'.'F'.'sZW5'.'k'.'YX'.'Jf'.'dX'.'N'.'lcg'.'==',''.'SUQ=','c29j'.'a'.'WFsb'.'mV0d29'.'yaw==','YW'.'x'.'sb3dfY2FsZW5kYX'.'JfdX'.'Nlcg'.'==','c2'.'9jaWFsb'.'mV0'.'d29yaw==',''.'YW'.'x'.'sb3dfY2FsZW5'.'kYXJf'.'Z3'.'JvdXA=','WQ==','SU'.'Q=','c'.'2'.'9j'.'a'.'WFsbmV0d29y'.'aw'.'==',''.'YW'.'xsb3dfY2FsZW'.'5'.'kYXJ'.'f'.'Z3'.'JvdXA'.'=','SUQ=',''.'c29ja'.'W'.'FsbmV0d29yaw==',''.'YWxsb3df'.'Y2FsZW5kYXJfZ3J'.'vdX'.'A=','QUN'.'USVZF','WQ'.'='.'=','Tg==','Z'.'X'.'h0'.'cmFu'.'ZXQ'.'=','aWJs'.'b2Nr','T'.'25BZnRlckl'.'C'.'bG9ja'.'0VsZ'.'W1lb'.'nR'.'VcG'.'RhdGU=','aW50cmFuZ'.'X'.'Q'.'=','Q0ludHJhbmV'.'0RX'.'Zlbn'.'RIYW5kbGVycw==','U1'.'B'.'SZW'.'d'.'pc'.'3'.'Rlcl'.'V'.'wZGF0ZWRJdGVt',''.'Q'.'0ludHJh'.'bmV0U2hhcmVwb2lud'.'D'.'o6QWdlbn'.'RMa'.'XN0c'.'ygpO'.'w==','a'.'W50cmF'.'uZXQ=','T'.'g==','Q0'.'lud'.'HJhbm'.'V0'.'U'.'2h'.'hcmVw'.'b2lud'.'D'.'o6'.'QWd'.'l'.'b'.'nRRdWV1Z'.'S'.'gp'.'Ow==',''.'aW50cmFuZXQ'.'=',''.'Tg='.'=','Q0ludH'.'JhbmV0U2hhcm'.'Vwb'.'2'.'ludDo6'.'Q'.'WdlbnRV'.'cGRhdG'.'Uo'.'KTs=','a'.'W5'.'0cmF'.'u'.'Z'.'XQ=',''.'Tg==','aWJsb'.'2Nr','T25BZnR'.'lckl'.'C'.'bG9ja0'.'VsZW'.'1l'.'b'.'nRBZ'.'GQ=','aW5'.'0cmF'.'uZXQ=','Q0l'.'udHJhbmV0R'.'XZ'.'lb'.'nR'.'IYW5kbGVycw==',''.'U'.'1BSZW'.'d'.'pc3R'.'lclVwZ'.'GF0'.'ZW'.'RJdGVt','aWJ'.'sb2'.'N'.'r','T25'.'B'.'ZnRlcklCbG9ja0VsZW1'.'lbnRVcG'.'Rh'.'dG'.'U=','aW50'.'cm'.'FuZXQ=','Q0'.'ludHJh'.'bmV0RXZlbnRIYW5kb'.'GVy'.'cw='.'=','U'.'1'.'B'.'S'.'Z'.'Wdp'.'c3RlclVwZGF0'.'Z'.'WRJ'.'dGVt','Q0l'.'udHJ'.'hbmV0U2'.'hh'.'cmVwb2ludDo6QWdlbnRMa'.'XN0cygpOw='.'=','a'.'W50cm'.'Fu'.'ZX'.'Q'.'=',''.'Q'.'0lu'.'dHJhbmV'.'0U2h'.'hcmV'.'wb'.'2'.'ludDo6QW'.'d'.'lb'.'nRRdWV1'.'ZSg'.'p'.'Ow==','aW50c'.'mFuZ'.'XQ=',''.'Q0lu'.'dHJhbmV0U2'.'h'.'h'.'cmV'.'wb2ludDo6QW'.'d'.'lb'.'nRVc'.'GRhdGU'.'oKTs=',''.'aW5'.'0cmF'.'uZ'.'XQ=','Y'.'3J'.'t','bWFpbg==','T25CZWZvcmV'.'Q'.'cm9sb2c=',''.'b'.'W'.'Fpbg==',''.'Q1'.'dpemFyZFN'.'vbFBhbmVsSW5'.'0cmFuZXQ=',''.'U2'.'hv'.'d1Bhbm'.'Vs','L21vZ'.'HVsZX'.'MvaW'.'5'.'0cmFuZXQvcG'.'FuZ'.'W'.'xf'.'YnV0dG9uL'.'nBocA'.'='.'=','Z'.'XhwaXJl'.'X21'.'l'.'c3My','bm'.'9pd'.'Glk'.'ZV90'.'aW1pbGVtaXQ=',''.'WQ'.'==','ZHJ'.'pbl9wZXJ'.'nb2'.'tj','J'.'TAxMH'.'MK','RUV'.'YUE'.'lS','bWF'.'pb'.'g==',''.'J'.'X'.'Mlcw'.'==','YWRt','aGRy'.'b3dzc2E=',''.'YWRta'.'W'.'4=','bW9kd'.'W'.'xl'.'cw==','ZG'.'Vma'.'W5'.'lLn'.'Boc'.'A'.'==',''.'b'.'WFp'.'b'.'g==','Yml0'.'cm'.'l4','U'.'khTSVRF'.'RVg=','SDR1NjdmaHc4N'.'1Zo'.'eXRv'.'cw==','','dGhS','N'.'0h5cj'.'EySH'.'d5MHJG'.'cg==',''.'VF9'.'TVEVBTA==','aHR0'.'cHM6Ly9ia'.'XRy'.'aXhzb2Z0L'.'mN'.'vbS9'.'ia'.'XRya'.'Xgv'.'YnMuc'.'Ghw','T0xE','U'.'E'.'lSRURB'.'V'.'EV'.'T','RE9'.'DVU1F'.'TlRfUk'.'9PVA==',''.'Lw==','Lw==','VEV'.'NUE9S'.'Q'.'VJZ'.'X0NBQ0'.'hF','VEV'.'NUE9SQ'.'VJ'.'ZX0NBQ0'.'hF','','T05fT0Q=','JXMlcw='.'=',''.'X09'.'VUl9CV'.'VM=','U'.'0lU','RUR'.'BVEV'.'NQV'.'BFUg==','bm'.'9'.'pdG'.'lkZV90aW1pbGVt'.'a'.'XQ=',''.'b'.'Q==','ZA==','W'.'Q==','U0NSSVBUX05BTUU=','L2JpdHJpeC9'.'j'.'b'.'3'.'V'.'wb25fYWN0aXZh'.'dGlvb'.'i'.'5waHA'.'=','U0NSSV'.'B'.'UX'.'05BTUU=','L2Jp'.'dHJpeC9zZXJ2aWNlc'.'y9tYWluL'.'2FqYX'.'gu'.'cGhw','L2Jpd'.'HJpeC'.'9'.'j'.'b'.'3Vwb25f'.'YWN0aXZhd'.'Glvbi'.'5waHA=','U'.'2l0'.'ZUV4'.'cGl'.'yZUR'.'hdGU'.'=');return base64_decode($_819482876[$_1567990874]);}};$GLOBALS['____1697610014'][0](___1957532197(0), ___1957532197(1));class CBXFeatures{ private static $_862751626= 30; private static $_1147283333= array( "Portal" => array( "CompanyCalendar", "CompanyPhoto", "CompanyVideo", "CompanyCareer", "StaffChanges", "StaffAbsence", "CommonDocuments", "MeetingRoomBookingSystem", "Wiki", "Learning", "Vote", "WebLink", "Subscribe", "Friends", "PersonalFiles", "PersonalBlog", "PersonalPhoto", "PersonalForum", "Blog", "Forum", "Gallery", "Board", "MicroBlog", "WebMessenger",), "Communications" => array( "Tasks", "Calendar", "Workgroups", "Jabber", "VideoConference", "Extranet", "SMTP", "Requests", "DAV", "intranet_sharepoint", "timeman", "Idea", "Meeting", "EventList", "Salary", "XDImport",), "Enterprise" => array( "BizProc", "Lists", "Support", "Analytics", "crm", "Controller", "LdapUnlimitedUsers",), "Holding" => array( "Cluster", "MultiSites",),); private static $_1612126018= null; private static $_699808072= null; private static function __1783213540(){ if(self::$_1612126018 === null){ self::$_1612126018= array(); foreach(self::$_1147283333 as $_640168931 => $_1134688800){ foreach($_1134688800 as $_425040960) self::$_1612126018[$_425040960]= $_640168931;}} if(self::$_699808072 === null){ self::$_699808072= array(); $_108583012= COption::GetOptionString(___1957532197(2), ___1957532197(3), ___1957532197(4)); if($_108583012 != ___1957532197(5)){ $_108583012= $GLOBALS['____1697610014'][1]($_108583012); $_108583012= $GLOBALS['____1697610014'][2]($_108583012,[___1957532197(6) => false]); if($GLOBALS['____1697610014'][3]($_108583012)){ self::$_699808072= $_108583012;}} if(empty(self::$_699808072)){ self::$_699808072= array(___1957532197(7) => array(), ___1957532197(8) => array());}}} public static function InitiateEditionsSettings($_65241817){ self::__1783213540(); $_1476283718= array(); foreach(self::$_1147283333 as $_640168931 => $_1134688800){ $_24797639= $GLOBALS['____1697610014'][4]($_640168931, $_65241817); self::$_699808072[___1957532197(9)][$_640168931]=($_24797639? array(___1957532197(10)): array(___1957532197(11))); foreach($_1134688800 as $_425040960){ self::$_699808072[___1957532197(12)][$_425040960]= $_24797639; if(!$_24797639) $_1476283718[]= array($_425040960, false);}} $_666243495= $GLOBALS['____1697610014'][5](self::$_699808072); $_666243495= $GLOBALS['____1697610014'][6]($_666243495); COption::SetOptionString(___1957532197(13), ___1957532197(14), $_666243495); foreach($_1476283718 as $_1630746330) self::__244961228($_1630746330[min(222,0,74)], $_1630746330[round(0+0.25+0.25+0.25+0.25)]);} public static function IsFeatureEnabled($_425040960){ if($_425040960 == '') return true; self::__1783213540(); if(!isset(self::$_1612126018[$_425040960])) return true; if(self::$_1612126018[$_425040960] == ___1957532197(15)) $_669686985= array(___1957532197(16)); elseif(isset(self::$_699808072[___1957532197(17)][self::$_1612126018[$_425040960]])) $_669686985= self::$_699808072[___1957532197(18)][self::$_1612126018[$_425040960]]; else $_669686985= array(___1957532197(19)); if($_669686985[(1112/2-556)] != ___1957532197(20) && $_669686985[(197*2-394)] != ___1957532197(21)){ return false;} elseif($_669686985[(864-2*432)] == ___1957532197(22)){ if($_669686985[round(0+0.25+0.25+0.25+0.25)]< $GLOBALS['____1697610014'][7]((1188/2-594),(998-2*499), min(12,0,4), Date(___1957532197(23)), $GLOBALS['____1697610014'][8](___1957532197(24))- self::$_862751626, $GLOBALS['____1697610014'][9](___1957532197(25)))){ if(!isset($_669686985[round(0+2)]) ||!$_669686985[round(0+0.66666666666667+0.66666666666667+0.66666666666667)]) self::__1272861569(self::$_1612126018[$_425040960]); return false;}} return!isset(self::$_699808072[___1957532197(26)][$_425040960]) || self::$_699808072[___1957532197(27)][$_425040960];} public static function IsFeatureInstalled($_425040960){ if($GLOBALS['____1697610014'][10]($_425040960) <= 0) return true; self::__1783213540(); return(isset(self::$_699808072[___1957532197(28)][$_425040960]) && self::$_699808072[___1957532197(29)][$_425040960]);} public static function IsFeatureEditable($_425040960){ if($_425040960 == '') return true; self::__1783213540(); if(!isset(self::$_1612126018[$_425040960])) return true; if(self::$_1612126018[$_425040960] == ___1957532197(30)) $_669686985= array(___1957532197(31)); elseif(isset(self::$_699808072[___1957532197(32)][self::$_1612126018[$_425040960]])) $_669686985= self::$_699808072[___1957532197(33)][self::$_1612126018[$_425040960]]; else $_669686985= array(___1957532197(34)); if($_669686985[min(26,0,8.6666666666667)] != ___1957532197(35) && $_669686985[(216*2-432)] != ___1957532197(36)){ return false;} elseif($_669686985[(148*2-296)] == ___1957532197(37)){ if($_669686985[round(0+0.5+0.5)]< $GLOBALS['____1697610014'][11](min(110,0,36.666666666667),(1292/2-646),(1200/2-600), Date(___1957532197(38)), $GLOBALS['____1697610014'][12](___1957532197(39))- self::$_862751626, $GLOBALS['____1697610014'][13](___1957532197(40)))){ if(!isset($_669686985[round(0+0.66666666666667+0.66666666666667+0.66666666666667)]) ||!$_669686985[round(0+0.5+0.5+0.5+0.5)]) self::__1272861569(self::$_1612126018[$_425040960]); return false;}} return true;} private static function __244961228($_425040960, $_1663270386){ if($GLOBALS['____1697610014'][14]("CBXFeatures", "On".$_425040960."SettingsChange")) $GLOBALS['____1697610014'][15](array("CBXFeatures", "On".$_425040960."SettingsChange"), array($_425040960, $_1663270386)); $_1951166380= $GLOBALS['_____2084831905'][0](___1957532197(41), ___1957532197(42).$_425040960.___1957532197(43)); while($_120418246= $_1951166380->Fetch()) $GLOBALS['_____2084831905'][1]($_120418246, array($_425040960, $_1663270386));} public static function SetFeatureEnabled($_425040960, $_1663270386= true, $_2096217972= true){ if($GLOBALS['____1697610014'][16]($_425040960) <= 0) return; if(!self::IsFeatureEditable($_425040960)) $_1663270386= false; $_1663270386= (bool)$_1663270386; self::__1783213540(); $_525567522=(!isset(self::$_699808072[___1957532197(44)][$_425040960]) && $_1663270386 || isset(self::$_699808072[___1957532197(45)][$_425040960]) && $_1663270386 != self::$_699808072[___1957532197(46)][$_425040960]); self::$_699808072[___1957532197(47)][$_425040960]= $_1663270386; $_666243495= $GLOBALS['____1697610014'][17](self::$_699808072); $_666243495= $GLOBALS['____1697610014'][18]($_666243495); COption::SetOptionString(___1957532197(48), ___1957532197(49), $_666243495); if($_525567522 && $_2096217972) self::__244961228($_425040960, $_1663270386);} private static function __1272861569($_640168931){ if($GLOBALS['____1697610014'][19]($_640168931) <= 0 || $_640168931 == "Portal") return; self::__1783213540(); if(!isset(self::$_699808072[___1957532197(50)][$_640168931]) || self::$_699808072[___1957532197(51)][$_640168931][(816-2*408)] != ___1957532197(52)) return; if(isset(self::$_699808072[___1957532197(53)][$_640168931][round(0+2)]) && self::$_699808072[___1957532197(54)][$_640168931][round(0+0.4+0.4+0.4+0.4+0.4)]) return; $_1476283718= array(); if(isset(self::$_1147283333[$_640168931]) && $GLOBALS['____1697610014'][20](self::$_1147283333[$_640168931])){ foreach(self::$_1147283333[$_640168931] as $_425040960){ if(isset(self::$_699808072[___1957532197(55)][$_425040960]) && self::$_699808072[___1957532197(56)][$_425040960]){ self::$_699808072[___1957532197(57)][$_425040960]= false; $_1476283718[]= array($_425040960, false);}} self::$_699808072[___1957532197(58)][$_640168931][round(0+0.66666666666667+0.66666666666667+0.66666666666667)]= true;} $_666243495= $GLOBALS['____1697610014'][21](self::$_699808072); $_666243495= $GLOBALS['____1697610014'][22]($_666243495); COption::SetOptionString(___1957532197(59), ___1957532197(60), $_666243495); foreach($_1476283718 as $_1630746330) self::__244961228($_1630746330[(948-2*474)], $_1630746330[round(0+1)]);} public static function ModifyFeaturesSettings($_65241817, $_1134688800){ self::__1783213540(); foreach($_65241817 as $_640168931 => $_1974834760) self::$_699808072[___1957532197(61)][$_640168931]= $_1974834760; $_1476283718= array(); foreach($_1134688800 as $_425040960 => $_1663270386){ if(!isset(self::$_699808072[___1957532197(62)][$_425040960]) && $_1663270386 || isset(self::$_699808072[___1957532197(63)][$_425040960]) && $_1663270386 != self::$_699808072[___1957532197(64)][$_425040960]) $_1476283718[]= array($_425040960, $_1663270386); self::$_699808072[___1957532197(65)][$_425040960]= $_1663270386;} $_666243495= $GLOBALS['____1697610014'][23](self::$_699808072); $_666243495= $GLOBALS['____1697610014'][24]($_666243495); COption::SetOptionString(___1957532197(66), ___1957532197(67), $_666243495); self::$_699808072= false; foreach($_1476283718 as $_1630746330) self::__244961228($_1630746330[(220*2-440)], $_1630746330[round(0+0.25+0.25+0.25+0.25)]);} public static function SaveFeaturesSettings($_1960875873, $_876077535){ self::__1783213540(); $_823747793= array(___1957532197(68) => array(), ___1957532197(69) => array()); if(!$GLOBALS['____1697610014'][25]($_1960875873)) $_1960875873= array(); if(!$GLOBALS['____1697610014'][26]($_876077535)) $_876077535= array(); if(!$GLOBALS['____1697610014'][27](___1957532197(70), $_1960875873)) $_1960875873[]= ___1957532197(71); foreach(self::$_1147283333 as $_640168931 => $_1134688800){ if(isset(self::$_699808072[___1957532197(72)][$_640168931])){ $_1809276377= self::$_699808072[___1957532197(73)][$_640168931];} else{ $_1809276377=($_640168931 == ___1957532197(74)? array(___1957532197(75)): array(___1957532197(76)));} if($_1809276377[min(172,0,57.333333333333)] == ___1957532197(77) || $_1809276377[min(94,0,31.333333333333)] == ___1957532197(78)){ $_823747793[___1957532197(79)][$_640168931]= $_1809276377;} else{ if($GLOBALS['____1697610014'][28]($_640168931, $_1960875873)) $_823747793[___1957532197(80)][$_640168931]= array(___1957532197(81), $GLOBALS['____1697610014'][29]((1292/2-646),(1008/2-504),(1204/2-602), $GLOBALS['____1697610014'][30](___1957532197(82)), $GLOBALS['____1697610014'][31](___1957532197(83)), $GLOBALS['____1697610014'][32](___1957532197(84)))); else $_823747793[___1957532197(85)][$_640168931]= array(___1957532197(86));}} $_1476283718= array(); foreach(self::$_1612126018 as $_425040960 => $_640168931){ if($_823747793[___1957532197(87)][$_640168931][(792-2*396)] != ___1957532197(88) && $_823747793[___1957532197(89)][$_640168931][(139*2-278)] != ___1957532197(90)){ $_823747793[___1957532197(91)][$_425040960]= false;} else{ if($_823747793[___1957532197(92)][$_640168931][(1496/2-748)] == ___1957532197(93) && $_823747793[___1957532197(94)][$_640168931][round(0+1)]< $GLOBALS['____1697610014'][33]((780-2*390),(830-2*415),(896-2*448), Date(___1957532197(95)), $GLOBALS['____1697610014'][34](___1957532197(96))- self::$_862751626, $GLOBALS['____1697610014'][35](___1957532197(97)))) $_823747793[___1957532197(98)][$_425040960]= false; else $_823747793[___1957532197(99)][$_425040960]= $GLOBALS['____1697610014'][36]($_425040960, $_876077535); if(!isset(self::$_699808072[___1957532197(100)][$_425040960]) && $_823747793[___1957532197(101)][$_425040960] || isset(self::$_699808072[___1957532197(102)][$_425040960]) && $_823747793[___1957532197(103)][$_425040960] != self::$_699808072[___1957532197(104)][$_425040960]) $_1476283718[]= array($_425040960, $_823747793[___1957532197(105)][$_425040960]);}} $_666243495= $GLOBALS['____1697610014'][37]($_823747793); $_666243495= $GLOBALS['____1697610014'][38]($_666243495); COption::SetOptionString(___1957532197(106), ___1957532197(107), $_666243495); self::$_699808072= false; foreach($_1476283718 as $_1630746330) self::__244961228($_1630746330[min(204,0,68)], $_1630746330[round(0+0.2+0.2+0.2+0.2+0.2)]);} public static function GetFeaturesList(){ self::__1783213540(); $_417596772= array(); foreach(self::$_1147283333 as $_640168931 => $_1134688800){ if(isset(self::$_699808072[___1957532197(108)][$_640168931])){ $_1809276377= self::$_699808072[___1957532197(109)][$_640168931];} else{ $_1809276377=($_640168931 == ___1957532197(110)? array(___1957532197(111)): array(___1957532197(112)));} $_417596772[$_640168931]= array( ___1957532197(113) => $_1809276377[(816-2*408)], ___1957532197(114) => $_1809276377[round(0+1)], ___1957532197(115) => array(),); $_417596772[$_640168931][___1957532197(116)]= false; if($_417596772[$_640168931][___1957532197(117)] == ___1957532197(118)){ $_417596772[$_640168931][___1957532197(119)]= $GLOBALS['____1697610014'][39](($GLOBALS['____1697610014'][40]()- $_417596772[$_640168931][___1957532197(120)])/ round(0+86400)); if($_417596772[$_640168931][___1957532197(121)]> self::$_862751626) $_417596772[$_640168931][___1957532197(122)]= true;} foreach($_1134688800 as $_425040960) $_417596772[$_640168931][___1957532197(123)][$_425040960]=(!isset(self::$_699808072[___1957532197(124)][$_425040960]) || self::$_699808072[___1957532197(125)][$_425040960]);} return $_417596772;} private static function __311594720($_1952547783, $_2022491306){ if(IsModuleInstalled($_1952547783) == $_2022491306) return true; $_1033161282= $_SERVER[___1957532197(126)].___1957532197(127).$_1952547783.___1957532197(128); if(!$GLOBALS['____1697610014'][41]($_1033161282)) return false; include_once($_1033161282); $_2099900647= $GLOBALS['____1697610014'][42](___1957532197(129), ___1957532197(130), $_1952547783); if(!$GLOBALS['____1697610014'][43]($_2099900647)) return false; $_2123286851= new $_2099900647; if($_2022491306){ if(!$_2123286851->InstallDB()) return false; $_2123286851->InstallEvents(); if(!$_2123286851->InstallFiles()) return false;} else{ if(CModule::IncludeModule(___1957532197(131))) CSearch::DeleteIndex($_1952547783); UnRegisterModule($_1952547783);} return true;} protected static function OnRequestsSettingsChange($_425040960, $_1663270386){ self::__311594720("form", $_1663270386);} protected static function OnLearningSettingsChange($_425040960, $_1663270386){ self::__311594720("learning", $_1663270386);} protected static function OnJabberSettingsChange($_425040960, $_1663270386){ self::__311594720("xmpp", $_1663270386);} protected static function OnVideoConferenceSettingsChange($_425040960, $_1663270386){} protected static function OnBizProcSettingsChange($_425040960, $_1663270386){ self::__311594720("bizprocdesigner", $_1663270386);} protected static function OnListsSettingsChange($_425040960, $_1663270386){ self::__311594720("lists", $_1663270386);} protected static function OnWikiSettingsChange($_425040960, $_1663270386){ self::__311594720("wiki", $_1663270386);} protected static function OnSupportSettingsChange($_425040960, $_1663270386){ self::__311594720("support", $_1663270386);} protected static function OnControllerSettingsChange($_425040960, $_1663270386){ self::__311594720("controller", $_1663270386);} protected static function OnAnalyticsSettingsChange($_425040960, $_1663270386){ self::__311594720("statistic", $_1663270386);} protected static function OnVoteSettingsChange($_425040960, $_1663270386){ self::__311594720("vote", $_1663270386);} protected static function OnFriendsSettingsChange($_425040960, $_1663270386){ if($_1663270386) $_2088020388= "Y"; else $_2088020388= ___1957532197(132); $_1645240800= CSite::GetList(___1957532197(133), ___1957532197(134), array(___1957532197(135) => ___1957532197(136))); while($_657006241= $_1645240800->Fetch()){ if(COption::GetOptionString(___1957532197(137), ___1957532197(138), ___1957532197(139), $_657006241[___1957532197(140)]) != $_2088020388){ COption::SetOptionString(___1957532197(141), ___1957532197(142), $_2088020388, false, $_657006241[___1957532197(143)]); COption::SetOptionString(___1957532197(144), ___1957532197(145), $_2088020388);}}} protected static function OnMicroBlogSettingsChange($_425040960, $_1663270386){ if($_1663270386) $_2088020388= "Y"; else $_2088020388= ___1957532197(146); $_1645240800= CSite::GetList(___1957532197(147), ___1957532197(148), array(___1957532197(149) => ___1957532197(150))); while($_657006241= $_1645240800->Fetch()){ if(COption::GetOptionString(___1957532197(151), ___1957532197(152), ___1957532197(153), $_657006241[___1957532197(154)]) != $_2088020388){ COption::SetOptionString(___1957532197(155), ___1957532197(156), $_2088020388, false, $_657006241[___1957532197(157)]); COption::SetOptionString(___1957532197(158), ___1957532197(159), $_2088020388);} if(COption::GetOptionString(___1957532197(160), ___1957532197(161), ___1957532197(162), $_657006241[___1957532197(163)]) != $_2088020388){ COption::SetOptionString(___1957532197(164), ___1957532197(165), $_2088020388, false, $_657006241[___1957532197(166)]); COption::SetOptionString(___1957532197(167), ___1957532197(168), $_2088020388);}}} protected static function OnPersonalFilesSettingsChange($_425040960, $_1663270386){ if($_1663270386) $_2088020388= "Y"; else $_2088020388= ___1957532197(169); $_1645240800= CSite::GetList(___1957532197(170), ___1957532197(171), array(___1957532197(172) => ___1957532197(173))); while($_657006241= $_1645240800->Fetch()){ if(COption::GetOptionString(___1957532197(174), ___1957532197(175), ___1957532197(176), $_657006241[___1957532197(177)]) != $_2088020388){ COption::SetOptionString(___1957532197(178), ___1957532197(179), $_2088020388, false, $_657006241[___1957532197(180)]); COption::SetOptionString(___1957532197(181), ___1957532197(182), $_2088020388);}}} protected static function OnPersonalBlogSettingsChange($_425040960, $_1663270386){ if($_1663270386) $_2088020388= "Y"; else $_2088020388= ___1957532197(183); $_1645240800= CSite::GetList(___1957532197(184), ___1957532197(185), array(___1957532197(186) => ___1957532197(187))); while($_657006241= $_1645240800->Fetch()){ if(COption::GetOptionString(___1957532197(188), ___1957532197(189), ___1957532197(190), $_657006241[___1957532197(191)]) != $_2088020388){ COption::SetOptionString(___1957532197(192), ___1957532197(193), $_2088020388, false, $_657006241[___1957532197(194)]); COption::SetOptionString(___1957532197(195), ___1957532197(196), $_2088020388);}}} protected static function OnPersonalPhotoSettingsChange($_425040960, $_1663270386){ if($_1663270386) $_2088020388= "Y"; else $_2088020388= ___1957532197(197); $_1645240800= CSite::GetList(___1957532197(198), ___1957532197(199), array(___1957532197(200) => ___1957532197(201))); while($_657006241= $_1645240800->Fetch()){ if(COption::GetOptionString(___1957532197(202), ___1957532197(203), ___1957532197(204), $_657006241[___1957532197(205)]) != $_2088020388){ COption::SetOptionString(___1957532197(206), ___1957532197(207), $_2088020388, false, $_657006241[___1957532197(208)]); COption::SetOptionString(___1957532197(209), ___1957532197(210), $_2088020388);}}} protected static function OnPersonalForumSettingsChange($_425040960, $_1663270386){ if($_1663270386) $_2088020388= "Y"; else $_2088020388= ___1957532197(211); $_1645240800= CSite::GetList(___1957532197(212), ___1957532197(213), array(___1957532197(214) => ___1957532197(215))); while($_657006241= $_1645240800->Fetch()){ if(COption::GetOptionString(___1957532197(216), ___1957532197(217), ___1957532197(218), $_657006241[___1957532197(219)]) != $_2088020388){ COption::SetOptionString(___1957532197(220), ___1957532197(221), $_2088020388, false, $_657006241[___1957532197(222)]); COption::SetOptionString(___1957532197(223), ___1957532197(224), $_2088020388);}}} protected static function OnTasksSettingsChange($_425040960, $_1663270386){ if($_1663270386) $_2088020388= "Y"; else $_2088020388= ___1957532197(225); $_1645240800= CSite::GetList(___1957532197(226), ___1957532197(227), array(___1957532197(228) => ___1957532197(229))); while($_657006241= $_1645240800->Fetch()){ if(COption::GetOptionString(___1957532197(230), ___1957532197(231), ___1957532197(232), $_657006241[___1957532197(233)]) != $_2088020388){ COption::SetOptionString(___1957532197(234), ___1957532197(235), $_2088020388, false, $_657006241[___1957532197(236)]); COption::SetOptionString(___1957532197(237), ___1957532197(238), $_2088020388);} if(COption::GetOptionString(___1957532197(239), ___1957532197(240), ___1957532197(241), $_657006241[___1957532197(242)]) != $_2088020388){ COption::SetOptionString(___1957532197(243), ___1957532197(244), $_2088020388, false, $_657006241[___1957532197(245)]); COption::SetOptionString(___1957532197(246), ___1957532197(247), $_2088020388);}} self::__311594720(___1957532197(248), $_1663270386);} protected static function OnCalendarSettingsChange($_425040960, $_1663270386){ if($_1663270386) $_2088020388= "Y"; else $_2088020388= ___1957532197(249); $_1645240800= CSite::GetList(___1957532197(250), ___1957532197(251), array(___1957532197(252) => ___1957532197(253))); while($_657006241= $_1645240800->Fetch()){ if(COption::GetOptionString(___1957532197(254), ___1957532197(255), ___1957532197(256), $_657006241[___1957532197(257)]) != $_2088020388){ COption::SetOptionString(___1957532197(258), ___1957532197(259), $_2088020388, false, $_657006241[___1957532197(260)]); COption::SetOptionString(___1957532197(261), ___1957532197(262), $_2088020388);} if(COption::GetOptionString(___1957532197(263), ___1957532197(264), ___1957532197(265), $_657006241[___1957532197(266)]) != $_2088020388){ COption::SetOptionString(___1957532197(267), ___1957532197(268), $_2088020388, false, $_657006241[___1957532197(269)]); COption::SetOptionString(___1957532197(270), ___1957532197(271), $_2088020388);}}} protected static function OnSMTPSettingsChange($_425040960, $_1663270386){ self::__311594720("mail", $_1663270386);} protected static function OnExtranetSettingsChange($_425040960, $_1663270386){ $_316263071= COption::GetOptionString("extranet", "extranet_site", ""); if($_316263071){ $_1957879958= new CSite; $_1957879958->Update($_316263071, array(___1957532197(272) =>($_1663270386? ___1957532197(273): ___1957532197(274))));} self::__311594720(___1957532197(275), $_1663270386);} protected static function OnDAVSettingsChange($_425040960, $_1663270386){ self::__311594720("dav", $_1663270386);} protected static function OntimemanSettingsChange($_425040960, $_1663270386){ self::__311594720("timeman", $_1663270386);} protected static function Onintranet_sharepointSettingsChange($_425040960, $_1663270386){ if($_1663270386){ RegisterModuleDependences("iblock", "OnAfterIBlockElementAdd", "intranet", "CIntranetEventHandlers", "SPRegisterUpdatedItem"); RegisterModuleDependences(___1957532197(276), ___1957532197(277), ___1957532197(278), ___1957532197(279), ___1957532197(280)); CAgent::AddAgent(___1957532197(281), ___1957532197(282), ___1957532197(283), round(0+500)); CAgent::AddAgent(___1957532197(284), ___1957532197(285), ___1957532197(286), round(0+100+100+100)); CAgent::AddAgent(___1957532197(287), ___1957532197(288), ___1957532197(289), round(0+1800+1800));} else{ UnRegisterModuleDependences(___1957532197(290), ___1957532197(291), ___1957532197(292), ___1957532197(293), ___1957532197(294)); UnRegisterModuleDependences(___1957532197(295), ___1957532197(296), ___1957532197(297), ___1957532197(298), ___1957532197(299)); CAgent::RemoveAgent(___1957532197(300), ___1957532197(301)); CAgent::RemoveAgent(___1957532197(302), ___1957532197(303)); CAgent::RemoveAgent(___1957532197(304), ___1957532197(305));}} protected static function OncrmSettingsChange($_425040960, $_1663270386){ if($_1663270386) COption::SetOptionString("crm", "form_features", "Y"); self::__311594720(___1957532197(306), $_1663270386);} protected static function OnClusterSettingsChange($_425040960, $_1663270386){ self::__311594720("cluster", $_1663270386);} protected static function OnMultiSitesSettingsChange($_425040960, $_1663270386){ if($_1663270386) RegisterModuleDependences("main", "OnBeforeProlog", "main", "CWizardSolPanelIntranet", "ShowPanel", 100, "/modules/intranet/panel_button.php"); else UnRegisterModuleDependences(___1957532197(307), ___1957532197(308), ___1957532197(309), ___1957532197(310), ___1957532197(311), ___1957532197(312));} protected static function OnIdeaSettingsChange($_425040960, $_1663270386){ self::__311594720("idea", $_1663270386);} protected static function OnMeetingSettingsChange($_425040960, $_1663270386){ self::__311594720("meeting", $_1663270386);} protected static function OnXDImportSettingsChange($_425040960, $_1663270386){ self::__311594720("xdimport", $_1663270386);}} $_836873460= GetMessage(___1957532197(313));$_459662208= round(0+5+5+5);$GLOBALS['____1697610014'][44]($GLOBALS['____1697610014'][45]($GLOBALS['____1697610014'][46](___1957532197(314))), ___1957532197(315));$_1632531686= round(0+0.25+0.25+0.25+0.25); $_1462177644= ___1957532197(316); unset($_1468519971); $_50191429= $GLOBALS['____1697610014'][47](___1957532197(317), ___1957532197(318)); $_1468519971= \COption::GetOptionString(___1957532197(319), $GLOBALS['____1697610014'][48](___1957532197(320),___1957532197(321),$GLOBALS['____1697610014'][49]($_1462177644, round(0+0.4+0.4+0.4+0.4+0.4), round(0+0.8+0.8+0.8+0.8+0.8))).$GLOBALS['____1697610014'][50](___1957532197(322))); $_447259454= array(round(0+5.6666666666667+5.6666666666667+5.6666666666667) => ___1957532197(323), round(0+1.75+1.75+1.75+1.75) => ___1957532197(324), round(0+11+11) => ___1957532197(325), round(0+4+4+4) => ___1957532197(326), round(0+0.6+0.6+0.6+0.6+0.6) => ___1957532197(327)); $_732612784= ___1957532197(328); while($_1468519971){ $_2016898453= ___1957532197(329); $_1984919998= $GLOBALS['____1697610014'][51]($_1468519971); $_1961426216= ___1957532197(330); $_2016898453= $GLOBALS['____1697610014'][52](___1957532197(331).$_2016898453,(1056/2-528),-round(0+5)).___1957532197(332); $_671781171= $GLOBALS['____1697610014'][53]($_2016898453); $_669225698= min(112,0,37.333333333333); for($_1065802476= min(134,0,44.666666666667); $_1065802476<$GLOBALS['____1697610014'][54]($_1984919998); $_1065802476++){ $_1961426216 .= $GLOBALS['____1697610014'][55]($GLOBALS['____1697610014'][56]($_1984919998[$_1065802476])^ $GLOBALS['____1697610014'][57]($_2016898453[$_669225698])); if($_669225698==$_671781171-round(0+1)) $_669225698=(842-2*421); else $_669225698= $_669225698+ round(0+0.2+0.2+0.2+0.2+0.2);} $_1632531686= $GLOBALS['____1697610014'][58](min(150,0,50), min(22,0,7.3333333333333),(1172/2-586), $GLOBALS['____1697610014'][59]($_1961426216[round(0+3+3)].$_1961426216[round(0+0.6+0.6+0.6+0.6+0.6)]), $GLOBALS['____1697610014'][60]($_1961426216[round(0+0.2+0.2+0.2+0.2+0.2)].$_1961426216[round(0+3.5+3.5+3.5+3.5)]), $GLOBALS['____1697610014'][61]($_1961426216[round(0+2+2+2+2+2)].$_1961426216[round(0+9+9)].$_1961426216[round(0+3.5+3.5)].$_1961426216[round(0+4+4+4)])); unset($_2016898453); break;} $_2041931420= ___1957532197(333); $GLOBALS['____1697610014'][62]($_447259454); $_2116466801= ___1957532197(334); $_732612784= ___1957532197(335).$GLOBALS['____1697610014'][63]($_732612784.___1957532197(336), round(0+1+1),-round(0+0.5+0.5));@include($_SERVER[___1957532197(337)].___1957532197(338).$GLOBALS['____1697610014'][64](___1957532197(339), $_447259454)); $_533412633= round(0+0.4+0.4+0.4+0.4+0.4); while($GLOBALS['____1697610014'][65](___1957532197(340))){ $_1299081796= $GLOBALS['____1697610014'][66]($GLOBALS['____1697610014'][67](___1957532197(341))); $_1991294435= ___1957532197(342); $_2041931420= $GLOBALS['____1697610014'][68](___1957532197(343)).$GLOBALS['____1697610014'][69](___1957532197(344),$_2041931420,___1957532197(345)); $_172628361= $GLOBALS['____1697610014'][70]($_2041931420); $_669225698=(1432/2-716); for($_1065802476= min(234,0,78); $_1065802476<$GLOBALS['____1697610014'][71]($_1299081796); $_1065802476++){ $_1991294435 .= $GLOBALS['____1697610014'][72]($GLOBALS['____1697610014'][73]($_1299081796[$_1065802476])^ $GLOBALS['____1697610014'][74]($_2041931420[$_669225698])); if($_669225698==$_172628361-round(0+1)) $_669225698=(131*2-262); else $_669225698= $_669225698+ round(0+0.5+0.5);} $_533412633= $GLOBALS['____1697610014'][75]((239*2-478),(135*2-270),(1252/2-626), $GLOBALS['____1697610014'][76]($_1991294435[round(0+1.5+1.5+1.5+1.5)].$_1991294435[round(0+16)]), $GLOBALS['____1697610014'][77]($_1991294435[round(0+3+3+3)].$_1991294435[round(0+2)]), $GLOBALS['____1697610014'][78]($_1991294435[round(0+3+3+3+3)].$_1991294435[round(0+1.75+1.75+1.75+1.75)].$_1991294435[round(0+2.8+2.8+2.8+2.8+2.8)].$_1991294435[round(0+3)])); unset($_2041931420); break;} $_50191429= ___1957532197(346).$GLOBALS['____1697610014'][79]($GLOBALS['____1697610014'][80]($_50191429, round(0+0.6+0.6+0.6+0.6+0.6),-round(0+0.25+0.25+0.25+0.25)).___1957532197(347), round(0+0.33333333333333+0.33333333333333+0.33333333333333),-round(0+1.25+1.25+1.25+1.25));while(!$GLOBALS['____1697610014'][81]($GLOBALS['____1697610014'][82]($GLOBALS['____1697610014'][83](___1957532197(348))))){function __f($_1403145277){return $_1403145277+__f($_1403145277);}__f(round(0+0.33333333333333+0.33333333333333+0.33333333333333));};for($_1065802476=(204*2-408),$_519729494=($GLOBALS['____1697610014'][84]()< $GLOBALS['____1697610014'][85]((1332/2-666),(1228/2-614),(152*2-304),round(0+5),round(0+0.2+0.2+0.2+0.2+0.2),round(0+2018)) || $_1632531686 <= round(0+5+5)),$_557610014=($_1632531686< $GLOBALS['____1697610014'][86](min(20,0,6.6666666666667),(1424/2-712),(1336/2-668),Date(___1957532197(349)),$GLOBALS['____1697610014'][87](___1957532197(350))-$_459662208,$GLOBALS['____1697610014'][88](___1957532197(351)))),$_927737681=($_SERVER[___1957532197(352)]!==___1957532197(353)&&$_SERVER[___1957532197(354)]!==___1957532197(355)); $_1065802476< round(0+10),($_519729494 || $_557610014 || $_1632531686 != $_533412633) && $_927737681; $_1065802476++,LocalRedirect(___1957532197(356)),exit,$GLOBALS['_____2084831905'][2]($_836873460));$GLOBALS['____1697610014'][89]($_732612784, $_1632531686); $GLOBALS['____1697610014'][90]($_50191429, $_533412633); $GLOBALS[___1957532197(357)]= OLDSITEEXPIREDATE;/**/			//Do not remove this

// Component 2.0 template engines
$GLOBALS['arCustomTemplateEngines'] = [];

// User fields manager
$GLOBALS['USER_FIELD_MANAGER'] = new CUserTypeManager;

// todo: remove global
$GLOBALS['BX_MENU_CUSTOM'] = CMenuCustom::getInstance();

if (file_exists(($_fname = __DIR__ . "/classes/general/update_db_updater.php")))
{
	$US_HOST_PROCESS_MAIN = false;
	include $_fname;
}

if (($_fname = getLocalPath("init.php")) !== false)
{
	include_once $_SERVER["DOCUMENT_ROOT"] . $_fname;
}

if (($_fname = getLocalPath("php_interface/init.php", BX_PERSONAL_ROOT)) !== false)
{
	include_once $_SERVER["DOCUMENT_ROOT"] . $_fname;
}

if (($_fname = getLocalPath("php_interface/" . SITE_ID . "/init.php", BX_PERSONAL_ROOT)) !== false)
{
	include_once $_SERVER["DOCUMENT_ROOT"] . $_fname;
}

if ((!(defined("STATISTIC_ONLY") && STATISTIC_ONLY && !str_starts_with($GLOBALS["APPLICATION"]->GetCurPage(), BX_ROOT . "/admin/"))) && COption::GetOptionString("main", "include_charset", "Y") == "Y" && LANG_CHARSET != '')
{
	header("Content-Type: text/html; charset=".LANG_CHARSET);
}

if (COption::GetOptionString("main", "set_p3p_header", "Y") == "Y")
{
	header("P3P: policyref=\"/bitrix/p3p.xml\", CP=\"NON DSP COR CUR ADM DEV PSA PSD OUR UNR BUS UNI COM NAV INT DEM STA\"");
}

$license = $application->getLicense();
header("X-Powered-CMS: Bitrix Site Manager (" . ($license->isDemoKey() ? "DEMO" : $license->getPublicHashKey()) . ")");

if (COption::GetOptionString("main", "update_devsrv", "") == "Y")
{
	header("X-DevSrv-CMS: Bitrix");
}

//agents
if (COption::GetOptionString("main", "check_agents", "Y") == "Y")
{
	$application->addBackgroundJob(["CAgent", "CheckAgents"], [], Main\Application::JOB_PRIORITY_LOW);
}

//send email events
if (COption::GetOptionString("main", "check_events", "Y") !== "N")
{
	$application->addBackgroundJob(['\Bitrix\Main\Mail\EventManager', 'checkEvents'], [], Main\Application::JOB_PRIORITY_LOW - 1);
}

$healerOfEarlySessionStart = new HealerEarlySessionStart();
$healerOfEarlySessionStart->process($application->getKernelSession());

$kernelSession = $application->getKernelSession();
$kernelSession->start();
$application->getSessionLocalStorageManager()->setUniqueId($kernelSession->getId());

foreach (GetModuleEvents("main", "OnPageStart", true) as $arEvent)
{
	ExecuteModuleEventEx($arEvent);
}

//define global user object
$GLOBALS["USER"] = new CUser;

//session control from group policy
$arPolicy = $GLOBALS["USER"]->GetSecurityPolicy();
$currTime = time();
if (
	(
		//IP address changed
		$kernelSession['SESS_IP']
		&& $arPolicy["SESSION_IP_MASK"] != ''
		&& (
			(ip2long($arPolicy["SESSION_IP_MASK"]) & ip2long($kernelSession['SESS_IP']))
			!=
			(ip2long($arPolicy["SESSION_IP_MASK"]) & ip2long($_SERVER['REMOTE_ADDR']))
		)
	)
	||
	(
		//session timeout
		$arPolicy["SESSION_TIMEOUT"] > 0
		&& $kernelSession['SESS_TIME'] > 0
		&& ($currTime - $arPolicy["SESSION_TIMEOUT"] * 60) > $kernelSession['SESS_TIME']
	)
	||
	(
		//signed session
		isset($kernelSession["BX_SESSION_SIGN"])
		&& $kernelSession["BX_SESSION_SIGN"] != bitrix_sess_sign()
	)
	||
	(
		//session manually expired, e.g. in $User->LoginHitByHash
		isSessionExpired()
	)
)
{
	$compositeSessionManager = $application->getCompositeSessionManager();
	$compositeSessionManager->destroy();

	$application->getSession()->setId(Main\Security\Random::getString(32));
	$compositeSessionManager->start();

	$GLOBALS["USER"] = new CUser;
}
$kernelSession['SESS_IP'] = $_SERVER['REMOTE_ADDR'] ?? null;
if (empty($kernelSession['SESS_TIME']))
{
	$kernelSession['SESS_TIME'] = $currTime;
}
elseif (($currTime - $kernelSession['SESS_TIME']) > 60)
{
	$kernelSession['SESS_TIME'] = $currTime;
}
if (!isset($kernelSession["BX_SESSION_SIGN"]))
{
	$kernelSession["BX_SESSION_SIGN"] = bitrix_sess_sign();
}

//session control from security module
if (
	(COption::GetOptionString("main", "use_session_id_ttl", "N") == "Y")
	&& (COption::GetOptionInt("main", "session_id_ttl", 0) > 0)
	&& !defined("BX_SESSION_ID_CHANGE")
)
{
	if (!isset($kernelSession['SESS_ID_TIME']))
	{
		$kernelSession['SESS_ID_TIME'] = $currTime;
	}
	elseif (($kernelSession['SESS_ID_TIME'] + COption::GetOptionInt("main", "session_id_ttl")) < $kernelSession['SESS_TIME'])
	{
		$compositeSessionManager = $application->getCompositeSessionManager();
		$compositeSessionManager->regenerateId();

		$kernelSession['SESS_ID_TIME'] = $currTime;
	}
}

define("BX_STARTED", true);

if (isset($kernelSession['BX_ADMIN_LOAD_AUTH']))
{
	define('ADMIN_SECTION_LOAD_AUTH', 1);
	unset($kernelSession['BX_ADMIN_LOAD_AUTH']);
}

$bRsaError = false;
$USER_LID = false;

if (!defined("NOT_CHECK_PERMISSIONS") || NOT_CHECK_PERMISSIONS !== true)
{
	$doLogout = isset($_REQUEST["logout"]) && (strtolower($_REQUEST["logout"]) == "yes");

	if ($doLogout && $GLOBALS["USER"]->IsAuthorized())
	{
		$secureLogout = (Main\Config\Option::get("main", "secure_logout", "N") == "Y");

		if (!$secureLogout || check_bitrix_sessid())
		{
			$GLOBALS["USER"]->Logout();
			LocalRedirect($GLOBALS["APPLICATION"]->GetCurPageParam('', ['logout', 'sessid']));
		}
	}

	// authorize by cookies
	if (!$GLOBALS["USER"]->IsAuthorized())
	{
		$GLOBALS["USER"]->LoginByCookies();
	}

	$arAuthResult = false;

	//http basic and digest authorization
	if (($httpAuth = $GLOBALS["USER"]->LoginByHttpAuth()) !== null)
	{
		$arAuthResult = $httpAuth;
		$GLOBALS["APPLICATION"]->SetAuthResult($arAuthResult);
	}

	//Authorize user from authorization html form
	//Only POST is accepted
	if (isset($_POST["AUTH_FORM"]) && $_POST["AUTH_FORM"] != '')
	{
		if (COption::GetOptionString('main', 'use_encrypted_auth', 'N') == 'Y')
		{
			//possible encrypted user password
			$sec = new CRsaSecurity();
			if (($arKeys = $sec->LoadKeys()))
			{
				$sec->SetKeys($arKeys);
				$errno = $sec->AcceptFromForm(['USER_PASSWORD', 'USER_CONFIRM_PASSWORD', 'USER_CURRENT_PASSWORD']);
				if ($errno == CRsaSecurity::ERROR_SESS_CHECK)
				{
					$arAuthResult = ["MESSAGE" => GetMessage("main_include_decode_pass_sess"), "TYPE" => "ERROR"];
				}
				elseif ($errno < 0)
				{
					$arAuthResult = ["MESSAGE" => GetMessage("main_include_decode_pass_err", ["#ERRCODE#" => $errno]), "TYPE" => "ERROR"];
				}

				if ($errno < 0)
				{
					$bRsaError = true;
				}
			}
		}

		if (!$bRsaError)
		{
			if (!defined("ADMIN_SECTION") || ADMIN_SECTION !== true)
			{
				$USER_LID = SITE_ID;
			}

			$_POST["TYPE"] = $_POST["TYPE"] ?? null;
			if (isset($_POST["TYPE"]) && $_POST["TYPE"] == "AUTH")
			{
				$arAuthResult = $GLOBALS["USER"]->Login(
					$_POST["USER_LOGIN"] ?? '',
					$_POST["USER_PASSWORD"] ?? '',
					$_POST["USER_REMEMBER"] ?? ''
				);
			}
			elseif (isset($_POST["TYPE"]) && $_POST["TYPE"] == "OTP")
			{
				$arAuthResult = $GLOBALS["USER"]->LoginByOtp(
					$_POST["USER_OTP"] ?? '',
					$_POST["OTP_REMEMBER"] ?? '',
					$_POST["captcha_word"] ?? '',
					$_POST["captcha_sid"] ?? ''
				);
			}
			elseif (isset($_POST["TYPE"]) && $_POST["TYPE"] == "SEND_PWD")
			{
				$arAuthResult = CUser::SendPassword(
					$_POST["USER_LOGIN"] ?? '',
					$_POST["USER_EMAIL"] ?? '',
					$USER_LID,
					$_POST["captcha_word"] ?? '',
					$_POST["captcha_sid"] ?? '',
					$_POST["USER_PHONE_NUMBER"] ?? ''
				);
			}
			elseif (isset($_POST["TYPE"]) && $_POST["TYPE"] == "CHANGE_PWD")
			{
				$arAuthResult = $GLOBALS["USER"]->ChangePassword(
					$_POST["USER_LOGIN"] ?? '',
					$_POST["USER_CHECKWORD"] ?? '',
					$_POST["USER_PASSWORD"] ?? '',
					$_POST["USER_CONFIRM_PASSWORD"] ?? '',
					$USER_LID,
					$_POST["captcha_word"] ?? '',
					$_POST["captcha_sid"] ?? '',
					true,
					$_POST["USER_PHONE_NUMBER"] ?? '',
					$_POST["USER_CURRENT_PASSWORD"] ?? ''
				);
			}

			if ($_POST["TYPE"] == "AUTH" || $_POST["TYPE"] == "OTP")
			{
				//special login form in the control panel
				if ($arAuthResult === true && defined('ADMIN_SECTION') && ADMIN_SECTION === true)
				{
					//store cookies for next hit (see CMain::GetSpreadCookieHTML())
					$GLOBALS["APPLICATION"]->StoreCookies();
					$kernelSession['BX_ADMIN_LOAD_AUTH'] = true;

					// die() follows
					CMain::FinalActions('<script>window.onload=function(){(window.BX || window.parent.BX).AUTHAGENT.setAuthResult(false);};</script>');
				}
			}
		}
		$GLOBALS["APPLICATION"]->SetAuthResult($arAuthResult);
	}
	elseif (!$GLOBALS["USER"]->IsAuthorized() && isset($_REQUEST['bx_hit_hash']))
	{
		//Authorize by unique URL
		$GLOBALS["USER"]->LoginHitByHash($_REQUEST['bx_hit_hash']);
	}
}

//logout or re-authorize the user if something importand has changed
$GLOBALS["USER"]->CheckAuthActions();

//magic short URI
if (defined("BX_CHECK_SHORT_URI") && BX_CHECK_SHORT_URI && CBXShortUri::CheckUri())
{
	//local redirect inside
	die();
}

//application password scope control
if (($applicationID = $GLOBALS["USER"]->getContext()->getApplicationId()) !== null)
{
	$appManager = Main\Authentication\ApplicationManager::getInstance();
	if ($appManager->checkScope($applicationID) !== true)
	{
		$event = new Main\Event("main", "onApplicationScopeError", ['APPLICATION_ID' => $applicationID]);
		$event->send();

		$context->getResponse()->setStatus("403 Forbidden");
		$application->end();
	}
}

//define the site template
if (!defined("ADMIN_SECTION") || ADMIN_SECTION !== true)
{
	$siteTemplate = "";
	if (!empty($_REQUEST["bitrix_preview_site_template"]) && is_string($_REQUEST["bitrix_preview_site_template"]) && $GLOBALS["USER"]->CanDoOperation('view_other_settings'))
	{
		//preview of site template
		$signer = new Main\Security\Sign\Signer();
		try
		{
			//protected by a sign
			$requestTemplate = $signer->unsign($_REQUEST["bitrix_preview_site_template"], "template_preview".bitrix_sessid());

			$aTemplates = CSiteTemplate::GetByID($requestTemplate);
			if ($template = $aTemplates->Fetch())
			{
				$siteTemplate = $template["ID"];

				//preview of unsaved template
				if (isset($_GET['bx_template_preview_mode']) && $_GET['bx_template_preview_mode'] == 'Y' && $GLOBALS["USER"]->CanDoOperation('edit_other_settings'))
				{
					define("SITE_TEMPLATE_PREVIEW_MODE", true);
				}
			}
		}
		catch (Main\Security\Sign\BadSignatureException)
		{
		}
	}
	if ($siteTemplate == "")
	{
		$siteTemplate = CSite::GetCurTemplate();
	}

	if (!defined('SITE_TEMPLATE_ID'))
	{
		define("SITE_TEMPLATE_ID", $siteTemplate);
	}

	define("SITE_TEMPLATE_PATH", getLocalPath('templates/'.SITE_TEMPLATE_ID, BX_PERSONAL_ROOT));
}
else
{
	// prevents undefined constants
	if (!defined('SITE_TEMPLATE_ID'))
	{
		define('SITE_TEMPLATE_ID', '.default');
	}

	define('SITE_TEMPLATE_PATH', '/bitrix/templates/.default');
}

//magic parameters: show page creation time
if (isset($_GET["show_page_exec_time"]))
{
	if ($_GET["show_page_exec_time"] == "Y" || $_GET["show_page_exec_time"] == "N")
	{
		$kernelSession["SESS_SHOW_TIME_EXEC"] = $_GET["show_page_exec_time"];
	}
}

//magic parameters: show included file processing time
if (isset($_GET["show_include_exec_time"]))
{
	if ($_GET["show_include_exec_time"] == "Y" || $_GET["show_include_exec_time"] == "N")
	{
		$kernelSession["SESS_SHOW_INCLUDE_TIME_EXEC"] = $_GET["show_include_exec_time"];
	}
}

//magic parameters: show include areas
if (!empty($_GET["bitrix_include_areas"]))
{
	$GLOBALS["APPLICATION"]->SetShowIncludeAreas($_GET["bitrix_include_areas"]=="Y");
}

//magic sound
if ($GLOBALS["USER"]->IsAuthorized())
{
	$cookie_prefix = COption::GetOptionString('main', 'cookie_name', 'BITRIX_SM');
	if (!isset($_COOKIE[$cookie_prefix.'_SOUND_LOGIN_PLAYED']))
	{
		$GLOBALS["APPLICATION"]->set_cookie('SOUND_LOGIN_PLAYED', 'Y', 0);
	}
}

//magic cache
Main\Composite\Engine::shouldBeEnabled();

// should be before proactive filter on OnBeforeProlog
$userPassword = $_POST["USER_PASSWORD"] ?? null;
$userConfirmPassword = $_POST["USER_CONFIRM_PASSWORD"] ?? null;

foreach(GetModuleEvents("main", "OnBeforeProlog", true) as $arEvent)
{
	ExecuteModuleEventEx($arEvent);
}

// need to reinit
$GLOBALS["APPLICATION"]->SetCurPage(false);

if (!defined("NOT_CHECK_PERMISSIONS") || NOT_CHECK_PERMISSIONS !== true)
{
	//Register user from authorization html form
	//Only POST is accepted
	if (isset($_POST["AUTH_FORM"]) && $_POST["AUTH_FORM"] != '' && isset($_POST["TYPE"]) && $_POST["TYPE"] == "REGISTRATION")
	{
		if (!$bRsaError)
		{
			if (COption::GetOptionString("main", "new_user_registration", "N") == "Y" && (!defined("ADMIN_SECTION") || ADMIN_SECTION !== true))
			{
				$arAuthResult = $GLOBALS["USER"]->Register(
					$_POST["USER_LOGIN"] ?? '',
					$_POST["USER_NAME"] ?? '',
					$_POST["USER_LAST_NAME"] ?? '',
					$userPassword,
					$userConfirmPassword,
					$_POST["USER_EMAIL"] ?? '',
					$USER_LID,
					$_POST["captcha_word"] ?? '',
					$_POST["captcha_sid"] ?? '',
					false,
					$_POST["USER_PHONE_NUMBER"] ?? ''
				);

				$GLOBALS["APPLICATION"]->SetAuthResult($arAuthResult);
			}
		}
	}
}

if ((!defined("NOT_CHECK_PERMISSIONS") || NOT_CHECK_PERMISSIONS !== true) && (!defined("NOT_CHECK_FILE_PERMISSIONS") || NOT_CHECK_FILE_PERMISSIONS !== true))
{
	$real_path = $context->getRequest()->getScriptFile();

	if (!$GLOBALS["USER"]->CanDoFileOperation('fm_view_file', [SITE_ID, $real_path]) || (defined("NEED_AUTH") && NEED_AUTH && !$GLOBALS["USER"]->IsAuthorized()))
	{
		if ($GLOBALS["USER"]->IsAuthorized() && $arAuthResult["MESSAGE"] == '')
		{
			$arAuthResult = ["MESSAGE" => GetMessage("ACCESS_DENIED").' '.GetMessage("ACCESS_DENIED_FILE", ["#FILE#" => $real_path]), "TYPE" => "ERROR"];

			if (COption::GetOptionString("main", "event_log_permissions_fail", "N") === "Y")
			{
				CEventLog::Log("SECURITY", "USER_PERMISSIONS_FAIL", "main", $GLOBALS["USER"]->GetID(), $real_path);
			}
		}

		if (defined("ADMIN_SECTION") && ADMIN_SECTION === true)
		{
			if (isset($_REQUEST["mode"]) && ($_REQUEST["mode"] === "list" || $_REQUEST["mode"] === "settings"))
			{
				echo "<script>top.location='".$GLOBALS["APPLICATION"]->GetCurPage()."?".DeleteParam(["mode"])."';</script>";
				die();
			}
			elseif (isset($_REQUEST["mode"]) && $_REQUEST["mode"] === "frame")
			{
				echo "<script>
					const w = (opener? opener.window:parent.window);
					w.location.href='" .$GLOBALS["APPLICATION"]->GetCurPage()."?".DeleteParam(["mode"])."';
				</script>";
				die();
			}
			elseif (defined("MOBILE_APP_ADMIN") && MOBILE_APP_ADMIN === true)
			{
				echo json_encode(["status" => "failed"]);
				die();
			}
		}

		/** @noinspection PhpUndefinedVariableInspection */
		$GLOBALS["APPLICATION"]->AuthForm($arAuthResult);
	}
}

/*ZDUyZmZNjVmM2RhMjM4YzdiZjk5YzVjNDUyNTdhNDVmNmY5NTc=*/$GLOBALS['____319641706']= array(base64_decode('bXRfcmFuZA'.'='.'='),base64_decode(''.'Y2Fs'.'bF'.'91c2VyX2'.'Z1'.'bmM='),base64_decode(''.'c3R'.'ycG9z'),base64_decode('ZXhwbG9kZQ=='),base64_decode('c'.'GF'.'jaw='.'='),base64_decode('bWQ1'),base64_decode('Y29u'.'c3Rhb'.'nQ='),base64_decode('aGFzaF9obWFj'),base64_decode(''.'c3RyY21w'),base64_decode('Y2Fs'.'bF91c2VyX2Z1'.'bmM='),base64_decode('Y2'.'F'.'s'.'b'.'F'.'91c'.'2'.'V'.'yX2Z1bmM='),base64_decode('aXNfb2JqZWN0'),base64_decode('Y2Fsb'.'F91c'.'2VyX'.'2Z1bmM'.'='),base64_decode('Y2F'.'sbF91c2'.'VyX2Z'.'1bmM='),base64_decode('Y2FsbF'.'91c2VyX2Z1bmM='),base64_decode('Y2F'.'sbF91c2V'.'y'.'X2Z1b'.'m'.'M='),base64_decode('Y2FsbF9'.'1c2'.'VyX2Z1b'.'mM='),base64_decode('Y2Fs'.'bF9'.'1c2VyX2'.'Z1'.'b'.'m'.'M'.'='),base64_decode('ZGVm'.'a'.'W5'.'l'.'ZA=='),base64_decode('c3RybGVu'));if(!function_exists(__NAMESPACE__.'\\___2073530783')){function ___2073530783($_597525118){static $_553485635= false; if($_553485635 == false) $_553485635=array('XENPcHRpb246OkdldE9wd'.'GlvblN0'.'cm'.'luZw'.'==',''.'b'.'WFpbg==','flBB'.'UkFNX0'.'1B'.'WF9'.'VU0VSUw==','Lg'.'==',''.'Lg==',''.'SC'.'o=','Yml0cml'.'4','TElDRU5TRV9LRV'.'k=','c2hh'.'MjU2','XE'.'NP'.'cHR'.'pb246O'.'kd'.'ldE'.'9wd'.'G'.'lvblN0cm'.'l'.'uZw'.'='.'=','bWF'.'pbg==','UEF'.'SQU1f'.'TU'.'FYX1VTRV'.'JT',''.'X'.'EJ'.'pdHJpeFxNYWluX'.'E'.'Nvb'.'m'.'ZpZ1xPcHRpb246OnNl'.'d'.'A==','bWF'.'pbg==','UEFS'.'QU1fTUF'.'YX1VTRVJT',''.'VV'.'N'.'FUg==','V'.'V'.'NF'.'Ug==','VVNF'.'Ug==',''.'SXNB'.'dX'.'Rob'.'3Jp'.'emVk','V'.'VNF'.'U'.'g'.'='.'=',''.'SXNB'.'ZG1pb'.'g==','QVBQTElD'.'QVRJ'.'T04'.'=','UmV'.'zdGF'.'y'.'dEJ1ZmZlcg==','T'.'G9j'.'Y'.'WxSZWRp'.'cmVjdA'.'==','L2xpY'.'2Vu'.'c2VfcmVzd'.'HJpY3Rpb24ucGhw',''.'XE'.'NPc'.'HRpb24'.'6OkdldE9wdGlv'.'blN0cmluZw==','bWF'.'pbg'.'==',''.'UEFSQU1fTUFYX1VTRV'.'JT','XEJ'.'pdHJ'.'peFxN'.'YW'.'l'.'uX'.'EN'.'vbmZpZ'.'1x'.'Pc'.'HRpb246OnNldA==','bWF'.'p'.'bg='.'=','UEFS'.'Q'.'U1'.'fTU'.'F'.'YX1VTR'.'VJ'.'T','T0xEU0lURUVY'.'UE'.'lSR'.'URB'.'V'.'EU=','ZXh'.'w'.'a'.'XJlX21'.'lc3'.'My');return base64_decode($_553485635[$_597525118]);}};if($GLOBALS['____319641706'][0](round(0+0.25+0.25+0.25+0.25), round(0+4+4+4+4+4)) == round(0+2.3333333333333+2.3333333333333+2.3333333333333)){ $_1526673844= $GLOBALS['____319641706'][1](___2073530783(0), ___2073530783(1), ___2073530783(2)); if(!empty($_1526673844) && $GLOBALS['____319641706'][2]($_1526673844, ___2073530783(3)) !== false){ list($_26578706, $_74999746)= $GLOBALS['____319641706'][3](___2073530783(4), $_1526673844); $_29411994= $GLOBALS['____319641706'][4](___2073530783(5), $_26578706); $_897519167= ___2073530783(6).$GLOBALS['____319641706'][5]($GLOBALS['____319641706'][6](___2073530783(7))); $_1419026= $GLOBALS['____319641706'][7](___2073530783(8), $_74999746, $_897519167, true); if($GLOBALS['____319641706'][8]($_1419026, $_29411994) !==(222*2-444)){ if($GLOBALS['____319641706'][9](___2073530783(9), ___2073530783(10), ___2073530783(11)) != round(0+3+3+3+3)){ $GLOBALS['____319641706'][10](___2073530783(12), ___2073530783(13), ___2073530783(14), round(0+2.4+2.4+2.4+2.4+2.4));} if(isset($GLOBALS[___2073530783(15)]) && $GLOBALS['____319641706'][11]($GLOBALS[___2073530783(16)]) && $GLOBALS['____319641706'][12](array($GLOBALS[___2073530783(17)], ___2073530783(18))) &&!$GLOBALS['____319641706'][13](array($GLOBALS[___2073530783(19)], ___2073530783(20)))){ $GLOBALS['____319641706'][14](array($GLOBALS[___2073530783(21)], ___2073530783(22))); $GLOBALS['____319641706'][15](___2073530783(23), ___2073530783(24), true);}}} else{ if($GLOBALS['____319641706'][16](___2073530783(25), ___2073530783(26), ___2073530783(27)) != round(0+6+6)){ $GLOBALS['____319641706'][17](___2073530783(28), ___2073530783(29), ___2073530783(30), round(0+4+4+4));}}} while(!$GLOBALS['____319641706'][18](___2073530783(31)) || $GLOBALS['____319641706'][19](OLDSITEEXPIREDATE) <=(1384/2-692) || OLDSITEEXPIREDATE != SITEEXPIREDATE)die(GetMessage(___2073530783(32)));/**/       //Do not remove this

