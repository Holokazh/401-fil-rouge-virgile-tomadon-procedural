<?php
require_once "controllers/dataController.php";
$ctrlData = new DataController();

// Récuperation de l'action dans l'URL
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'bdd') {
        $ctrlData->initBdd();
    }
}
?>

<?php require_once "template/header.php" ?>

<section class="content">
    <section class="content-home">
        <h3 id="homeTitle">ACCUEIL DU FIL ROUGE VIRGILE TOMADON</h3>
    </section>
</section>

<?php require_once "template/footer.php" ?>