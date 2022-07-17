<?php

require join(DIRECTORY_SEPARATOR, array(__DIR__, "..", "database", "config.php"));

class Myanmar3D{
    
    public $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo =& $pdo;
    }

    public static function ShowHistoryAndLive($limit){

        $self = new static;
        $history2dList = [];
        $stmtRecord = $self->pdo->prepare("SELECT * FROM 3dHistory ORDER BY ID DESC LIMIT $limit");
        $history3d  = $stmtRecord->execute();
        $history3d  = $stmtRecord->fetchAll(PDO::FETCH_ASSOC);
        foreach ($history3d as $value) {
            $row['no']   = $value['3d'];
            $row['date'] = $value['3ddate'];
            array_push($history2dList, $row);
        }
        return json_encode(array("live"=>self::Api(),"history"=>$history2dList), JSON_UNESCAPED_SLASHES);
    }

    public static function AddHistory() {

        $self = new static;
        // Call Myanmar3D Api
        $json3d = self::Api();
        $threed = $json3d['no'];
        $date   = $json3d['date'];
        // If api data is not ready yet
        if ($threed == 'lot' || $threed == 'xxx') {
            echo "Data not ready yet ! <br><br>";
            print_r($json3d);
            return;
        }
        // if 3D is ready,we'll check DB latest 3D value
        $stmtcheck3d = $self->pdo->prepare("SELECT * FROM 3dHistory WHERE 3d = ? AND 3ddate = ? ORDER BY id DESC LIMIT 1");
        $checkresult = $stmtcheck3d->execute([$threed, $date]);
        $checkresult = $stmtcheck3d->fetch(PDO::FETCH_ASSOC);

        // If 3D Number is exist ,do nothing
        if ($stmtcheck3d->rowCount() === 1 && $checkresult) {
            echo "Data already exist.";
        } else {
            $stmt    = $self->pdo->prepare("INSERT INTO 3dHistory(3d, 3ddate) VALUE (:3d,:3ddate)");
            $result  = $stmt->execute(
                array(':3d' => $threed, ':3ddate' => $date)
            );
            if($result){
                echo "Successfully inserted.";
            }
        }
    }

    public static function Api(){
        try {
            $html = file_get_contents("https://news.sanook.com/lotto/");

            $arr = array("0", "0", "0", "0");

            $start = strpos($html, "lotto--result__subheader");
            if ($start === false) {
                $start = strpos($html, "lottohead-click-pc");
            }

            if ($start !== false) {
                $html = substr($html, $start);
                $html = substr($html, strpos($html, ">") + 1);
                $length = strpos($html, "</");
                $date = substr($html, 0, $length);
                $arr = explode(" ", $date);
                $arr[2] = str_replace("มกราคม", "January", $arr[2]);
                $arr[2] = str_replace("กุมภาพันธ์", "February", $arr[2]);
                $arr[2] = str_replace("มีนาคม", "March", $arr[2]);
                $arr[2] = str_replace("เมษายน", "April", $arr[2]);
                $arr[2] = str_replace("พฤษภาคม", "May", $arr[2]);
                $arr[2] = str_replace("มิถุนายน", "June", $arr[2]);
                $arr[2] = str_replace("กรกฎาคม", "July", $arr[2]);
                $arr[2] = str_replace("สิงหาคม", "August", $arr[2]);
                $arr[2] = str_replace("กันยายน", "September", $arr[2]);
                $arr[2] = str_replace("ตุลาคม", "October", $arr[2]);
                $arr[2] = str_replace("พฤศจิกายน", "November", $arr[2]);
                $arr[2] = str_replace("ธันวาคม", "December", $arr[2]);
                $arr[3] = $arr[3] - 543;
            }

            $start = strpos($html, "lotto__number--01");
            if ($start === false) {
                $start = strpos($html, "lotto__number--first");
            }
            $html = substr($html, $start);
            $html = substr($html, strpos($html, ">") + 4);
            $threed = substr($html, 0, 3);

            return array('date' => $arr[1] . " " . $arr[2] . " " . $arr[3], 'no' => $threed);

        } catch (\Throwable $th) {

            return array('date' => "- -", 'no' => "- -");
        }
    }
}
