<?php

require_once('includes/header.php');
?>

<?php

require_once('includes/functions_panier.php');

$prixfinal = 0;

$erreur = false;

$action = (isset($_POST['action'])?$_POST['action']:(isset($_GET['action'])?$_GET['action']:null));



if(!$erreur){

	switch($action){

		Case "ajout":

		ajouterArticle($l,$q,$p);

		break;

		Case "suppression":


		supprimerArticle($l);

		break;

		Default:

		break;

	}

}

?>


	<table width="800">
		<tr> 
			<?php echo '<br>';?>
			<td colspan="4"> <center> <h1> Votre panier</h1></center></td>
		</tr>
		<tr>
			<td><center>Nom du Produit</center></td>
			<td>Prix unitaire</td>
			<td><center>Quantité</center></td>
			<td>Remise</td>
			<td>Supprimer</td>
		</tr>
		<?php

			if(isset($_GET['deletepanier']) && $_GET['deletepanier'] == true){

				supprimerPanier();

			}

			if(creationPanier()){

			$nbProduits = count($_SESSION['panier']['libelleProduit']);

			if($nbProduits <= 0){

				echo'<br/><p style="font-size:20px; color:Red;">Oops, panier vide !</p>';

			}else{

				$total = MontantGlobal();
				$totalremise = MontantGlobalRemise();
				$prixfinal = $totalremise ;

				for($i = 0; $i<$nbProduits; $i++){

					?>

					<tr>

						<td><br/><center><?php echo $_SESSION['panier']['libelleProduit'][$i]; ?><center></td>
						<td><br/><?php echo $_SESSION['panier']['prixProduit'][$i];?></td>
						<td><br/><input name="q[]" value="<?php echo $_SESSION['panier']['qteProduit'][$i]; ?>" size="5"/></td>
						<td><br/><?php echo $_SESSION['panier']['remise']." %"; ?></td>
						<td><br/><center><a href="panier.php?action=suppression&amp;l=<?php echo $_SESSION['panier']['slugProduit'][$i]; ?>">X</a></center></td>

					</tr>
					<?php } ?>
					<tr>

						<td colspan="2"><br/>
							<p>Sous-Total : <?php echo $total." €"; ?></p><br/>
							<p>Total avec Remise : <?php echo $totalremise." €"; ?></p>
							<?php if(isset($_SESSION['user_id'])){ ?>
							
							<form method="post" action="transaction.php">
                           	<?php $_SESSION['prix']=$prixfinal; ?>
							<input type="submit" value="Passer la commande"/>

							</form>
						<?php }
						else{?><h4 style="color:red;">Vous devez être connecté pour payer votre commande. <a href="connect.php">Se connecter</a></h4><?php } ?>


							

						</td>
					</tr>
					<tr>
						<td colspan="4">
							
							<a href="?deletepanier=true">Supprimer le panier</a>
						</td>
					</tr>

					<?php


			}

		}

		?>
	</table>


<?php

require_once('includes/footer.php');

?>