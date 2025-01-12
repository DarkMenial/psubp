<?php
function getDevice() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $device = 'Unknown';
    
    // List of common user agents for different devices
    $mobileUserAgents = array('iPhone', 'iPad', 'Android', 'Windows Phone', 'BlackBerry', 'Mobile');
    $tabletUserAgents = array('iPad', 'Android', 'Tablet');
    
    // Check if the user agent contains any of the mobile user agents
    foreach ($mobileUserAgents as $mobileAgent) {
        if (stripos($userAgent, $mobileAgent) !== false) {
            $device = 'Mobile';
            break;
        }
    }
    
    // If the device is still 'Unknown', check if it's a tablet
    if ($device === 'Unknown') {
        foreach ($tabletUserAgents as $tabletAgent) {
            if (stripos($userAgent, $tabletAgent) !== false) {
                $device = 'Tablet';
                break;
            }
        }
    }
    
    return $device;
}

// Example usage:
// $device = getDevice();
// echo "Device: $device";
?>
