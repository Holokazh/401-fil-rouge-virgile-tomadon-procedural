<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On inclut les fichiers de configuration et d'accès aux données
include_once '../bdd/database.php';
include_once '../models/type.php';
include_once '../models/attaque.php';
include_once '../models/attaque_type.php';

// On instancie la base de données
$database = new Database();
$db = $database->getConnection();

// On instancie un nouvel objet de la class Type
$type = new Type($db);

// On vérifie que la méthode utilisée est correcte
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    // Si l'id dans l'url n'est pas vide
    if (!empty($_GET["id"])) {
        // On définit l'id en le récupérant dans l'URL
        $type->id = $_GET["id"];

        // On récupère les données du type
        $detailsType = $type->readOne();

        $attaque = new Attaque($db);

        // On récupère les attaques du type
        $attaquesType = $attaque->readAttaquesOfType($type->id);

        // On créé un tableau multidimenssinnel
        $type = array(
            'type' => $detailsType,
            'attaques' => $attaquesType
        );

        // On vérifie si le produit existe
        if ($type['type']['nom'] != null) {

            // On envoie le code réponse 200 OK
            http_response_code(200);

            // On encode en json et on envoie
            echo json_encode($type);
        } else {
            // 404 Not found
            http_response_code(404);

            echo json_encode(array("message" => "Le type n'existe pas."));
        }
    } else {
        // On récupère les données
        $types = $type->read();

        // On vérifie si le produit existe
        if ($types) {

            // On envoie le code réponse 200 OK
            http_response_code(200);

            // On encode en json et on envoie
            echo json_encode($types);
        } else {
            // 404 Not found
            http_response_code(404);

            echo json_encode(array("message" => "Aucun type."));
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // On récupère les informations envoyées
    $input = json_decode(file_get_contents("php://input"));

    $attaque_type = new Attaque_type($db);

    if (!empty($_GET["id"])) {
        if (!empty($input->attaqueId)) {
            $attaque_type->attaqueId = $input->attaqueId;
            $attaque_type->typeId = $_GET["id"];

            if ($attaque_type->addAttaqueToType()) {
                // On envoie un code 201
                http_response_code(201);
                echo json_encode(["message" => "L'ajout a été effectué"]);
            } else {
                // On envoie un code 503
                http_response_code(503);
                echo json_encode(["message" => "L'ajout n'a pas été effectué"]);
            }
        }
    } else {
        if (!empty($input->nom) && !empty($input->caracteristique)) {
            $type->nom = $input->nom;
            $type->caracteristique = $input->caracteristique;

            if ($type->create()) {
                // On envoie un code 201
                http_response_code(201);
                echo json_encode(["message" => "L'ajout a été effectué"]);
            } else {
                // On envoie un code 503
                http_response_code(503);
                echo json_encode(["message" => "L'ajout n'a pas été effectué"]);
            }
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == "PUT") {
    // Si l'id dans l'url n'est pas vide
    if (!empty($_GET["id"])) {
        // On récupère les informations envoyées
        $input = json_decode(file_get_contents("php://input"));

        if (!empty($input->nom) && !empty($input->caracteristique)) {
            $type->id = $_GET["id"];
            $type->nom = $input->nom;
            $type->caracteristique = $input->caracteristique;

            if ($type->update()) {
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

        $type->id = $_GET["id"];

        if ($type->deleteTypeOfPokemon() && $type->delete()) { //TODO : Si ta base de donnée était correctement paramétrée, tu n'aurais pas besoin de faire ça.
            // Ici la suppression a fonctionné
            // On envoie un code 200
            http_response_code(200);
            echo json_encode(["message" => "La suppression a été effectuée"]);
        } else {
            // Ici la création n'a pas fonctionné
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
