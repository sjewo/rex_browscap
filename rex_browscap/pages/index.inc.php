<?php

/**
 * RexBrowscap Addon
 * Based on http://code.google.com/p/phpbrowscap/
 * @author st DOT jonathan AT gmail DOT com 
 * @author rexdev.de
 * @package redaxo4.2
 * @version svn:$Id$
 */

// PARAMS
////////////////////////////////////////////////////////////////////////////////
$page = rex_request('page', 'string');
$subpage = rex_request('subpage', 'string');
$chapter = rex_request('chapter', 'string');
$func = rex_request('func', 'string');

// BACKEND CSS
////////////////////////////////////////////////////////////////////////////////
if ($REX['REDAXO']) {
  require_once $REX['INCLUDE_PATH'].'/addons/'.$page.'/functions/function.rex_browscap_css_add.inc.php';
  rex_register_extension('PAGE_HEADER', 'rex_browscap_css_add');
}

// INCLUDE FUNCTIONS
////////////////////////////////////////////////////////////////////////////////
require_once $REX['INCLUDE_PATH'].'/addons/'.$page.'/functions/function.textile_parser.inc.php';

// REX TOP
////////////////////////////////////////////////////////////////////////////////
require $REX['INCLUDE_PATH'] . '/layout/top.php';

// BUILD SUBNAVIGATION
////////////////////////////////////////////////////////////////////////////////
$subpages = array (
    array ('','Cache'),
    array ('help','Hilfe')
  );

rex_title('RexBrowscap '.$REX['ADDON']['version'][$page], $subpages);

// SET DEFAULT PAGE / INCLUDE PAGE
////////////////////////////////////////////////////////////////////////////////
if(!$subpage) {
  $subpage = 'settings';
}
require $REX['INCLUDE_PATH'] . '/addons/'.$page.'/pages/'.$subpage.'.inc.php';

// REX BOTTOM
////////////////////////////////////////////////////////////////////////////////
require $REX['INCLUDE_PATH'] . '/layout/bottom.php';

?>