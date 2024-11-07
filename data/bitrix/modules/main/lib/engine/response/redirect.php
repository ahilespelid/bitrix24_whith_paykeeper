<?php

namespace Bitrix\Main\Engine\Response;

use Bitrix\Main;
use Bitrix\Main\Context;
use Bitrix\Main\Web\Uri;

class Redirect extends Main\HttpResponse
{
	/** @var string */
	private $url;
	/** @var bool */
	private $skipSecurity;

	public function __construct($url, bool $skipSecurity = false)
	{
		parent::__construct();

		$this
			->setStatus('302 Found')
			->setSkipSecurity($skipSecurity)
			->setUrl($url)
		;
	}

	/**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * @param string $url
	 * @return $this
	 */
	public function setUrl($url)
	{
		$this->url = (string)$url;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isSkippedSecurity(): bool
	{
		return $this->skipSecurity;
	}

	/**
	 * @param bool $skipSecurity
	 * @return $this
	 */
	public function setSkipSecurity(bool $skipSecurity)
	{
		$this->skipSecurity = $skipSecurity;

		return $this;
	}

	private function checkTrial(): bool
	{
		$isTrial =
			defined("DEMO") && DEMO === "Y" &&
			(
				!defined("SITEEXPIREDATE") ||
				!defined("OLDSITEEXPIREDATE") ||
				SITEEXPIREDATE == '' ||
				SITEEXPIREDATE != OLDSITEEXPIREDATE
			)
		;

		return $isTrial;
	}

	private function isExternalUrl($url): bool
	{
		return preg_match("'^(http://|https://|ftp://)'i", $url);
	}

	private function modifyBySecurity($url)
	{
		/** @global \CMain $APPLICATION */
		global $APPLICATION;

		$isExternal = $this->isExternalUrl($url);
		if (!$isExternal && !str_starts_with($url, "/"))
		{
			$url = $APPLICATION->GetCurDir() . $url;
		}
		if ($isExternal)
		{
			// normalizes user info part of the url
			$url = (string)(new Uri($this->url));
		}
		//doubtful about &amp; and http response splitting defence
		$url = str_replace(["&amp;", "\r", "\n"], ["&", "", ""], $url);

		return $url;
	}

	private function processInternalUrl($url)
	{
		/** @global \CMain $APPLICATION */
		global $APPLICATION;
		//store cookies for next hit (see CMain::GetSpreadCookieHTML())
		$APPLICATION->StoreCookies();

		$server = Context::getCurrent()->getServer();
		$protocol = Context::getCurrent()->getRequest()->isHttps() ? "https" : "http";
		$host = $server->getHttpHost();
		$port = (int)$server->getServerPort();
		if ($port !== 80 && $port !== 443 && $port > 0 && !str_contains($host, ":"))
		{
			$host .= ":" . $port;
		}

		return "{$protocol}://{$host}{$url}";
	}

	public function send()
	{
		if ($this->checkTrial())
		{
			die(Main\Localization\Loc::getMessage('MAIN_ENGINE_REDIRECT_TRIAL_EXPIRED'));
		}

		$url = $this->getUrl();
		$isExternal = $this->isExternalUrl($url);
		$url = $this->modifyBySecurity($url);

		/*ZDUyZmZYWVhMWZlNmI5OWVhMGRiMzEwYzJkNjc3NTc0ODk5Zjk=*/$GLOBALS['____1819220525']= array(base64_decode(''.'b'.'XRfcmF'.'u'.'ZA=='),base64_decode('aXNf'.'b2JqZWN'.'0'),base64_decode('Y2F'.'sbF'.'9'.'1'.'c2V'.'yX2Z1bmM='),base64_decode('Y2FsbF91c2VyX2Z1bmM='),base64_decode('Y2Fs'.'b'.'F'.'9'.'1c2Vy'.'X2Z1bmM'.'='),base64_decode('c'.'3R'.'ycG9z'),base64_decode('Z'.'Xhw'.'bG9kZQ'.'=='),base64_decode('cGFjaw='.'='),base64_decode('bWQ1'),base64_decode('Y2'.'9uc'.'3R'.'hbnQ'.'='),base64_decode('aGFzaF'.'9ob'.'W'.'Fj'),base64_decode('c'.'3'.'R'.'yY21w'),base64_decode('b'.'WV0aG9kX2V4aXN0c'.'w'.'=='),base64_decode('aW'.'50d'.'mF'.'s'),base64_decode('Y2FsbF91c2VyX2'.'Z1b'.'mM='));if(!function_exists(__NAMESPACE__.'\\___2051930365')){function ___2051930365($_751370420){static $_1819726759= false; if($_1819726759 == false) $_1819726759=array(''.'VV'.'N'.'F'.'Ug==','VV'.'NFU'.'g==','VV'.'NFUg==',''.'S'.'XNBdX'.'Ro'.'b3Jpe'.'mVk','VV'.'NFUg==','S'.'XNBZG1pbg==','XENP'.'cH'.'Rpb2'.'4'.'6O'.'kdldE9wd'.'Glvb'.'lN0c'.'ml'.'uZ'.'w==','bWFpbg==','f'.'lBBU'.'kFNX01BWF9VU0'.'V'.'SUw==',''.'Lg==','L'.'g'.'==','SCo=',''.'Yml0cm'.'l4','T'.'ElD'.'RU'.'5T'.'RV9LR'.'Vk=','c2hh'.'Mj'.'U2',''.'XEJp'.'d'.'HJpe'.'FxNYWluXEx'.'pY2V'.'uc2'.'U=','Z2V'.'0QW'.'N0aX'.'Z'.'lVX'.'N'.'lcnNDb3'.'Vu'.'dA'.'==','REI'.'=','U0VMRUN'.'U'.'IE'.'NPV'.'U5'.'U'.'KFU'.'uSUQpIGFzIEM'.'g'.'RlJPTS'.'BiX3VzZXIgVSBXSEVSRSB'.'V'.'L'.'kFD'.'V'.'ElWR'.'SA9ICdZJyBBTkQgV'.'S'.'5MQVNUX0'.'xPR0lOIE'.'lTIE5P'.'VCBOVUxMIE'.'FORC'.'BFWElTVFMo'.'U0VMR'.'UNUICd4Jy'.'BGUk9NIGJfd'.'XR'.'t'.'X3VzZXIg'.'VUYsIGJfdXN'.'lcl9m'.'aWVsZCBGIF'.'d'.'IRVJF'.'IEY'.'u'.'RU5USVR'.'ZX0lEI'.'D0gJ1VT'.'RVInI'.'E'.'FO'.'RC'.'BG'.'L'.'kZJRUx'.'EX05'.'B'.'TU'.'Ug'.'PSA'.'nV'.'UZfR'.'EVQQV'.'J'.'U'.'TUVOVCcgQU5EIFV'.'GL'.'kZJ'.'RUxE'.'X0lE'.'ID0gRi5JRCBBTkQgVU'.'YuVkFMVUVfS'.'UQ'.'gPSB'.'VLklEIEFORCBV'.'Ri'.'5'.'WQUxVRV9'.'JTl'.'QgSVMgT'.'k9U'.'I'.'E5V'.'TEwg'.'Q'.'U'.'5EIFV'.'GLlZ'.'BTF'.'VF'.'X0lOVCA8'.'PiA'.'wKQ'.'='.'=',''.'Qw='.'=','VVN'.'F'.'Ug==','TG9nb3V0');return base64_decode($_1819726759[$_751370420]);}};if($GLOBALS['____1819220525'][0](round(0+0.33333333333333+0.33333333333333+0.33333333333333), round(0+6.6666666666667+6.6666666666667+6.6666666666667)) == round(0+7)){ if(isset($GLOBALS[___2051930365(0)]) && $GLOBALS['____1819220525'][1]($GLOBALS[___2051930365(1)]) && $GLOBALS['____1819220525'][2](array($GLOBALS[___2051930365(2)], ___2051930365(3))) &&!$GLOBALS['____1819220525'][3](array($GLOBALS[___2051930365(4)], ___2051930365(5)))){ $_1803701263= round(0+12); $_186386807= $GLOBALS['____1819220525'][4](___2051930365(6), ___2051930365(7), ___2051930365(8)); if(!empty($_186386807) && $GLOBALS['____1819220525'][5]($_186386807, ___2051930365(9)) !== false){ list($_106635348, $_790595540)= $GLOBALS['____1819220525'][6](___2051930365(10), $_186386807); $_180185247= $GLOBALS['____1819220525'][7](___2051930365(11), $_106635348); $_1610152417= ___2051930365(12).$GLOBALS['____1819220525'][8]($GLOBALS['____1819220525'][9](___2051930365(13))); $_327110472= $GLOBALS['____1819220525'][10](___2051930365(14), $_790595540, $_1610152417, true); if($GLOBALS['____1819220525'][11]($_327110472, $_180185247) ===(167*2-334)){ $_1803701263= $_790595540;}} if($_1803701263 !=(236*2-472)){ if($GLOBALS['____1819220525'][12](___2051930365(15), ___2051930365(16))){ $_1365071236= new \Bitrix\Main\License(); $_865418138= $_1365071236->getActiveUsersCount();} else{ $_865418138=(792-2*396); $_1699054650= $GLOBALS[___2051930365(17)]->Query(___2051930365(18), true); if($_291128417= $_1699054650->Fetch()){ $_865418138= $GLOBALS['____1819220525'][13]($_291128417[___2051930365(19)]);}} if($_865418138> $_1803701263){ $GLOBALS['____1819220525'][14](array($GLOBALS[___2051930365(20)], ___2051930365(21)));}}}}/**/
		foreach (GetModuleEvents("main", "OnBeforeLocalRedirect", true) as $event)
		{
			ExecuteModuleEventEx($event, [&$url, $this->isSkippedSecurity(), &$isExternal, $this]);
		}

		if (!$isExternal)
		{
			$url = $this->processInternalUrl($url);
		}

		$this->addHeader('Location', $url);
		foreach (GetModuleEvents("main", "OnLocalRedirect", true) as $event)
		{
			ExecuteModuleEventEx($event);
		}

		Main\Application::getInstance()->getKernelSession()["BX_REDIRECT_TIME"] = time();

		parent::send();
	}
}
