<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On inclut les fichiers de configuration et d'accès aux données
include_once '../bdd/database.php';
include_once '../models/attaque_type.php';

// On instancie la base de données
$database = new Database();
$db = $database->getConnection();

// On instancie un nouvel objet de la class Type
$attaque_type = new Attaque_type($db);

// On vérifie que la méthode utilisée est correcte
//TODO : concept intéressant mais est-ce utilisé ?
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (!empty($_GET["id"])) {
        // On récupère les données
        $attaques = $attaque_type->readAttaquesNotInType($_GET["id"]);

        // On vérifie si le produit existe
        if ($attaques) {

            // On envoie le code réponse 200 OK
            http_response_code(200);

            // On encode en json et on envoie
            echo json_encode($attaques);
        } else {
            // 404 Not found
            http_response_code(404);

            echo json_encode(array("message" => "Aucune attaques."));
        }
    }
}
