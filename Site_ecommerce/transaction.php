<?php 

require_once("includes/header.php");

?> 

<style>
	.modifications{
				margin-top:40px;
				text-align:center;
				font-size:40px;
			}
		</style>



<h1 class="modifications">Bienvenue, <?php echo $_SESSION['username']; ?></h1>
<table width=40%>
	<form action="process.php" method="POST">
	<tr>
		<td><h4>Nom </td><td><input type="text" name="name"/></h4>	</td>

	</tr>
	<tr>
		<td><h4>Adresse </td><td><input type="text" name="street"/></h4></td>

	</tr>
	<tr>
		<td><h4>Ville </td><td><input type="text" name="ville"/></h4></td>

	</tr>
	<tr>
		<td><h4>Pays </td><td><input type="text" name="pays"/></h4></td>

	</tr>
	<tr>
		<td><h4>Telephone </td><td><input type="tel" name="tel"/></h4></td>

	</tr>
	<tr>
		<td><h4>Type de Carte </td><td><input type="text" name="typecarte"/></h4></td>

	</tr>
	<tr>
		<td><h4>Numero carte </td><td><input type="text" name="number"/></h4></td>

	</tr>
	<tr>
		<td><h4>Nom sur la carte </td><td><input type="text" name="nomcarte"/></h4></td>

	</tr>
	<tr>
	<td><h4>Date d'expiration </td><td><input type="date" name="date"/></h4></td>

	</tr>
	<tr>
		<td><h4>Cryptogramme visuel </td><td><input type="text" name="crypto"/></h4></td>

	</tr>
	<tr>
	<td><h4>Prix  </td><td> <?php echo $_SESSION['prix']?>€</h4></td>;

	</tr>
	
	<tr>
	<td></td><td><input class="btn btn-light" type="submit" name="submit"/>
</td>
	</tr>
	</form>
	
	</table>


