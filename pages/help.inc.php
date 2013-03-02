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
$mypage    = rex_request('page', 'string');
$subpage = rex_request('subpage', 'string');
$chapter = rex_request('chapter', 'string');
$func    = rex_request('func', 'string');

// CHAPTER DEFS ('CHAPTER PARAM' => array('TITLE','SOURCE','PARSEMODE'))
////////////////////////////////////////////////////////////////////////////////
$chapterpages = array (
''                => array('Readme','_readme.txt','textile'),
'addonchangelog'  => array('Changelog','_changelog.txt','textile'),
'tickets'         => array('PHPBrowscap Projektseite','https://github.com/garetjax/phpbrowscap','jsopenwin')
);

// BUILD CHAPTER NAVIGATION
////////////////////////////////////////////////////////////////////////////////
$chapternav = '';
foreach ($chapterpages as $chapterparam => $chapterprops)
{
  if ($chapter != $chapterparam) {
    $chapternav .= ' | <a href="?page='.$mypage.'&subpage=help&chapter='.$chapterparam.'">'.$chapterprops[0].'</a>';
  } else {
    $chapternav .= ' | '.$chapterprops[0];
  }
}
$chapternav = ltrim($chapternav, " | ");

// SWITCH PARSEMODES & BUILD OUTPUT
////////////////////////////////////////////////////////////////////////////////
$addonroot = $REX['INCLUDE_PATH']. '/addons/'.$mypage.'/';
$source    = $chapterpages[$chapter][1];
$parsemode = $chapterpages[$chapter][2];


// ADDON OUTPUT
////////////////////////////////////////////////////////////////////////////////
echo '
<div class="rex-addon-output">
  <h2 class="rex-hl2" style="font-size:1em">'.$chapternav.'</h2>
  <div class="rex-addon-content">
    <div class= "rexbrowscap">
    '.browscap_incparse($addonroot,$source,$parsemode,true).'
    </div>
  </div>
</div>';

