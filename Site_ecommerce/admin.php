<?php

	
	require_once("includes/header.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf8">
		<link href="../style/bootstrap.css" type="text/css" rel="stylesheet"/>
		<style>
		
			.modifications{
				margin-top:40px;
				text-align:center;
				font-size:40px;
			}
			.modifications1{
				margin-left:425px;
				font-size:20px;

			}
			.modifications2{
				margin-left:200px;
				font-size:20px;

			}
			.modifications3{

				margin-left:675px;
				font-size:20px;

			}
			.modifications4{
				margin-left:170px;
				font-size:20px;
			}

            .modifications5{
				margin-left:220px;
				font-size:20px;
			}
		</style>
<link href="../style/bootstrap.css" type="text/css" rel="stylesheet"/>

<h1 class="modifications">Bienvenue, <?php echo $_SESSION['username']; ?></h1>
<br/>

<a class="modifications1"href="?action=add">Ajouter un produit</a>
<a class="modifications2"href="?action=modifyanddelete">Modifier / Supprimer un produit</a><br/><br/>

<a class="modifications1"href="?action=add_category">Ajouter une categorie</a>
<a class="modifications4"href="?action=modifyanddelete_category">Modifier / Supprimer une categorie</a><br/><br/>
<a class="modifications1"href="?action=add_seller"> Ajouter vendeur</a>
<a class="modifications5"href="?action=modifyanddelete_seller"> Modifier / Supprimer un vendeur</a>

<a class="modifications3"href="?action=options">Options</a><br/><br/>

<?php
   //Generer des URL a partir de PHP fonction trouvée sur internet pour nettoyer les caracteres spéciaux
	function slugify($text){
		$text = preg_replace('~[^\pL\d]+~u', '-', $text);

		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		$text = preg_replace('~[^-\w]+~', '', $text);

		$text = trim($text, '-');

		$text = preg_replace('~-+~', '-', $text);

		$text = strtolower($text);

		if (empty($text)) {
		  return 'n-a';
		}

  		return $text;
	}

	try{

		$db = new PDO('mysql:host=localhost;dbname=ECE', 'root','');
		$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER); // les noms de champs seront en caractères minuscules
		$db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION); // les erreurs lanceront des exceptions
		$db->exec('SET NAMES utf8');				
	}

	catch(Exception $e){

		die('Une erreur est survenue');

	}

	if(isset($_SESSION['username'])){

		if(isset($_GET['action'])){

			if($_GET['action']=='add'){

				if(isset($_POST['submit'])){

					$stock = $_POST['stock'];
					$title= addslashes($_POST['title']);
					$slug = slugify($title);
					$description= addslashes($_POST['description']);
					$price=$_POST['price'];

					$img = $_FILES['img']['name'];

					$img_tmp = $_FILES['img']['tmp_name'];

					if(!empty($img_tmp)){

						$image = explode('.',$img);

						$image_ext = end($image);

						if(in_array(strtolower($image_ext),array('png','jpg','jpeg'))===false){

							echo'Veuillez rentrer une image ayant pour extension : png, jpg ou jpeg';

						}else{

							$image_size = getimagesize($img_tmp);

							if($image_size['mime']=='image/jpeg'){

								$image_src = imagecreatefromjpeg($img_tmp);

							}else if($image_size['mime']=='image/png'){

								$image_src = imagecreatefrompng($img_tmp);

							}else{

								$image_src = false;
								echo'Veuillez rentrer une image valide';

							}

							if($image_src!==false){

								$image_width=200;

								if($image_size[0]==$image_width){

									$image_finale = $image_src;

								}else{

									$new_width[0]=$image_width;

									$new_height[1] = 200;

									$image_finale = imagecreatetruecolor($new_width[0],$new_height[1]);

									imagecopyresampled($image_finale,$image_src,0,0,0,0,$new_width[0],$new_height[1],$image_size[0],$image_size[1]);

								}

								imagejpeg($image_finale,'imgs/'.$slug.'.jpg');

							}

						}

					}else{

						echo'Veuillez rentrer une image';

					}

					if($title&&$description&&$price&&$stock){

						$category=$_POST['category'];


						$old_price = $price;

						$Final_price = $old_price;

						$select=$db->query("SELECT remise FROM products");

						$s1=$select->fetch(PDO::FETCH_OBJ);

						if($s1){

							$remise = $s1->remise;

						}else{
							$remise = 20;
						}

						$final_price_1 = $Final_price+$Final_price*$remise/100;

						$insert = $db->query("INSERT INTO products (title,slug,description,price,category,remise,final_price,stock) VALUES('$title','$slug','$description','$price','$category','$remise','$final_price_1','$stock')");

						header("index.php");

					}else{

						echo'Veuillez remplir tous les champs';

					}

				}

			?>
			<style>
			.modification{
				margin-left:400px;
			}

			</style>
<table class="modification" width="50%">
				<form action="" method="post" enctype="multipart/form-data">
				<tr>
				<td><h3>Titre du produit : </td><td></h3><input type="text" name="title"/></td>

				</tr>
				<tr>
				<td><h3>Description du produit : </td><td></h3><textarea name="description"></textarea></td>

				</tr>
				<tr>
				<td><h3>Prix : </td><td></h3><input type="text" name="price"/><br/><br/></td>

				</tr>
				<tr>
				<td><h3>Image : </td><td></h3><input type="file" name="img"/><br/><br/></td>


				</tr>
				<tr>
				<td><h3>Categorie : </td><td></h3><select name="category">
				<?php $select=$db->query("SELECT * FROM category");

					while($s = $select->fetch(PDO::FETCH_OBJ)){

						?>

						<option><?php echo $s->name; ?></option>
						<?php

					}

				 ?>
				</td>
				</tr>

				

				</select><br/><br/>
				<tr>
				<td><h3>Stock : </td><td></h3><input type="text" name="stock"/><br/><br/></td>

				</tr>
				<tr>
				<td></td><td><input class="btn btn-light" type="submit" name="submit"/></td>

				</tr>
				</form>
</table>
<br>
<br><br><br>

			<?php

			}else if($_GET['action']=='modifyanddelete'){

				$select = $db->prepare("SELECT * FROM products");
				$select->execute();

				while($s=$select->fetch(PDO::FETCH_OBJ)){

					echo $s->title;
					?>
					<a href="?action=modify&amp;id=<?php echo $s->id; ?>">Modifier</a>
					<a href="?action=delete&amp;id=<?php echo $s->id; ?>">Supprimer</a><br/><br/>
					<?php

				}

			}else if($_GET['action']=='modify'){

				$id=$_GET['id'];

				$select = $db->prepare("SELECT * FROM products WHERE id=$id");
				$select->execute();

				$data = $select->fetch(PDO::FETCH_OBJ);

				?>

				<form action="" method="post">
				<h3>Titre du produit :</h3><input value="<?php echo $data->title; ?>" type="text" name="title"/>
				<h3>Description du produit :</h3><textarea name="description"><?php echo $data->description; ?></textarea>
				<h3>Prix</h3><input value="<?php echo $data->price; ?>" type="text" name="price"/>
				<h3>Stock : </h3><input type="text" value="<?php echo $data->stock; ?>"name="stock"/><br/><br/>
				<input type="submit" name="submit" value="Modifier"/>
				</form>

				<?php

				if(isset($_POST['submit'])){

					$stock = $_POST['stock'];
					$title=$_POST['title'];
					$description=$_POST['description'];
					$price=$_POST['price'];

					$update = $db->prepare("UPDATE products SET title='$title',description='$description',price='$price',stock='$stock' WHERE id=$id");
					$update->execute();

					header('Location: admin.php?action=modifyanddelete');

				}

			}else if($_GET['action']=='delete'){

				$id=$_GET['id'];
				$delete = $db->prepare("DELETE FROM products WHERE id=$id");
				$delete->execute();
				header('Location: admin.php?action=modifyanddelete');

			}else if($_GET['action']=='add_category'){

				if(isset($_POST['submit'])){

					$name = addslashes($_POST['name']);
					$slug = slugify($name);

					if($name){

						$insert = $db->prepare("INSERT INTO category (name,slug) VALUES('$name','$slug')");
						$insert->execute();


					}else{

						echo'Veuillez remplir tous les champs';

					}

				}

				?>
				<style>
				.categorie{
					text-align:center;
				}
				.categorie1{
					margin-left:650px;				
					}
					.categorie2{
					margin-left:710px;				
					}
					
				</style>
				<form action="" method="post">
				<h3 class="categorie"> Titre de la categorie : </h3>
				<br>
				<input class="categorie1" type="text" name="name"/><br/><br/>
				<div class="categorie2">
				<input  class="btn btn-light" type="submit" name="submit" value="Ajouter" />
				</div>
				</form>
				<style>
					.modifier{
						text-align:center;
						}
					</style>
<div class= "modifier">
				<?php


			}else if($_GET['action']=='modifyanddelete_category'){

				$select = $db->prepare("SELECT * FROM category");
				$select->execute();

				while($s=$select->fetch(PDO::FETCH_OBJ)){

					echo $s->name;
					?>
					</div>
					<a  href="?action=modify_category&amp;id=<?php echo $s->id; ?>">Modifier</a>
					<a  href="?action=delete_category&amp;id=<?php echo $s->id; ?>">Supprimer</a><br/><br/>
					<?php

				}

			}else if($_GET['action']=='modify_category'){

				$id=$_GET['id'];

				$select = $db->prepare("SELECT * FROM category WHERE id=$id");
				$select->execute();

				$data = $select->fetch(PDO::FETCH_OBJ);

				?>

				<form action="" method="post">
				<h3>Titre de la categorie :</h3><input value="<?php echo $data->name; ?>" type="text" name="name"/><br/>
				<input type="submit" name="submit" value="Modifier"/>
				</form>

				<?php

				if(isset($_POST['submit'])){

					$name=$_POST['name'];

					$select = $db->query("SELECT name FROM category WHERE id='$id'");

					$result = $select->fetch(PDO::FETCH_OBJ);

					$update = $db->prepare("UPDATE category SET name='$name' WHERE id=$id");
					$update->execute();

					$id = $_GET['id'];
				
					$update = $db->query("UPDATE products SET category='$name' WHERE category='$result->name'");
					
					header('Location: admin.php?action=modifyanddelete_category');
				}

			}else if($_GET['action']=='delete_category'){

				$id=$_GET['id'];
				$delete = $db->prepare("DELETE FROM category WHERE id=$id");
				$delete->execute();

				header('Location: admin.php?action=modifyanddelete_category');

			}else if($_GET['action']=='options'){

				?>
				<style>
				.option{
					text-align:center;
				}
				</style>

				<h3 class="option">Options de remise</h3>

				<?php
				

				$select=$db->query("SELECT remise FROM products");

				$s = $select->fetch(PDO::FETCH_OBJ);

				if(!$s){
					$show_remise = 20;
				}else{
					$show_remise = $s->remise;
				}

				if(isset($_POST['submit2'])){

					$remise=$_POST['remise'];

					if($remise){

						$update = $db->query("UPDATE products SET remise=$remise");
						header("Refresh:0");

					}

				}

				?>
				<h3 class="option">Remise : </h3>

				<form class="option" action="" method="post"/>
				<input type="text" name="remise" value="<?= $show_remise; ?>"/>
				<br>
				<input class="btn btn-light" type="submit" name="submit2" value="Modifier"/>
				</form>
 
				<?php


			}else if($_GET['action']=='add_seller'){


	if(isset($_POST['submit'])){

		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$repeatpassword = $_POST['repeatpassword'];

		if($username&&$email&&$password){
			
				$db->query("INSERT INTO seller(username, email, password) VALUES('$username', '$email', '$password')");
				echo '<br/><h3 style="color:green;">Vous avez créé votre compte vendeur, vous pouvez maintenant vous <a href="indexvendeur.php">connecter</a>.</h3>';
			
		    }
		    else{
			echo '<br/><h3 style="color:red;">Veuillez remplir tous les champs.</h3>';
		    }

	    }

	?>
        <table class="connect" width="30%">
	<form action="" method="POST">
	<tr>
	<td><h4>Pseudo du vendeur</td><td><input type="text" name="username"/></h4></td>

	</tr>
	<tr>
	<td><h4>Email </td><td><input type="email" name="email"/></h4></td>

	</tr>
	<tr>
	<td><h4>Mot-de-passe </td><td><input type="password" name="password"/></h4>
</td>
	</tr>
	<tr>
	
	</tr>
	<tr>
	<td></td><td><input class="btn btn-light" type="submit" name="submit"/>
</td>
	</tr>
	</form>
	

	</table>
		<style>
		.connect{
			margin-left:450px;
		}
		.connectTitre{
			margin-left:550px;

		}
		</style>

<?php
}


              
   else if($_GET['action']=='modifyanddelete_seller'){
            

            $select = $db->prepare("SELECT * FROM seller");
				$select->execute();

				while($s=$select->fetch(PDO::FETCH_OBJ)){

					echo $s->username;
					?>
					</div>
					<a  href="?action=modify_seller&amp;id=<?php echo $s->idvendeur; ?>">Modifier</a>
					<a  href="?action=delete_seller&amp;id=<?php echo $s->idvendeur; ?>">Supprimer</a><br/><br/>
					<?php

				}

			}else if($_GET['action']=='modify_seller'){

				$id=$_GET['id'];

				$select = $db->prepare("SELECT * FROM seller WHERE idvendeur=$id");
				$select->execute();

				$data = $select->fetch(PDO::FETCH_OBJ);

				?>

				<form action="" method="post">
				<h3>Nom :</h3><input value="<?php echo $data->username; ?>" type="text" name="name"/><br/>
				<h3>email :</h3><input value="<?php echo $data->email; ?>" type="text" name="email"/><br/>
				<h3>Mot de passe :</h3><input value="<?php echo $data->password; ?>" type="text" name="password"/><br/>
				<input type="submit" name="submit" value="Modifier"/>
				</form>

				<?php

				if(isset($_POST['submit'])){

					$name=$_POST['name'];
                    $email=$_POST['email'];
                    $password=$_POST['password'];
					$select = $db->query("SELECT username FROM seller WHERE idvendeur='$id'");

					$result = $select->fetch(PDO::FETCH_OBJ);

					$update = $db->prepare("UPDATE seller SET username='$name' WHERE idvendeur=$id");
					$update->execute();

					$select = $db->query("SELECT email FROM seller WHERE idvendeur='$id'");

					$result = $select->fetch(PDO::FETCH_OBJ);

					$update = $db->prepare("UPDATE seller SET email='$email' WHERE idvendeur=$id");
					$update->execute();

                    $select = $db->query("SELECT password FROM seller WHERE idvendeur='$id'");

					$result = $select->fetch(PDO::FETCH_OBJ);

					$update = $db->prepare("UPDATE seller SET password='$password' WHERE idvendeur=$id");
					$update->execute();

				
		





					
					header('Location: admin.php?action=modifyanddelete_seller');




				}

			}else if($_GET['action']=='delete_seller'){

				$id=$_GET['id'];
				$delete = $db->prepare("DELETE FROM seller WHERE idvendeur=$id");
				$delete->execute();

				header('Location: admin.php?action=modifyanddelete_seller');














   }
			}
		

	}else{

		header('Location: index.php');

	}

?>
<?php
	require_once("includes/footer.php");
?>
