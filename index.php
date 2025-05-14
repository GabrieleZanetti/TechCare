<?php
    require_once("Classes/Database.php");
    require_once ("functions.php");
    require_once("Classes/User.php");

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(exist($_POST,"login"))
            relocator("login.php",null);

        if(exist($_POST,"signup"))
            relocator("signup.php",null);
    }
?>


<form action="index.php" method="post">
    <button name="login" value="true">Vai alla login!</button>
</form>

<form action="index.php" method="post">
    <button name="signup" value="true">Vai alla registrazione!</button>
</form>