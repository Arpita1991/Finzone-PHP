<?php
    $BASE_URL = "https://api.login.yahoo.com/oauth/v2/get_request_token";
    $yql_query = 'select * from pm.finance where symbol="YHOO"';
    $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json";
    // Make call with cURL
    $session = curl_init($yql_query_url);
    curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
    $json = curl_exec($session);
    // Convert JSON to PHP object
     $phpObj =  json_decode($json);
    var_dump($phpObj);
?>