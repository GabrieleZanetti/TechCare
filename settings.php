<?php
	require_once("Classes/Database.php");
	require_once("functions.php");
	require_once("Classes/User.php");

	openSession();
	authGuard("index.php","Non hai eseguito la login!");

	$db = getDB();

	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		exist($_POST,"logout") ? logout():null;
		exist($_POST,"home") ? relocator("home.php",null):null;

		$current_password = $_POST['current_password'] ?? null;
		!$db->verifyPassword($_SESSION["Auth"]->getId(),$current_password) ? relocator("settings.php","Password attuale errata!"):null;	

		if(exist($_POST,"cambiaNome"))
		{
			$user = $_POST['username'];
			$response = $db->updateUsername($_SESSION["Auth"]->getId(),$user);

			if($response['status'] == "success")
			{
				$_SESSION["Auth"] = $response['new_user'];
				relocator("settings.php",$response['message']);
			}
			else
				relocator("settings.php",$response['message']);
		}

		if(exist($_POST,"cambiaPass"))
		{
			$pass = $_POST['password'];
			$confirmed_password = $_POST['confirm_password'];
			$response = $db->updatePassword($_SESSION["Auth"]->getId(),$pass,$confirmed_password);

			if($response['status'] == "success")
			{
				$_SESSION["Auth"] = $response['new_user'];
				relocator("settings.php",$response['message']);
			}
			else
				relocator("settings.php",$response['message']);
		}

		if(exist($_POST,"cambiaEmail"))
		{
			$email = $_POST['email'];
			$response = $db->updateEmail($_SESSION["Auth"]->getId(),$email);

			if($response['status'] == "success")
			{
				$_SESSION["Auth"] = $response['new_user'];
				relocator("settings.php",$response['message']);
			}
			else
				relocator("settings.php",$response['message']);
		}

		if(exist($_POST,"cambiaAvatar"))
		{
			$response = fileHandler();

			if($response[0])
			{
				$avatar = $response[1];
				$response = $db->updateAvatar($_SESSION["Auth"]->getId(),$avatar);

				if($response['status'] == "success")
				{
					$_SESSION["Auth"] = $response['new_user'];
					relocator("settings.php",$response['message']);
				}
				else
					relocator("settings.php",$response['message']);
			}	
		}
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
	<form action="settings.php" method="post">
		Cambia username: <input type="text" name="username" required><br>
		Password  attuale: <input type="password" name="current_password" required><br>
		<button name="cambiaNome" value="true">Cambia</button>
	</form>

	<form action="settings.php" method="post">
		Cambia password: <input type="password" name="password" required><br>
		Conferma password: <input type="password" name="confirm_password" required><br>
		Password  attuale: <input type="password" name="current_password" required><br>
		<button name="cambiaPass" value="true">Cambia</button>
	</form>

	<form action="settings.php" method="post">
		Cambia email: <input type="email" name="email" required><br>
		Password  attuale: <input type="password" name="current_password" required><br>
		<button name="cambiaEmail" value="true">Cambia</button>
	</form>

	<form action="settings.php" method="post" enctype="multipart/form-data">
		Cambia avatar: <input type="file" name="avatar" accept="image/*"><br>
		Password  attuale: <input type="password" name="current_password" required><br>
		<button name="cambiaAvatar" value="true">Cambia</button>
	</form>

	<form action="settings.php" method="post">
		<button name="home" value="true">Vai alla home!</button>
	</form>

	<form action="settings.php" method="post">
		<button name="logout" value="true">Vai alla disconnesione!</button>
	</form>
</body>
</html>

<?php
	if(exist($_GET,"err"))
		echo $_GET["err"];
?>