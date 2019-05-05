<?php 

require_once('includes/header.php');


if(!isset($_SESSION['user_id'])){

	if(isset($_POST['submit'])){

		$email = $_POST['email'];
		$password = $_POST['password'];

		if($email&&$password){
			$select = $db->query("SELECT idvendeur FROM seller WHERE email='$email' AND password='$password'");
			if($select->fetchColumn()){
				$select = $db->query("SELECT * FROM seller WHERE email='$email'");
				$result = $select->fetch(PDO::FETCH_OBJ);
				$_SESSION['seller_id'] = $result->id;
				$_SESSION['seller_name'] = $result->username;
				$_SESSION['seler_email'] = $result->email;
				$_SESSION['seller_password'] = $result->password;
				header('Location: vendeur.php');
			}else{
				echo '<br/><h3 style="color:red;">Mauvais identifiants.</h3>';
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
			margin-left:500px;
		}
		.connectTitre{
text-align:center;
		}
		</style>
	<br/>
	<h1 class="connectTitre">Se connecter a votre espace vendeur</h1>

	<table class="connect">
	
	<form action="" method="POST">
	<tr><td><h4>Votre email </td><td><input type="email" name="email"/></h4></td>

	</tr>
	<tr>
	<td><h4>Votre mot-de-passe </td><td><input type="password" name="password"/></h4></td>

	</tr>
	<tr>
	<td></td><td><input class="btn btn-light" type="submit" name="submit"/></td>

	</tr>
	</form>
	<tr>
	<td>	<a href="registervendeur.php">S'inscrire en tant que vendeur</a></td>

	</tr>
	<br/>
	</table>
<?php

}else{
	header('Location:my_account.php');
}

require_once('includes/footer.php');

?>