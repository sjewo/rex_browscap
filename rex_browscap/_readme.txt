h1. 1. Funktion _rex_get_browser()_ absichern

Da die von diesem Addon zur Verfügung gestellte Funktionalität nicht zum Redaxo Core gehört, sollte die Verwendung der Funktion(en) für den Fall einer De-Installation/Aktivierung des Addons abgesichert werden.

In den Kopfbereich jedes Templates, Moduls, Addons, oder wo auch immer @rex_get_browser()@ verwendet werden soll zur Sicherheit folgende (oder vergleichbare) Dummy Funktion einfügen:

bc. if (!function_exists('rex_get_browser')) {
  function rex_get_browser() {
    echo 'RexBrowscap Addon nicht installiert!';
  }
}

Ohne eine solche Dummy Funktion kann es zu erheblichen Schwierigkeiten und evtl. totaler Nichterreichbarkeit von frontend *und* backend führen falls die Library/ das Addon nicht eingebunden und somit die Funktion @rex_get_browser()@ undefiniert ist. Sollte der worst case einmal eingetreten sein, dann müßen als ultima ratio die @rex_get_browser()@ Aufrufe manuell aus der DB gelöscht werden.

h1. 2. Anwendung

Der Aufruf der Funktion @rex_get_browser()@ gibt ein array mit einer Vielzahl von Parametern bezügl. des aufrufenden Browsers zurück

bc. $browser = rex_get_browser(); // array 

Ein solches array sieht z.b. so aus:

bc. Array
(
    [browser_name] => Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.5; de; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3 FirePHP/0.4
    [browser_name_regex] => ^mozilla/5\.0 \(macintosh; .*; .*mac os x.*; .*; rv\:1\.9\.2.*\) gecko/.* firefox/3\.6.*$
    [browser_name_pattern] => Mozilla/5.0 (Macintosh; *; *Mac OS X*; *; rv:1.9.2*) Gecko/* Firefox/3.6*
    [Parent] => Firefox 3.6
    [Platform] => MacOSX
    [Browser] => Firefox
    [Version] => 3.6
    [MajorVer] => 3
    [MinorVer] => 6
    [Frames] => 1
    [IFrames] => 1
    [Tables] => 1
    [Cookies] => 1
    [JavaApplets] => 1
    [JavaScript] => 1
    [CssVersion] => 3
    [supportsCSS] => 1
    [Alpha] => 
    [Beta] => 
    [Win16] => 
    [Win32] => 
    [Win64] => 
    [BackgroundSounds] => 
    [CDF] => 
    [VBScript] => 
    [ActiveXControls] => 
    [isBanned] => 
    [isMobileDevice] => 
    [isSyndicationReader] => 
    [Crawler] => 
    [AOL] => 
    [aolVersion] => 0
)

h1. 3. Beispiel

bc.. // Mobile Geräte (Handys, PDAs, etc.) aussieben

$browser = rex_get_browser();
if ($browser['isMobileDevice']==1)
{
  // Code für MobileDevices..
}

p. Analog diesem Beispiel können alle keys des arrays abgefragt und für beliebige Aktionen verwertet werden.
