<?php
include 'navbar.php';
include 'baza.php';

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $prijava_id = $_GET['id'];
    
    $query = "SELECT p.*, s.ime_sole AS school_name 
              FROM prijave p 
              INNER JOIN sole s ON p.sola_id = s.id_sole 
              WHERE id_prijave = ?";
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
        .delete_button{
            text-align: center;
        }
       .btn-danger{
        cursor: pointer;
              background-color: red;
              color: white;
              border: none;
              padding: 15px 25px;
              border-radius: 40px;
              font-size: 24px;
              margin-top: 20px;
              text-align: center;
              transition: background-color 1s;
       }
       .btn-danger:hover{
        background-color: darkred;
    }
        .container {
            max-width: 800px;
            margin: 40px auto;
            background-color: #fff;
            padding: 20px;

            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            
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
            <label>Šola obiska:</label> <?php echo $prijava['school_name']; ?>
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

    <div class="delete_button">
<form method="post" action="prijava_izbris.php?id=<?php echo $prijava['id_prijave']; ?>">
    <input type="hidden" name="id_prijave" value="<?php  echo $prijava['id_prijave']; ?>">
    <button type="submit" class="btn btn-danger">Izbriši</button>
</form>
    </div>
</body>
</html>
