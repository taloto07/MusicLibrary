<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *///173.254.28.56
    $db_hostname = "just56.justhost.com";
    $db_database = "koolninc_music";
    $db_username = 'koolninc_H';
    $db_password = 'Abc123456';
    
    try{
        $conn = new PDO("mysql:host=$db_hostname;dbname=$db_database", $db_username, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->query("SET NAMES UTF8");

        $rows = $conn->query("SELECT * FROM songs");

        if (count($rows)){
            foreach ($rows as $row){
                echo "<div id='playMusic' class='playMusic' value='$row[2]'>$row[0] $row[1]</div>";
            }
        }else{
            echo "No result.";
        }

        // Close connection
        $conn = null;
    }catch(PDOException $e){
        echo "ERROR: ". $e->getMessage();
    }
?>

