<?php
session_start();

if (isset($_SESSION['idRevendeur'])) {
	
	header("Location: index.php");
}



if (isset($_POST['submit'])) {

	require_once('config.php');
	
	if (!empty($_POST['email']) AND !empty($_POST['password'])) {
		
		$email =  htmlspecialchars($_POST['email']); 
		$pwd = md5($_POST['password']); 

		$reqVerifEmail = $bdd->prepare("SELECT * FROM revendeur WHERE mdp = ? AND mail = ?"); 
		$reqVerifEmail->execute(array($pwd, $email)); 
		$res = $reqVerifEmail->rowCount(); 

		if ($res == 1) {
			
			$info = $reqVerifEmail->fetch();
			$_SESSION['idRevendeur'] = $info['id']; 
			header("Location: index.php");
		}
		else{

			$erreur = "Identifiant ou mot de passe incorect !";
		}
	}
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="styles.css">
	<title></title>
</head>
<body>
		<br><br><br>
	<form method="POST" action="">
		<?php 
		if (isset($erreur)) {
			echo "<center style='color : red'>".$erreur."</center>";
		}
		?>

		<table class="table" align="center">
			<tr>
				<td class="identification"><img class="identification" src="images/MeubleDesign.png"></td>
				<td class="identification"><h1>Identification</h1></td>
			</tr>

			<tr>
				<td class="identification">Saisir votre adresse mail :</td>
				<td class="identification"><input class="identification" type="text" name="email" value="test@test.fr"></td>
			</tr>

			<tr>
				<td class="identification">Saisir votre mot de passe :</td>
				<td class="identification"><input class="identification" type="password" name="password" value="test"></td>
			</tr>
			<tr>
				<td class="identification"><button class="submit" name="submit">Continuer</button></td>
			</tr>
		</table>
	</form>

</body>
</html>