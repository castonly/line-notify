<?php 
$user_id = "U9d9ea40b1b06d2518a9bd6e64e74147d";
$access_token = "q+wPquCFdGY2ZqRj/BBpS95kouLlO2OdKHjshfccPcMHeC8XALFW/nI6V1/ZKNcz1KehUU6mlOzom9JT0TNGqirxQV3HS/VrVodntXYsMzdozLsfnsahYwbH4oZoeMOj/0U6EVWC/PA64+9l4ZrcOwdB04t89/1O/w1cDnyilFU=";



    $message = array(
        "type" => "text",
        "message" => "Your verfication code is "
    );

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.line.me/v2/bot/message/push",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => http_build_query("to=".$user_id."&message=".$message),
        CURLOPT_HTTPHEADER => array(
            "content-type: application/json",
            "Authorization: Bearer ".$access_token
        ),
    ));
    $response_send = json_decode(curl_exec($curl));
    curl_close($curl);

    echo "to=".$user_id."&message=".json_encode($message);

    var_dump($response_send);

?>