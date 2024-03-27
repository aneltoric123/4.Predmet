<?php
include 'navbar.php';
include 'baza.php';
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
        .plus-btn {
            background-color: green;
            color: white;
            border: none;
            padding: 5px 10px;
          margin-top: 20px;
            
        }

        .minus-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            margin-top: 20px;
            
        }
        .status-prosto {
            background-color: #9ACD32;
            color: black;
        }
        .status-not-prosto {
            background-color: #FF6347;
            color: black;
        }
        .default{
            background-color: #FFFFFF;
            color: black;
        }
        #calendar {
            margin-top: 20px;
        }
        
    </style>
     <script>
        $(document).ready(function() {
            function updateCalendar() {
                $('#calendar').fullCalendar('refetchEvents');
            }

            setInterval(updateCalendar, 100);
        });
    </script>
</head>
<body>
 
<div id='calendar'></div>
<script>
$(document).ready(function() {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
        },
        locale: 'sl',
        dayRender: function(date, cell) {
            var dateStr = date.format('YYYY-MM-DD');
            $.ajax({
                url: 'termin_status.php',
                type: 'POST',
                data: {
                    date: dateStr
                },
                success: function(response) {
                    if (response === 'Prosto') {
                        cell.addClass('status-prosto').append('Prosto');
                        
                    } else if (response === 'Zasedeno') {
                        cell.addClass('status-not-prosto').append('Zasedeno');
                    } else {
                        cell.addClass('default').append('');
                    }
                         var plusButton = $('<button class="plus-btn">+</button>');
                    var minusButton = $('<button class="minus-btn">-</button>');

                    plusButton.appendTo(cell);
                    minusButton.appendTo(cell);
                    
                    plusButton.click(function(e) {
                        e.preventDefault(); 
                        handleButtonClick(dateStr, 'plus');
                    });

                    minusButton.click(function(e) {
                        e.preventDefault(); 
                        handleButtonClick(dateStr, 'minus');
                    });
                },
              
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
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
                alert(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
});
</script>
</body>
</html>

