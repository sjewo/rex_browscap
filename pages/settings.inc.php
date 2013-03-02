<?php

/**
 * RexBrowscap Addon
 *
 * @author st DOT jonathan AT gmail DOT com
 * @link https://github.com/GaretJax/phpbrowscap/
 * @author rexdev.de
 * @link https://github.com/jdlx/rex_browscap
 *
 * @package redaxo 4.3.x/4.4.x/4.5.x
 */

// PARAMS
////////////////////////////////////////////////////////////////////////////////
$mypage          = rex_request('page', 'string');
$subpage         = rex_request('subpage', 'string');
$func            = rex_request('func', 'string');


// FORM FUNCTIONS
////////////////////////////////////////////////////////////////////////////////
switch($func)
{
  case'flush':
    // FLUSH CACHE FILES
    $cachefiles = array('browscap.ini','cache.php');
    $success = TRUE;
    foreach($cachefiles as $file) {
      $file = $REX['ADDON']['_rex_browscap']['cache'].'/'.$file;
      if(is_file($file)) {
        if(unlink($file)) {
          echo rex_info('"'.$file.'" wurde gel&ouml;scht.');
        } else {
          $success = FALSE;
          echo rex_warning('"'.$file.'" konnte nicht gel&ouml;scht werden!');
        }
      }
    }

    if(isset($_SESSION['rex_get_browser'])){
      unset($_SESSION['rex_get_browser']);
      rex_get_browser();
    }
    if ($success) {
      echo rex_info('Browser-Datenbank wurde regeneriert.');
    } else {
      echo rex_warning('Beim L&ouml;schen des Cache traten Probleme auf - Schreibrechte für Cache Ordner &uuml;berpr&uuml;fen und ggf Korrigieren!');
    }
  break;

  case'savesettings':
    // MERGE REQUEST & ADDON SETTINGS
    $params_cast = $REX['ADDON'][$mypage]['params_cast'];
    $myCONF = array_merge($REX['ADDON'][$mypage]['settings'],browscap_cast($_POST,$params_cast));

    // SAVE SETTINGS
    if(browscap_saveConf($myCONF)) {
      echo rex_info('Einstellungen wurden gespeichert.');
    } else {
      echo rex_warning('Beim speichern der Einstellungen ist ein Problem aufgetreten.');
    }
  break;
  default:
}


// frontend_js_include SELECT
////////////////////////////////////////////////////////////////////////////////
$tmp = new rex_select();
$tmp->setSize(1);
$tmp->setName('frontend_js_include');
$tmp->addOption('Kein Include',0);
$tmp->addOption('Automatisch nach head bzw. base tag',1);
$tmp->setSelected($REX['ADDON'][$mypage]['settings']['frontend_js_include']);
$frontend_js_include = $tmp->get();


// use_mobiledetect SELECT
////////////////////////////////////////////////////////////////////////////////
$tmp = new rex_select();
$tmp->setSize(1);
$tmp->setName('use_mobiledetect');
$tmp->addOption('Nein',0);
$tmp->addOption('Ja',1);
$tmp->setSelected($REX['ADDON'][$mypage]['settings']['use_mobiledetect']);
$use_mobiledetect = $tmp->get();

// FORM
////////////////////////////////////////////////////////////////////////////////
echo '
<div class="rex-addon-output" id="subpage-'.$subpage.'">
  <div class="rex-form">

  <form action="index.php?page='.$mypage.'" method="POST" id="settings">
    <input type="hidden" name="page" value="'.$mypage.'" />
    <input type="hidden" name="subpage" value="'.$subpage.'" />
    <input type="hidden" name="func" value="savesettings" />


        <fieldset class="rex-form-col-1">
          <legend>Einstellungen</legend>
          <div class="rex-form-wrapper">

            <div class="rex-form-row">
              <p class="rex-form-col-a rex-form-select">
                <label for="frontend_js_include">Frontend JS Include</label>
                '.$frontend_js_include.'
              </p>
            </div><!-- .rex-form-row -->

            <div class="rex-form-row">
              <p class="rex-form-col-a rex-form-select">
                <label for="frontend_js_include">MobileDetect Auswertung</label>
                '.$use_mobiledetect.'
              </p>
            </div><!-- .rex-form-row -->

            <div class="rex-form-row rex-form-element-v2">
              <p class="rex-form-submit">
                <input class="rex-form-submit" type="submit" id="submit" name="submit" value="Einstellungen speichern" />
              </p>
            </div><!-- .rex-form-row -->

          </div><!-- .rex-form-wrapper -->
        </fieldset>

  </form>

  </div><!-- .rex-form -->
</div><!-- .rex-addon-output -->
';



echo '
<div class="rex-addon-output" id="subpage-'.$subpage.'">

  <h2 class="rex-hl2" style="font-size:1em">Browscap-Cache</h2>

  <div class="rex-area-content">

    <p class="rex-tx1">
      Die Browser-Datenbank wird alle 5 Tage automatisiert upgedatet. <br />
      Bei Problemen oder Verdacht auf Beschädigung kann sie hier manuell regeneriert werden.
    <p>

    <div class="rex-form">

      <form action="index.php?page='.$mypage.'" method="get">
        <input type="hidden" name="page" value="'.$mypage.'" />
        <input type="hidden" name="subpage" value="'.$subpage.'" />
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

  </div><!-- .rex-area-content -->

</div><!-- .rex-addon-output -->
';
