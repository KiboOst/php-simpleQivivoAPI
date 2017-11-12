# php-simpleQivivoAPI

## Simple to use php official API warper for Smart Qivivo Thermostat

This php API is a set of functions used with the official Qivivo API, so you don't have to mess with oauth2 autorization, access token and curl requests handling.

[Link to official Qivivo API](https://documenter.getpostman.com/view/1147709/qivivo-api/2MsDNL)

Actually, the official API doesn't support multi-zone. You can have a look here if you need it: [php-qivivoAPI](https://github.com/KiboOst/php-qivivoAPI)



[Requirements](#requirements)<br />
[How-to](#how-to)<br />
[Connection](#connection)<br />
[Reading datas](#reading-operations)<br />
[Changing datas](#changing-operations)<br />
[Version history](#version-history)<br />

## Requirements
- PHP v5+
- Your Qivivo application *Client ID* and *Secret ID*.

If you don't have Qivivo App yet, just create one, it's simple and free:

- Register at https://account.qivivo.com/
- Create an app with any name and *https://qivivo.com/authorize* as redirection URL.
- After successfully created your app, just get *Client ID* and *Secret ID*.

[&#8657;](#php-simpleqivivoapi)

## How-to
- Download class/splQivivoAPI.php and put it on your server.
- Include splQivivoAPI.php in your script.
- Start it with your Qivivo *Client ID* and *Secret ID*.


#### Connection

```php
require($_SERVER['DOCUMENT_ROOT'].'/path/to/splQivivoAPI.php');
$_qivivo = new splQivivoAPI($clienID, $secretID);
if (isset($_qivivo->error)) die($_qivivo->error);
```

[&#8657;](#php-simpleqivivoapi)
Let the fun begin:

#### READING OPERATIONS<br />

```php
//Retrieve the basics information of the gateway:
$gatewayInfos = $_qivivo->getGatewayInfos();
echo "<pre>_____>gatewayInfos:<br>".json_encode($gatewayInfos, JSON_PRETTY_PRINT)."</pre><br>";

//Retrieve the basic thermostat info:
$thermostatInfos = $_qivivo->getThermostatInfos();
echo "<pre>_____>thermostatInfos:<br>".json_encode($thermostatInfos, JSON_PRETTY_PRINT)."</pre><br>";

//Retrieve the last temperature measured by the given thermostat.:
$thermostatTemperature = $_qivivo->getThermostatTemperature();
echo "<pre>_____>thermostatTemperature:<br>".json_encode($thermostatTemperature, JSON_PRETTY_PRINT)."</pre><br>";

//Retrieve the humidity measured by the thermostat:
$thermostatHumidity = $_qivivo->getThermostatHumidity();
echo "<pre>_____>thermostatHumidity:<br>".json_encode($thermostatHumidity, JSON_PRETTY_PRINT)."</pre><br>";

//Retrieve the presence measured by the thermostat:
$thermostatPresence = $_qivivo->getThermostatPresence();
echo "<pre>_____>thermostatPresence:<br>".json_encode($thermostatPresence, JSON_PRETTY_PRINT)."</pre><br>";

//Retrieve the last recorded presence in the house:
$lastPresence = $_qivivo->getLastPresence();
echo "<pre>_____>lastPresence:<br>".json_encode($lastPresence, JSON_PRETTY_PRINT)."</pre><br>";

//Retrieve the list of settings of the house:
$settings = $_qivivo->getSettings();
echo "<pre>_____>settings:<br>".json_encode($settings, JSON_PRETTY_PRINT)."</pre><br>";

//Retrieve the list of event planned in the house:
$events = $_qivivo->getEvents();
echo "<pre>_____>events:<br>".json_encode($events, JSON_PRETTY_PRINT)."</pre><br>";

//Retrieve the list of devices owned by the current user:
$devices = $_qivivo->getDevices();
echo "<pre>_____>devices:<br>".json_encode($devices, JSON_PRETTY_PRINT)."</pre><br>";

//Retrieve the basic wireless module info:
$uuid = 'fcb231fd-3eda-4089-8fb0-643c966d2ef3';
$moduleInfos = $_qivivo->getModuleInfos($uuid);
echo "<pre>_____>moduleInfos:<br>".json_encode($moduleInfos, JSON_PRETTY_PRINT)."</pre><br>";


//!following reading functions actually works only when multizone is NOT enabled (official API limitations):

//Retrieve user programs:
$thermostatPrograms = $_qivivo->getThermostatPrograms();
echo "<pre>_____>thermostatPrograms:<br>".json_encode($thermostatPrograms, JSON_PRETTY_PRINT)."</pre><br>";

//Retrieve the last temperature measured by the wireless module:
$moduleTemperature = $_qivivo->getModuleTemperature($uuid);
echo "<pre>_____>moduleTemperature:<br>".json_encode($moduleTemperature, JSON_PRETTY_PRINT)."</pre><br>";

//Retrieve the last humidity level measured by the wireless module:
$moduleHumidity = $_qivivo->getModuleHumidity($uuid);
echo "<pre>_____>moduleHumidity:<br>".json_encode($moduleHumidity, JSON_PRETTY_PRINT)."</pre><br>";

//Retrieve the current active pilot wire order:
$moduleOrder = $_qivivo->getModuleLastOrder($uuid);
echo "<pre>_____>moduleOrder:<br>".json_encode($moduleOrder, JSON_PRETTY_PRINT)."</pre><br>";
```

[&#8657;](#php-simpleqivivoapi)
#### CHANGING OPERATIONS<br />

```php
//Set an absence periode:
$startDate = '2017-11-12 16:00';
$endDate = '2017-11-14 16:00';
$absence = $_qivivo->setAbsence($startDate, $endDate);
echo "<pre>_____>absence:<br>".json_encode($absence, JSON_PRETTY_PRINT)."</pre><br>";

//Cancel an absence periode. The thermostat will go back to its regular behaviors and will follow the programmation set:
$absence = $_qivivo->cancelAbsence();
echo "<pre>_____>absence:<br>".json_encode($absence, JSON_PRETTY_PRINT)."</pre><br>";

//Set the number of day before receiving an absence alert when the thermostat measures no presence (OFFICIAL API CAN SET ONLY FULL DAYS, not 1.5 for example):
$alert = $_qivivo->setAbsenceAlertDays(1);
echo "<pre>_____>alert:<br>".json_encode($alert, JSON_PRETTY_PRINT)."</pre><br>";

//Set temperature for one of the following default temperature settings:
//presence_temperature_1 presence_temperature_2 presence_temperature_3 presence_temperature_4 night_temperature absence_temperature frost_protection_temperature
$setting = $_qivivo->setSetting('presence_temperature_4', 25);
echo "<pre>_____>setting:<br>".json_encode($setting, JSON_PRETTY_PRINT)."</pre><br>";

//Set a temporary temperature for the zone controlled by the thermostat, during 20mins:
$thermostat = $_qivivo->setThermostatTemperature(21, 20);
echo "<pre>_____>thermostat:<br>".json_encode($thermostat, JSON_PRETTY_PRINT)."</pre><br>";

//Stop the current temporary temperature for the zone controlled by the thermostat:
$_qivivo->cancelThermostatTemperature()

//Following functions are used for thermostat zone programs. Other zones programs are not yer supported by official API.

//Edit the name of a program:
$renameProgram = $_qivivo->renameThermostatProgram('Semaine Vacances', 'Vacances');
echo "<pre>_____>renameProgram:<br>".json_encode($renameProgram, JSON_PRETTY_PRINT)."</pre><br>";

//Delete a thermostat program:
$delProgram = $_qivivo->deleteThermostatProgram('myProgram');
echo "<pre>_____>delProgram:<br>".json_encode($delProgram, JSON_PRETTY_PRINT)."</pre><br>";

//Set the program to active, making it the program used by the thermostat:
$activeProgram = $_qivivo->setActiveThermostatProgram('Semaine Travail');
echo "<pre>_____>activeProgram:<br>".json_encode($activeProgram, JSON_PRETTY_PRINT)."</pre><br>";

//create a new thermostat zone program:
$program = array();
$program['name'] = 'myProgram';
$program['program']['monday'] = array(array('period_start'=>'00:00',
											'period_end'=>'06:59',
											'temperature_setting'=>'night_temperature',
											),
									  array('period_start'=>'07:00',
										 	'period_end'=>'23:59',
										 	'temperature_setting'=>'night_temperature'
											)
								);
$program['program']['tuesday'] = array(array('period_start'=>'07:00',
										 	'period_end'=>'23:59',
										 	'temperature_setting'=>'night_temperature'
											)
								);
$program['program']['wednesday'] = array(array('period_start'=>'07:00',
										 	'period_end'=>'23:59',
										 	'temperature_setting'=>'night_temperature'
											)
								);
$program['program']['thursday'] = array(array('period_start'=>'07:00',
										 	'period_end'=>'23:59',
										 	'temperature_setting'=>'night_temperature'
											)
								);
$program['program']['friday'] = array(array('period_start'=>'07:00',
										 	'period_end'=>'23:59',
										 	'temperature_setting'=>'night_temperature'
											)
								);
$program['program']['saturday'] = array(array('period_start'=>'07:00',
										 	'period_end'=>'23:59',
										 	'temperature_setting'=>'night_temperature'
											)
								);
$program['program']['sunday'] = array(array('period_start'=>'07:00',
										 	'period_end'=>'23:59',
										 	'temperature_setting'=>'night_temperature'
											)
								);
$newProgram = $_qivivo->createThermostatProgram($program);
echo "<pre>_____>newProgram:<br>".json_encode($newProgram, JSON_PRETTY_PRINT)."</pre><br>";

```

[&#8657;](#php-simpleqivivoapi)
## Version history

#### v0.1 (2017-11-12)
- First public version!

[&#8657;](#php-simpleqivivoapi)
## License

The MIT License (MIT)

Copyright (c) 2017 KiboOst

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
