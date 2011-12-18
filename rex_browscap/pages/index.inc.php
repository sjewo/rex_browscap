<?php

/**
 * RexBrowscap Addon
 * Based on https://github.com/GaretJax/phpbrowscap/
 * @author Jonathan Stoppani <jonathan@stoppani.name>
 * @author rexdev.de
 * @package redaxo4.2
 * @version svn:$Id$
 */

// PARAMS, ADDON IDENTIFIER & ROOT DIR
////////////////////////////////////////////////////////////////////////////////
$mypage = rex_request('page', 'string');
$subpage = rex_request('subpage', 'string');
$chapter = rex_request('chapter', 'string');
$func = rex_request('func', 'string');
$myroot = $REX['INCLUDE_PATH'].'/addons/'.$mypage;

// BACKEND CSS
////////////////////////////////////////////////////////////////////////////////
$header = array(
'  <link rel="stylesheet" type="text/css" href="../files/addons/'.$mypage.'/backend.css" media="screen, projection, print" />'
);

if ($REX['REDAXO']) {
  include_once $myroot.'/functions/function.rexdev_header_add.inc.php';
  rex_register_extension('PAGE_HEADER', 'rexdev_header_add',$header);
}

// INCLUDE FUNCTIONS
////////////////////////////////////////////////////////////////////////////////
require_once $REX['INCLUDE_PATH'].'/addons/'.$mypage.'/functions/function.textile_parser.inc.php';

// REX TOP
////////////////////////////////////////////////////////////////////////////////
require $REX['INCLUDE_PATH'] . '/layout/top.php';

// BUILD SUBNAVIGATION
////////////////////////////////////////////////////////////////////////////////
$subpages = array (
    array ('','Cache'),
    array ('help','Hilfe')
  );

rex_title('RexBrowscap <span class="addonversion">'.$REX['ADDON']['version'][$mypage].'</span>', $subpages);

// SET DEFAULT PAGE / INCLUDE PAGE
////////////////////////////////////////////////////////////////////////////////
if(!$subpage) {
  $subpage = 'settings';
}
require $REX['INCLUDE_PATH'] . '/addons/'.$mypage.'/pages/'.$subpage.'.inc.php';

// REX BOTTOM
////////////////////////////////////////////////////////////////////////////////
require $REX['INCLUDE_PATH'] . '/layout/bottom.php';

?>