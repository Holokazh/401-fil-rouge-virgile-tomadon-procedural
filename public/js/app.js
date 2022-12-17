function escapeHtml(str) {
  if (str === null || str === "") return false;
  // On renvoie une chaîne de caractères représentant l'objet
  else str = str.toString();

  // REGEX to identify HTML tags in the input string. Replacing the identified HTML tag with a null string.
  return str.replace(/(<([^>]+)>)/gi, "");
}

function pagination(nbPage) {
  var str = window.location.href;
  var url = new URL(str);
  var currentPage = Number(url.searchParams.get("page"));

  if (currentPage > 1) {
    previousPage = currentPage - 1;
    document.querySelector(
      ".pagination"
    ).innerHTML += `<li class="page-item"><a class="page-link my-page-link" href="?page=1"><span>&laquo;</span></a></li>
                    <li class="page-item"><a class="page-link my-page-link" href="?page=${previousPage}" id="previous">Précédent</a></li>`;
  }

  for (let i = 1; i <= nbPage; i++) {
    if (i == currentPage - 1) {
      document.querySelector(
        ".pagination"
      ).innerHTML += `<li class="page-item"><a class="page-link my-page-link" href="?page=${i}">${i}</a></li>`;
    }
    if (i == currentPage) {
      document.querySelector(
        ".pagination"
      ).innerHTML += `<li class="page-item active"><a class="page-link my-page-link" href="?page=${i}">${i}</a></li>`;
    }
    if (i == currentPage + 1) {
      document.querySelector(
        ".pagination"
      ).innerHTML += `<li class="page-item"><a class="page-link my-page-link" href="?page=${i}">${i}</a></li>`;
    }
  }

  if (currentPage < nbPage) {
    nextPage = currentPage + 1;
    document.querySelector(
      ".pagination"
    ).innerHTML += `<li class="page-item"><a class="page-link my-page-link" href="?page=${nextPage}" id="next">Suivant</a></li>
                    <li class="page-item"><a class="page-link my-page-link" href="?page=${nbPage}"><span>&raquo;</span></li>`;
  }
}

$(document).ready(function () {
  // Fonction qui permet de supprimer les balises html

  // Au clique, on ouvre la div ayant la classe content-update-modal qui permet de modifier un type
  $(".button-update").click(function () {
    $(".content-update-modal").toggle();
    $(".message").html("");
  });

  // Au clique, j'ouvre la div ayant la classe content-add-type-modal
  $(".button-add").click(function () {
    $(".content-add-modal").toggle();
    $(".message").html("");
  });

  // Au clique, j'ouvre la div ayant la classe content-add-attack-modal
  $(".button-add-attack").click(function () {
    $(".content-add-attackToType-modal").toggle();
    $(".message").html("");
  });
});
