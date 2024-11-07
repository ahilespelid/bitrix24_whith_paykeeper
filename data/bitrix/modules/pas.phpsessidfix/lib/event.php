<?php

namespace Pas\PhpsessidFix;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class Event
{
    const MODULE_ID = PAS_PHPSESSIDFIX_MODULE_ID;

    public static function OnPageStart()
    {
        // $hostDomain = "";
        $hostDomain = Option::get(self::MODULE_ID, PAS_PHPSESSIDFIX_OPTION_DOMAIN);
        $useSessionFix = "N";
        $useSessionFix = Option::get(self::MODULE_ID, PAS_PHPSESSIDFIX_OPTION_USE);
        $useSessionFixWwwActive = "N";
        $useSessionFixWwwActive = Option::get(self::MODULE_ID, PAS_PHPSESSIDFIX_OPTION_WWW_ACTIVE);
        $useSessionFixLog = "N";
        $useSessionFixLog = Option::get(self::MODULE_ID, PAS_PHPSESSIDFIX_OPTION_USE_LOG);


        if($useSessionFix == "Y" && !empty($hostDomain)){

            

            if(
                session_id()
                && isset($_COOKIE["PHPSESSID"])
                && $_COOKIE["PHPSESSID"] != session_id()
                && (
                    !isset($_COOKIE["SESS_BUG_STEP"])
                    || $_COOKIE["SESS_BUG_STEP"] < "8"
                )
            )
            {
                
                $needReload = false;
                $curStep = 0;
                $domain = "";
        
                if(!isset($_COOKIE["SESS_BUG_STEP"]) || $_COOKIE["SESS_BUG_STEP"] == ""){
                    $domain = '.'.$hostDomain;
                    $needReload = true;
                    $curStep = 1;
                
                }
                elseif($_COOKIE["SESS_BUG_STEP"] == "1"){
                    $domain = $hostDomain;
                    $needReload = true;
                    if($useSessionFixWwwActive == "Y")
                        $curStep = 2;
                    else
                        $curStep = 4;
                
                }

                if($useSessionFixWwwActive == "Y"){

                    if($_COOKIE["SESS_BUG_STEP"] == "2"){
                        $domain = '.www.'.$hostDomain;
                        $needReload = true;
                        $curStep = 3;
            
                    }
                    elseif($_COOKIE["SESS_BUG_STEP"] == "3"){
                        $domain = 'www.'.$hostDomain;
                        $needReload = true;
                        $curStep = 4;
            
                    }
                }
                
                if($_COOKIE["SESS_BUG_STEP"] >= "4"){
                    $domain = '';
                    $needReload = true;
                    $curStep++;
        
                }
        
                if($needReload){
                
                    if($useSessionFixLog){
                        AddMessage2Log("COOCKIE PROBLEM - C_ID = ".$_COOKIE["PHPSESSID"].", S_ID = ".session_id().", U_ID = ".$_COOKIE["BX_USER_ID"].", G_ID = ".$_COOKIE["BX_GUEST_ID"].", BUG_STEP = ".$curStep.", DOMAIN = ".$domain, self::MODULE_ID);
                    }
            
                    
                    setcookie('SESS_BUG_STEP', $curStep, time() + 300, '/');

                    if(!empty($domain))
                        setcookie('PHPSESSID', '', time() - 100, '/', $domain);
                    else
                        setcookie('PHPSESSID', '', time() - 100, '/');

                    header('Location: '.$_SERVER['REQUEST_URI']);
                }
        
        
            }
        
            elseif(
                session_id()
                && isset($_COOKIE["PHPSESSID"])
                && $_COOKIE["PHPSESSID"] == session_id()
                && isset($_COOKIE["SESS_BUG_STEP"])
            )
            {
            
                if($useSessionFixLog){
                    AddMessage2Log("COOCKIE PROBLEM - C_ID = ".$_COOKIE["PHPSESSID"].", S_ID = ".session_id().", U_ID = ".$_COOKIE["BX_USER_ID"].", G_ID = ".$_COOKIE["BX_GUEST_ID"].", BUG_STEP = ".$_COOKIE["SESS_BUG_STEP"].", DOMAIN = NULL, FINISH = Y", self::MODULE_ID);
                }
                setcookie('SESS_BUG_STEP', '', time() - 100, '/');
                header('Location: '.$_SERVER['REQUEST_URI']);
            }
            
        }

    }

}
