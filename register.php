<?php
	session_start();

	$db = new PDO("mysql: host=localhost; dbname=user", "root", "root");

?>
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html> 
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf8" />
	<title>17login, register</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">

<style type="type/css">
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

	<h2>17login, register</h2>

	<form method="POST" action="">
		<table>
			<tr><th colspan="2">Edit credentials</th></tr>
			<tr><th><label for="name">Name</label></th>
			<td><input name="name" type="text" placeholder="Name" id="name"/></td></tr>
			<tr><th><label for="mail">Mail</label></th>
			<td><input name="mail" type="text" placeholder="Mail" id="mail"/></td></tr>
			<tr><th><label for="mail2">Mail Confirm</label></th>
			<td><input name="mail2" type="txt" placeholder="Mail confirmation" id="mail2"/></td></tr>
			<tr><th><label for="pwd">Pwd</label></th>
			<td><input name="pwd" type="password" placeholder="Password" id="pwd"/></td></tr>
			<tr><th><label for="pwd2">Pwd Confirm</label></th>
			<td><input name="pwd2" type="password" placeholder="Password Again" id="pwd2"/></td></tr>
			<tr><td></td><td><input type="submit" /></td></tr>
		</table>
	</form>

	<?php

	if(!isset($_SESSION['name'])) {
		
		if(isset($_POST['name'])) {

			$newname = htmlspecialchars(trim($_POST['name']));
			$newmail = htmlspecialchars(trim($_POST['mail']));
			$newmail2 = htmlspecialchars(trim($_POST['mail2']));
			$newpwd = sha1($_POST['pwd']);
			$newpwd2 = sha1($_POST['pwd2']);

			if(!empty($newname) && !empty($newmail) && !empty($newmail2) && !empty($newpwd) && !empty($newpwd2)) {
			
				//name
				$reqverifusrname = $db->prepare("SELECT * FROM login WHERE name = ?");
				$reqverifusrname->execute(array($newname));
				$verifusrname = $reqverifusrname->rowCount();
				//$usrinfo = $reqverifusrname->fetch();
							
				if($verifusrname == 0) {
					//$requpdatenameusr = $db->prepare("INSERT INTO login SET name = ?");
					//$requpdatenameusr->execute(array($newname);

					if($newmail == $newmail2) {

						$reqverifusrmail = $db->prepare("SELECT * FROM login WHERE mail = ?");
						$reqverifusrmail->execute(array($newmail));
						$verifusrmail = $reqverifusrmail->rowCount();

						if($verifusrmail == 0) {
							//$requpdatemailusr = $db->prepare("INSERT INTO login SET mail = ?");
							//$requpdatemailusr->execute(array($newmail, $_SESSION['id']));

							if($_POST['pwd'] == $_POST['pwd2']) {

								$requsrinsert = $db->prepare("INSERT INTO login(name, password, mail) VALUES(?, ?, ?)");
								$requsrinsert->execute(array($newname, $newpwd, $newmail));

								$_SESSION['name'] = $newname;
								$_SESSION['pwd'] = $newpwd;
								$_SESSION['mail'] = $newmail;

							} else {
								$msg = "The two pwd you entered don\'t match";
							}							

						} else {
							$msg = "This user mail is unawaillable";
						}
					} else {
						$msg = "The two mail you entered don\'t match";
					}

				} else {
					$msg = "This user name is unawaillable";
				}

			} else {
				$msg = "Fill all the fields";
			}
		} else {
			$msg = "You can submit a new user";
		}
	} else {
			$msg = "You are already logged, loggout first before creating a new account";
	}

	?>
	logged as <?php echo "<br />".
	$_SESSION['name']." name<br />".
	$_SESSION['mail']." mail<br />".
	$_SESSION['pwd']." pwd<br />".
	$_SESSION['id']." id<br />"; 
	if(isset($msg)) echo $msg; ?><br />

	<?php if(isset($verifusrname)) print_r($verifusrname."verifusrname"); ?>

</div>

</body>

</html>