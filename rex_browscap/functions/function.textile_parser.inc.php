<?php

/**
 * RexBrowscap Addon
 * Based on http://code.google.com/p/phpbrowscap/
 * @author st DOT jonathan AT gmail DOT com 
 * @author rexdev.de
 * @package redaxo4.2
 * @version svn:$Id$
 */

// TEXTILE PARSER FUNCTION
////////////////////////////////////////////////////////////////////////////////
if (!function_exists('textile_parser'))
{
  function textile_parser($textile)
  {
    global $REX;
    if(OOAddon::isAvailable("textile"))
    {
      if($textile!='')
      {
        // Aktuell und korrigiert REX_VALUE Abfrage (http://forum.redaxo.de/sutra60654.html) 
        $textile = htmlspecialchars_decode($textile);
        $textile = str_replace("<br />","",$textile);
        $textile = str_replace("&#039;","'",$textile);
         if (strpos($REX['LANG'],'utf')) {
          return rex_a79_textile($textile);
        } else {
          return utf8_decode(rex_a79_textile($textile));
        }
      }
    } else {
      $fallback = rex_warning('WARNUNG: Das <a href="index.php?page=addon">Textile Addon</a> ist nicht aktiviert! Der Text wird ungeparst angezeigt..');
      $fallback .= '<pre>'.$textile.'</pre>';
      return $fallback;
    }
  }
}

// ECHO TEXTILE FORMATED STRING
////////////////////////////////////////////////////////////////////////////////
if (!function_exists('echotextile'))
{
  function echotextile($msg) {
    global $REX;
    if(OOAddon::isAvailable("textile")) {
      if($msg!='') {
         $msg = str_replace("	","",$msg); // tabs entfernen
         if (strpos($REX['LANG'],'utf')) {
          echo rex_a79_textile($msg);
        } else {
          echo utf8_decode(rex_a79_textile($msg));
        }
      }
    } else {
      $fallback = rex_warning('WARNUNG: Das <a href="index.php?page=addon">Textile Addon</a> ist nicht aktiviert! Der Text wird ungeparst angezeigt..');
      $fallback .= '<pre>'.$msg.'</pre>';
      echo $fallback;
    }
  }
}
?>