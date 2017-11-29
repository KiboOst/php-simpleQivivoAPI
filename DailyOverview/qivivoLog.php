<?php

require($_SERVER['DOCUMENT_ROOT'].'/path/to/splQivivoAPI.php'); //Qivivo SDK API
$logfilePath = $_SERVER['DOCUMENT_ROOT'].'/path/to/qivivoLog.json';
$logMaxDays = 90;

$_qivivo = new splQivivoAPI($clienID, $secretID);

//LOGGING:
$log = qiLog();

function qiLog($filePath='/')
{
	global $_qivivo;
    global $logfilePath;
    global $logMaxDays;

    if (@file_exists($logfilePath))
    {
        $prevDatas = json_decode(file_get_contents($logfilePath), true);
    }
    else
    {
        $prevDatas = array();
    }

    //get today sums for each device:
    $today = date('d.m.Y');
    $nowTime = date('H:i');

    //if Qivivo servers are online:
    if (!isset($_qivivo->error))
    {
        //Qivivo data:
        $thermostatTemperature = $_qivivo->getThermostatTemperature();
        $current_temperature_order = $thermostatTemperature['current_temperature_order'];
        $current_temperature = $thermostatTemperature['temperature'];
        $thermostatHumidity = $_qivivo->getThermostatHumidity();
        $current_humidity = $thermostatHumidity['humidity'];

        $thermostatPresence = $_qivivo->getThermostatPresence();
        $var = $thermostatPresence['presence_detected'];
        $presence_detected = 0;
        if ($var == true) $presence_detected = 1;

        //log all these:
        $prevDatas[$today][$nowTime] = array(
                                        'current_temperature_order' => $current_temperature_order,
                                        'current_temperature' => $current_temperature,
                                        'current_humidity' => $current_humidity,
                                        'presence_detected' => $presence_detected,
                                        'exterior_temperature' => $exterior_temperature
                                        );
    }
    else
    {
        if (isset($prevDatas[$today]))
        {
            $prevTime = end($prevDatas[$today]);
            $prevDatas[$today][$nowTime] = $prevTime;
        }
    }

    //set recent up:
    $keys = array_keys($prevDatas);
    usort($keys, 'sortByDate');
    $newArray = array();
    foreach ($keys as $key)
    {
        $newArray[$key] = $prevDatas[$key];
    }
    $prevDatas = $newArray;

    if (count($prevDatas) > $logMaxDays) array_pop($prevDatas);

    //write it to file:
    @$put = file_put_contents($logfilePath, json_encode($prevDatas, JSON_PRETTY_PRINT));
    if ($put) return array('result'=>$prevDatas);
    return array('result'=>$prevDatas, 'error'=>'Unable to write file!');
}

function sortByDate($a, $b)
    {
        $t1 = strtotime($a);
        $t2 = strtotime($b);
        return ($t2 - $t1);
    }

?>