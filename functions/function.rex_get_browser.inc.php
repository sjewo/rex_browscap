<?php

/**
 * RexBrowscap Addon
 *
 * @author st DOT jonathan AT gmail DOT com
 * @link https://github.com/GaretJax/phpbrowscap/
 * @author rexdev.de
 * @link https://github.com/jdlx/rex_browscap
 *
 * @package redaxo 4.3.x/4.4.x/4.5.x
 */


// REX_GET_BROWSER FUNCTION
////////////////////////////////////////////////////////////////////////////////
if (!function_exists('rex_get_browser'))
{
  function rex_get_browser($user_agent = null, $return_array = true)
  {
    global $REX;

    if(!session_id()){
      session_start();
    }

    if(isset($_SESSION['rex_get_browser']['browser_name'])){
      return $_SESSION['rex_get_browser'];
    }

    $bc = new Browscap($REX['ADDON']['_rex_browscap']['cache']);
    $bc->silent = $REX['ADDON']['_rex_browscap']['silent'];
    $bc->userAgent = $REX['ADDON']['_rex_browscap']['userAgent'];

    // USE TEMP URLS WHILE BROWSCAP PROJECT IS MIGRATING
    // https://github.com/GaretJax/phpbrowscap/issues/24#issuecomment-10088419
    $bc->remoteIniUrl = 'http://tempdownloads.browserscap.com/stream.php?BrowsCapINI';
    $bc->remoteVerUrl = 'http://tempdownloads.browserscap.com/versions/version-date.php';

    $browser = $bc->getBrowser($user_agent, $return_array);

    if($REX['ADDON']['_rex_browscap']['settings']['use_mobiledetect']==1){
      $browser = array_merge($browser,rex_browscap_get_mobiledetect_result());
    }

    $_SESSION['rex_get_browser'] = isset($_SESSION['rex_get_browser'])
                                 ? array_merge($_SESSION['rex_get_browser'],$browser)
                                 : $browser;

    return $_SESSION['rex_get_browser'];
  }
}

function rex_browscap_get_mobiledetect_result()
{
  $detect = new Mobile_Detect;
  $md = array();
  $md['md_isMobile'] = $detect->isMobile();
  $md['md_isTablet'] = $detect->isTablet();
  foreach($detect->getRules() as $name => $regex){
    $md['md_is'.$name] = $detect->{'is'.$name}();
  }
  return $md;
}
