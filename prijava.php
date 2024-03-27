<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/prijava2.css">
    <title>Prijava</title>
</head>
<body>
<?php
require_once 'baza.php';
require_once 'header.php';
?>
<script>
    var groups;
    var currentIndex;

    function showNextGroup() {
        
        groups[currentIndex].classList.remove('active');

        
        if (groups[currentIndex + 1]) {
            groups[currentIndex + 1].classList.add('active');
            currentIndex++;
        }

       
        updateButtonVisibility();
    }

    function showPreviousGroup() {
      
        groups[currentIndex].classList.remove('active');

        
        if (groups[currentIndex - 1]) {
            groups[currentIndex - 1].classList.add('active');
            currentIndex--;
        }

        
        updateButtonVisibility();
    }

    function updateButtonVisibility() {
        var nextButton = document.getElementById('nextButton');
        var backButton = document.getElementById('backButton');
        var submitButton = document.getElementById('submitButton');

        nextButton.style.display = groups[currentIndex + 1] ? 'block' : 'none';
        backButton.style.display = currentIndex > 0 ? 'block' : 'none';
        submitButton.style.display = groups[currentIndex + 1] ? 'none' : 'block';
    }

    document.addEventListener('DOMContentLoaded', function () {
        groups = document.getElementsByClassName('input-group');
        currentIndex = 0;

       
        groups[currentIndex].classList.add('active');

        
        updateButtonVisibility();
    });
</script>
<div class="container">
    <h1>PRIJAVA</h1>
    <form method="post" action="prijava_insert.php">
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
                <input type="date" name="field3" id="selectedDateInput" required  >
            </div>
            <script>
                    

                    var allowedDates = <?php 
                                        $sql = "SELECT datum FROM termini WHERE prosto = 1";
                                        $result = $conn->query($sql);
                                        echo "[";
                                        while ($row = $result->fetch_assoc()) {
                                            echo "'" . $row['datum'] . "', ";
                                        }
                                        echo "]";
                                        $conn->close();
                                        ?>;
                    
                    var selectedDateInput = document.getElementById('selectedDateInput');

                    flatpickr("#selectedDateInput", {
                        enable: allowedDates
                    });
                </script>
            <div class="prasanje">
                <label for="urnik">Želen urnik obiska: <br>(pričetek, malica, zaključek)</label>
                <select id="urnik" name="field4" required>
                    <option value="" disabled selected>Izberite urnik</option>
                    <option value="8:00 - 11:00 (malica: 9:30 - 10:00)">8:00 - 11:00 (malica: 9:30 - 10:00)</option>
                    <option value="8:00 - 12:00 (malica: 9:30 - 10:00)">8:00 - 12:00 (malica: 9:30 - 10:00)</option>
                    <option value="9:00 - 12:00 (malica: 10:00 - 10:30)">9:00 - 12:00 (malica: 10:00 - 10:30)</option>
                    <option value="10:00 - 13:00 (Brez malice)">10:00 - 13:00 (Brez malice)</option>
                    <option value="11:00 - 14:00 (Brez malice)">11:00 - 14:00 (Brez malice)</option>
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
                        <label>Elektro in računalniška šola</label>
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
                        <label>7.razred</label>
                        <label>8.razred</label>
                        <label>9.razred</label>
                    </div>
                </div>
                <div class="prasanje">
            <label>E-naslov kontaktne osebe:</label>
            <input type="email" name="field8" required>
            </div>
                <div class="prasanje">
                    <label>Telefonska številka kontaktne osebe:</label>
                    <input type="text" name="field7" required>
                </div>
        </div>
        <div class="input-group">
                <div class="prasanje">
                    <label>Število učencev:</label>
                    <input type="text" name="field9" required>
                </div>
                <div class="prasanje">
    <label>Pričakovanja:</label>
    <textarea name="field10" rows="8" required></textarea>
</div>
<div class="prasanje">
    <label>Nam kaj želite sporočiti:</label>
    <textarea name="field11" rows="8" required></textarea>
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
