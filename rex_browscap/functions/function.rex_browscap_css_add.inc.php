<?php

/**
 * RexBrowscap Addon
 * Based on http://code.google.com/p/phpbrowscap/
 * @author st DOT jonathan AT gmail DOT com 
 * @author rexdev.de
 * @package redaxo4.2
 * @version svn:$Id$
 */

function rex_browscap_css_add($params) {
  $n ="\n";
  $params['subject'] .= $n.'<link rel="stylesheet" type="text/css" href="../files/addons/rex_browscap/rex_browscap_backend.css" />'.$n;
  return $params['subject'];
}
?>