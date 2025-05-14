<?php
    require_once("Classes/Database.php");
    require_once ("functions.php");
    require_once("Classes/User.php");

    $db = getDB();

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(exist($_POST,"signup"))
        {
            check();

            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            //$hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $response = $db->checkSignup($username,$email);

            if($response['status'] == "success")
            {
                $response = $db->doSignup($username,$email,$password);

                if($response['status'] == "success")
                    relocator("login.php",$response['message']);
                else
                    relocator("signup.php",$response['message']);
            }
            else 
                relocator("signup.php",$response['message']);
        }
    }


    ####################
    #####FUNZIONI#######
    ####################
    function check()
    {
        if(!exist($_POST,"username") || !exist($_POST,"email") || !exist($_POST,"password"))
                relocator("signup.php","Compila tutti i campi!");

        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
                relocator("signup.php","Email non valida!");

        if(!preg_match("/^[a-zA-Z0-9]*$/", $_POST["username"]))
                relocator("signup.php","Username non valido!");

        if(!preg_match("/^[a-zA-Z0-9]*$/", $_POST["password"]))
                relocator("signup.php","Password non valida!");
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
    <form action="signup.php" method="post">
        Username: <input type="text" name="username" required><br>
        Email: <input type="email" name="email" required><br>
        Password: <input type="password" name="password" required><br>
        <button name="signup" value="true">Registrati</button>
    </form>
</body>
</html>