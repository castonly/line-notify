<?php 
if (!isset($_SESSION)) {
	session_start();
}

/* get AJAX function */
if(isset($_POST["method"])){
	$method = $_POST["method"];
} else if (isset($_GET["method"])) {
	$method = $_GET["method"];
}
if (isset($method) && $method != "" 
	&& ($method == "line_send_verification_code")
) {

	if ($method == "line_send_verification_code"){
		line_send_verification_code();
	}
}

function line_send_verification_code() {

	if (isset($_SESSION["users_api_sessions"]) && !empty($_SESSION["users_api_sessions"])) {

		$users_api_sessions = $_SESSION["users_api_sessions"];
		for ($i = 0; $i < count($users_api_sessions); $i++) {
			if ($users_api_sessions[$i]["api_name"] == "Line") {

				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_URL => "https://api.line.me/oauth2/v2.1/verify?access_token=".$users_api_sessions[$i]["api_access_token"],
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

			}
			
		}
		
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

}
?>