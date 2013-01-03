<?php

/**
 * RexBrowscap Addon
 * Based on https://github.com/GaretJax/phpbrowscap/
 * @author Jonathan Stoppani <jonathan@stoppani.name>
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
    $bc->silent = $REX['ADDON']['rex_browscap']['silent'];
    $bc->userAgent = $REX['ADDON']['rex_browscap']['userAgent'];

    return $bc->getBrowser($user_agent, $return_array);
  }
}
 
 ?>