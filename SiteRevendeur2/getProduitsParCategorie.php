<?php
    $idCateg = 1;
    $idCateg = $_GET["idCateg"];
    
    $bdd = new PDO('mysql:host=localhost;dbname=ajax;charset=UTF8', 'root', '')
		or die('Erreur connexion à la base de données');
        
    $requete = "select * from produit where pr_categorie = '$idCateg' ";  
    $resultat = $bdd->query($requete);
    $lesProduits = $resultat->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($lesProduits);
?>
