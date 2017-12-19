<?php
/*

https://github.com/KiboOst/php-simpleQivivoAPI

Test file so you can set a working config easier.

You must have:
- Your webserver with php running (being a NAS, a webhosting etc)
- Your qivivo Client ID and Secret ID.
- The file splQivivoAPI.php on your server.
*/

//set your API client/secret. You can get them from another php file, a database, encrypted or not. Or simply put them here:
$clienID = 'myclientid';
$secretID = 'mysecretid';

//Here you need to include the splQivivoAPI.php so your script (this file) can access its functions:
require($_SERVER['DOCUMENT_ROOT'].'/path/to/splQivivoAPI.php');

//Then, initiliaze the API:
$_qivivo = new splQivivoAPI($clienID, $secretID);
if (isset($_qivivo->error)) die($_qivivo->error);


//Here, do whatever you want!
//You can call this script via http, cron, etc.
//For example: http://www.mydomaine.com/path/to/test_script.php
$thermostatInfos = $_qivivo->getThermostatInfos(1);
echo "<pre>_____>thermostatInfos:<br>".json_encode($thermostatInfos, JSON_PRETTY_PRINT)."</pre><br>";

$thermostatTemperature = $_qivivo->getThermostatTemperature();
echo "<pre>_____>thermostatTemperature:<br>".json_encode($thermostatTemperature, JSON_PRETTY_PRINT)."</pre><br>";

$thermostatHumidity = $_qivivo->getThermostatHumidity(1);
echo "<pre>_____>thermostatHumidity:<br>".json_encode($thermostatHumidity, JSON_PRETTY_PRINT)."</pre><br>";

$thermostatPresence = $_qivivo->getThermostatPresence(1);
echo "<pre>_____>thermostatPresence:<br>".json_encode($thermostatPresence, JSON_PRETTY_PRINT)."</pre><br>";

$lastPresence = $_qivivo->getLastPresence();
echo "<pre>_____>lastPresence:<br>".json_encode($lastPresence, JSON_PRETTY_PRINT)."</pre><br>";

$settings = $_qivivo->getSettings();
echo "<pre>_____>settings:<br>".json_encode($settings, JSON_PRETTY_PRINT)."</pre><br>";




//DEBUG
echo "<br><pre>_____>_qivivo:<br>".json_encode($_qivivo, JSON_PRETTY_PRINT)."</pre><br>";
?>