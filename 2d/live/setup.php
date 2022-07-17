<?php

function showApi($api){
    require join(DIRECTORY_SEPARATOR, array(__DIR__, "../..", "app/class", "requestLimit.php"));

    if (isset($_POST["pass"]) && isset($_POST["author"])) {

        $allowed_hosts = array("zplus2d.com", "burma2d3d.com", "localhost", "localhost:8080", "localhost:8000", "127.0.0.1");

        if ($_POST["pass"] == "13579" && $_POST["author"] == "zakerxa") {
            if (!isset($_SERVER['HTTP_HOST']) || !in_array($_SERVER['HTTP_HOST'], $allowed_hosts)) {
                Server::ApiRateLimit(60, 3, $api, "3 requests per minute.");
                exit;
            } else {
                Server::ApiRateLimit(60, 15, $api, "15 request per minute.");
            }
        } else {
            header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
        }
    } else {
        Server::ApiRateLimit(60, 3, $api, "3 requests per minute.");
    }
}
