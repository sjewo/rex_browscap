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

// IDENTIFIER & ROOT
////////////////////////////////////////////////////////////////////////////////
$mypage = 'rex_browscap';
$myroot = $REX['INCLUDE_PATH'].'/addons/'.$mypage.'/';


// REX ADDON PARAMS
////////////////////////////////////////////////////////////////////////////////
$REX['ADDON']['rxid'][$mypage]        = '714';
$REX['ADDON']['name'][$mypage]        = 'RexBrowscap';
$REX['ADDON']['version'][$mypage]     = '0.2.2';
$REX['ADDON']['author'][$mypage]      = 'rexdev.de';
$REX['ADDON']['supportpage'][$mypage] = 'forum.redaxo.de';


// SETTINGS
////////////////////////////////////////////////////////////////////////////////
$REX['ADDON']['rex_browscap']['cache'] = $REX['HTDOCS_PATH'].'files/addons/rex_browscap/cache';
$REX['ADDON']['rex_browscap']['silent'] = true;
$REX['ADDON']['rex_browscap']['userAgent'] = 'Redaxo Addon "rex_browsecap" - version '.$REX['ADDON']['version'][$mypage];


// --- DYN
// --- /DYN


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
    rex_warning('Die PHP4 Version ist depreciated!');
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

