<?php

/**
 * RexBrowscap Addon
 * Based on http://code.google.com/p/phpbrowscap/
 * @author st DOT jonathan AT gmail DOT com 
 * @author rexdev.de
 * @package redaxo4.2
 * @version svn:$Id$
 */

// PARAMS, ADDON IDENTIFIER & ROOT DIR
////////////////////////////////////////////////////////////////////////////////
$myself = rex_request('page', 'string');
$subpage = rex_request('subpage', 'string');
$chapter = rex_request('chapter', 'string');
$func = rex_request('func', 'string');
$myroot = $REX['INCLUDE_PATH'].'/addons/'.$myself;

// BACKEND CSS
////////////////////////////////////////////////////////////////////////////////
$header = array(
'  <link rel="stylesheet" type="text/css" href="../files/addons/'.$myself.'/backend.css" media="screen, projection, print" />'
);

if ($REX['REDAXO']) {
  include_once $myroot.'/functions/function.rexdev_header_add.inc.php';
  rex_register_extension('PAGE_HEADER', 'rexdev_header_add',$header);
}

// INCLUDE FUNCTIONS
////////////////////////////////////////////////////////////////////////////////
require_once $REX['INCLUDE_PATH'].'/addons/'.$myself.'/functions/function.textile_parser.inc.php';

// REX TOP
////////////////////////////////////////////////////////////////////////////////
require $REX['INCLUDE_PATH'] . '/layout/top.php';

// BUILD SUBNAVIGATION
////////////////////////////////////////////////////////////////////////////////
$subpages = array (
    array ('','Cache'),
    array ('help','Hilfe')
  );

rex_title('RexBrowscap <span class="addonversion">v. '.$REX['ADDON']['version'][$myself].'</span>', $subpages);

// SET DEFAULT PAGE / INCLUDE PAGE
////////////////////////////////////////////////////////////////////////////////
if(!$subpage) {
  $subpage = 'settings';
}
require $REX['INCLUDE_PATH'] . '/addons/'.$myself.'/pages/'.$subpage.'.inc.php';

// REX BOTTOM
////////////////////////////////////////////////////////////////////////////////
require $REX['INCLUDE_PATH'] . '/layout/bottom.php';

?>