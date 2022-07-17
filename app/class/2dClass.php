<?php
require join(DIRECTORY_SEPARATOR, array(__DIR__, "..", "database", "config.php"));

class Myanmar2D
{

    public $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = &$pdo;
    }

    public static function Api()
    {
        $opts = array(
            'http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query(
                    array(
                        'author' => 'zakerxa',
                        'pass'   => '13579'
                    )
                )

            )
        );
        return file_get_contents("https://api.zakerxa.com/2d/live/", false, stream_context_create($opts));
    }

    // Show 2dHistory to UI
    public static function ShowHistory($limit){
        $self = new static;
        $stmtGetRecords = $self->pdo->prepare("SELECT * FROM 2dHistory ORDER BY id DESC LIMIT $limit");
        $records        = $stmtGetRecords->execute();
        $records        = $stmtGetRecords->fetchAll(PDO::FETCH_ASSOC);

        $array = [];
        if ($stmtGetRecords->rowCount() >= 1 && $records) {
            foreach ($records as $value) {
                $row['id']     = $value['id'];
                $row['firdig']    = $value['fir2d'];
                $row['firset']   = $value['firset'];
                $row['firvalue'] = $value['firvalue'];
                $row['findig']    = $value['fin2d'];
                $row['finset']   = $value['finset'];
                $row['finvalue'] = $value['finvalue'];
                $row['firMD'] = $value['firMd'];
                $row['firIN'] = $value['firIn'];
                $row['finMD'] = $value['finMd'];
                $row['finIN'] = $value['finIn'];
                $row['date'] = $value['date'];
                $row['created_date'] = $value['created_date'];
                $array[] = $row;
            }
            return json_encode($array, JSON_UNESCAPED_SLASHES);
        } else {
            return json_encode(array("error"), JSON_UNESCAPED_SLASHES);;
        }
    }

    // Add 2dHistory to Database
    public static function AddHistory(){

        $self = new static;
        $date     = date("Y-M-d ( l )");
        $data = json_decode(self::Api(), true);
        $data = $data['live'];

        $stmtGetRecords = $self->pdo->prepare("SELECT * FROM 2dHistory ORDER BY id DESC LIMIT 1");
        $records        = $stmtGetRecords->execute();
        $records        = $stmtGetRecords->fetch(PDO::FETCH_OBJ);
        
        if (($data['finset'] == $records->finset) && ($data['finvalue'] == $records->finvalue && $data['finMD'] == $records->finMd)) {
          echo "Data Exist! Can't Insert Again.";
          die();
        } else {
          $stmtInsert = $self->pdo->prepare("INSERT INTO 2dHistory (fir2d,firset,firvalue,fin2d,finset,finvalue,firMd,firIn,finMd,finIn,date,created_date) VALUES (?,?,?,?,?,?,?,?,?,?,?,NOW())");
          $insert     = $stmtInsert->execute([$data['firdig'], $data['firset'], $data['firvalue'], $data['findig'], $data['finset'], $data['finvalue'], $data['firMD'], $data['firIN'], $data['finMD'], $data['finIN'], $date]);
          if ($insert) {
            echo "Successfully Inserted data.";
          }
        }
    }
}
