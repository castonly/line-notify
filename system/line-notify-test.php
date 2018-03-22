<?php 
$user_id = "U9d9ea40b1b06d2518a9bd6e64e74147d";
$access_token = "q+wPquCFdGY2ZqRj/BBpS95kouLlO2OdKHjshfccPcMHeC8XALFW/nI6V1/ZKNcz1KehUU6mlOzom9JT0TNGqirxQV3HS/VrVodntXYsMzdozLsfnsahYwbH4oZoeMOj/0U6EVWC/PA64+9l4ZrcOwdB04t89/1O/w1cDnyilFU=";
$channel_secret = "7596dca412ced79ae5c8b72feda17c52";

$messages = array(
    array(
        "type" => "text",
        "text" => "Your verfication code is "
    )
);

$parameters = array(
    "to" => $user_id,
    "messages" => $messages
);

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.line.me/v2/bot/message/push",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode($parameters),
    CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json",
        "Authorization: Bearer ".$access_token
    ),
));
$response_send = json_decode(curl_exec($curl));
var_dump($response_send);
curl_close($curl);
?>