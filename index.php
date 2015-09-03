<?php
	session_start();
	
	$db = new PDO("mysql: host=localhost; dbname=user", "root", "root");

?>
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html> 
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf8" />
	<title>17login, index</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">

<script>	
</script>

</head>
<body>
	
<div id="right"><?php include("menu.php"); ?></div>
	
<div id="left">

	<h2>17login, index</h2>

	<table>
		<tr><th>Account</th></tr>
		<tr><td><a href="connect.php">Log in</a></td></tr>
		<tr><td><a href="register.php">Register</a></td></tr>
		<tr><td><a href="edit.php">Edit Profile</a></td></tr>
		<tr><td><a href="logout.php">Log out</a></td></tr>
	</table>

	<?php
		$res = array();

		$allusr = $db->prepare("SELECT * FROM login");
		$allusr->execute();

		while($row = $allusr->fetch(PDO::FETCH_ASSOC)) {
			$res[] = $row;
		}

		echo "Form DB : <ul>";

		foreach($res as $usr) {
			echo "<li>".$usr['id'].
			"<br />".$usr['name'].
			"<br />".$usr['password'].
			"<br />".$usr['mail']."</li>";
		}
		echo "</ul>";

		$allusr2 = $db->prepare("SELECT * FROM login");
		$allusr2->execute();

		echo "<ul>";
		foreach($allusr2 as $user) {
			echo "<li>".$user['name']."</li>";
		}
		echo "</ul>";

		echo "Logged in with the user -> ".$_SESSION['name'];

	?>
	


</div>

</body>

</html>