<?php
include "template/header.php";

include_once './bdd/database.php';
include_once './models/type.php';

// On instancie la base de données
$database = new Database();
$db = $database->getConnection();

// On instancie un nouvel objet de la class Type
$type = new Type($db); ?>

<?php
// Si l'id dans l'url n'est pas vide
if (isset($_GET["id"])) {

  // Si l'id n'est pas relié à un type on affiche un message d'erreur
  if (!$type->findOneById($_GET["id"])) { ?>
    <section class='content'>
      <p id='invalidIdMessage'>ID invalide</p>
    </section>

  <?php
    // Sinon, on affiche les boutons admin modifier et supprimer ainsi que le formulaire de modification
  } else { ?>
    <section class="content-btn-admin">
      <button class="btn btn-sm btn-warning me-2 button-update">Modifier</button>
      <button class="btn btn-sm btn-danger me-2 button-delete">Supprimer</button>
      <button class="btn btn-sm btn-success button-add-attack">Ajouter une attaque</button>
    </section>

    <!-- On créer une section modal contenant le formulaire de modification du type qu'on display à none en CSS -->
    <section class="content-update-modal">

      <div class="message"></div>

      <form id="formUpdateType" method="put">
        <div class="mb-3 text-center">
          <label for="nom" class="form-label">Nom du type</label>
          <input type="text" class="form-control" id="nom" placeholder="Nom du type" value="" required>
        </div>
        <div class="mb-3 text-center">
          <label for="caracteristique" class="form-label">Description du type</label>
          <textarea class="form-control" id="caracteristique" rows="3" cols="50" placeholder="Description du type" required></textarea>
        </div>

        <input type="submit" value="Modifier" class="btn btn-warning" id="submit">
      </form>

    </section>

    <!-- On créer une section modal contenant un formulaire d'ajout d'attaques au type sur lequel 
    on se trouve que l'on display à none en CSS -->
    <section class="content-add-attackToType-modal">

      <div class="message"></div>

      <form id="formAddAttackToType" method="post">

        <div class="mb-3 text-center">
          <label for="attaqueId" class="form-label">Choisissez l'attaque</label>
          <select class="form-select" id="attaqueId" aria-label="Default select example">
          </select>
        </div>

        <input type="submit" value="Ajouter" class="btn btn-success" id="submit">
      </form>

    </section>
  <?php } ?>
<?php } else { ?>
  <section class="content-btn-admin">
    <button class="button-add">Créer un type</button>
  </section>

  <!-- On créer une section modal contenant un formulaire d'ajout de type qu'on display à none en CSS -->
  <section class="content-add-modal">

    <div class="message"></div>

    <form id="formAddType" method="post">
      <div class="mb-3 text-center">
        <label for="nom" class="form-label">Nom du type</label>
        <input type="text" class="form-control" id="nom" placeholder="Nom du type" required>
      </div>
      <div class="mb-3 text-center">
        <label for="caracteristique" class="form-label">Description du type</label>
        <textarea class="form-control" id="caracteristique" rows="3" cols="50" placeholder="Description du type" required></textarea>
      </div>

      <input type="submit" value="Ajouter" class="btn btn-success" id="submit">
    </form>

  </section>
<?php } ?>


<!-- Contenu principal -->
<section class="content">
</section>

<?php include "template/footer.php" ?>


<!-- Import sur JS pour les types -->
<script src="./public/js/type.js"></script>

<script>
  <?php if (isset($_GET['id'])) {
    $id = $_GET['id'] ?>

    fetchOneType(<?= $id ?>)
    fetchDeleteType(<?= $id ?>)
    fetchUpdateType(<?= $id ?>)
    fetchAddAttackToType(<?= $id ?>)

  <?php } else { ?>

    fetchAllTypes()
    fetchCreateType()

  <?php } ?>
</script>