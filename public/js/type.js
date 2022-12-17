/***** Fetch pour récupérer tout les types *****/
function fetchAllTypes() {
  fetch("api/type.php", {
    method: "GET",
  })
    .then((response) => response.json())
    .then((types) => {
      // On insère la section qui va contenir les types
      document.querySelector(".content").innerHTML =
        "<section id='content-type'></section>";

      // Si data renvoie un message on l'affiche, sinon on boucle que les données que renvoie data et on les affiches
      if (types.message) {
        document.querySelector(
          "#content-type"
        ).innerHTML += `<h6>${types.message}</h6>`;
      } else {
        types.forEach((type) => {
          document.querySelector(
            "#content-type"
          ).innerHTML += `<a href="?id=${type.id}">
                <h2>${type.nom}</h2>
                <p>${type.caracteristique}</p>
              </a>`;
        });
      }
    });
}

/***** On fetch sur la méthode POST pour créer un type *****/
function fetchCreateType() {
  // On récupère le formulaire
  var form = document.getElementById("formAddType");

  // Lorsque le formulaire est soumis
  form.addEventListener("submit", function (e) {
    e.preventDefault();

    // On récupère la valeur des inputs
    var nom = escapeHtml(document.getElementById("nom").value);
    var caracteristique = escapeHtml(
      document.getElementById("caracteristique").value
    );

    // On créer un objet Type
    let type = {
      nom: nom,
      caracteristique: caracteristique,
    };

    // On fetch sur la méthode POST
    fetch("api/type.php", {
      method: "POST",
      // On convertit notre objet type en JSON
      body: JSON.stringify(type),
    })
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
        // On ajoute le message que contient data
        document.querySelector(
          ".content-add-modal .message"
        ).innerHTML = `<p>${data.message}</p>`;

        // On ajoute dynamiquement le type à notre liste qu'on vient de créer
        // dans la liste des types via la fonction fetchAllTypes
        fetchAllTypes(); //TODO : tu peux optimiser ça en faisant en sorte d'affichier directement le nouvel élément au lieu de faire une nouvelle requête
      })
      // Si il y a une erreur, on l'a récupère dans un console.log
      .catch((error) => console.error("Error:", error));
  });
}

/***** Fetch pour récupérer les données d'un pokémon via l'id passé en paramètre de l'URL *****/
function fetchOneType(id) {
  fetch("api/type.php?id=" + id, {
    method: "GET",
  })
    .then((response) => response.json())
    .then((type) => {
      console.log(type); //TODO : delete
      document.querySelector(".content").innerHTML =
        "<section id='content-details-type'></section>";
      document.querySelector(
        "#content-details-type"
      ).innerHTML += `<div id="div-content-details-type">
              <h2 class="nomType" data-nom="${type.type.nom}">${type.type.nom}</h2>
              <p class="caracteristiqueType" data-caracteristique="${type.type.caracteristique}">${type.type.caracteristique}</p>
              <ul id="ul-content-attack">
                <p>Attaques : </p>`;
      type.attaques.forEach((attaque) => {
        document.querySelector(
          "#ul-content-attack"
        ).innerHTML += `<li>${attaque.nom}</li>`;
      });
      `</ul>
            </div>`;
    });
}

/***** On fetch sur la méthode DELETE *****/
function fetchDeleteType(id) {
  // Lorsqu'on clique sur le button supprimer
  document
    .querySelector(".button-delete")
    .addEventListener("click", function (e) {
      e.preventDefault();

      // On fetch sur la méthode DELETE
      fetch("api/type.php?id=" + id, {
        method: "DELETE",
      })
        .then(function (response) {
          return response.json();
        })
        .then(function (data) {
          console.log(data.message);//TODO : y'en a trooop
          document.querySelector(
            "#content-details-type"
          ).innerHTML = `<p class="message-delete">${data.message}</p>`;
        });
    });
}

/***** On fetch sur la méthode PUT avec l'id qu'on recupère depuis les paramètres de l'URL *****/
function fetchUpdateType(id) {
  // Au clique sur le bouton modifier, on récupère la valeur du nom et des caracteristiques actuels du type
  // Et on insère les inputs contenant les valeurs actuelles dans le formulaire de modification
  document
    .querySelector(".button-update")
    .addEventListener("click", function (e) {
      e.preventDefault();

      //On récupère la valeur des attributs
      var nomOld = document.querySelector(".nomType").getAttribute("data-nom");
      var caracteristiqueOld = document
        .querySelector(".caracteristiqueType")
        .getAttribute("data-caracteristique");

      document.getElementById("nom").setAttribute("value", nomOld);
      document.getElementById("caracteristique").innerHTML = caracteristiqueOld;
    });

  // On récupère le formulaire
  var form = document.getElementById("formUpdateType");

  // Lorsque le formulaire est soumis
  form.addEventListener("submit", function (e) {
    e.preventDefault();

    // On récupère la valeur des inputs
    var nom = escapeHtml(document.querySelector("#nom").value);
    var caracteristique = escapeHtml(
      document.querySelector("#caracteristique").value
    );

    // On créer un objet Type
    let type = {
      nom: nom,
      caracteristique: caracteristique,
    };

    // On fetch sur la méthode PUT avec l'id qu'on recupère depuis les paramètres de l'URL
    fetch("api/type.php?id=" + id, {
      method: "PUT",
      // On convertit notre objet type en JSON
      body: JSON.stringify(type),
      headers: {
        "Content-type": "application/json; charset=UTF-8",
      },
    })
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
        // On affiche le message dans la modal
        document.querySelector(
          ".content-update-modal .message"
        ).innerHTML = `<p>${data.message}</p>`;

        // On vide la section content puis on affiche les informations du type mis à jour
        document.querySelector(".content").innerHTML = "";
        fetchOneType(id); //TODO : même remarque qu'un peu plus haut, tu pourrais ne faire qu'une requête au lieu d'en faire deux
      })
      .catch((error) => console.error("Error:", error));
  });
}

function fetchAllAttackOnForm(id) {
  // On fetch sur la méthode GET pour récupérer les types et les insérer dans le select
  fetch("api/attaque_type.php?id=" + id, {
    method: "get",
  })
    .then((response) => {
      return response.json();
    })
    .then((attaques) => {
      document.querySelector("#attaqueId").innerHTML = ``;
      attaques.forEach((attaque) => {
        document.querySelector(
          "#attaqueId"
        ).innerHTML += `<option value="${attaque.id}">${attaque.nom}</option>`;
      });
    });
}

/***** On fetch sur la méthode POST pour ajouter une attaque à un type *****/
function fetchAddAttackToType(id) {
  fetchAllAttackOnForm(id);

  // On récupère le formulaire
  var form = document.getElementById("formAddAttackToType");

  // Lorsque le formulaire est soumis
  form.addEventListener("submit", function (e) {
    e.preventDefault();

    // On récupère la valeur des inputs
    var attaqueId = escapeHtml(document.getElementById("attaqueId").value);

    // On créer un objet Type
    let attaque = {
      attaqueId: attaqueId,
    };

    // On fetch sur la méthode POST
    fetch("api/type.php?id=" + id, {
      method: "POST",
      // On convertit notre objet type en JSON
      body: JSON.stringify(attaque),
    })
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
        // On ajoute le message que contient data
        document.querySelector(
          ".content-add-attackToType-modal .message"
        ).innerHTML = `<p>${data.message}</p>`;

        fetchOneType(id); //TODO : Même problème
        fetchAllAttackOnForm(id); //TODO : Idem
      });
  });
}
