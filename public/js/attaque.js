$(document).ready(function () {
  /***** On fetch sur la méthode DELETE *****/
  function fetchDeleteAttaque(id) {
    // On fetch sur la méthode DELETE
    fetch("api/attaque.php?id=" + id, {
      method: "DELETE",
    })
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
        if (data.status === 200) {
          $("#trAttackId-" + id).remove();
        }
      })
      .catch((error) => {
        console.log(error);
      });
  }

  /***** Fetch pour récupérer toutes les attaques *****/
  function fetchAllAttaques() {
    fetch("api/attaque.php", {
      method: "GET",
    })
      .then((response) => {
        return response.json();
      })
      .then((attaques) => {
        // Si data renvoie un message on l'affiche, sinon on boucle que les données que renvoie data et on les affiches
        if (attaques.message) {
          document.querySelector(
            ".content"
          ).innerHTML += `<h6 class="message-no-data">${attaques.message}</h6>`;
        } else {
          attaques.forEach((attaque) => {
            document.querySelector("#tableAttack tbody").innerHTML += `<tr id="trAttackId-${attaque.id}">
                  <td id="nameAttackId-${attaque.id}" value="${attaque.nom}"><h6>${attaque.nom}</h6></td>
                  <td class="tdAttackOptions" colspan="2">
                    <i id="delete-${attaque.id}" class="btn btn-outline-danger btn-delete-attack me-2 bi bi-trash3-fill"></i>
                    <i id="update-${attaque.id}"class="btn btn-outline-warning btn-update-attack bi bi-pencil-fill"></i>
                  </td>
                </tr>`;
          });
        }
      })
      .catch((error) => {
        console.log(error);
      });
  }

  function fetchAttackAfterCreated(name) {
    // On fetch sur la méthode POST
    fetch("api/attaque.php?name=" + name, {
      method: "GET",
    })
      .then((response) => {
        return response.json();
      })
      .then((attaque) => {
        // On vide le tbody qui va contenir les attaques
        document.querySelector("#tableAttack tbody").innerHTML += `<tr>
        <td id="nameAttackId-${attaque.id}" value="${attaque.nom}"><h6>${attaque.nom}</h6></td>
        <td class="tdAttackOptions" colspan="2">
          <i id="delete-${attaque.id}" class="btn btn-outline-danger btn-delete-attack me-2 bi bi-trash3-fill"></i>
          <i id="update-${attaque.id}"class="btn btn-outline-warning btn-update-attack bi bi-pencil-fill"></i>
        </td>
      </tr>`;
      });
  }

  /***** On fetch sur la méthode POST pour créer une attaque *****/
  function fetchCreateAttaque() {
    // On récupère le formulaire
    var form = document.getElementById("formAddAttack");

    // Lorsque le formulaire est soumis
    form.addEventListener("submit", function (e) {
      e.preventDefault();

      // On récupère la valeur du input
      var nom = escapeHtml(document.getElementById("nomAddAttack").value); //TODO : peu d'intérêt de protéger des données en js, il faut gérer ça dans le back

      // On créer un objet Attaque
      let attaque = {
        nom: nom,
      };

      // On fetch sur la méthode POST
      fetch("api/attaque.php", {
        method: "POST",
        // On convertit notre objet attaque en JSON
        body: JSON.stringify(attaque),
      })
        .then((response) => {
          return response.json();
        })
        .then((data) => {
          // On ajoute le message que contient data
          document.querySelector(".content-add-modal .message").innerHTML = ``;
          document.querySelector(
            ".content-add-modal .message"
          ).innerHTML = `<p>${data.message}</p>`;

          if (data.status == 200) {
            fetchAttackAfterCreated(attaque.nom);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    });
  }

  /***** On fetch sur la méthode PUT pour modifier une attaque *****/
  function fetchUpdateAttaque(id) {
    var nameAttackOld = $("#nameAttackId-" + id).attr("value");

    // On récupère le formulaire
    var form = document.getElementById("formUpdateAttack");

    // Lorsque le formulaire est soumis
    form.addEventListener("submit", function (e) {
      e.preventDefault();

      // On récupère la valeur du input
      var nom = escapeHtml(document.getElementById("nomUpdateAttack").value); //TODO : Idem

      // On créer un objet Attaque
      let attaque = {
        nom: nom,
      };

      // On fetch sur la méthode PUT
      fetch("api/attaque.php?id=" + id, {
        method: "PUT",
        // On convertit notre objet attaque en JSON
        body: JSON.stringify(attaque),
      })
        .then((response) => {
          return response.json();
        })
        .then(function (data) {
          $(".content .message").show();
          document.querySelector(
            ".content .message"
          ).innerHTML = `<p class="message-update">${data.message}</p>`;
          setTimeout(() => {
            $(".content .message").hide();
          }, 2000);

          if (data.status == 200) {
            $("#nameAttackId-" + id).attr("value", attaque.nom);
            $("#nameAttackId-" + id).html(`<h6>${attaque.nom}</h6>`);
            $(".btn-update-attack").prop("disabled", false);
          } else {
            $("#nameAttackId-" + id).html(`<h6>${nameAttackOld}</h6>`);
          }
        });
    });
  }

  // Quand on clique sur le bouton delete d'une attaque, on execute la fonction fetchDeleteAttaque
  $(document).on("click", ".btn-delete-attack", function () {
    var idAttack = this.getAttribute("id").replace(/^\D+/g, "");
    Swal.fire({
      title: "Êtes-vous sûr ?",
      text: "Cette action sera irrémadiable",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Oui, supprimer !",
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire(
          "Supprimée !",
          "Votre attaque a bien été supprimée",
          "success"
        );
        fetchDeleteAttaque(idAttack);
      }
    });
  });

  // Modification d'une attaque
  var btnUpdateClicked = false;

  // Au clique sur un bouton possédant la class btn-update-attack
  $(document).on("click", ".btn-update-attack", function () {
    if (btnUpdateClicked === false) {
      // On récupère l'id qu'on a passé au bouton sur lequel on a cliqué, puis on extrait uniquement les chiffres
      var idAttack = this.getAttribute("id").replace(/^\D+/g, "");

      var nameAttackOld = $("#nameAttackId-" + idAttack).attr("value");

      $("#nameAttackId-" + idAttack)
        .html(`<form id="formUpdateAttack" method="put">
              <input type="text" class="form-control me-2" id="nomUpdateAttack" value="${nameAttackOld}" required>
              <input type="submit" value="Modifier" class="btn btn-warning" id="submit">
            </form>`);

      fetchUpdateAttaque(idAttack);

      // On désactive tous les boutons modifiés puis on ré-active celui sur lequel on a cliqué
      $(".btn-update-attack").prop("disabled", true);
      $(this).prop("disabled", false);

      btnUpdateClicked = true;
    } else {
      // On réactive les boutons modifier
      $(".btn-update-attack").prop("disabled", false);

      // On récupère l'id qu'on a passé au bouton sur lequel on a cliqué, puis on extrait uniquement les chiffres
      var idAttack = this.getAttribute("id").replace(/^\D+/g, "");

      var nameAttackOld = $("#nameAttackId-" + idAttack).attr("value");

      // On annule la modification en remplacant le formulaire par le h6 de base
      $("#nameAttackId-" + idAttack).html(`<h6>${nameAttackOld}</h6>`);

      btnUpdateClicked = false;
    }
  });

  fetchAllAttaques();
  fetchCreateAttaque();
});
