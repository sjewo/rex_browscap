<?php

/**
 * RexBrowscap Addon
 *
 * @author st DOT jonathan AT gmail DOT com
 * @link https://github.com/GaretJax/phpbrowscap/
 * @author rexdev.de
 * @link https://github.com/jdlx/rex_browscap
 *
 * @package redaxo 4.3.x/4.4.x
 */

// AJAX RECEIVER/API
////////////////////////////////////////////////////////////////////////////////
$data = rex_request('rex_browscap','string',false);

if($data!==false)
{
  $data = json_decode(stripslashes($data),true);                                #FB::log($data,' $data'); die;

  if(!is_array($data)) {
    return rex_panel_ajax_reply(array('error'=>'no valid POST data'));
  }

  switch($data['action'])
  {
    case 'store_to_session':
      foreach($data as $k => $v){
        if($k!='action'){
          $_SESSION['rex_get_browser'][$k] = $v;
        }
      }                                                                         #FB::log($_SESSION,' $_SESSION');
      die;
      break;

    case 'rex_get_browser':
      return rex_browscap_ajax_reply($_SESSION['rex_get_browser']);             #FB::log($_SESSION,' $_SESSION');
      die;
      break;

    default:
     return rex_panel_ajax_reply(array('error'=>'no valid action defined'));
     break;
  }

}

function rex_browscap_ajax_reply($data=false)
{
  if(!$data)
    return false;

  if(is_array($data) && count($data)>0)
  {
    while(ob_get_level()){
      ob_end_clean();
    }
    ob_start();
    header('Content-Type: application/json');
    echo json_encode($data);
    die();
  }
}


// IDENTIFIER & ROOT
////////////////////////////////////////////////////////////////////////////////
$mypage = '_rex_browscap';
$myroot = $REX['INCLUDE_PATH'].'/addons/'.$mypage.'/';


// REX ADDON PARAMS
////////////////////////////////////////////////////////////////////////////////
$REX['ADDON']['rxid'][$mypage]        = '714';
$REX['ADDON']['name'][$mypage]        = 'RexBrowscap';
$REX['ADDON']['version'][$mypage]     = '0.9.2 beta';
$REX['ADDON']['author'][$mypage]      = 'rexdev.de';
$REX['ADDON']['supportpage'][$mypage] = 'forum.redaxo.de';
$REX['ADDON']['perm'][$mypage]   	    = $mypage."[]";
$REX['PERM'][] = $mypage.'[]';


// FIXED SETTINGS
////////////////////////////////////////////////////////////////////////////////
$REX['ADDON'][$mypage]['cache'] = $REX['HTDOCS_PATH'].'files/addons/_rex_browscap/cache';
$REX['ADDON'][$mypage]['silent'] = true;
$REX['ADDON'][$mypage]['userAgent'] = 'Redaxo Browscap Addon - version '.$REX['ADDON']['version'][$mypage];
$REX['ADDON'][$mypage]['params_cast'] = array (
  'page'        => 'unset',
  'subpage'     => 'unset',
  'minorpage'   => 'unset',
  'func'        => 'unset',
  'submit'      => 'unset',
  'sendit'      => 'unset',
  'PHPSESSID'   => 'unset',
  );

// USER SETTINGS
////////////////////////////////////////////////////////////////////////////////
// --- DYN
$REX["ADDON"]["_rex_browscap"]["settings"] = array (
  'frontend_js_include' => '1',
  'use_mobiledetect' => '1',
);
// --- /DYN

// SUBPAGES
//////////////////////////////////////////////////////////////////////////////
if ($REX['USER'] && ($REX['USER']->isAdmin() || $REX['USER']->hasPerm($mypage.'[]')))
{
  $REX['ADDON'][$mypage]['SUBPAGES'] = array (
    //     subpage    ,label                         ,perm   ,params               ,attributes
    array (''         ,'Settings'                    ,''     ,''                   ,''),
    array ('help'     ,'Hilfe'                       ,''     ,''                   ,''),
  );
}

// REQUIRE LIBS BY PHP VERSION
////////////////////////////////////////////////////////////////////////////////
$phpversion = intval(PHP_VERSION);

switch($phpversion)
{
  case ($phpversion<4):
    rex_warning('Mindestens PHP4 benötigt!');
    break;

  case ($phpversion<5):
    // VERSION FÜR PHP 4
    rex_warning('Die PHP4 Version ist deprecated!');
    require_once('vendor/phpbrowscap/php4/Browscap.php');
    break;

  default:
    // VERSION FÜR PHP 5
    require_once('vendor/phpbrowscap/php5/Browscap.php');
    break;
}

require_once('vendor/mobiledetect/Mobile_Detect.php');

// REQUIRE REX_GET_BROWSER FUNCTION
////////////////////////////////////////////////////////////////////////////////
require_once('functions/function.rex_get_browser.inc.php');


// EXIT HERE IF BACKEND..
////////////////////////////////////////////////////////////////////////////////
if($REX['REDAXO']){
  return;
}

// FRONTEND JS SCREEN SIZE SNIFFER
////////////////////////////////////////////////////////////////////////////////
if($REX["ADDON"]["_rex_browscap"]["settings"]['frontend_js_include']!=='0')
{
  $rex_browscap_frontend_js = '
  <!-- '.$mypage.' -->
    <script src="'.$REX['HTDOCS_PATH'].'files/addons/'.$mypage.'/rex_browscap.min.js" type="text/javascript"></script>
  <!-- /'.$mypage.' -->';

  rex_register_extension('OUTPUT_FILTER', 'rex_browscap_frontend_opf');

  function rex_browscap_frontend_opf($params){
    global $rex_browscap_frontend_js;
    preg_match_all('/<(?:base|head(?!e))[^>]*>/i',$params['subject'],$m);
    $needle = array_pop($m[0]);
    return str_replace($needle,$needle.$rex_browscap_frontend_js,$params['subject']);
  }
}
