<?php

require_once 'config.php';

function getAssetData($serialNumber) {
    global $config;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $config["cmdbUrl"] . "/api/v1/hardware/byserial/$serialNumber");
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $config["cmdbAccessToken"]));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $cmdbData = curl_exec($curl);
    $cmdbData = json_decode($cmdbData, true);
    curl_close($curl);
    return $cmdbData;
}

?>