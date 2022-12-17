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
//TODO : ceci est un controleur
// On instancie la base de données
$database = new Database();
$db = $database->getConnection();

// On instancie un nouvel objet de la class Type
$attaque = new Attaque($db);

// On vérifie que la méthode utilisée est correcte
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET["name"])) {
        $attaque = $attaque->findOneByName($_GET["name"]);

        // On vérifie si les attaques existent
        if ($attaque) {

            // On envoie le code réponse 200 OK
            http_response_code(200);

            // On encode en json et on envoie
            echo json_encode($attaque);
        } else {
            // 404 Not found
            http_response_code(404);

            echo json_encode(array("message" => "Aucune attaque comportant ce nom."));
        }
    } else {
        // On récupère les données
        $attaques = $attaque->read();

        // On vérifie si les attaques existent
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
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // On récupère les informations envoyées
    $input = json_decode(file_get_contents("php://input"));
    //TODO : étonnant : ceci devrait faire partie de ta fonction attaque->create()
    if (!empty($input->nom)) {

        // On instancie une variable pour savoir si l'attaque est unique
        $uniqueAttack = true;

        // On compare si l'attaque existe déjà dans la base de données
        $attaques = $attaque->read();
        foreach ($attaques as $value) {
            if ($value['nom'] == $input->nom) {
                $uniqueAttack = false;
            }
        }

        // On définit la propriété nom de l'objet attaque par la valeur du input
        $attaque->nom = $input->nom;

        // si uniqueAttack est égal à true
        if ($uniqueAttack == true) {
            if ($attaque->create()) {
                // On envoie un code 201
                http_response_code(201);
                echo json_encode(["message" => "L'ajout a été effectué", "status" => 200]);
            } else {
                // On envoie un code 503
                http_response_code(503);
                echo json_encode(["message" => "L'ajout n'a pas été effectué"]);
            }
        } else {
            // On envoie un code 503
            http_response_code(503);
            echo json_encode(["message" => "Ce nom existe déjà"]);
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == "PUT") {
    // Si l'id dans l'url n'est pas vide
    if (!empty($_GET["id"])) {
        // On récupère les informations envoyées
        $input = json_decode(file_get_contents("php://input"));

        if (!empty($input->nom)) {
            $attaque->id = $_GET["id"];
            $attaque->nom = $input->nom;

            if ($attaque->update()) {
                // Ici la modification a fonctionné
                // On envoie un code 200
                http_response_code(200);
                echo json_encode(["message" => "La modification a été effectuée", "status" => 200]);
            } else {
                // Ici la création n'a pas fonctionné
                // On envoie un code 503
                http_response_code(503);
                echo json_encode(["message" => "La modification n'a pas été effectuée"]);
            }
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {

    $input = json_decode(file_get_contents("php://input"));

    // Si l'id dans l'url n'est pas vide
    if (!empty($_GET["id"])) {

        $attaque->id = $_GET["id"];

        if ($attaque->findOneById($_GET["id"])) { //TODO ; je pense que ce cas pourrait être délégué à la fonction delete
            if ($attaque->delete()) {
                // Ici la suppression a fonctionné
                // On envoie un code 200
                http_response_code(200);
                echo json_encode(["message" => "La suppression a été effectuée", "status" => 200]);
            } else {
                // Ici la création n'a pas fonctionné
                // On envoie un code 503
                http_response_code(503);
                echo json_encode(["message" => "La suppression n'a pas été effectuée"]);
            }
        } else {
            http_response_code(404);
            echo json_encode(["message" => "L'ID spécifié n'existe pas"]);
        }
    }
} else {
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
