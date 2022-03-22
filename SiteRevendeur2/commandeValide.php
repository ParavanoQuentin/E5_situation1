<?php 
session_start();

header("Refresh: 25; index.php");
$numCommande = $_SESSION['numCommande'];


?>
<!DOCTYPE html>
<html>
<head>
	<link rel='stylesheet' type='text/css' href='styles.css'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<br><br>
	<center><h1 style="color: green;">La commande a bien été effectuée !</h1><br>
			<h3>Votre numéro de commande est : <b><?= $numCommande ?>.</b></h3><br>
	<a href='index.php'>Retour à la page d'acceuil</a></center>

</body>
</html>

