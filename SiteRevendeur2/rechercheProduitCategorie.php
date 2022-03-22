<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1> Recherche des Produits par Catégorie.</h1>
    Liste des Categories : <br/>

    <?php
    $lesCategories = getLesCategories(); 
    // var_dump ($lesCategories) ;
    ?>


    <select id="listeCategorie">
    
    <?php
        foreach ($lesCategories as $categorie) {
            echo "<option value = '".$categorie['ca_id']."'>".$categorie['ca_libelle']."</option>";
    } ?>

    </select><br/>

    
    Liste des produits : <br/>
    <select id="listePdt"><br/>
    </select><br />

    prix : <div id="divPrix">€</div>
    <img  style="max-width: 200px;" id="divImage" src="divImage"></img>

</body>
</html>

<?php

    function getLesCategories() {

        $lesCategories = null;

        $bdd = new PDO('mysql:host=127.0.0.1;dbname=ajax;charset=UTF8', 'root', '') 
        or die('Erreur connexion à la base de données');

        $requete = "select * from categorie";
        $resultat = $bdd->query($requete);
        $lesCategories = $resultat->fetchAll();

        return $lesCategories;
    }
?>
<script>


    let listeCategorie = document.getElementById("listeCategorie");
    listeCategorie.addEventListener("change", recupProduit);


    function recupProduit(){
        let idCategorie = listeCategorie.value;
        fetch("getProduitsParCategorie.php?idCateg="+ idCategorie)
        .then(response => response.json())
        .then(data => {
                let listePdt = document.getElementById("listePdt");
                listePdt.length = data.length;
                for (let i = 0 ; i < data.length ; i++){
                        listePdt.options[i].text = data[i]["pr_libelle"];
                        listePdt.options[i].value = data[i]["pr_id"];
                }
        })
	  .catch(function (error) {
			console.log('Request failed', error);
	});
  }



  let listePdt = document.getElementById("listePdt");
  listePdt.addEventListener("click", recupPrix);

    function recupPrix(){
        let idProduit = listePdt.value;
        fetch("getPrix.php?idProduit="+ idProduit)
        .then(response => response.json())
        .then(data => {
                let idPrix = document.getElementById("divPrix");
                idPrix.innerHTML = data["pr_prix"];               
        })
	  .catch(function (error) {
			console.log('Request failed', error);
	   });
  }


    // let listePdt = document.getElementById("listePdt");
    listePdt.addEventListener("click", recupImage);

  function recupImage(){
        let idProduit = listePdt.value;
        fetch("getImage.php?idProduit="+ idProduit)

        .then(response => response.json())
        .then(data => {
                let idImage = document.getElementById("divImage");
                if(data["url_image"] != "")  {
                    idImage.src = data["url_image"]; 
                }              
        })
        .catch(function (error) {
            console.log('Request failed', error);
        });
  }
</script>