<?php
    $idProduit = $_GET['idProduit']; 
    
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=ajax;charset=UTF8', 'root', '') 
		or die('Erreur connexion à la base de données');
       
        $requete = "select pr_prix from produit where pr_id = '$idProduit'";
        $resultat = $bdd->query($requete);


        $prix = $resultat->fetch(PDO::FETCH_ASSOC);
        echo json_encode($prix);
?>
