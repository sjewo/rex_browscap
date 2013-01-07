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
$mypage = "rex_browscap";

if (intval(PHP_VERSION) < 5)
{
    $REX['ADDON']['installmsg'][$mypage] = 'Dieses Addon ben&ouml;tigt für volle Funktionalit&auml;t PHP 5! Die PHP 4 Version ist depreciated.';
}

$REX['ADDON']['install'][$mypage] = 1;

