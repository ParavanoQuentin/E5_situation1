<?php
session_start();
// Si l'ID revendeur est reconnu alors la page s'affiche
if (isset($_SESSION['idRevendeur'])) {
	
	require_once("accesBdd.php"); 
	require_once("class/panier.php");

	if (isset($_POST['submit'])) {

		if ($_POST['qte'] > 0) {

			if (!empty($_POST['qte']) AND !empty($_POST['listePdt'])) {

				$id = htmlspecialchars($_POST['listePdt']);
				$qte = htmlspecialchars(intval($_POST['qte']));
				// creation d"un nouveau panier et ajout
				$p = new Panier; 
				$p->ajouter($id,$qte); 
				
				$noerreur = "<h4 style='color: green'>Le produit a été ajouter au panier</h4>";
				header("Refresh: 4;");
			}
			else{
				$erreur = "<h4 style='color: red'>Veuillez selectionner un produit</h4>";
			}
		}
	}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <title>Meuble Design</title>
</head>
<body>
<header>
	    <nav>
	      <input type="checkbox" id="check">
	      <label class="logo"><a class="logo" href="index.php"><img class="logo" src="images/MeubleDesign.png"></a></label>
	      <label for="check" class="checkbtn">
	        <i style="color: black;" class="fa fa-bars"></i>
	      </label>

	      	<ul>
		      	<li><a class="active" href="">Achat</a></li>
		      	<li><a class="nav" href="panier.php">Panier</a></li>
		      	<li><a class="nav" href="donnerClient.php">Données client</a></li>
		      	<?php if (isset($_SESSION['idRevendeur'])) { ?>
		      	
		      	<li><a href="deconnexion.php" style="color : red" class="nav">Déconnexion</a></li>
		      	<?php }?>

		      	<?php 
		      	if (!isset($_SESSION['idRevendeur'])) { ?>
		      		<li><a href="identification.php" class="nav">Connexion</a></li>
		      	<?php }?>
	      	</ul>
		</nav>
</header>	
<br><br><br><br><br>
	<!-- Message d'erreur -->
	<?php
	if (isset($erreur)) {
		echo "<center><p style='color: red'>".$erreur."</p></center><br>";
	}
	if (isset($noerreur)) {
		echo "<center><p style='color: green'>".$noerreur."</p></center><br>";
	}
	?>

<div class="container">
	<h1 class="title">Choisir votre produit</h1><br>
	<form method="POST" action="">
		<table class="table">
			<tr class="table-light">
				
				<?php 
			    $lesCategories = getLesCategories(); 
			    ?>

				<td>
					Liste categories :
					<select class="select" id="listeCategorie">
	    				<option></option>
					    <?php
					        foreach ($lesCategories as $categorie) {
					            echo "<option value = '".$categorie['ca_id']."'>".$categorie['ca_libelle']."</option>";
					    } ?>

	    			</select>
				</td>
			</tr>
			<tr>
				<td>
					Liste des produits : 
					<select class="select" name="listePdt" id="listePdt">
	    			</select>
	    		</td>

			</tr>

			<tr class="table-light">
				<td>Prix (€):
					<div id="divPrix"></div>
				</td>
			</tr>

			<tr>
				<td>
					<img class="image-annonce" id="divImage"></img>
					<img class="image-annonce" id="divImage2"></img>
				</td>
			</tr>
			<tr>
				<td>
					<img class="image-annonce" id="divImage3"></img>
					<img class="image-annonce" id="divImage4"></img>
				</td>
			</tr>

			<tr class="table-light">
				<td>
					Quantité
					<input class="qte" type="number" name="qte" value="1">
				</td>
			</tr>
			<tr>
				<td><button class="submit" name="submit">Ajouter au panier <i class="fa fa-shopping-cart"></i></button></td>
			</tr>
			<tr>
				<td><button class="vider" name="viderPanier">Vider le panier</button></td>
			</tr>
		</table>
		<br><br>
	</form>
</div>
</body>
</html>


<script type="text/javascript" src="fonctions.js"></script>

<?php
    
}
else{
	header("Location: identification.php");
}

?>


