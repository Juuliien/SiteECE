<?php 

require_once('includes/header.php');
//require_once('includes/sidebar.php');

if(!isset($_SESSION['user_id'])){

	if(isset($_POST['submit'])){

		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$repeatpassword = $_POST['repeatpassword'];

		if($username&&$email&&$password&&$repeatpassword){
			if($password==$repeatpassword){
				$db->query("INSERT INTO seller(username, email, password) VALUES('$username', '$email', '$password')");
				echo '<br/><h3 style="color:green;">Vous avez créé votre compte vendeur, vous pouvez maintenant vous <a href="indexvendeur.php">connecter</a>.</h3>';
			}else{
				echo '<br/><h3 style="color:red;">Les mot-de-passes ne sont pas identiques.</h3>';
			}
		}else{
			echo '<br/><h3 style="color:red;">Veuillez remplir tous les champs.</h3>';
		}

	}

	?>
	<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf8">
		<link href="style/bootstrap.css" type="text/css" rel="stylesheet"/>
		<style>
		.connect{
			margin-left:450px;
		}
		.connectTitre{
			margin-left:550px;

		}
		</style>
	<br/>
	<h1 class="connectTitre">S'enregister comme vendeur</h1>
<table class="connect" width="40%">
	<form action="" method="POST">
	<tr>
	<td><h4>Votre pseudo </td><td><input type="text" name="username"/></h4></td>

	</tr>
	<tr>
	<td><h4>Votre email </td><td><input type="email" name="email"/></h4></td>

	</tr>
	<tr>
	<td><h4>Votre mot-de-passe </td><td><input type="password" name="password"/></h4>
</td>
	</tr>
	<tr>
	<td><h4>Répétez votre mot-de-passe </td><td><input type="password" name="repeatpassword"/></h4>
</td>
	</tr>
	<tr>
	<td></td><td><input class="btn btn-light" type="submit" name="submit"/>
</td>
	</tr>
	</form>
	<tr>
	<td>	<a href="indexvendeur.php">Se connecter</a>
</td></tr>
	<br/>
	</table>

<?php

}
?>
<?php
require_once('includes/footer.php');

?>