<?php
require_once 'navbar.php';
include_once 'baza.php';

$query = "SELECT p.*, s.ime_sole AS school_name FROM prijave p INNER JOIN sole s ON p.sola_id = s.id_sole";
$result = $conn->query($query);
$prijave = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $title = $row['school_name'] . ' - ' . $row['ime_sole'] . ' - ' . 'Prijava' . ' (' . $row['status'] . ')';
        $prijave[] = [
            'id' => $row['id_prijave'],
            'title' => $title,
            'start' => $row['datum_obiska'], 
            'url' => 'prikaz_prijava_admin.php?id=' . $row['id_prijave'],
            'description' => $row['ime_sole'] 
        ];
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
    <link href='termini.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.print.min.css' rel='stylesheet' media='print' />
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/sl.js'></script>
    <style>
        .calendar-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="test">
    <div class="container">
        <div class="calendar-container">
            <div id="calendar"></div>
        </div>
        <div class="data-container">
            <div id="data-container"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Initialize the calendar
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay'
            },
            locale: 'sl', 
            events: <?php echo json_encode($prijave); ?>,
            eventClick: function(event) {
                window.location.href = event.url;
            }
        });
    });
</script>
</body>
</html>
