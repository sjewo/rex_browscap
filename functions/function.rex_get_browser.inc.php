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
function rex_get_browser($user_agent = null, $return_array = true)
{                                                                               #FB::group('function '.__FUNCTION__.'()', array("Collapsed"=>false)); FB::log($_SESSION,' $_SESSION');FB::log($_COOKIE,' $_COOKIE');FB::log(session_id(),' session_id()');
  global $REX;

  if(!session_id()){
    session_start();
  }

  // CHECK IF BACKEND DATA ALREADY IN SESSION
  if(isset($_SESSION['rex_get_browser']['browser_name']))
  {                                                                             #FB::log('OK, FROM SESSION...');FB::groupEnd();
    // CHECK IF FRONTEND DATA ALREADY IN SESSION & AVAILABLE
    if(!isset($_SESSION['rex_get_browser']['landscape']) && rex_browscap_get_frontend_data() !== false)
    {
      $_SESSION['rex_get_browser'] = array_merge(rex_browscap_get_frontend_data(),$_SESSION['rex_get_browser']);
    }
    return $_SESSION['rex_get_browser'];
  }

  $bc = new Browscap($REX['ADDON']['_rex_browscap']['cache']);
  $bc->silent = $REX['ADDON']['_rex_browscap']['silent'];
  $bc->userAgent = $REX['ADDON']['_rex_browscap']['userAgent'];

  // USE TEMP URLS WHILE BROWSCAP PROJECT IS MIGRATING
  // https://github.com/GaretJax/phpbrowscap/issues/24#issuecomment-10088419
  $bc->remoteIniUrl = $REX['ADDON']['_rex_browscap']['remoteIniUrl'];
  $bc->remoteVerUrl = $REX['ADDON']['_rex_browscap']['remoteVerUrl'];

  $browser = $bc->getBrowser($user_agent, $return_array);                       #FB::log($browser,' $browser');

  if($REX['ADDON']['_rex_browscap']['settings']['use_mobiledetect']==1){
    $browser = array_merge($browser,rex_browscap_get_mobiledetect_result());    #FB::log($browser,' $browser');
  }

  $browser = isset($_SESSION['rex_get_browser_frontend_data'])
           ? array_merge($_SESSION['rex_get_browser_frontend_data'],$browser)
           : $browser;                                                          #FB::log($browser,' $browser');

  $_SESSION['rex_get_browser'] = $browser;                                      #FB::log($_SESSION,' $_SESSION');
                                                                                #FB::groupEnd();
  return $browser;
}


function rex_browscap_get_frontend_data()
{
  if(isset($_SESSION['rex_get_browser_frontend_data']))
  {
    return $_SESSION['rex_get_browser_frontend_data'];
  }
  elseif(isset($_COOKIE['rex_browscap_COOKIE_set']))
  {
    return array('display_width'   => $_COOKIE['display_width'],
                 'display_height'  => $_COOKIE['display_height'],
                 'viewport_width'  => $_COOKIE['viewport_width'],
                 'viewport_height' => $_COOKIE['viewport_height'],
                 'landscape'       => ($_COOKIE['viewport_height'] > $_COOKIE['viewport_width'])
                 );
  }
  else
  {
    return false;
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
