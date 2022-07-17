<?php

class Server
{
    public static function ApiRateLimit($maxSec, $maxReq, $api, $message)
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');
        error_reporting(0);
        session_start();

        $time_interval = $maxSec; # In sec
        $max_requests  = $maxReq;
        $fast_request_check = ($_SESSION["last_session_request"] > time() - $time_interval);

        if (!isset($_SESSION)) {
            # This is fresh session, initialize session and its variables
            $_SESSION["last_session_request"] = time();
            $_SESSION["request_cnt"] = 1;
        } elseif ($fast_request_check && ($_SESSION["request_cnt"] < $max_requests)) {
            # This is fast, consecutive request, but meets max requests limit
            $_SESSION["request_cnt"]++;
            echo $api;
        } elseif ($fast_request_check) {
            # This is fast, consecutive request, and exceeds max requests limit - kill it
            header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
            echo json_encode(array("Notice" => "Contact the owner for more requests.","Exceed Limit"=>$message), JSON_UNESCAPED_SLASHES);
            die();
        } else {
            # This request is not fast, so reset session variables
            $_SESSION["last_session_request"] = time();
            $_SESSION["request_cnt"] = 1;
            echo $api;
        }
    }
}
