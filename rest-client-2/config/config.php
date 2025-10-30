<?php
function http_request_get($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'X-Api-Key: a5cc5cdfc7fb41ac91f432303bc26607'
    ));
    
    $output = curl_exec($ch);
    
    if(curl_errno($ch)) {
        error_log('Curl error: ' . curl_error($ch));
    }
    
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    error_log('HTTP Code: ' . $httpCode);
    
    curl_close($ch);
    return $output;
}

?>