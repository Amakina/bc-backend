<?php

require_once ('core.php');

header('Access-Control-Allow-Origin: ' . $site);
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Max-Age: 3600');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

$json = json_decode(file_get_contents('php://input'));

$query = $json->query;
$start = $json->start;

try {
  $result = $google->GetQueryResults($query, $start);
  $google->SaveQueryToDB($pdo, $result, $query);
  echo $result;

  /*
  $result = $yandex->GetQueryResults($query, $start);
  $yandex->SaveQueryToDB($pdo, $result, $query);
  echo $result;
  */

} catch (PDOException $pe) {
  echo 'Error occured';
}


