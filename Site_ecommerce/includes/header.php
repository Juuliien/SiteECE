<?php

	session_start();

	try{

		$db = new PDO('mysql:host=localhost;dbname=ECE', 'root','');
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
		<meta charset="utf8">
		<link href="style/bootstrap.css" type="text/css" rel="stylesheet"/>
		<style>
					.menu li a{

						margin-right:-2px;
						padding:12px 93px;
						background-color:rgb(5, 44, 68);
						color:white;

					 }
			        .titre{
						text-align:center;
						background-color:rgb(5, 44, 68);
						color:white;
						height:150px;
						margin-top:20px;

					 }
					 .agencement{
						 width:500px;
						 text-align:center;
						 background-color:rgb(5, 44, 68);
						 color:white;
						 height:25px
					 }
					 .menu{
						 width:1500px;
					 }
					.image{
						width:150px;
						height:150px;
						margin-top:-25px;
						margin-left:-200px;
					}
					.lieu{
						margin-top:-50px;
					}
					.directeur{
						margin-top:-100px;
					}
					.tel{
						margin-top:20px;
					}
		</style>
	


</head>
	<header>
		<table>
			<tr>
				<td class="agencement"></td>
				<td class="agencement"></td>
				<td class="agencement"><div class="tel">Numero de telephone : 07 83 10 51 71 </div></td>
			</tr>
		<tr>
			<td class="agencement"><img class="image" src="logo.jpg"></td>
			<td class="agencement"><div class="titre"><h1>AMAZON ECE</h1></div></td>
			<td class="agencement"><div class="lieu">Lieu : Quai de Grenelle</div></td>
		</tr>
		<tr>
			<td class="agencement"></td>
			<td class="agencement"></td>
			<td class="agencement" ><div class="directeur"><a href="indexadmin.php">Accès Administrateur</div></a></td>
		</tr>
	</table>
		<ul class="menu">
			<li><a class="barre" href="index.php">Accueil</a></li>
			<li><a href="categorie.php">Categorie</a></li>
			<li><a href="panier.php">Panier</a></li>
			<?php if(!isset($_SESSION['user_id'])){?>
			<li><a href="register.php">S'inscrire</a></li>
			<li><a href="connect.php">Se connecter</a></li>
			<?php }else{ ?>
			<li><a href="my_account.php">Mon compte</a></li>
			
			
			<?php } ?>
			<li><a href="indexvendeur.php">Vendeur</a></li>
		</ul>
	</header>