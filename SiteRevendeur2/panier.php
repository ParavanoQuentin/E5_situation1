<?php
session_start();

if (isset($_SESSION['idRevendeur'])) {

    require_once('accesBdd.php'); 
    require_once('class/panier.php');
    require_once('config.php');

    	// Retirer un article du panier 
    	if (isset($_GET['action'])) {
    		if ($_GET['action'] == 'retirer') {
    			
    			if (isset($_GET['id'])) {
    				if (!empty($_GET['id'])) {

    						$id = $_GET['id']; 
    						$panier = new Panier; 
    						$panier->retirer($id); 
    						header("Location: panier.php");
    				}
    			}
    		}
    	}

    	// retirer un Article par quantité
    		if (isset($_GET['action'])) {
    		if ($_GET['action'] == 'retirerQte') {
    			
    			if (isset($_GET['id'])) {
    				if (!empty($_GET['id'])) {

    						$id = $_GET['id']; 
    						$panier = new Panier; 
    						$panier->retirerQte($id); 
    						header("Location: panier.php");
    				}
    			}
    		}
    	}

    	// Ajouter un Article par quantité
    		if (isset($_GET['action'])) {
    		if ($_GET['action'] == 'ajouterQte') {
    			
    			if (isset($_GET['id'])) {
    				if (!empty($_GET['id'])) {

    						$id = $_GET['id']; 
    						$panier = new Panier; 
    						$panier->ajouterQte($id); 
    						header("Location: panier.php");
    				}
    			}
    		}
    	}


    if (isset($_POST['viderPanier'])) {

    	$v = new Panier; 
    	$v->vider();
    }

    if (isset($_POST['poursuivre'])) {

    	header("Location: index.php");
    }

    if (isset($_POST['ValiderCommande'])) {
    	
    	$resReqNumCmd = 1; 
    	while ($resReqNumCmd == 1) {
    		//Creation numero de commmande 
    		$commande = ""; 
    	 	$numCommande1 = mt_rand(10,20);
    	 	$numCommande2 = mt_rand(10,20);
    	 	$numCommande3 = mt_rand(10,20); 
    	 	$numCommande4 = mt_rand(10,20);
    	 	$numCommande5 = mt_rand(10,20);
    	 	$numero = $numCommande1.$numCommande2.$numCommande3.$numCommande4.$numCommande5;
    	 	// Verification si le numero de commande généré existe deja dans la bdd
    	 	$verifNumCmd = $bdd->query("SELECT numero_commande FROM commandes WHERE numero_commande = $numero");
    	 	$resReqNumCmd = $verifNumCmd->rowCount(); 
    	}

            $numCommande .= "MD-".$numero;
    	   	$prixTtc = 0;

    	   	//Recuperation du nom et prix de l'article appartir de l'ID 
    		foreach ($_SESSION['panier'] as $id2 => $qte2) {
    		 	
    		 	$reqNom = $bdd->query("SELECT pr_libelle,pr_prix FROM produit WHERE pr_id = $id2"); 
                $resNom = $reqNom->fetch();  
                // Calcule le prix total pour chaque article
                $prixPdtCommande = intval($qte2) * $resNom['pr_prix'];  
                $prixTtc += $prixPdtCommande;   
                $commande .= $qte2." ".$resNom['pr_libelle'].", ";

    		}

    		date_default_timezone_set('Europe/Paris');
            $date = date('Y-m-d H:i:s'); 
            $id_payeur = intval($_SESSION['idRevendeur']);
            // Insertion dans la bdd du numero de cmde + le recapitulatif + prix total + date et heure de cmde
            $insertPdt = $bdd->prepare("INSERT INTO commandes (id_client,numero_commande, commande, prix_total, co_date) VALUES (?,?,?,?,?)");
            $insert = $insertPdt->execute(array($id_payeur,$numCommande, $commande, $prixTtc, $date));  

    	 	$noerreur = "La commande a bien été effectuée"; 

            $_SESSION['numCommande'] = $numCommande;     
    	 	$v = new Panier; 
    		$v->vider();

    		header("Location: commandeValide.php"); 

    }


    if (isset($_SESSION['panier'])) {
    	if(!empty($_SESSION['panier'])){
    	
    		include('config.php');
    ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="styles.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
	<title>Mon panier</title>
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
    	      	<li><a class="nav" href="index.php">Achat</a></li>
    	      	<li><a class="active" href="panier.php">Panier <i class="fa fa-shopping-bag"></i></a></li>
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

	<div class="container">
	<h1 class="title">Mon panier <i class="fa fa-shopping-cart"></i></h1><br><br>

	<?php
	if (isset($noerreur)) {
		echo "<p style='color: green'>".$noerreur."</p><br>";
	}
	?>

		<form method="GET" action="">
			<table class="table">
				<thead>
					<tr class="table-primary">
						<td><h4>Article</h4></td>
						<td></td>
						<td><h4>Quantité</h4></td>
						<td><h4>Prix à l'unité</h4></td>
						<td></td>
					</tr>
				</thead>

		<?php 

			$prixTotal = 0;

		    foreach ($_SESSION['panier'] as $nomPdt => $qte) {
		    	
		    	// recupere pour chaque porduit selectionner son nom prix id et image
		    	$bdd = new PDO('mysql:host=127.0.0.1;dbname=ajax;charset=UTF8', 'root', ''); 
				$reqNomPdt = $bdd->query("SELECT pr_libelle, pr_prix, pr_id, url_image FROM produit WHERE pr_id = $nomPdt"); 
		    	$res = $reqNomPdt->fetch();
		    		
	    		foreach ($_SESSION['panier'] as $idTotal => $qteTotal) {
	    				// Verifie si l'id correspond a l'id recuperer dans la bdd
		    			if ($idTotal == $res['pr_id']) {
		    				//prix d'un article mutiplier par sa quant. pour obtenir le prix total de toute la commande
		    				$prixArticle = $res['pr_prix'] * $qteTotal; 
		    				$prixTotal += $prixArticle; 

		    			}

	    		}

		    	$nomPdt = $res['pr_libelle'];
		    	$id = $res['pr_id']; 
		    	$imgPdt = $res['url_image'];

		?>
			
				<tbody>
					<tr class="table-light">
						<td><p><?= $nomPdt ?></p></td>
						<td><img class="imgPdt" src="<?= $imgPdt ?>"></td>
						<td>
							<h5>
								<a href="panier.php?action=retirerQte&id=<?= $id ?>"><i class="fa fa-minus"></i></a>
									<span><?= $qte ?></span>  
								<a href="panier.php?action=ajouterQte&id=<?= $id ?>"><i class="fa fa-plus"></i></a> 
							</h5>
						</td>
						<td><p><?= $res['pr_prix'] ?> € </p></td>
						<td><a href="panier.php?action=retirer&id=<?= $id ?>"><i style="font-size: 27px; color: red;" class="fa fa-trash" aria-hidden="true"></i></a></td>
					</tr>
				</tbody>

		  	<?php  } ?>

			</table>
		</form>
		<br><br>

		<form method="POST" action="">
			<table class="table">
		  		<tr class="table-light">
			 		<td><button class="poursuivre" name="poursuivre">Poursuivre la commande</button></td>
			 		<td><h4 class="prixTotal">Prix TTC : <?= $prixTotal ?> €</h4></td>
			 	</tr>
			 	<tr class="table-light">
			 		<td><button class="vider" name="viderPanier">Vider le panier</button></td>
		  			<td class="prixTotal"><button class="submit" name="ValiderCommande">Valider la commande</button></td>
			 	</tr> 
			</table>
		</form>
	</div>
	<br><br><br>
</body>
</html>

<?php 
    	}
    	else{
    		header("Refresh: 4; index.php");
    		echo "<br><br>	<link rel='stylesheet' type='text/css' href='styles.css'>
    		<meta name='viewport' content='width=device-width, initial-scale=1.0'>
    		<center><h1>Votre panier est vide</h1><br>
    			<a href='index.php'>Retour à la page d'acceuil</a></center>";
    	}
    }
    else{
    	header("Refresh: 4; index.php");
    	echo "<br><br>	<link rel='stylesheet' type='text/css' href='styles.css'>
    	<center><h1>Votre panier est vide</h1><br>
    		<a href='index.php'>Retour à la page d'acceuil</a></center>";
    }


    
}
else{
    header("Location: identification.php");
}

?>