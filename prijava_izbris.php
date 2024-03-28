<?php
include 'baza.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM prijave WHERE id_prijave = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();


    if($stmt->affected_rows > 0){
        header('Location: mainpage.php');
    } else {
        echo "Napaka pri brisanju termina";
    }
}
?>
