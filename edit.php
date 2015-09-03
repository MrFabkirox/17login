<?php 
session_start();

	$db = new PDO("mysql: host=localhost; dbname=user", "root", "root");

?>
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html> 
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf8" />
	<title>17login , editprofil</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">


<script>
</script>

</head>
<body>
	
<div id="right"><?php include("menu.php"); ?></div>
	
<div id="left">

	<h2>17login, editprofil</h2>

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
			<tr><td></td><td><input type="submit" /></td></td></tr>
		</table>
	</form>

	<?php

		if(isset($_POST['name'])) {
			$newname = htmlspecialchars(trim($_POST['name']));
			$newmail = htmlspecialchars(trim($_POST['mail']));
			$newmail2 = htmlspecialchars(trim($_POST['mail2']));

			if(!empty($_POST['pwd'])) {
				$newpwd = sha1($_POST['pwd']);
				$newpwd2 = sha1($_POST['pwd2']);
			}

			if(!empty($newname) && !empty($newmail) && !empty($newmail2) && !empty($newpwd) && !empty($newpwd2)) {
				//name
				$reqverifusrname = $db->prepare("SELECT * FROM login WHERE name = ?");
				$reqverifusrname->execute(array($newname));
				$verifusrname = $reqverifusrname->rowCount();
				$usrinfo = $reqverifusrname->fetch();
							
				if($verifusrname == 0 || ($verifusrname == 1 && $usrinfo['name'] == $newname)) {
					$requpdatenameusr = $db->prepare("UPDATE login SET name = ? WHERE id = ?");
					$requpdatenameusr->execute(array($newname, $_SESSION['id']));

					$_SESSION['name'] = $newname;

				} else {
					$msg = "This user name is unawaillable";
				}
				//mail
				$reqverifusrmail = $db->prepare("SELECT * FROM login WHERE mail = ?");
				$reqverifusrmail->execute(array($newmail));
				$verifusrmail = $reqverifusrmail->rowCount();

				if($newmail == $newmail2) {
					if($verifusrmail == 0 || ($verifusrmail == 1 && $usrinfo['mail'] == $newmail)) {
						$requpdatemailusr = $db->prepare("UPDATE login SET mail = ? WHERE id = ?");
						$requpdatemailusr->execute(array($newmail, $_SESSION['id']));

						$_SESSION['mail'] = $newmail;

					} else {
						$msg = "This user mail is unawaillable";
					}
				} else {
					$msg = "The two mail you entered don\'t match";
				}
				//mail

				if($newpwd == $newpwd) {
					$requpdatepwdusr = $db->prepare("UPDATE login SET password = ? WHERE id = ?");
					$requpdatepwdusr->execute(array($newpwd, $_SESSION['id']));

					$_SESSION['pwd'] = $newmail;

				} else {
					$msg = "The two pwd you entered don\'t match";
				}

			} else {
				$msg = "Fill all the fields";
			}
		}

	?>
	logged as <?php echo $_SESSION['name']."<br />".
	$_SESSION['mail']."<br />".
	$_SESSION['pwd']."<br />".
	$_SESSION['id']."<br />"; 
	if(isset($msg)) echo $msg; ?><br />

	<?php if(isset($verifusrname)) print_r($verifusrname); ?>

</div>

</body>

</html>