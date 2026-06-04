<?php
header("Content-Type: application/json");

$file = __DIR__ . "/visitor-count.json";
$handle = fopen($file, "c+");

if (!$handle) {
	http_response_code(500);
	echo json_encode(["error" => "Could not open counter"]);
	exit;
}

flock($handle, LOCK_EX);

$contents = stream_get_contents($handle);
$data = json_decode($contents ?: "{\"count\":0}", true);
$count = isset($data["count"]) ? (int) $data["count"] : 0;
$count++;

ftruncate($handle, 0);
rewind($handle);
fwrite($handle, json_encode(["count" => $count], JSON_PRETTY_PRINT));

flock($handle, LOCK_UN);
fclose($handle);

echo json_encode(["count" => $count]);
