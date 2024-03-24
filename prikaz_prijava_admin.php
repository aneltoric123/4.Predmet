<?php
include 'navbar.php';
include 'baza.php';

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $prijava_id = $_GET['id'];
    
    $query = "SELECT * FROM prijave WHERE id_prijave = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $prijava_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1) {
        $prijava = $result->fetch_assoc();
        
    } else {
      
        echo "Prijava not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prikaz Prijave</title>
    <style>
        body {
            font-family: "Open Sans", sans-serif;
            background-color: #f4f4f4;
           
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-top: 0;
            text-align: center;
        }
        .detail {
            margin-bottom: 10px;
        }
        .detail label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Podrobnosti Prijave</h1>
        <div class="detail">
            <label>Ime Osnovne šole:</label> <?php echo $prijava['ime_sole']; ?>
        </div>
        <div class="detail">
            <label>Izvedba delavnic:</label> <?php echo $prijava['izvedba_delavnic']; ?>
        </div>
        <div class="detail">
            <label>Datum obiska:</label> <?php echo $prijava['datum_obiska']; ?>
        </div>
        <div class="detail">
            <label>Urnik obiska:</label> <?php echo $prijava['urnik_obiska']; ?>
        </div>
        <div class="detail">
            <label>Šola obiska:</label> <?php echo $prijava['sola_id']; ?>
        </div>
        <div class="detail">
            <label>Razred:</label> <?php echo $prijava['razred']; ?>
        </div>
        <div class="detail">
            <label>E-naslov kontaktne osebe:</label> <?php echo $prijava['e_naslov']; ?>
        </div>
        <div class="detail">
            <label>Telefon kontaktne osebe:</label> <?php echo $prijava['telefon']; ?>
        </div>
        <div class="detail">
            <label>Število učencev:</label> <?php echo $prijava['st_ucencev']; ?>
    </div>
    <div class="detail">
        <label>Pričakovanja:</label> <?php echo $prijava['pricakovanja']; ?>
    </div>
    <div class="detail">
        <label>Sporočilo:</label> <?php echo $prijava['sporocilo']; ?>
    </div>
    <div class="detail">
        <label>Status:</label> <?php echo $prijava['status']; ?>
    </div>
</body>
</html>
