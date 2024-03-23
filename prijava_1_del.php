<?php
require_once 'baza.php';
require_once 'header.php';
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/prijava2.css">
    <title>Prijava</title>
</head>
<body>
<script>
   var groups;
        var currentIndex;

        function showNextGroup() {
            // Hide the current group
            groups[currentIndex].classList.remove('active');

            // Display the next group, if available
            if (groups[currentIndex + 1]) {
                groups[currentIndex + 1].classList.add('active');
                currentIndex++;
            }

            // Show or hide the Next and Back buttons based on the current group
            var nextButton = document.getElementById('nextButton');
            var backButton = document.getElementById('backButton');
            var submitButton = document.getElementById('submitButton')
            nextButton.style.display = groups[currentIndex + 1] ? 'block' : 'none';
            backButton.style.display = currentIndex > 0 ? 'block' : 'none';
            submitButton.style.display = groups[currentIndex + 1] ? 'none' : 'block';
        }

        function showPreviousGroup() {
            // Hide the current group
            groups[currentIndex].classList.remove('active');

            // Display the previous group, if available
            if (groups[currentIndex - 1]) {
                groups[currentIndex - 1].classList.add('active');
                currentIndex--;
            }

            // Show or hide the Next and Back buttons based on the current group
            var nextButton = document.getElementById('nextButton');
            var backButton = document.getElementById('backButton');
            var submitButton = document.getElementById('submitButton')
            nextButton.style.display = groups[currentIndex + 1] ? 'block' : 'none';
            backButton.style.display = currentIndex > 0 ? 'block' : 'none';
            submitButton.style.display = groups[currentIndex + 1] ? 'none' : 'block';
        }

        document.addEventListener('DOMContentLoaded', function() {
            groups = document.getElementsByClassName('input-group');
            currentIndex = 0;

            // Display the first group
            groups[currentIndex].classList.add('active');

            // Show or hide the Next and Back buttons based on the current group
            var nextButton = document.getElementById('nextButton');
            var backButton = document.getElementById('backButton');
            var submitButton = document.getElementById('submitButton')
            nextButton.style.display = groups[currentIndex + 1] ? 'block' : 'none';
            backButton.style.display = currentIndex > 0 ? 'block' : 'none';
            submitButton.style.display = groups[currentIndex + 1] ? 'none' : 'block';

        });
    </script>
<div class="container">
    <h1>PRIJAVA</h1>
    <form method="post" action="obdelava_prijave.php">
        <div class="input-group active">
            <div class="prasanje">
                <label>Ime osnovne šole:</label>
                <input type="text" name="field1" required>
            </div>
            <div class="prasanje">
                <label>Kako želite izvesti delavnice na ŠC Velenje:</label>
                <div class="radiolayout">
                    <label>
                        <input type="radio" id="delavnicesolacheck" name="field2" value="Delavnice bi izvedli na ŠC Velenje" onClick="drugaceCheck()" required>
                        Delavnice bi izvedli na ŠC Velenje
                    </label>
                    <label>
                        <input type="radio" name="field2" value="Delavnice bi izvedli na naši šoli" onClick="drugaceCheck()" required>
                        Delavnice bi izvedli na naši šoli
                    </label>
                    <label>
                        <input type="radio" name="field2" value="Roditeljski sestanek na OŠ" onClick="drugaceCheck()" required>
                        Roditeljski sestanek na OŠ
                    </label>
                    <label>
                        <input type="radio" id="delavnicedrugacecheck" name="field2" value="Drugace" onClick="drugaceCheck()" required>
                        Drugace
                    </label>
                    <input type="text" id="drugace" name="drugacetext" style="visibility:hidden;">
                </div>
            </div>
            <div class="prasanje">
                <label>Izberite datum obiska:</label>
                <input type="date" name="field3" id="selectedDateInput" required>
            </div>
            <div class="prasanje">
                <label for="urnik">Želen urnik obiska: <br>(pričetek, malica, zaključek)</label>
                <select id="urnik" name="field4" required>
                    <option value="" disabled selected>Izberite urnik</option>
                    <option value="8-11">8:00 - 11:00 (malica: 9:30 - 10:00)</option>
                    <option value="8-12">8:00 - 12:00 (malica: 9:30 - 10:00)</option>
                    <option value="9-12">9:00 - 12:00 (malica: 10:00 - 10:30)</option>
                    <option value="10-13">10:00 - 13:00 (Brez malice)</option>
                    <option value="11-14">11:00 - 14:00 (Brez malice)</option>
                </select>
            </div>
        </div>
        <div class="input-group"></div>
        <div class="prasanje">
                <label>E-naslovkontaktne osebe:</label>
                    <input type="email" name="field8" required>
                </div>

            </div>
            <div class="button-group">
                <button class="butten" style="font-size:20px; color:black" type="button" id="backButton" onclick="showPreviousGroup()">Nazaj</button>
                <button class="butten" style="font-size:20px; color:black" type="button" id="nextButton" onclick="showNextGroup()">Naprej</button>
                <input type="submit" style="font-size:20px; color:black" class="butten" id="submitButton" value="Poslji">
            </div>
        </form>
    </div>
   
</body>


</html>