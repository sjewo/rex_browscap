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


function rex_browscap_cookies(data){
  document.cookie="display_width="+data.display_width+"; path=/";
  document.cookie="display_height="+data.display_height+"; path=/";
  document.cookie="viewport_width="+data.viewport_width+"; path=/";
  document.cookie="viewport_height="+data.viewport_height+"; path=/";
}

function rex_browscap_callback(data) {
    var xmlhttp = null;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }else if (window.ActiveXObject) {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.open('POST', 'index.php', true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send('rex_browscap='+JSON.stringify(data));
}

function rex_browscap_screen_sniff(){
  var data = {};
  data.display_width = screen.width;
  data.display_height = screen.height;
  var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName("body")[0],x=w.innerWidth||e.clientWidth||g.clientWidth,y=w.innerHeight||e.clientHeight||g.clientHeight;
  data.viewport_width = x;
  data.viewport_height = y;
  data.landscape = data.viewport_width>data.viewport_height ? true : false;

  rex_browscap_cookies(data);
  data.action = 'store_to_session';
  rex_browscap_callback(data);
}

// http://stackoverflow.com/a/4541963/668767
var waitForFinalEvent = (function () {
  var timers = {};
  return function (callback, ms, uniqueId) {
    if (!uniqueId) {
      uniqueId = 'autoId';
    }
    if (timers[uniqueId]) {
      clearTimeout (timers[uniqueId]);
    }
    timers[uniqueId] = setTimeout(callback, ms);
  };
})();

// MAIN
////////////////////////////////////////////////////////////////////////////////

// ONE SHOT ON LOAD
rex_browscap_screen_sniff();

// ON RESIZE
window.onresize=function () {
  waitForFinalEvent(function(){
    rex_browscap_screen_sniff();
  }, 500, "body");
};
