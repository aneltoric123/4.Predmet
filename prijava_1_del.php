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
        var nextIndex = currentIndex + 1;
        if (nextIndex < groups.length) {
            groups[currentIndex].classList.remove('active');
            groups[nextIndex].classList.add('active');
            currentIndex = nextIndex;
            updateButtonVisibility();
        }
    }

    function showPreviousGroup() {
        var previousIndex = currentIndex - 1;
        if (previousIndex >= 0) {
            groups[currentIndex].classList.remove('active');
            groups[previousIndex].classList.add('active');
            currentIndex = previousIndex;
            updateButtonVisibility();
        }
    }

    function updateButtonVisibility() {
        var backButton = document.getElementById('backButton');
        var nextButton = document.getElementById('nextButton');
        var submitButton = document.getElementById('submitButton');

        if (currentIndex === 0) {
            backButton.style.display = 'none';
        } else {
            backButton.style.display = 'block';
        }

        if (currentIndex === groups.length - 1) {
            nextButton.style.display = 'none';
            submitButton.style.display = 'block';
        } else {
            nextButton.style.display = 'block';
            submitButton.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        groups = document.querySelectorAll('.input-group');
        // Hide all groups initially
        for (var i = 0; i < groups.length; i++) {
            groups[i].classList.remove('active');
        }
        // Show only the first group initially
        groups[0].classList.add('active');
        currentIndex = 0;
        updateButtonVisibility();
    });
</script>
<div class="container">
    <h1>PRIJAVA</h1>
    <form method="post" action="obdelava_prijave.php">
        <div class="input-group">
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
        <div class="input-group">
            <div class="prasanje">
                <label>Katero šolo boste obiskali:</label>
                <div class="radiolayout">
                    <input type="radio" name="field5" value="1" required>
                    <input type="radio" name="field5" value="2" required>
                    <input type="radio" name="field5" value="3" required>
                    <input type="radio" name="field5" value="4" required>
                    <input type="radio" name="field5" value="5" required>
                </div>
                <div class="radiolayout">
                    <label>Gimnazija</label>
                    <label>Elektro računalniška šola</label>
                    <label>Šola za storitvene dejavnosti</label>
                    <label>Šola za strojništvo, geotehniko in okolje</label>
                    <label>Vse</label>
                </div>
            </div>
            <div class="prasanje">
                <label>Starostna skupina otrok:</label>
                <div class="radiolayout">
                    <input type="radio" name="field6" value="7 razred" required>
                    <input type="radio" name="field6" value="8 razred" required>
                    <input type="radio" name="field6" value="9 razred" required>
                </div>
                <div class="radiolayout">
                    <label>7. razred</label>
                    <label>8. razred</label>
                    <label>9. razred</label>
                </div>
            </div>
            <div class="prasanje">
                <label>Telefonska številka kontaktne osebe:</label>
                <input type="text" name="field7" required>
            </div>
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