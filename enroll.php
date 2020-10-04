<?php

require_once 'config.php';
require_once 'AirWatch_Functions.php';
require_once 'CMDB_Functions.php';

# This is the Event Notification from Workspace ONE
$post = file_get_contents("php://input");

# Here the data is decoded
$jsonData = json_decode($post);

# This is where the Workspace ONE device ID is defined
$deviceId = $jsonData->DeviceId;

# This is where the Workspace ONE device serial is defined
$serialNumber = $jsonData->SerialNumber;

# This is where the asset tag is retrieved from the CMDB
$cmdbData = getAssetData($serialNumber);

if (!empty($cmdbData['rows'])) {

    # If an asset is found in the CMDB
    # we need to find the asset tag and
    # update the device details in Workspace ONE
    $rows  = $cmdbData['rows'];
    $asset = $rows[0];

    # This is where we define the asset tag
    $tag = $asset['asset_tag'];

    # This is where we update the device 
    # details in Workspace ONE with the asset tag
    updateAssetTag($deviceId, $tag);
    
    sleep(5);
        
    switch ($jsonData->Platform) {
        # AppleOsX means macOS
        case "AppleOsX":
            # This is the profile ID for the Hello-IT profile
            $profileId = 28021;
            break;
        # Apple means iOS or iPadOS
        case "Apple":
            # This is the profile ID for the Lock Screen profile
            $profileId = 27116;
            break;
    }
    
    # Push the profile depending on the enrolled platform
    pushProfile($deviceId, $profileId);
    
}