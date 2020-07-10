<?php

require_once ('./vendor/autoload.php');
require_once ('mysqlConfig.php');
require_once ('dbConnection.php');
require_once ('dbConfig.php');
require_once ('loginService.php');
require_once ('yandexSearch.php');
require_once ('googleSearch.php');

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;

$main = 'localhost';

$site = 'http://' . $main;

$config = new MySQLConfig('localhost', 'bcbackend', 'root', '');
$connection = new DatabaseConnection($config);
$pdo = $connection->getPDOConntection();

$googleSearchKey = '';
$googleSearchEngineKey = '';

$yandexSearchUser = '';
$yandexSearchKey = '';

$yandex = new YandexSearch($yandexSearchKey, $yandexSearchUser);
$google = new GoogleSearch($googleSearchKey, $googleSearchEngineKey);

$dataUser = 'user';
$dataPassword = 'password';

$loginService = new LoginService();

$iss = $main;
$aud = $main;
$key = new Key('H8loj3scjPggpHDnUHfVz6TllLTJZqyA');
$signer = new Sha256();
