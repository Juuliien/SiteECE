<?php

require_once('includes/header.php');
require_once('includes/sidebar.php');
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
			margin-left:550px;

		}
		</style>
		<br>
<h1 class="connectTitre">Mon compte</h1>
<h2 class="connectTitre">Mes informations</h2>
<br>
<?php
$user_id = $_SESSION['user_id'];
$select = $db->query("SELECT * FROM users WHERE id = '$user_id'");

while($s = $select->fetch(PDO::FETCH_OBJ)){
	?>
	<table width="30%" class="connect">
	<tr>
	<td><h4>Pseudo : </td><td><?php echo $s->username; ?></h4>
</td>
	</tr>
	<tr>
	<td><h4>Email : </td><td><?php echo $s->email; ?></h4>
</td>
	</tr>
	<tr>
	<td><h4>Password : </td><td><?php echo $s->password; ?></h4>
</td>
	</tr>
	</table>
	<?php
}

?>
<h2 class="connectTitre">Mes transactions</h2>
<?php
$select = $db->query("SELECT * FROM transactions WHERE user_id = '$user_id'");

while($s = $select->fetch(PDO::FETCH_OBJ)){

	$transaction_id = $s->transaction_id;
	$select2 = $db->query("SELECT * FROM products_transactions WHERE transaction_id='$transaction_id'");

	?>

	<h4>Nom et prénom : <?php echo $s->name; ?></h4>
	<h4>Rue : <?php echo $s->street; ?></h4>
	<h4>Ville : <?php echo $s->city; ?></h4>
	<h4>Pays : <?php echo $s->country; ?></h4>
	<h4>Date de transaction : <?php echo $s->date; ?></h4>
	<h4>ID de transaction : <?php echo $s->transaction_id; ?></h4>
	<h4>Prix total : <?php echo $s->amount; ?></h4>
	<h4>Produits : </h4>
	<?php while($r = $select2->fetch(PDO::FETCH_OBJ)){?> 
	<h5>Nom : <?php echo $r->product; ?></h5>
	<h5>Quantité : <?php echo $r->quantity; ?></h5>
	<?php } ?>
	<h4>Devise utilisée : <?php echo $s->currency_code; ?></h4>
	
	<?php
}
?>
<a class="connect"href="disconnect.php">Se déconnecter</a>
<?php

require_once('includes/footer.php');

?>