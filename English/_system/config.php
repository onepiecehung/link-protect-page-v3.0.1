<?php
/* >_ Developed by Vy Nghia */
require 'class/ProtectClass.php';

//default config
define('PAGEID', '123456789');
define('WEBURL', 'http://domain.com');

$db = new Database;
$db->dbhost('localhost');
$db->dbuser('username');
$db->dbpass('password');
$db->dbname('database_name');

$db->connect();

//Facebook App
$FacebookAppID = '123456789';
$FacebookAppSecret = 'XXXXXXXXXXXXXXXXXXXXXXXX';

//Google Api
$GoogleApiKey = 'XXXXXXXXXXXXXXXXXXXXXXXX';