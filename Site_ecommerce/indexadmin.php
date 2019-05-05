<?php

	
    require_once("includes/header.php");
	$user='Amir';
	$password_definit='Amir';

	/*if($_SESSION['username']){
		header('Location: admin.php');
	}*/

	if(isset($_POST['submit'])){

		$username = $_POST['username'];
		$password = $_POST['password'];

		if($username&&$password){

			if($username==$user&&$password==$password_definit){

				$_SESSION['username']=$username;	
				header('Location: admin.php');

			}else{

				echo'Identifiants eronnes , veuillez reessayer';

			}

		}else{

			echo'Veuillez remplir tous les champs !';

		}

	}


?>
<link href="../style/bootstrap.css" type="text/css" rel="stylesheet"/>
<?php echo '<br><br>' ?>
<center> <h1>Administrateur - Connexion</h1> </center>

<form action="" method="POST">
<h3>Pseudo : Amir</h3><input type="text" name="username"/><br/><br/>
<h3>Mot-de-passe :Amir</h3><input type="password" name="password"/><br/><br/>
<input type="submit" name="submit"/><br/><br/>
</form>