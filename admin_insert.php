<?php
// Include database connection
require_once 'baza.php';

// Function to insert admin into the database
function insertAdmin($username, $password, $sola_id) {
    global $conn; // Assuming $db is your database connection

  
    $stmt = $conn->prepare("INSERT INTO admini (username, password, sola_id) VALUES (?, ?, ?)");

    // Bind parameters to the prepared statement
    $stmt->bind_param("ssi", $username, $password, $sola_id);

    // Execute the prepared statement
    $stmt->execute();

    // Check if the insertion was successful
    if ($stmt->affected_rows > 0) {
        echo "Admin inserted successfully.";
    } else {
        echo "Error inserting admin: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}


$username = "admin_gim";
$password = password_hash("admin", PASSWORD_DEFAULT); 
$sola_id = 1; 


insertAdmin($username, $password, $sola_id);

