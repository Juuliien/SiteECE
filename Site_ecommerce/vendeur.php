<?php

	require_once("includes/header.php");
?>

<link href="../style/bootstrap.css" type="text/css" rel="stylesheet"/>

<h1>Bienvenue, <?php echo $_SESSION['username']; ?></h1>
<br/>

<a href="?action=add">Ajouter un produit</a>
<a href="?action=modifyanddelete">Modifier / Supprimer un produit</a><br/><br/>

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

								imagejpeg($image_finale,'../imgs/'.$slug.'.jpg');

							}

						}

					}else{

						echo'Veuillez rentrer une image';

					}

					if($title&&$description&&$price&&$stock){

						$category=$_POST['category'];


					//	$select = $db->query("SELECT price FROM weights WHERE name='$weight'");

						//$s = $select->fetch(PDO::FETCH_OBJ);



						$old_price = $price;

						$Final_price = $old_price;

						$select=$db->query("SELECT tva FROM products");

						$s1=$select->fetch(PDO::FETCH_OBJ);

						if($s1){

							$tva = $s1->tva;

						}else{
							$tva = 20;
						}

						$final_price_1 = $Final_price+$Final_price*$tva/100;

						$insert = $db->query("INSERT INTO products (title,slug,description,price,category,tva,final_price,stock) VALUES('$title','$slug','$description','$price','$category','$tva','$final_price_1','$stock')");

						header('Location: ../categorie.php?category='.$category);

					}else{

						echo'Veuillez remplir tous les champs';

					}

				}

			?>

				<form action="" method="post" enctype="multipart/form-data">
				<h3>Titre du produit :</h3><input type="text" name="title"/>
				<h3>Description du produit :</h3><textarea name="description"></textarea>
				<h3>Prix :</h3><input type="text" name="price"/><br/><br/>
				<h3>Image :</h3>
				<input type="file" name="img"/><br/><br/>
				<h3>Categorie :</h3><select name="category">

				<?php $select=$db->query("SELECT * FROM category");

					while($s = $select->fetch(PDO::FETCH_OBJ)){

						?>

						<option><?php echo $s->name; ?></option>

						<?php

					}

				 ?>

				</select><br/><br/>
				
				<h3>Stock : </h3><input type="text" name="stock"/><br/><br/>
				<input type="submit" name="submit"/>
				</form>

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

			}
		}

	}else{

		header('Location: ../index.php');

	}
	require_once("includes/footer.php")
?>