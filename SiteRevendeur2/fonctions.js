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



    // let listePdt = document.getElementById("listePdt");
    listePdt.addEventListener("click", recupImage2);

  function recupImage2(){
        let idProduit = listePdt.value;
        fetch("getImage2.php?idProduit="+ idProduit)

        .then(response => response.json())
        .then(data => {
                let idImage2 = document.getElementById("divImage2");
                if(data["url_image2"] != "")  {
                    idImage2.src = data["url_image2"]; 
                }              
        })
        .catch(function (error) {
            console.log('Request failed', error);
        });
  }



  listePdt.addEventListener("click", recupImage3);

  function recupImage3(){
        let idProduit = listePdt.value;
        fetch("getImage3.php?idProduit="+ idProduit)

        .then(response => response.json())
        .then(data => {
                let idImage3 = document.getElementById("divImage3");
                if(data["url_image3"] != "")  {
                    idImage3.src = data["url_image3"]; 
                }              
        })
        .catch(function (error) {
            console.log('Request failed', error);
        });
  }


  listePdt.addEventListener("click", recupImage4);

  function recupImage4(){
        let idProduit = listePdt.value;
        fetch("getImage4.php?idProduit="+ idProduit)

        .then(response => response.json())
        .then(data => {
                let idImage4 = document.getElementById("divImage4");
                if(data["url_image4"] != "")  {
                    idImage4.src = data["url_image4"]; 
                }              
        })
        .catch(function (error) {
            console.log('Request failed', error);
        });
  }