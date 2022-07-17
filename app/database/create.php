<?php

require "config.php";

if(isset($_GET['table'])){
    $table = $_GET['table'];
    $table = "CREATE TABLE $table (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        fir2d VARCHAR(5),
        firset VARCHAR(10),
        firvalue VARCHAR(10),
        firdate VARCHAR(50),
        firMd VARCHAR(5), 
        firIn VARCHAR(5),
        fin2d VARCHAR(5), 
        finset VARCHAR(10), 
        finvalue VARCHAR(10), 
        findate VARCHAR(50),
        finMd VARCHAR(5), 
        finIn VARCHAR(5),
        created_date DATE)";
    create($pdo, $table, "Table => ".$table);
}



// ================= Create Function ====================

function create($pdo, $query, $message)
{
    try {
        // use exec() because no results are returned
        $pdo->exec($query);
        echo "\nCreate $message successfully \n";
    } catch (PDOException $e) {
        echo $query . "<br>" . $e->getMessage();
    }
}

$pdo = null;
