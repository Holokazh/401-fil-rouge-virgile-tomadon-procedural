function fetchAllTypesOnForm() {
  // On fetch sur la méthode GET pour récupérer les types et les insérer dans le select
  fetch("api/type.php", {
    method: "get",
  })
    .then((response) => {
      return response.json();
    })
    .then((types) => {
      types.forEach((type) => {
        document.querySelector(
          "#typeId"
        ).innerHTML += `<option value="${type.id}">${type.nom}</option>`;
      });
    });
}

/***** Fetch pour récupérer tout les types *****/
function fetchAllPokemons(currentPage) {
  // Fetch pour récupérer tout les pokémons
  fetch("api/pokemon.php?page=" + currentPage, {
    method: "GET",
  })
    .then((response) => response.json())
    .then((pokemons) => {
      document.querySelector(".content").innerHTML =
        "<section id='content-pokemon'></section>";
      if (pokemons.message) {
        document.querySelector(
          "#content-pokemon"
        ).innerHTML += `<h6>${pokemons.message}</h6>`;
      } else {
        pokemons.pokemons.forEach((pokemon) => {
          document.querySelector(
            "#content-pokemon"
          ).innerHTML += `<div class="card-pokemon" data-id="${pokemon.id}">
                <a href="?id=${pokemon.id}">
                  <img src="${pokemon.image}" alt="Image de ${pokemon.nom}">
                </a>
                <h2>${pokemon.nom}</h2>
              </div>`;
        });

        var nbPage = pokemons.nbPage;

        pagination(nbPage);
      }
    });
}

/***** On fetch sur la méthode POST pour créer un type *****/
function fetchCreatePokemon() {
  fetchAllTypesOnForm();

  // On récupère le formulaire
  var form = document.getElementById("formAddPokemon");

  // Lorsque le formulaire est soumis
  form.addEventListener("submit", function (e) {
    e.preventDefault();

    // On récupère la valeur des inputs
    var nom = escapeHtml(document.getElementById("nom").value);
    var numero = escapeHtml(document.getElementById("numero").value);
    var typeId = escapeHtml(document.getElementById("typeId").value);
    var image = escapeHtml(document.getElementById("image").value);

    // On créer un objet pokemon
    let pokemon = {
      nom: nom,
      numero: numero,
      typeId: typeId,
      image: image,
    };

    // On fetch sur la méthode POST
    fetch("api/pokemon.php", {
      method: "POST",
      // On convertit notre objet pokemon en JSON
      body: JSON.stringify(pokemon),
    })
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
        // On ajoute le message que contient data
        document.querySelector(
          ".content-add-modal .message"
        ).innerHTML = `<p>${data.message}</p>`;

        if (data.status == 201) {
          document.querySelector(".pagination").innerHTML = "";

          fetchAllPokemons(currentPage);
        }
      })
      // Si il y a une erreur, on l'a récupère dans un console.log
      .catch((error) => console.error("Error:", error)); //TODO : peu d'intérêt pour l'utilisateur
  });
}

/***** Fetch pour récupérer les données d'un pokémon via l'id passé en paramètre de l'URL *****/
function fetchOnePokemon(id) {
  // Fetch pour récupérer les données d'un pokémon via l'id passé en URL
  fetch("api/pokemon.php?id=" + id, {
    method: "GET",
  })
    .then((response) => response.json())
    .then((pokemon) => {
      console.log(pokemon);
      document.querySelector(".content").innerHTML =
        "<section id='content-details-pokemon'></section>";
      document.querySelector(
        "#content-details-pokemon"
      ).innerHTML += `<div id="content-details-pokemon-img">
            <img src="${pokemon.pokemon.image}" alt="Image de ${pokemon.pokemon.nom}" class="imagePokemon" data-image="${pokemon.pokemon.image}">
            </div>
            <div>
              <h2 class="nomPokemon" data-nom="${pokemon.pokemon.nom}">${pokemon.pokemon.nom}</h2>
              <p class="numeroPokemon" data-numero="${pokemon.pokemon.numero}">Numéro Pokédex : ${pokemon.pokemon.numero}</p>
              <p class="typeIdPokemon" data-typeId="${pokemon.pokemon.typeId}">Type : ${pokemon.pokemon.nomType}</p>
              <ul id="ul-content-attack">
                <p>Attaques : </p>`;
      pokemon.attaques.forEach((attaque) => {
        document.querySelector(
          "#ul-content-attack"
        ).innerHTML += `<li>${attaque.nom}</li>`;
      });
      `</ul>
            </div>`;
    });
}

/***** On fetch sur la méthode DELETE *****/
function fetchDeletePokemon(id) {
  // Lorsqu'on clique sur le button supprimer
  document
    .querySelector(".button-delete")
    .addEventListener("click", function (e) {
      e.preventDefault();

      // On fetch sur la méthode DELETE
      fetch("api/pokemon.php?id=" + id, {
        method: "DELETE",
      })
        .then(function (response) {
          return response.json();
        })
        .then(function (data) {
          console.log(data.message); //TODO : à supprimer
          document.querySelector(
            "#content-details-pokemon"
          ).innerHTML = `<p class="message-delete">${data.message}</p>`;
        });
    });
}

/***** On fetch sur la méthode PUT avec l'id qu'on recupère depuis les paramètres de l'URL *****/
function fetchUpdatePokemon(id) {
  fetchAllTypesOnForm();

  // Au clique sur le bouton modifier, on récupère la valeur du nom et des caracteristiques actuels du type
  // Et on insère les inputs contenant les valeurs actuelles dans le formulaire de modification
  document
    .querySelector(".button-update")
    .addEventListener("click", function (e) {
      e.preventDefault();

      //On récupère la valeur des attributs des détails du pokémon
      var nomOld = document
        .querySelector(".nomPokemon")
        .getAttribute("data-nom");
      var numeroOld = document
        .querySelector(".numeroPokemon")
        .getAttribute("data-numero");
      var typeIdOld = document
        .querySelector(".typeIdPokemon")
        .getAttribute("data-typeId");
      var imageOld = document
        .querySelector(".imagePokemon")
        .getAttribute("data-image");

      //Puis on définit les valeurs des inputs du formulaire
      document.querySelector("#nom").setAttribute("value", nomOld);
      document.querySelector("#numero").setAttribute("value", numeroOld);
      document.querySelector("#typeId").options[typeIdOld - 1].selected = true;
      document.querySelector("#image").setAttribute("value", imageOld);
    });

  // On récupère le formulaire
  var form = document.querySelector("#formUpdatePokemon");

  // Lorsque le formulaire est soumis
  form.addEventListener("submit", function (e) {
    e.preventDefault();

    // On récupère la valeur des inputs
    var nom = escapeHtml(document.querySelector("#nom").value);
    var numero = escapeHtml(document.querySelector("#numero").value);
    var typeId = escapeHtml(document.querySelector("#typeId").value);
    var image = escapeHtml(document.querySelector("#image").value);

    // On créer un objet Pokemon
    let pokemon = {
      nom: nom,
      numero: numero,
      typeId: typeId,
      image: image,
    };

    console.log(pokemon); //TODO : Noooooooon

    // On fetch sur la méthode PUT avec l'id qu'on recupère depuis les paramètres de l'URL
    fetch("api/pokemon.php?id=" + id, {
      method: "PUT",
      // On convertit notre objet type en JSON
      body: JSON.stringify(pokemon),
    })
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
        // On affiche le message dans la modal
        document.querySelector(
          ".content-update-modal .message"
        ).innerHTML = `<p>${data.message}</p>`;

        // On vide la section content puis on affiche les informations du pokémon mis à jour
        document.querySelector(".content").innerHTML = "";
        fetchOnePokemon(id);
      });
  });
}
