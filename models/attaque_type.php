<?php
class Attaque_type
{
    // Connexion
    private $connexion;
    private $table = "Attaque_Type";

    // object properties
    public $attaqueId;
    public $typeId;

    /**
     * Constructeur avec $db pour la connexion à la base de données
     */
    public function __construct($db)
    {
        $this->connexion = $db;
    }

    /**
     * Ajouter une ou des attaques au type
     */
    public function addAttaqueToType()
    {
        $sql = "INSERT INTO " . $this->table . " (attaqueId, typeId) VALUES (:attaqueId, :typeId)";
        $query = $this->connexion->prepare($sql);

        // On sécurise les données
        $this->attaqueId = htmlspecialchars(strip_tags($this->attaqueId));
        $this->typeId = htmlspecialchars(strip_tags($this->typeId));

        $query->bindValue(":attaqueId", $this->attaqueId);
        $query->bindValue(":typeId", $this->typeId);

        // Exécution de la requête
        if ($query->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Afficher les attaques d'un type
     */
    //TODO : cette fonction ne semble pas utilisée
    public function readAttaquesOfType($id)
    {
        $sql = "SELECT a.nom FROM " . $this->table . " as a 
        JOIN Attaque_Type as aty ON aty.attaqueId = a.id
        JOIN Type as t ON aty.typeId = t.id
        WHERE t.id != :id";

        $queryAttaque = $this->connexion->prepare($sql);

        $queryAttaque->bindParam(":id", $id);

        $queryAttaque->execute();

        return $queryAttaque->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Afficher les attaques qui ne sont pas reliées au type
     */
    public function readAttaquesNotInType($id)
    {
        $sql = "SELECT DISTINCT a.id, a.nom FROM Attaque as a
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
     * Supprimer une ou des attaques du type
     */
    public function deleteAttaqueOfType()
    {
        // On écrit la requête
        $sql = "DELETE FROM " . $this->table . " WHERE type = :id";

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
