<?php
session_start();
require_once('includes/functions_panier.php');

try{

	$db = new PDO('mysql:host=127.0.0.1;dbname=ECE', 'root','');
	$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER); // les noms de champs seront en caractères minuscules
	$db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION); // les erreurs lanceront des exceptions
						
}

catch(Exception $e){

	die('Veuillez vérifier la connexion à la base de données');

}


$name = $_POST['name'];

$street = $_POST['street'];
$city = $_POST['ville'];
$pays = $_POST['pays'];
$tel= $_POST['tel'];
$typecarte= $_POST['typecarte'];
$price = $_SESSION['prix'];
$numcarte = $_POST['number'];
$nomcarte = $_POST['nomcarte'];
$date = $_POST['date'];
$crypto = $_POST['crypto'];
$user_id = $_SESSION['user_id'];
$transaction_id = rand();

$db->query("INSERT INTO transactions(name, Adresse, Ville, Pays, telephone, transaction_id, user_id, typecarte, numerocarte, nomcarte, dateexpi, crypto, prix) 
	VALUES('$name', '$street', '$city', '$pays', '$tel', '$transaction_id', '$user_id', '$typecarte', '$numcarte','$nomcarte','$date','$crypto', '$price')");


for($i = 0; $i<count($_SESSION['panier']['libelleProduit']); $i++){
	$product = $_SESSION['panier']['libelleProduit'][$i];
	$quantity = $_SESSION['panier']['qteProduit'][$i];
	$insert = $db->query("INSERT INTO products_transactions (product, quantity, transaction_id) VALUES('$product','$quantity', '$transaction_id')");
	$select = $db->query("SELECT * FROM products WHERE title='$product'");
	$r = $select->fetch(PDO::FETCH_OBJ);
	$stock = $r->stock;
	$stock = $stock-$quantity;
	$update = $db->query("UPDATE products SET stock='$stock' WHERE title='$product'");
}

supprimerPanier();
header('Location: success.php');

?>