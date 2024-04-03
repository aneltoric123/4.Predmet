<?php
include 'baza.php';
include 'navbar.php';
$current_date = date('Y-m-d');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_prijave'], $_POST['action'])) {
    $id_prijave = $_POST['id_prijave'];
    $action = $_POST['action'];
    $e_naslov = $_POST['e_naslov'];
    $st_ucencev=$_POST['st_ucencev'];
    $update_query = "UPDATE prijave SET status = ? WHERE id_prijave = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('si', $action, $id_prijave);
    $stmt->execute();
    $school_name_query="SELECT s.ime_sole
                        FROM prijave p
                        INNER JOIN sole s ON p.sola_id = s.id_sole
                        WHERE id_prijave = ?";
    $stmt = $conn->prepare($school_name_query);
    $stmt->bind_param('i', $id_prijave);
    $stmt->execute();
    $stmt->bind_result($school_name);
    $stmt->fetch();
    $stmt->close();
    header("Location: mainpage.php?filter=Vsi");

    if ($action == "Sprejeto") {
        $to = $e_naslov;
        $subject = "Prijava Sprejeta";
        $message = "
        <html>
        <head>
          <title>Prijava Sprejeta</title>
        </head>
        <body>
          <p>Pozdravljeni,</p>
          <p>Vaša prijava za ogled Šolskega centra Velenje in predstavitve poklicev, za katere izobražujejo, je bila sprejeta. Spodaj najdete podrobnosti o urniku delavnic:</p>
         <p>Vi ste za obisk zbrali šolo ".$school_name." in ta bodo tudi delavnice potekale.</p>
          <h2>Urnik Delavnic</h2>";
          
        if ($st_ucencev <= 20) {
            $message .= "
            <p>Delavnice se izvajajo na lokaciji ŠC Velenje:</p>
            <ul>
              <li><strong>ŠC Velenje:</strong> 9:00 - 10:00 Predstavitev". $school_name ."</li>
              <li><strong>ŠC Velenje:</strong> 10:00 - 10:30 Malica</li>
              <li><strong>ŠČ Velenje:</strong> 10:30 - 12:00 Delavnica</li>
            </ul>";
        } elseif ($school_name == 'ERŠ' and $st_ucencev > 20) {
            $message .= "
            <p>Razdeljeni boste v 2 skupine (Prosimo Vas, da skupine predhodno določite).Delavnice se izvajajo na 2 lokacijah Medpodjetniški izobraževalni center (MIC) in ŠČ Velenje:</p>
            
            <ul>
              <h1>Urnik za 1.Skupino:</h1> 
              <li><strong>MIC:</strong>9:00 - 10:00 Predstavitev MIC-a</li>
              <li><strong>MIC:</strong>10:00 - 10:30 Malica</li>
              <li><strong>MIC:</strong>10:30 - 12:00 Delavnice na MIC-u</li>
            </ul>
            <ul>
            <h1>Urnik za 2.Skupino:</h1>
            <li><strong>ŠCV:</strong>9:00 - 10:00 Predstavitev ŠCV-a</li>
              <li><strong>ŠCV:</strong>10:00 - 10:30 Malica</li>
              <li><strong>ŠCV:</strong>10:30 - 12:00 Delavnice na ŠCV-u</li>
            </ul>
            "
           ;
        }
        elseif($st_ucencev > 20 and $school_name != 'ERŠ'){
            $message .= "
            <p>Razdeljeni boste v 2 skupine (Prosimo Vas, da skupine predhodno določite)</p>
            <ul>
              <h1>Urnik za 1.Skupino:</h1> 
              <li><strong>MIC:</strong>9:00 - 10:00 Predstavitev " .$school_name."</li>
              <li><strong>MIC:</strong>10:00 - 10:30 Malica</li>
              <li><strong>MIC:</strong>10:30 - 12:00 Delavnice na " .$school_name."</li>
            </ul>
            <ul>
            <h1>Urnik za 2.Skupino:</h1>
            <li><strong>MIC:</strong>9:00 - 10:30 Delavnice na " .$school_name."</li>
              <li><strong>ŠCV:</strong>10:30 - 11:00 Malica</li>
              <li><strong>MIC:</strong>11:00 - 12:00 Predstavitev " .$school_name."</li>
            </ul>";
        }

        $message .= "
          <p>Več informacij lahko najdete na <a href='https://informativni.scv.si'>spletni strani</a> ŠC Velenje.</p>
          <p>Za dodatne informacije ali vprašanja sem vam na voljo na naslovu sabina.omic@scv.si ali na telefonski številki 031 693600.</p>
          <p>Lep pozdrav,<br>Peter Vrčkovnik<br>ŠC Velenje</p>
        </body>
        </html>
        ";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: ŠC Velenje <noreply@scv.si>\r\n";
        $headers .= "Reply-To: sabina.omic@scv.si\r\n";

        if (mail($to, $subject, $message, $headers)) {
            echo "Email sent successfully!";
        } else {
            echo "Email sending failed.";
        }
        exit();
    }
}

$query_school = "SELECT s.ime_sole,s.id_sole
                 FROM sole s
                 INNER JOIN admini a ON s.id_sole = a.sola_id
                 WHERE a.admin_id = ?";
$stmt = $conn->prepare($query_school);
$stmt->bind_param('i', $_SESSION['admin_id']);
$stmt->execute();
$stmt->bind_result($ime_sole, $id_sole);
if ($stmt->fetch()) {
    $school_name = $ime_sole;
} else {
    $school_name = "No School Found";
}
$stmt->close();

if ($school_name == 'vse') {
    $prijave_query = "SELECT * FROM prijave";
    $stmt = $conn->prepare($prijave_query);
} else {
    $prijave_query = "SELECT p.*
                      FROM prijave p
                      INNER JOIN sole s ON p.sola_id = s.id_sole
                      WHERE s.id_sole = ?";
    $stmt = $conn->prepare($prijave_query);
    $stmt->bind_param('i', $id_sole);
}

$stmt->execute();
$stmt->bind_result($id, $ime_sole, $izvedba_delavnic, $datum_obiska, $urnik_obiska, $sola_id, $razred, $e_naslov, $telefon, $st_ucencev, $pricakovanja, $sporocilo, $status);
$prijave = array();
while ($stmt->fetch()) {
    $prijave[] = array(
        'id_prijave' => $id,
        'ime_sole' => $ime_sole,
        'izvedba_delavnic' => $izvedba_delavnic,
        'datum_obiska' => $datum_obiska,
        'urnik_obiska' => $urnik_obiska,
        'sola_id' => $sola_id,
        'razred' => $razred,
        'e_naslov' => $e_naslov,
        'telefon' => $telefon,
        'st_ucencev' => $st_ucencev,
        'pricakovanja' => $pricakovanja,
        'sporocilo' => $sporocilo,
        'status' => $status
    );
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prijave</title>
    <style>
        h1{
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .btn-container {
            display: flex;
            justify-content: center;
        }
        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .sprejmi {
            background-color: #4CAF50;
            color: white;
            margin-left: 5px;
            font-weight: bold;
        }
        .sprejmi:hover {
            background-color: #45a049;
        }
        .zavrni {
            background-color: #f44336;
            color: white;
            margin-left: 5px;
            font-weight: bold;
        }
        .zavrni:hover {
            background-color: #d32f2f;
        }
        .sprejeto {
            color: green;
            font-weight: bold;
        }
        .zavrnjeno {
            color: red;
            font-weight: bold;
        }
        .opcije{
            text-align: center;
        }

    </style>
</head>
<body>
<div class="container">
    <h1>Prijave za  <?php if($school_name =='vse')
        {
            echo "Vse šole";
        } else echo $school_name;?></h1>
    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="filter">Filter:</label>
        <select id="filter" name="filter">
            <option value="Vsi" <?php if ($_GET['filter'] == 'Vsi') echo 'selected'; ?>>Vsi</option>
            <option value="Preteklo" <?php if ($_GET['filter'] == 'Preteklo') echo 'selected'; ?>>Preteklo</option>
            <option value="Sprejeto" <?php if ($_GET['filter'] == 'Sprejeto') echo 'selected'; ?>>Sprejeto</option>
            <option value="Zavrnjeno" <?php if ($_GET['filter'] == 'Zavrnjeno') echo 'selected'; ?>>Zavrnjeno</option>
            <option value="Nedoločeno" <?php if ($_GET['filter'] == 'Nedoločeno') echo 'selected'; ?>>Nedoločeno</option>
            <option value="Prihodnjo" <?php if ($_GET['filter'] == 'Prihodnjo') echo 'selected'; ?>>Prihodnjo</option>
        </select>
        <button type="submit">Apply</button>
    </form>
    <br>
    <table>
        <thead>
        <tr>
            <th>Ime Osnovne šole</th>
            <th>Email</th>
            <th>Status</th>
            <th class="opcije">Opcije</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($prijave as $prijava): ?>
            <?php if ($_GET['filter'] == 'Vsi' ||
                ($_GET['filter'] == 'Sprejeto' && $prijava['status'] == 'Sprejeto') ||
                ($_GET['filter'] == 'Zavrnjeno' && $prijava['status'] == 'Zavrnjeno') ||
                ($_GET['filter'] == 'Nedoločeno' && $prijava['status'] == 'Nedoločeno') ||
                ($_GET['filter'] == 'Preteklo' && $prijava['datum_obiska'] < $current_date) ||
                ($_GET['filter'] == 'Prihodnjo' && $prijava['datum_obiska'] >= $current_date)): ?>
                <tr>
                    <td><a class="prijava-link" href="prikaz_prijava_admin.php?id=<?php echo $prijava['id_prijave']; ?>"><?php echo $prijava['ime_sole']; ?></a></td>
                    <td><?php echo $prijava['e_naslov'] ?></td>
                    <td class="<?php echo ($prijava['status'] == 'Sprejeto') ? 'sprejeto' : 'zavrnjeno'; ?>">
                        <?php echo $prijava['status']; ?>
                    </td>
                    <td class="btn-container">
                        <form method="post">
                            <input type="hidden" name="id_prijave" value="<?php echo $prijava['id_prijave']; ?>">
                            <input type="hidden" name="st_ucencev" value="<?php echo $prijava['st_ucencev']; ?>">
                            <input type="hidden" name="e_naslov" value="<?php echo $prijava['e_naslov']; ?>">
                            <button class="btn sprejmi" type="submit" name="action" value="Sprejeto">Sprejmi</button>
                            <button class="btn zavrni" type="submit" name="action" value="Zavrnjeno">Zavrni</button>
                        </form>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>


</body>
</html>
