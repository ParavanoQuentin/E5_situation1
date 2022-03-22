<?php 
	
function getLesCategories() {

    $lesCategories = null;

    include('config.php');

    $requete = "select * from categorie";
    $resultat = $bdd->query($requete);
    $lesCategories = $resultat->fetchAll();

    return $lesCategories;
}
	    

?>