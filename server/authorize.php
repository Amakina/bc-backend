<?php
require_once ('core.php');

header('Access-Control-Allow-Origin: ' .  $site);
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Max-Age: 3600');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

$data = json_decode(file_get_contents('php://input'));
$jwt = $data->token;


if ($loginService->validate($jwt)) {
    http_response_code(200);
} else  {
    http_response_code(401);
}