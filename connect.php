<?php
	session_start();

	$db = new PDO("mysql: host=localhost; dbname=user", "root", "root" );

	if(isset($_POST['name'])) {

		$name = htmlspecialchars($_POST['name']);
		$pwd = sha1($_POST['pwd']);

		if(!empty($name) AND !empty($pwd)) {

			$reqfindusr = $db->prepare("SELECT * FROM login WHERE name = ? AND password = ?");
			$reqfindusr->execute(array($name, $pwd));
			$usrexist = $reqfindusr->rowCount();

			if($usrexist == 1) {

				$usrinfo = $reqfindusr->fetch();
				$_SESSION['id'] = $usrinfo['id'];
				$_SESSION['name'] = $usrinfo['name'];
				$_SESSION['pwd'] = $usrinfo['password'];
				$_SESSION['mail'] = $usrinfo['mail'];

			} else {

				$msg = "User not found in db";

			}
		}

	}

?>
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html> 
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf8" />
	<title>16login, index</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">

<style type="text/css">
	table, tr, th, td{
		text-align:center;
	}
</style>

<script>
</script>

</head>
<body>
	
<div id="right"><?php include("menu.php"); ?></div>
	
<div id="left">

	<h2>16login, connect</h2>

	<form method="POST" action="">
		<table>
			<tr><th colspan="2">Enter credentials</th></tr>
			<tr><th><label for="name">Name</label></th>
			<td><input name="name" type="text" placeholder="name" id="name"/></td></tr>
			<tr><th><label for="pwd">Pwd</label></th>
			<td><input name="pwd" type="password" placeholder="pwd" id="pwd"/></td></tr>
			<tr><td colspan="2"><input type="submit" /></td></tr>
		</table>
	</form>

	<p><a href="logout.php">log out</a></p>

	<?php

		$arrayusr = array();

		$allusr = $db->prepare("SELECT * FROM login");
		$allusr->execute();

		while($row = $allusr->fetch(PDO::FETCH_ASSOC)) {
			$arrayusr[] = $row;
		}

		echo "From DB :<ul>";
		foreach($arrayusr as $i) {
			echo "<li>"
			.$i['id']."</li><li>"
			.$i['name']."</li><li>"
			.$i['password']."</li><li>"
			.$i['mail']."</li>";
		}
		echo "</ul>";

		echo "Logged in with the user -> "
		."<br />".$_SESSION['id']
		."<br />".$_SESSION['name']
		."<br />".$_SESSION['pwd']
		."<br />".$_SESSION['mail'];

	?>

</div>

</body>

</html>