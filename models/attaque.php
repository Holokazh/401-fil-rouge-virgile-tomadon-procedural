<?php
class Attaque
{
    // Connexion
    private $connexion;
    private $table = "Attaque";

    // object properties
    public $id;
    public $nom;

    /**
     * Constructeur avec $db pour la connexion à la base de données
     */
    public function __construct($db)
    {
        $this->connexion = $db;
    }

    /**
     * Trouver une attaque par son ID
     */
    public function findOneById($id)
    {
        // On écrit la requête
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id";
    //TODO : éviter les *
        // On prépare la requête
        $queryType = $this->connexion->prepare($sql);

        // On sécurise les données
        $id = htmlspecialchars(strip_tags($id));

        // On attache l'id
        $queryType->bindParam(":id", $id);

        // On exécute la requête
        $queryType->execute();

        // on récupère la ligne
        return $queryType->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Afficher les attaques d'un type
     */
    public function readAttaquesOfType($id)
    {
        $sql = "SELECT a.nom FROM " . $this->table . " as a 
        JOIN Attaque_Type as aty ON aty.attaqueId = a.id
        JOIN Type as t ON aty.typeId = t.id
        WHERE t.id = :id";
        //TODO : mettre le nom de la table en propriété de la classe est une bonne idée, mais finalement tu vois ici que ça n'a pas d'intérêt
        $queryAttaque = $this->connexion->prepare($sql);

        $queryAttaque->bindParam(":id", $id);

        $queryAttaque->execute();

        return $queryAttaque->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Afficher les attaques qui ne sont pas reliées au type
     */
    //TODO  :cette fonction ne semble pas utilisée
    public function readAttaquesNotIntype($id)
    {
        $sql = "SELECT a.nom FROM " . $this->table . " as a
        JOIN Attaque_Type as aty ON a.id = aty.attaqueId
        JOIN Type as t ON t.id = aty.typeId
        WHERE aty.attaqueId IN (
            SELECT DISTINCT attaqueId FROM Attaque_Type
            WHERE attaqueId NOT IN (
                SELECT attaqueId FROM Attaque_Type
                WHERE typeId = :id
            )
        )";

        $queryAttaque = $this->connexion->prepare($sql);

        $queryAttaque->bindParam(":id", $id);

        $queryAttaque->execute();

        return $queryAttaque->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Afficher la liste des attaques
     */
    public function read()
    {
        // On écrit la requête
        $sql = "SELECT * FROM " . $this->table; //TODO : limiter le nombre de ligne retourné par la requête

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Récupérer l'attaque par son nom (le nom d'une attaque est unique)
     */
    public function findOneByName($name)
    {
        // On écrit la requête
        $sql = "SELECT * FROM " . $this->table . " WHERE nom = :nom";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        $name = htmlspecialchars(strip_tags($name));

        $query->bindValue(":nom", $name);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Ajouter une attaque
     */
    public function create()
    {
        $sql = "INSERT INTO Attaque (nom) VALUES (:nom)";
        $query = $this->connexion->prepare($sql);

        $this->nom = htmlspecialchars(strip_tags($this->nom));

        $query->bindValue(":nom", $this->nom);

        // Exécution de la requête
        if ($query->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Modifier une attaque
     */
    public function update()
    {
        // On écrit la requête
        $sql = "UPDATE " . $this->table . " SET nom = :nom WHERE id = :id";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On sécurise les données
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // On attache les variables
        $query->bindValue(":nom", $this->nom);
        $query->bindValue(':id', $this->id);

        // On exécute
        if ($query->execute()) {
            return true;
        }

        return false;
    }

    /**
     * Supprimer une attaque
     */
    public function delete()
    {
        // On écrit la requête
        $sql = "DELETE FROM " . $this->table . " WHERE id = :id";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On sécurise les données
        $this->id = htmlspecialchars(strip_tags($this->id));

        // On attache l'id
        $query->bindParam(":id", $this->id);

        // On exécute la requête
        if ($query->execute()) {
            return true;
        }

        return false;
    }
}
