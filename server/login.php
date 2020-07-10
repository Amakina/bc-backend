<?php

require_once ('core.php');

header('Access-Control-Allow-Origin: ' . $site);
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Max-Age: 3600');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

$data = json_decode(file_get_contents('php://input'));

$user = $data->user;
$password = $data->password;

$token = $loginService->signIn($user, $password);

if ($token == NULL) {
    http_response_code(401);
    echo json_encode(array('message' => 'Login failed'));
} else {
    http_response_code(200);
    echo json_encode(array('message' => 'Succesfull login', 'token' => (string)$token));
}
