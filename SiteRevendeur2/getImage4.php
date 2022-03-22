<?php

    $idProduit = $_GET['idProduit']; 
    // $idProduit = 1;
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=ajax;charset=UTF8', 'root', '') 
		or die('Erreur connexion à la base de données');

        $requete = "select url_image4 from produit where pr_id = '$idProduit'";
        $resultat = $bdd->query($requete);
       
        $image4 = $resultat->fetch(PDO::FETCH_ASSOC);
        echo json_encode($image4);

?>
