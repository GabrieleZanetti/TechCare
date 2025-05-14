<?php
    require_once("Classes/Database.php");
    require_once ("functions.php");
    require_once("Classes/User.php");

    openSession();
    $db = getDB();

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {

        exist($_POST,"back") ? relocator("index.php",null) : null;

        if(exist($_POST,"login"))
        {
            check();

            $username = $_POST['username'];
            $password = $_POST['password'];

            //Hashare la password per renderla sicura (anche sul db deve essere sicura) 
            //$hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $response = $db->doLogin($username,$password);

            if($response['status'] == "success")
            {
                $_SESSION["Auth"] = $response['user'];
                $_SESSION["Auth"]->getRole() == "Admin" ? relocator("console.php",$response['message']): relocator("home.php",$response['message']);
            }
        }
    }

    ####################
    #####FUNZIONI#######
    ####################
    function check()
    {
        if(!exist($_POST,"username") || !exist($_POST,"password"))
            relocator("login.php","Compila tutti i campi!");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="login.php" method="post">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <button name="login" value="true">Login</button>
    </form>

    <form action="login.php" method="post">
        <button name="back" value="true">Torna alla prima pagina!</button>
    </form>
</body>
</html>
