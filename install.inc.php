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

// ADDON IDENTIFIER
$mypage = "_rex_browscap";


// CHECK ADDON FOLDER NAME
////////////////////////////////////////////////////////////////////////////////
$addon_folder = basename(dirname(__FILE__));
if($addon_folder != $mypage)
{
  $REX['ADDON']['installmsg'][$addon_folder] = '<br />Der Name des Addon-Ordners ist inkorrekt: <code style="color:black;font-size:12px;">'.$addon_folder.'</code>
                                                <br />Addon-Ordner in <code style="color:black;font-size:1.23em;">'.$mypage.'</code> umbenennen und Installation wiederholen';
  $REX['ADDON']['install'][$addon_folder] = 0;
  return;
}


// PHP VERSION CHECK
////////////////////////////////////////////////////////////////////////////////
if (intval(PHP_VERSION) < 5)
{
  $REX['ADDON']['installmsg'][$mypage] = 'Dieses Addon ben&ouml;tigt für volle Funktionalit&auml;t PHP 5! Die PHP 4 Version ist depreciated.';
  $REX['ADDON']['install'][$mypage] = 0;
  return;
}

$REX['ADDON']['install'][$mypage] = 1;

