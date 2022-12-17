<?php
include "template/header.php";

// On inclut les fichiers de configuration et d'accès aux données
include_once './bdd/database.php';
include_once './models/pokemon.php';

// On instancie la base de données
$database = new Database();
$db = $database->getConnection();

// On instancie un nouvel objet de la class Type
$pokemon = new Pokemon($db); ?>

<?php
// Si l'id dans l'url n'est pas vide
if (isset($_GET["id"])) {
  if (!$pokemon->findOneById($_GET["id"])) { ?>
    <section class='content'>
      <p id='invalidIdMessage'>ID invalide</p>
    </section>
  <?php  } else { ?>
    <section class="content-btn-admin">
      <button class="btn btn-sm btn-warning me-2 button-update">Modifier</button>
      <button class="btn btn-sm btn-danger button-delete">Supprimer</button>
    </section>

    <!-- On créer une section modal contenant le formulaire de modification du type qu'on display à none en CSS -->
    <section class="content-update-modal">

      <div class="message"></div>

      <form id="formUpdatePokemon" method="put">

        <div class="mb-3 text-center">
          <label for="nom" class="form-label">Nom du pokémon</label>
          <input type="text" class="form-control" id="nom" placeholder="Nom du pokémon" required>
        </div>
        <div class="col-2 mb-3 text-center">
          <label for="numero" class="form-label">N° pokédex</label>
          <input type="number" class="form-control" id="numero" placeholder="N°" required>
        </div>
        <div class="mb-3 text-center">
          <label for="typeId" class="form-label">Choisissez le type du pokémon</label>
          <select class="form-select" id="typeId">
          </select>
        </div>
        <div class="col-10 mb-3 text-center">
          <label for="image" class="form-label">Image du pokémon</label>
          <input type="url" id="image" class="form-control" placeholder="https://example.com" pattern="https://.*|http://.*" required>
        </div>

        <input type="submit" value="Modifier" class="btn btn-warning" id="submit">

      </form>

    </section>
  <?php } ?>
<?php } else { ?>
  <section class="content-btn-admin">
    <button class="button-add">Créer un pokémon</button>
  </section>

  <!-- On créer une section modal contenant un formulaire d'ajout de type qu'on display à none en CSS -->
  <section class="content-add-modal">

    <div class="message"></div>

    <form id="formAddPokemon" method="post">

      <div class="mb-3 text-center">
        <label for="nom" class="form-label">Nom du pokémon</label>
        <input type="text" class="form-control" id="nom" placeholder="Nom du pokémon" required>
      </div>
      <div class="col-2 mb-3 text-center">
        <label for="numero" class="form-label">N° pokédex</label>
        <input type="number" class="form-control" id="numero" placeholder="N°" required>
      </div>
      <div class="mb-3 text-center">
        <label for="typeId" class="form-label">Choisissez le type du pokémon</label>
        <select class="form-select" id="typeId" aria-label="Default select example">
          <option selected>Type du pokémon</option>
        </select>
      </div>
      <div class="col-10 mb-3 text-center">
        <label for="image" class="form-label">Image du pokémon</label>
        <input type="url" id="image" class="form-control" placeholder="https://example.com" required>
      </div>

      <input type="submit" value="Ajouter" class="btn btn-success" id="submit">

    </form>

  </section>
<?php } ?>


<!-- Contenu principal -->
<section class="content">
</section>

<!-- Pagination -->
<?php if (!isset($_GET["id"])) { ?>
  <section class="content-pagination">
    <nav>
      <ul class="pagination">
      </ul>
    </nav>
  </section>
<?php } ?>


<?php include "template/footer.php" ?>


<!-- Import sur JS pour les pokémons -->
<script src="./public/js/pokemon.js"></script>

<!-- Execution des fonctions -->
<script>
  <?php if (isset($_GET['id'])) {
    $id = $_GET['id'] ?>

    fetchOnePokemon(<?= $id ?>)
    fetchDeletePokemon(<?= $id ?>)
    fetchUpdatePokemon(<?= $id ?>)

  <?php } else { ?>

    <?php if (isset($_GET['page'])) {

      $page = $_GET['page']; ?>
      fetchAllPokemons(<?= $page ?>)

    <?php } ?>

    fetchCreatePokemon()

  <?php } ?>
</script>