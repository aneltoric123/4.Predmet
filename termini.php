<?php
include 'navbar.php';
include 'baza.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
    <script src='calendar.js'></script>
    <style>
        .plus-btn {
            background-color: green;
            color: white;
            border: none;
            padding: 5px 10px;
            margin-left: 5px;
        }

        .minus-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            margin-left: 5px;
        }
        #calendar{
            margin-top: 20px;
        }
    </style>
</head>
<body>
 
    <div id='calendar'>
    <script>
    $(document).ready(function() {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
        },
        dayRender: function(date, cell) {
            var plusButton = $('<button class="plus-btn">+</button>');
            var minusButton = $('<button class="minus-btn">-</button>');

            plusButton.appendTo(cell);
            minusButton.appendTo(cell);

            plusButton.click(function(e) {
                e.preventDefault(); 
                var dateStr = date.format('YYYY-MM-DD');
                handleButtonClick(dateStr, 'plus');
            });

            minusButton.click(function(e) {
                e.preventDefault(); 
                var dateStr = date.format('YYYY-MM-DD');
                handleButtonClick(dateStr, 'minus');
            });
        }
    });

    function handleButtonClick(dateStr, action) {
        $.ajax({
            url: 'termini_insert.php',
            type: 'POST',
            data: {
                date: dateStr,
                action: action
            },
            success: function(response) {
                // Handle success response
                alert(response);
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(xhr.responseText);
            }
        });
    }
});
</script>
</div>
</body>
</html>
