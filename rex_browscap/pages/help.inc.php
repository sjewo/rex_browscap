<?php

/**
 * RexBrowscap Addon
 * Based on http://code.google.com/p/phpbrowscap/
 * @author st DOT jonathan AT gmail DOT com 
 * @author rexdev.de
 * @package redaxo4.2
 * @version svn:$Id$
 */

// PARAMS
////////////////////////////////////////////////////////////////////////////////
$page = rex_request('page', 'string');
$subpage = rex_request('subpage', 'string');
$chapter = rex_request('chapter', 'string');
$func = rex_request('func', 'string');

// CHAPTER DEFS ('CHAPTER PARAM' => array('TITLE','SOURCE','PARSEMODE'))
////////////////////////////////////////////////////////////////////////////////
$chapterpages = array (
''             => array('Addon Hilfe','_help.txt','textile'),
'tickets'      => array('Addon Tickets','http://gn2-code.de/projects/rex_browscap/issues','jsopenwin')
);

// BUILD CHAPTER NAVIGATION
////////////////////////////////////////////////////////////////////////////////
$chapternav = '';
foreach ($chapterpages as $chapterparam => $chapterprops)
{
  if ($chapter != $chapterparam) {
    $chapternav .= ' | <a href="?page='.$page.'&subpage=help&chapter='.$chapterparam.'">'.$chapterprops[0].'</a>';
  } else {
    $chapternav .= ' | '.$chapterprops[0];
  }
}
$chapternav = ltrim($chapternav, " | ");

// SWITCH PARSEMODES & BUILD OUTPUT
////////////////////////////////////////////////////////////////////////////////
$addonroot = $REX['INCLUDE_PATH']. '/addons/'.$page.'/';
$source    = $chapterpages[$chapter][1];
$parse     = $chapterpages[$chapter][2];

switch ($parse)
{
  case 'textile':
  $source = $addonroot.$source;
  $content = file_get_contents($source);
  $html = textile_parser($content);
  break;
  
  case 'txt':
  $source = $addonroot.$source;
  $content = file_get_contents($source);
  $html =  '<pre class="plain">'.$content.'</pre>';
  break;
  
  case 'iframe':
  $html = '<iframe src="'.$source.'" width="99%" height="600px"></iframe>';
  break;
  
  case 'jsopenwin':
  $html = 'Externer link: <a href="'.$source.'">'.$source.'</a>
  <script language="JavaScript">
  <!--
  window.open(\''.$source.'\',\''.$chapterpages[$chapter][1].'\');
  //-->
  </script>';
  break;
}

// ADDON OUTPUT
////////////////////////////////////////////////////////////////////////////////
echo '
<div class="rex-addon-output">
  <h2 class="rex-hl2" style="font-size:1em">'.$chapternav.'</h2>
  <div class="rex-addon-content">
    <div class= "backendoverride">
    '.$html.'
    </div>
  </div>
</div>';

?>