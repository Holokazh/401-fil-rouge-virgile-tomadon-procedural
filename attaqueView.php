<?php include "template/header.php"; ?>

<!-- Section qui contient les boutons d'administration create, delete & update -->
<?php if (!isset($_GET['id'])) { ?>
  <section class="content-btn-admin">
    <button class="button-add">Créer une attaque</button>
  </section>

  <!-- On créer une section modal contenant un formulaire d'ajout de type qu'on display à none en CSS -->
  <section class="content-add-modal">

    <div class="message"></div>

    <form id="formAddAttack" method="post">
      <div class="mb-3 text-center">
        <label for="nom" class="form-label">Nom de l'attaque</label>
        <input type="text" class="form-control" id="nomAddAttack" placeholder="Nom de l'attaque" required>
      </div>

      <input type="submit" value="Ajouter" class="btn btn-success" id="submit">
    </form>

  </section>
<?php } ?>

<!-- Contenu principal -->
<section class="content">

  <div class="message"></div>

  <table id="tableAttack" class="table">
    <thead>
      <tr>
        <th scope="col">Attaque</th>
        <th scope="col" class="thAttackOptions">Options</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>

</section>

<!-- Import sur JS pour les attaques -->
<script src="./public/js/attaque.js"></script>

<?php include "template/footer.php" ?>