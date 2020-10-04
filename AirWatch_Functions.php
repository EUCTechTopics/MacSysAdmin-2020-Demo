<?php

require_once 'config.php';

function updateAssetTag($deviceId, $assetTag) {
    global $config;
    $curl = curl_init();
    $data = array('AssetNumber' => $assetTag);
    $data = json_encode($data);
    $url = $config["awApiUrl"] . "/API/mdm/devices/$deviceId";
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "aw-tenant-code: " . $config["awTenantCode"],
        "Content-Type: application/json",
        "Authorization: Basic " . $config["awBasicAuth"]
        ));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);        
    curl_exec($curl);
    curl_close($curl);
}

function pushProfile($deviceId, $profileId) {
    global $config;
	$curl = curl_init();
    $data = array('DeviceId' => $deviceId);
    $data = json_encode($data);
    $url = $config["awApiUrl"] . "/API/mdm/profiles/$profileId/install";
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "aw-tenant-code: " . $config["awTenantCode"],
        "Content-Type: application/json",
        "Authorization: Basic " . $config["awBasicAuth"]
        ));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);        
    curl_exec($curl);
    curl_close($curl);
}

?>