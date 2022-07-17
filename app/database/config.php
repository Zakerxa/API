<?php

$production = false;

if($production){
  // Production
  define('MYSQL_DATABASE','cp285633_API');
  define('MYSQL_USER','cp285633_API');
  define('MYSQL_PASSWORD','kNQ9ok7Y_%l%');
}else{
  //LocalHost
  define('MYSQL_DATABASE','api');
  define('MYSQL_USER','root');
  define('MYSQL_PASSWORD','Pass@1234');
}
define('MYSQL_HOST','127.0.0.1');

$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
);

$pdo = new PDO(
    'mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DATABASE,MYSQL_USER,MYSQL_PASSWORD,$options
);

date_default_timezone_set("Asia/Yangon");

$diffWithGMT = 6 * 60 * 60 + 30 * 60; //converting time difference to seconds.
$ygntime     = gmdate("Y-m-d H:i:s", time() + $diffWithGMT);
$ygndate     = gmdate("Y-F-d", time() + $diffWithGMT);
$ygndatetime = gmdate("Y-F-d ( D ) h:i A", time() + $diffWithGMT);
$today       = date("d/n/Y");
$date     = date("Y-M-d ( l )");
