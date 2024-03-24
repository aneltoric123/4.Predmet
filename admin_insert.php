<?php

require_once 'baza.php';


function insertAdmin($username, $password, $sola_id) {
    global $conn; 

  
    $stmt = $conn->prepare("INSERT INTO admini (username, password, sola_id) VALUES (?, ?, ?)");

   
    $stmt->bind_param("ssi", $username, $password, $sola_id);

   
    $stmt->execute();

   
    if ($stmt->affected_rows > 0) {
        echo "Admin inserted successfully.";
    } else {
        echo "Error inserting admin: " . $stmt->error;
    }

    
    $stmt->close();
}


$username = "admin_gim";
$password = password_hash("admin", PASSWORD_DEFAULT); 
$sola_id = 1; 


insertAdmin($username, $password, $sola_id);

