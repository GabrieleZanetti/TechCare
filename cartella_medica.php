<?php
  echo "Work in progress...\n";
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="refresh" content="3;url=home.php">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Work in Progress</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      text-align: center;
    }

    h1 {
      color: #333;
    }

    p {
      color: #666;
    }

    .loader {
      margin: 20px auto;
      border: 6px solid #f3f3f3;
      border-top: 6px solid #555;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Work in progress...</h1>
    <p>Verrai reindirizzato alla home tra pochi secondi.</p>
    <div class="loader"></div>
  </div>

</body>
</html>
