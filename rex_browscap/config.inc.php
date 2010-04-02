<?php

/**
 * RexBrowscap Addon
 * Based on http://code.google.com/p/phpbrowscap/
 * @author st DOT jonathan AT gmail DOT com 
 * @author rexdev.de
 * @package redaxo4.2
 * @version svn:$Id$
 */

 // ADDON IDENTIFIER
$mypage = "rex_browscap";
// UNIQUE ID
$REX['ADDON']['rxid'][$mypage] = '714';
// NAME SHOWN IN THE REDAXO MAIN MENU
$REX['ADDON']['name'][$mypage] = 'RexBrowscap';
 
$REX['ADDON']['version'][$mypage] = '0.1';
$REX['ADDON']['author'][$mypage] = 'rexdev.de';
$REX['ADDON']['supportpage'][$mypage] = 'forum.redaxo.de';

// CACHE LOCATION
$REX['ADDON']['rex_browscap']['cache'] = $REX['HTDOCS_PATH'].'/files/addons/rex_browscap/cache';

// --- DYN
$REX['ADDON']['rex_browscap']['foo'] = 'fooval';
$REX['ADDON']['rex_browscap']['bar'] = 'barval';
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
    require_once('libs/php4/Browscap.php');
    break;
    
  default:
    // VERSION FÜR PHP 5
    require_once('libs/php5/Browscap.php');
    break;
}

// REQUIRE REX_GET_BROWSER FUNCTION
////////////////////////////////////////////////////////////////////////////////
require_once('functions/function.rex_get_browser.inc.php');

?>