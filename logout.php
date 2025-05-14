<?php
    require_once("Classes/Database.php");
    require_once("functions.php");
    require_once("Classes/User.php");

    openSession();
    authGuard("login.php","Non hai eseguito la login!");

    session_unset();
    session_destroy();

    relocator("login.php",null);
?>