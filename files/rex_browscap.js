/**
 * RexBrowscap Addon - JS frontend functions
 *
 * @author st DOT jonathan AT gmail DOT com
 * @link https://github.com/GaretJax/phpbrowscap/
 * @author rexdev.de
 * @link https://github.com/jdlx/rex_browscap
 *
 * @package redaxo 4.3.x/4.4.x
 */


function rex_browscap_cookies(data){                                            //console.log('setting cookies..');
  document.cookie="display_width="+data.display_width+"; path=/";
  document.cookie="display_height="+data.display_height+"; path=/";
  document.cookie="viewport_width="+data.viewport_width+"; path=/";
  document.cookie="viewport_height="+data.viewport_height+"; path=/";
  document.cookie="rex_browscap_cookies_set=true; path=/";
}

function getCookie(c_name)
{                                                                               //console.log('reading cookie: '+c_name);
var i,x,y,ARRcookies=document.cookie.split(";");
for (i=0;i<ARRcookies.length;i++)
{
  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
  x=x.replace(/^\s+|\s+$/g,"");
  if (x==c_name)
    {
    return unescape(y);
    }
  }
}

function rex_browscap_callback(data,async){
    var xmlhttp = null;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }else if (window.ActiveXObject) {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.open('POST', 'index.php', async);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send('rex_browscap='+JSON.stringify(data));
    return xmlhttp.responseText;
}

function rex_get_browser(){
  data = {};
  data.action = 'rex_get_browser';
  return JSON.parse(rex_browscap_callback(data,false));
}

function rex_browscap_screen_sniff(forced){                                     //console.log('sniffing forced: '+forced);
  if(!forced){
    if(getCookie('rex_browscap_cookies_set')=='true'){                          //console.log('rex_browscap_cookies_set: true');
      return false;
    }
  }                                                                             //console.log('doing screen sniffing..');
  var data = {};
  data.display_width = screen.width;
  data.display_height = screen.height;
  var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName("body")[0],x=w.innerWidth||e.clientWidth||g.clientWidth,y=w.innerHeight||e.clientHeight||g.clientHeight;
  data.viewport_width = x;
  data.viewport_height = y;
  data.landscape = data.viewport_width>data.viewport_height ? true : false;

  rex_browscap_cookies(data);
  data.action = 'store_to_session';                                             //console.log('doing backend callback..');
  rex_browscap_callback(data,true);
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
rex_browscap_screen_sniff(false);

// ON RESIZE
window.onresize=function () {
  waitForFinalEvent(function(){
    rex_browscap_screen_sniff(true);
  }, 500, "body");
};
                                                                                //console.log(rex_get_browser());
