<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PokéChill</title>

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <!-- BOOTSTRAP 5.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    <!-- My CSS -->
    <link rel="stylesheet" href="public/css/style.css">

    <!-- My JavaScript -->
    <script src="public/js/app.js" defer></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
</head>

<body>

    <header>
        <section id="header-content-title">
            <a href="index.php">
                <div>
                    <?php require "public/img/pokeball.svg" ?>
                    <h1>PokéChill</h1>
                    <?php require "public/img/pokeball.svg" ?>
                </div>
            </a>
            <p>Envie d'un pokémon pour vous tenir compagnie ? Vous êtes au bon endroit !</p>
        </section>
        <section id="header-content-nav">
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="pokemonView.php?page=1">Pokémons</a></li>
                    <li><a href="typeView.php">Types</a></li>
                    <li><a href="attaqueView.php">Attaques</a></li>
                    <li><a href="index.php?action=bdd">Réinitialiser BDD</a></li>
                </ul>
            </nav>
        </section>
    </header>

    <main>