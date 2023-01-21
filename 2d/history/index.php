<?php 

require join(DIRECTORY_SEPARATOR, array(__DIR__, "../..","app/class", "2dClass.php"));
require join(DIRECTORY_SEPARATOR, array(__DIR__, "../..","app/class", "requestLimit.php"));

$allowed_hosts = array("localhost", "localhost:8080", "localhost:8000", "127.0.0.1");

if (!isset($_SERVER['HTTP_HOST']) || !in_array($_SERVER['HTTP_HOST'], $allowed_hosts)) {
    Server::ApiRateLimit(60, 3, Myanmar2D::ShowHistory((20)),"3 requests per minute.");
    exit;
} else {
    Server::ApiRateLimit(60, 15, Myanmar2D::ShowHistory((20)), "15 request per minute.");
}
