<?php
header("Content-Type: application/json");

$counterUrl = "https://api.counterapi.dev/v1/owenj-expository/home/up";
$response = @file_get_contents($counterUrl);

if ($response === false) {
	http_response_code(502);
	echo json_encode(["error" => "CounterAPI request failed"]);
	exit;
}

$data = json_decode($response, true);

if (!is_array($data) || !isset($data["count"])) {
	http_response_code(502);
	echo json_encode(["error" => "CounterAPI returned an invalid response"]);
	exit;
}

echo json_encode(["count" => (int) $data["count"]]);
