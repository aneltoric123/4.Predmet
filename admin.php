<?php


include 'baza.php';
$sola=isset($_GET['sola']) ? $_GET['sola'] : '';

if (isset($_SESSION['admin_id'])) {
    header('Location: mainpage.php?filter=all');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
     
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

   
    $sql = "SELECT admin_id, username, password, ime_sole FROM admini a INNER JOIN sole s ON a.sola_id=s.id_sole WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
       
        if (password_verify($password, $row['password'])) {
            if ($row['ime_sole'] == $sola) {
                $_SESSION['admin_id'] = $row['admin_id'];
                setcookie('admin', json_encode(array('admin_id' => $row['admin_id'], 'username' => $row['username'], 'ime' => $row['ime_sole'])), time() + (86400 * 30), '/');
                header('Location: mainpage.php?filter=all');
                exit;
            } else {
                $error_message = 'Invalid username for this school';
            }
        } else {
            $error_message = 'Invalid password';
        }
    } else {
        $error_message = 'Invalid username';
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Select School</title>
    <link rel="stylesheet" href="CSS/admin.css">
    <link href="header.php" rel="import" type="text/php">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: <?php $id = isset($_GET['sola']) ? $_GET['sola'] : '';
                switch ($id) {
                    case 'ssgo':
                        echo "#a6ce39"; // red
                        break;
                    case 'ers':
                        echo "#0094d9"; // green
                        break;
                    case 'ssd':
                        echo "#ee5ba0"; // blue
                        break;
                    case 'gim':
                        echo "#ffca05"; // white
                        break;
                    case 'vse':
                        echo "#f5f5f5"; // black
                        break;
                }
            ?>;
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #000000;
        }
        input[type="submit"] {
            margin-left: 25%;
            margin-top: 20%;
            width: 50%;
            height: 40px;
            background-color: <?php $id = isset($_GET['sola']) ? $_GET['sola'] : '';
                switch ($id) {
                    case 'ssgo':
                        echo "#a6ce39";
                        break;
                    case 'ers':
                        echo "#0094d9"; 
                        break;
                    case 'ssd':
                        echo "#ee5ba0"; 
                        break;
                    case 'gim':
                        echo "#ffca05"; 
                        break;
                    case 'vse':
                        echo "#f5f5f5"; 
                        break;
                }
            ?>;;
            color: #000000;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }
        input[type="submit"]:hover {
            background-color:<?php $id = isset($_GET['sola']) ? $_GET['sola'] : '';
                switch ($id) {
                    case 'ssgo':
                        echo "#7c9b2a"; 
                        break;
                    case 'ers':
                        echo "#0071a5";
                        break;
                    case 'ssd':
                        echo "#bb477d"; 
                        break;
                    case 'gim':
                        echo "#cca104"; 
                        break;
                    case 'vse':
                        echo "#c2c2c2"; 
                        break;
                }
            ?>;
        }
        button[type="submit"] a {
            color: inherit;
            text-decoration: none;
            display: block;
            width: 100%;
            height: 100%;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }
        button[type="submit"] a:hover {
            background-color:<?php $id = isset($_GET['sola']) ? $_GET['sola'] : '';
                switch ($id) {
                    case 'ssgo':
                        echo "#7c9b2a"; // red
                        break;
                    case 'ers':
                        echo "#0071a5"; // green
                        break;
                    case 'ssd':
                        echo "#bb477d"; // blue
                        break;
                    case 'gim':
                        echo "#cca104"; // white
                        break;
                    case 'vse':
                        echo "#c2c2c2"; // black
                        break;
                }
            ?>;
        }
    </style>
</head>
<body>

<div class="container2">
    <?php if(isset($error_message)) { ?>
        <p class=test><?php echo $error_message; ?></p>
    <?php } ?>
    <form class="form" method="post" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <input type="submit" value="Log In">
        </form>
        <br>
        <a  href="select_school.php"> <button type="submit" class="back-button">Nazaj</button></a>   
</div>
    
   

</body>
</html>
