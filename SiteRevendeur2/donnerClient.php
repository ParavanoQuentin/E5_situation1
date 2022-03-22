<?php 
session_start(); 
if (isset($_SESSION['idRevendeur'])) {

	require_once('config.php');

	$reqAllCmd = $bdd->query("SELECT * FROM commandes"); 

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css">
	<meta charset="utf-8">
	<title></title>
</head>
<header>
	    <nav>
	      <input type="checkbox" id="check">
	      <label class="logo"><a class="logo" href="index.php"><img class="logo" src="images/MeubleDesign.png"></a></label>
	      <label for="check" class="checkbtn">
	        <i style="color: black;" class="fa fa-bars"></i>
	      </label>

	        <ul>
    	      	<li><a class="nav" href="index.php">Achat</a></li>
    	      	<li><a class="nav" href="panier.php">Panier <i class="fa fa-shopping-bag"></i></a></li>
    	      	<li><a class="active" href="donnerClient.php">Données client</a></li>
    	      	<?php if (isset($_SESSION['idRevendeur'])) { ?>
    	      	
    	      	<li><a href="deconnexion.php" style="color : red" class="nav">Déconnexion</a></li>
    	      	<?php }?>

    	      	<?php 
    	      	if (!isset($_SESSION['idRevendeur'])) { ?>
    	      		<li><a href="identification.php" class="nav">Connexion</a></li>
    	      	<?php }?>
            </ul>
		</nav>
</header><br><br><br>
<body>
	<div class="container"><br>
		<h1 class="title">Données clients</h1><br><br>
		<table class="table">
			<thead>
				<tr class="table-primary">
					<td>
						ID commande
					</td>
					<td>
						ID client
					</td>
					<td>
						Numéro commande
					</td>
					<td>
						Commande
					</td>
					<td>
						Prix Total
					</td>
					<td>
						Date de la commande
					</td>

				</tr>
			</thead>
			<tbody>
				<?php 

				 while ($infoClient = $reqAllCmd->fetch()) {
				  
				?>
				<tr class="table-warning">
					<td>
						<?= $infoClient["co_id"] ?>
					</td>
					<td>
						<?= $infoClient["id_client"] ?>
					</td>
					<td>
						<?= $infoClient["numero_commande"] ?>
					</td>
					<td>
						<?= $infoClient["commande"] ?>
					</td>
					<td>
						<?= $infoClient["prix_total"] ?> €
					</td>
					<td>
						<?= $infoClient["co_date"] ?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
			
		</table>
	</div>

</body>
</html>

<?php    
}
else{
	header("Location: identification.php");
}

?>