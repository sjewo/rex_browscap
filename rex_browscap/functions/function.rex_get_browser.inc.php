<?php

/**
 * RexBrowscap Addon
 * Based on http://code.google.com/p/phpbrowscap/
 * @author st DOT jonathan AT gmail DOT com 
 * @author rexdev.de
 * @package redaxo4.2
 * @version svn:$Id$
 */


// REX_GET_BROWSER FUNCTION
////////////////////////////////////////////////////////////////////////////////
if (!function_exists('rex_get_browser'))
{
  function rex_get_browser($user_agent = null, $return_array = true)
  {
    global $REX;
    $cache = $REX['ADDON']['rex_browscap']['cache'];
    $bc = new Browscap($cache);
    $browser = $bc->getBrowser($user_agent, $return_array);
    return $browser;
  }
}
 
 ?>