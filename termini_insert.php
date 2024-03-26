<?php

require_once 'baza.php';



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $action = $_POST['action'];

    
    $query = "SELECT * FROM termini WHERE datum = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
       
        $query = "UPDATE termini SET prosto = ? WHERE datum = ?";
        $stmt = $conn->prepare($query);
        if ($action === 'plus') {
            $stmt->bind_param('is', $prosto, $date);
            $prosto = 1;
        } else {
            $stmt->bind_param('is', $prosto, $date);
            $prosto = 0;
        }
    } else {
        
        $query = "INSERT INTO termini (datum, prosto) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        if ($action === 'plus') {
            $stmt->bind_param('si', $date, $prosto);
            $prosto = 1;
        } else {
            $stmt->bind_param('si', $date, $prosto);
            $prosto = 0;
        }
    }

   
    if ($stmt->execute()) {
        echo "Record updated/inserted successfully";
    } else {
        echo "Error updating/inserting record: " . $conn->error;
    }

    
    $stmt->close();
    $conn->close();
}

?>
