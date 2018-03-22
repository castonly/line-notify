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
		line_send_verification_code($_POST["channel_secret"], $_POST["access_token"], $_POST["user_id"], $_POST["messages"]);
	}
}

function push_message($access_token, $user_id, $messages) {

	/* get global: ajax function */
	global $method;

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
	curl_close($curl);

	if (isset($method) && $method == __FUNCTION__) {
		echo json_encode($response_send);
	} else {
		return $response_send;
	}
	unset($response_send);
	$response_send = array();
	exit();

}
?>