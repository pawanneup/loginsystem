<?php   
    $servername = "localhost";
    $username_db = "root";
    $password_db = ""; 
    $dbname = "pawandb";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username_db, $password_db);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
      
       
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }