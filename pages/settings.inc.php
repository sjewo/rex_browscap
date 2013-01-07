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

// PARAMS
////////////////////////////////////////////////////////////////////////////////
$page = rex_request('page', 'string');
$subpage = rex_request('subpage', 'string');
$func = rex_request('func', 'string');
$def_desc = rex_request('def_desc', 'string');
$def_keys = rex_request('def_keys', 'string');
$allow_articleid = rex_request('allow_articleid', 'int');


// FLUSH CACHE FILES
////////////////////////////////////////////////////////////////////////////////
$cachefiles = array('browscap.ini','cache.php');

if ($func == "flush")
{
  $success = TRUE;
  foreach($cachefiles as $file)
  {
    $file = $REX['ADDON']['rex_browscap']['cache'].'/'.$file;

    if(is_file($file))
    {
      if(unlink($file))
      {
        echo rex_info('"'.$file.'" wurde gel&ouml;scht.');
      }
      else
      {
        $success = FALSE;
        echo rex_warning('"'.$file.'" konnte nicht gel&ouml;scht werden!');
      }
    }
  }

  if ($success)
  {
    echo rex_info('Browser-Datenbank wird beim n&auml;chsten Seitenaufruf regeneriert.');
  }
  else
  {
    echo rex_warning('Beim L&ouml;schen des Cache traten Probleme auf - Schreibrechte für Cache Ordner &uuml;berpr&uuml;fen und ggf Korrigieren!');
  }


}


// FORM
////////////////////////////////////////////////////////////////////////////////
echo '
<div class="rex-addon-output">

  <h2 class="rex-hl2" style="font-size:1em">Browser-Datenbank</h2>


  <div class="rex-area-content">

    <p class="rex-tx1">
      Die Browser-Datenbank wird alle 5 Tage automatisiert upgedatet. <br />
      Bei Problemen oder Verdacht auf Beschädigung kann sie hier manuell regeneriert werden.
    <p>

    <div class="rex-form">

      <form action="index.php" method="get">
        <input type="hidden" name="page" value="rex_browscap" />
        <input type="hidden" name="subpage" value="settings" />
        <input type="hidden" name="func" value="flush" />
        <fieldset class="rex-form-col-1">

          <div class="rex-form-wrapper">
            <div class="rex-form-row rex-form-element-v2">
              <p class="rex-form-submit">
                <input class="rex-form-submit" type="submit" id="sendit" name="sendit" value="Cache löschen & Datenbank regnerieren" />
              </p>
            </div>
          </div>

        </fieldset>
      </form>

    </div>

  </div>

</div>
';
