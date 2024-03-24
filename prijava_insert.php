<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $ime_sole = htmlspecialchars($_POST['field1']);
    $izvedba_delavnic = htmlspecialchars($_POST['field2']);
    $datum_obiska = $_POST['field3'];
    $urnik_obiska = htmlspecialchars($_POST['field4']);
    $sola_id = intval($_POST['field5']); 
    $razred = htmlspecialchars($_POST['field6']);
    $e_naslov = filter_var($_POST['field8'], FILTER_SANITIZE_EMAIL);
    $telefon = htmlspecialchars($_POST['field7']);
    $st_ucencev = intval($_POST['field9']); 
    $pricakovanja = htmlspecialchars($_POST['field10']);
    $sporocilo = htmlspecialchars($_POST['field11']);
 $status = "Nedoločeno";
   
    require_once 'baza.php';

    
    $stmt = $conn->prepare("INSERT INTO prijave (ime_sole, izvedba_delavnic, datum_obiska, urnik_obiska, sola_id, razred, e_naslov, telefon, st_ucencev, pricakovanja, sporocilo, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
    
   
    $stmt->bind_param("ssssisssisss", $ime_sole, $izvedba_delavnic, $datum_obiska, $urnik_obiska, $sola_id, $razred, $e_naslov, $telefon, $st_ucencev, $pricakovanja, $sporocilo,$status);
    
   
    if ($stmt->execute()) {
        header("Location: prijava_uspeh.php");
        exit();
    } else {
        echo "Napaka pri vstavljanju podatkov: " . $stmt->error;
    }

   
    $stmt->close();
    $conn->close();
} else {
   
    header("Location: prijava.php");
    exit();
}
?>
