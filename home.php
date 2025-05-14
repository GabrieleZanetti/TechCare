<?php
    require_once("Classes/Database.php");
    require_once("functions.php");
    require_once("Classes/User.php");

    openSession();
    authGuard("index.php","Non hai eseguito la login!");

    $db = getDB();
    $imgURL = $db->getAvatar($_SESSION["Auth"]->getId());

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      exist($_POST,"logout") ? logout():null;
      exist($_POST,"settings") ? relocator("settings.php",null):null;
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pagina di esempio</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <header>
    <div>
      <h1>Tech&Care</h1>
      <p>CareBrace</p>
    </div>

    <form action="home.php" method="post">
        <button type="submit" name="logout" value="true" style="padding: 10px 16px; border: 1px solid black; background-color: white; cursor: pointer;">
          Logout
        </button>
    </form>

    <form action="home.php" method="post">
      <button type="submit" class="story-button" name="settings" value="true">
        <img src="<?php echo $imgURL; ?>">
      </button>
    </form>
  </header>

  <!-- Primo div cartella clinica, Secondo grafici Live -->
  <main style="display: flex; height: 80vh;">
    <!-- PRIMO DIV: CARTELLA MEDICA -->
    <div style="flex: 1; border: 1px solid black; padding: 20px; display: flex; flex-direction: column; justify-content: space-between;">
      <h2 style="text-align: center;">Cartella Medica</h2>

      <div style="display: flex; justify-content: center; margin: 20px 0;">
        <div id="bpm-status" style="width: 100px; height: 100px; background-color: green; border-radius: 10px;"></div>
      </div>

      <div style="padding: 10px;">
        <p><strong>Nome:</strong> <?php echo "Nome"; ?></p>
        <p><strong>Cognome:</strong> <?php echo "Cognome"; ?></p>
        <p><strong>Data di Nascita:</strong> <?php echo "01/01/1980"; ?></p>
        <p><strong>Codice Fiscale:</strong> <?php echo "CGNNMO80A01F205P"; ?></p>
        <p><strong>Informazioni Sanitarie:</strong></p>
        <textarea readonly style="width: 100%; height: 80px; resize: none;">Informazioni sanitarie</textarea>
      </div>

      <form action="cartella_medica.php" method="get" style="text-align: center;">
        <button type="submit" style="padding: 10px 20px; background-color: #ddd; border: 1px solid black; cursor: pointer;">Vai alla Cartella Medica</button>
      </form>
    </div>

    <!-- SECONDO DIV: GRAFICO -->
    <div style="flex: 1; border: 1px solid black;">
      <canvas id="heartRateChart" width="600" height="400"></canvas>
    </div>
  </main>

  <footer>
    <p>&copy; 2025 Il nostro sito. Tutti i diritti riservati.</p>
  </footer>

  <script>
    const ctx = document.getElementById('heartRateChart').getContext('2d');

    const heartRateChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: [],
        datasets: [{
          label: 'Battito Cardiaco (BPM)',
          data: [],
          borderColor: 'red',
          borderWidth: 2,
          fill: false,
          tension: 0.4
        }]
      },
      options: {
        animation: false,
        responsive: true,
        scales: {
          y: {
            min: 40,
            max: 180
          }
        }
      }
    });

    let currentBPM = 70;
    let time = 0;
    let bpmData = [];

    function updateStatusColor() {
      const avg = bpmData.reduce((a, b) => a + b, 0) / bpmData.length;
      const statusBox = document.getElementById("bpm-status");
      statusBox.style.backgroundColor = avg >= 60 && avg <= 100 ? 'green' : 'red';
    }

    function simulateHeartRate() {
      const delta = (Math.random() - 0.5) * 20;
      //currentBPM = 130 + Math.random() * 20; // prova per un battito sbagliato 
      currentBPM = Math.min(Math.max(currentBPM + delta, 60), 100);

      heartRateChart.data.labels.push(time);
      heartRateChart.data.datasets[0].data.push(Math.round(currentBPM));

      bpmData.push(currentBPM);
      if (bpmData.length > 20) bpmData.shift();

      updateStatusColor();

      if (heartRateChart.data.labels.length > 20) {
        heartRateChart.data.labels.shift();
        heartRateChart.data.datasets[0].data.shift();
      }

      heartRateChart.update();
      time++;
    }

    setInterval(simulateHeartRate, 1000);
  </script>

</body>
</html>
