<?php
date_default_timezone_set("Asia/Yangon");

$path = join(DIRECTORY_SEPARATOR, array(__DIR__, "..", "2d/live", "index.php"));

$myfile = fopen($path, "w") or die("Can’t open $path");
fwrite($myfile,'<?php require join(DIRECTORY_SEPARATOR, array(__DIR__, "..","live", "setup.php"));$api = \'' . sendData() . '\';showApi($api);');
fclose($myfile);


function sendData(){

    $api  = file_get_contents('https://live-2d-api.onrender.com/live/2d/info');
    $data = json_decode($api, true); // Json String to PHP Array
    $set   = $data['live_set'];
    $value = $data['live_value'];
    $live  = $data['live_result'];

    if ($data['market_status'] != "Closed") {
        if ((date("g-a") == "12-pm" && date("i") >= "01") || (date("g-a") == "1-pm") || (date("g") == "2" && date("i") < 30)) {
            $set   = $data['first_out']['set'] ?? $set;
            $value = $data['first_out']['value'] ?? $value;
            $live  = $data['first_out']['result'] ?? $live;
        }
    }

    $json = array(
        'live' => [
            'set'     => $set,
            'value'   => $value,
            'd'       => $live,
            'status'  => $data['market_status'],
            'firMD' => $data['first_modern'] ?? '- -',
            'firIN' => $data['first_internet'] ?? '- -',
            'firdig'  => $data['first_out']['result'] ?? '- -',
            'firset'  => $data['first_out']['set'] ?? '- -',
            'firvalue'  => $data['first_out']['value'] ?? '- -',
            'firdate' => $data['first_out']['datetime'] ?? '- -',
            'finMD' => $data['final_modern'] ?? '- -',
            'finIN' => $data['final_internet'] ?? '- -',
            'findig'  => $data['final_out']['result'] ?? '- -',
            'finset'  => $data['final_out']['set'] ?? '- -',
            'finvalue'  => $data['final_out']['value'] ?? '- -',
            'findate' => $data['final_out']['datetime'] ?? '- -',
            'date'    => date("d/n/Y")
        ]
    );

    return json_encode($json, JSON_UNESCAPED_SLASHES);
}
