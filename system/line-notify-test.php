<?php 
$access_token = "eyJhbGciOiJIUzI1NiJ9.lQUH9e-VuDkzya6gqTYB4OGbcKwj8E2CF4pPMNFGqR1c994lcku5eO_uObhLKRjtxBOYv9b5oGVP_sgC9qH6P5_5guTmRkLOtK8nNm1Xj0kyKEbQBtXDlajFrhPXvSCG_ALtUjzQ4UDfjEmyoeK6U8lQA_A5PMDtUWH4GZhcg8s.o1xa1AVt9ALwsI37NBQkkVylCH881RNCVi7u9ZmwjBk";
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.line.me/oauth2/v2.1/verify?access_token=".$access_token,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
));
$response_verify = json_decode(curl_exec($curl));
curl_close($curl);

if ($response_verify->expires_in > 0) {

    $message = array(
        "id" => "userId",
        "type" => "text",
        "message" => "Your verfication code is "
    );

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.line.me/v2/bot/message/push",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "to=".$users_api_sessions[$i]["api_details"]["userId"]."&message=".json_encode($message),
        CURLOPT_HTTPHEADER => array(
            "content-type: application/json",
            "Authorization: Bearer ".$users_api_sessions[$i]["api_access_token"]
        ),
    ));
    $response_send = json_decode(curl_exec($curl));
    curl_close($curl);

    echo "to=".$users_api_sessions[$i]["api_details"]["userId"]."&message=".json_encode($message);

    var_dump($response_send);

    if ($response_send) {

        $response["status"] = true;
        $response["message"] = translate("Successfully sent Line message");
        $response["values"] = $parameters;

        unset($parameters);
        $parameters = array();
        
    } else {

        $response["status"] = false;
        $response["message"] = translate("Unable to send Line message");
        $response["values"] = $parameters;

        unset($parameters);
        $parameters = array();

    }

} else {

    $response["status"] = false;
    $response["message"] = translate("Unable to send Line message");
    $response["values"] = $parameters;

    unset($parameters);
    $parameters = array();

}

if (isset($con)) {
    stop($con);
}

if (isset($method) && $method == __FUNCTION__) {
    echo json_encode($response);
} else {
    return $response["values"];
}
unset($response);
$response = array();
unset($method);
exit();
?>