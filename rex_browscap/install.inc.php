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

if (intval(PHP_VERSION) < 5)
{
    $REX['ADDON']['installmsg'][$mypage] = 'Dieses Addon ben&ouml;tigt für volle Funktionalit&auml;t PHP 5! Die PHP 4 Version ist depreciated.';
}

$REX['ADDON']['install'][$mypage] = 1;

?>