<?php
include 'baza.php';

if (isset($_POST['date'])) {
    $date = $_POST['date'];

    $query = "SELECT prosto FROM termini WHERE datum = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $date);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($prosto);
        $stmt->fetch();
        echo $prosto === 1 ? 'Prosto' : 'Zasedeno';
    } else {
       
        echo ''; 
    }
} else {
    echo "date-not-provided";
}

$stmt->close();
$conn->close();
?>
