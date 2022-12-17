<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On inclut les fichiers de configuration et d'accès aux données
include_once '../bdd/database.php';
include_once '../models/pokemon.php';
include_once '../models/attaque.php';

// On instancie la base de données
$database = new Database();
$db = $database->getConnection();

// On instancie un nouvel objet de la class Pokemon
$pokemon = new Pokemon($db);

// On vérifie que la méthode utilisée est correcte
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    // Si l'id dans l'url n'est pas vide
    if (!empty($_GET["id"])) {
        // On définie l'id en le récupérant dans l'URL
        $pokemon->id = $_GET["id"];

        // On récupère les données du pokemon
        $detailsPokemon = $pokemon->readOne();

        $attaque = new Attaque($db);

        // On récupère les attaques du type
        $attaquesType = $attaque->readAttaquesOfType($detailsPokemon['typeId']);

        // On créer un tableau multidimenssinnel
        $pokemon = array(
            'pokemon' => $detailsPokemon,
            'attaques' => $attaquesType
        );

        // On vérifie si le pokémon existe
        if ($pokemon['pokemon']['nom'] != null) {

            // On envoie le code réponse 200 OK
            http_response_code(200);

            // On encode en json et on envoie
            echo json_encode($pokemon);
        } else {
            // 404 Not found
            http_response_code(404);

            echo json_encode(array("message" => "Le pokemon n'existe pas."));
        }
    } else {
        if (!empty($_GET["page"])) {
            // On créer un tableau multidimenssinnel
            $pokemons = array(
                'pokemons' => $pokemon->read($_GET["page"]),
                'nbPage' => $pokemon->nbPage()
            );
        }

        // On vérifie si il y a des pokémons
        if ($pokemons['pokemons']) {

            // On envoie le code réponse 200 OK
            http_response_code(200);

            // On encode en json et on envoie
            echo json_encode($pokemons);
        } else {
            // 404 Not found
            http_response_code(404);

            echo json_encode(array("message" => "Aucun pokémon."));
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // On récupère les informations envoyées par le formulaire
    $input = json_decode(file_get_contents("php://input"));

    if (!empty($input->nom) && !empty($input->numero) && !empty($input->typeId) && !empty($input->image)) {
        $pokemon->nom = $input->nom;
        $pokemon->numero = $input->numero;
        $pokemon->typeId = $input->typeId;
        $pokemon->image = $input->image;

        if ($pokemon->create()) {
            // On envoie un code 201
            http_response_code(201);
            echo json_encode(["message" => "L'ajout a été effectué", "status" => 201]);
        } else {
            // On envoie un code 503
            http_response_code(503);
            echo json_encode(["message" => "L'ajout n'a pas été effectué"]);
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == "PUT") {
    // Si l'id dans l'url n'est pas vide
    if (!empty($_GET["id"])) {
        // On récupère les informations envoyées
        $input = json_decode(file_get_contents("php://input"));

        if (!empty($input->nom) && !empty($input->numero) && !empty($input->typeId) && !empty($input->image)) {
            $pokemon->id = $_GET["id"];
            $pokemon->nom = $input->nom;
            $pokemon->numero = $input->numero;
            $pokemon->typeId = $input->typeId;
            $pokemon->image = $input->image;

            if ($pokemon->update()) {
                // Ici la modification a fonctionné
                // On envoie un code 200
                http_response_code(200);
                echo json_encode(["message" => "La modification a été effectuée"]);
            } else {
                // Ici la création n'a pas fonctionné
                // On envoie un code 503
                http_response_code(503);
                echo json_encode(["message" => "La modification n'a pas été effectuée"]);
            }
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
    // Si l'id dans l'url n'est pas vide
    if (!empty($_GET["id"])) {

        $pokemon->id = $_GET["id"];

        // Si le pokémon est supprimé
        if ($pokemon->delete()) {
            // On envoie un code 200
            http_response_code(200);
            echo json_encode(["message" => "La suppression a été effectuée"]);
        } else {
            // On envoie un code 503
            http_response_code(503);
            echo json_encode(["message" => "La suppression n'a pas été effectuée"]);
        }
    }
} else {
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
