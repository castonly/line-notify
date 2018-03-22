<?php 
/* get AJAX function */
if(isset($_POST["method"])){
	$method = $_POST["method"];
} else if (isset($_GET["method"])) {
	$method = $_GET["method"];
}
if (isset($method) && $method != "" 
	&& ($method == "push_message")
) {

	/* get parameters for AJAX function */
	if(isset($_POST["parameters"])){
		$parameters = $_POST["parameters"];
	}

	if ($method == "push_message"){
		line_send_verification_code($_POST["parameters"]);
	}
}

function push_message($channel_secret, $access_token, $user_id, $message) {

    $parameters = array(
        "to" => $user_id,
        "messages" => $messages
    );

    var_dump(json_encode($param));

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
	curl_close($curl);
	
	echo $response_send;

}
?>