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
