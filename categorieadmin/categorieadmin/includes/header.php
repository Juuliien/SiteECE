<?php

	session_start();

	try{

		$db = new PDO('mysql:host=127.0.0.1;dbname=ECE', 'root','');
		$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER); // les noms de champs seront en caractères minuscules
		$db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION); // les erreurs lanceront des exceptions
		$db->exec('SET NAMES utf8');				
	}

	catch(Exception $e){ // 

		die('Veuillez vérifier la connexion à la base de données');

	}

?>
<!DOCTYPE html>
<html>
	<head>
		<style>
			.bonjour{background-color: blue;}
		</style>
		<meta charset="utf8">
		<link href="style/bootstrap.css" type="text/css" rel="stylesheet"/>
	</head>
	<header>
		<br/>
		<div class="bonjour">
			<h1>Site E-Commerce</h1><br/>
		</div>
		<ul class="menu">
			<li><a href="index.php">Accueil</a></li>
			<li><a href="categorie.php">Categorie</a></li>
			<li><a href="panier.php">Panier</a></li>
			<?php if(!isset($_SESSION['user_id'])){?>
			<li><a href="register.php">S'inscrire</a></li>
			<li><a href="connect.php">Se connecter</a></li>
			<?php }else{ ?>
			<li><a href="my_account.php">Mon compte</a></li>
			<?php } ?>
			<li><a href="admin/index.php">Admin</a></li>
		</ul>
	</header>
