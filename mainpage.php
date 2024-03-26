<?php
include 'baza.php';
include 'navbar.php';
$current_date = date('Y-m-d');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_prijave'], $_POST['action'])) {
    $id_prijave = $_POST['id_prijave'];
    $action = $_POST['action'];
    
    
    $update_query = "UPDATE prijave SET status = ? WHERE id_prijave = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('si', $action, $id_prijave);
    $stmt->execute();
    
    
    header("Location: mainpage.php?filter=Vsi");
    exit();
}
$query_school = "SELECT s.ime_sole,s.id_sole
                 FROM sole s
                 INNER JOIN admini a ON s.id_sole = a.sola_id
                 WHERE a.admin_id = ?";
$stmt = $conn->prepare($query_school);
$stmt->bind_param('i', $_SESSION['admin_id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $school = $result->fetch_assoc();
    $school_name = $school['ime_sole']; 
} else {
    $school_name = "No School Found"; 
}
if ($school_name == 'vse') {
    $prijave_query = "SELECT * FROM prijave";
    $stmt = $conn->prepare($prijave_query);
} else {
    $prijave_query = "SELECT p.*
                      FROM prijave p
                      INNER JOIN sole s ON p.sola_id = s.id_sole
                      WHERE s.id_sole = ?";
    $stmt = $conn->prepare($prijave_query);
    $stmt->bind_param('i', $school['id_sole']);
}

$stmt->execute();
$prijave = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
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