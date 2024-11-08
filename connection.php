<?php

       include"credentials.php";

     //database connection
     $connection = new mysqli('localhost',$user, $pw, $db);
     
     //select all records from our table
     $AllRecords = $connection->prepare("SELECT * FROM `Scp Foundation`");
     $AllRecords->execute();
     $results =$AllRecords->get_result();
     
?>     