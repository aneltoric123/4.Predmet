<?php
require_once 'baza.php';
require_once 'header.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prijava</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/prijava.css">
</head>
<body>
    <div class="container">
        <div class="big_text mt-5">POZDRAVLJENI!</div>
        <div class="medium_text mt-3">Prijava na dneve dejavnosti ŠC Velenje</div>
        <form action="prijava_info.php">
            <button class="butten">PRIJAVA</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>