<?php

require_once('includes/header.php');
?>

<?php
require_once('includes/functions_panier.php');

$prixfinal = 0;

$erreur = false;

$action = (isset($_POST['action'])?$_POST['action']:(isset($_GET['action'])?$_GET['action']:null));

if($action!==null){

if(!in_array($action, array('ajout','suppression','refresh')))

$erreur = true;

$l = (isset($_POST['l'])?$_POST['l']:(isset($_GET['l'])?$_GET['l']:null));
$q = (isset($_POST['q'])?$_POST['q']:(isset($_GET['q'])?$_GET['q']:null));
$p = (isset($_POST['p'])?$_POST['p']:(isset($_GET['p'])?$_GET['p']:null));

$l = preg_replace('#\v#', '', $l);

$p = floatval($p);

if(is_array($q)){

$QteArticle= array();

$i = 0;

foreach($q as $contenu){

$QteArticle[$i++] = intval($contenu);

}

}else{

$q = intval($q);

}

}

if(!$erreur){

	switch($action){

		Case "ajout":

		ajouterArticle($l,$q,$p);

		break;

		Case "suppression":


		supprimerArticle($l);

		break;

		Case "refresh":

		for($i = 0;$i<count($QteArticle);$i++){

			modifierQTeArticle($_SESSION['panier']['slugProduit'][$i], round($QteArticle[$i]));

		}

		break;

		Default:

		break;

	}

}

?>

<form method="post" action="">
	<table width="400">
		<tr>
			<td colspan="4">Votre panier</td>
		</tr>
		<tr>
			<td>Libellé produit</td>
			<td>Prix unitaire</td>
			<td>Quantité</td>
			<td>TVA</td>
			<td>Action</td>
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
				$totaltva = MontantGlobalTVA();
				//$shipping = CalculFraisPorts();
				$prixfinal = $totaltva ;//+ $shipping;

				for($i = 0; $i<$nbProduits; $i++){

					?>

					<tr>

						<td><br/><?php echo $_SESSION['panier']['libelleProduit'][$i]; ?></td>
						<td><br/><?php echo $_SESSION['panier']['prixProduit'][$i];?></td>
						<td><br/><input name="q[]" value="<?php echo $_SESSION['panier']['qteProduit'][$i]; ?>" size="5"/></td>
						<td><br/><?php echo $_SESSION['panier']['tva']." %"; ?></td>
						<td><br/><a href="panier.php?action=suppression&amp;l=<?php echo $_SESSION['panier']['slugProduit'][$i]; ?>">X</a></td>

					</tr>
					<?php } ?>
					<tr>

						<td colspan="2"><br/>
							<p>Total : <?php echo $total." €"; ?></p><br/>
							<p>Total avec TVA : <?php echo $totaltva." €"; ?></p>
						 <!--	<p>Calcul des frais de port : <?php echo $shipping." €"; ?></p>-->
							<?php if(isset($_SESSION['user_id'])){ ?><?php }else{?><h4 style="color:red;">Vous devez être connecté pour payer votre commande. <a href="connect.php">Se connecter</a></h4><?php } ?>
						</td>
					</tr>
					<tr>
						<td colspan="4">
							<input type="submit" value="rafraichir"/>
							<input type="hidden" name="action" value="refresh"/>
							<a href="?deletepanier=true">Supprimer le panier</a>
						</td>
					</tr>

					<?php


			}

		}

		?>
	</table>
</form>

<?php

require_once('includes/footer.php');

?>