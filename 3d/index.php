<?php 

require join(DIRECTORY_SEPARATOR, array(__DIR__, "..","app/class", "3dClass.php"));
require join(DIRECTORY_SEPARATOR, array(__DIR__, "..","app/class", "requestLimit.php"));

$allowed_hosts = array("zplus2d.com", "burma2d3d.com", "localhost", "localhost:8080", "localhost:8000", "127.0.0.1");

if (!isset($_SERVER['HTTP_HOST']) || !in_array($_SERVER['HTTP_HOST'], $allowed_hosts)) {
    Server::ApiRateLimit(60, 4, Myanmar3D::ShowHistoryAndLive(15),"5 requests per minute.");
    exit;
} else {
    Server::ApiRateLimit(60, 15, Myanmar3D::ShowHistoryAndLive(15), "15 request per minute.");
}