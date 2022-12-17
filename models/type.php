<?php
class Type
{
    // Connexion
    private $connexion;
    private $table = "Type";

    // Propriétés de l'objet
    public $id;
    public $nom;
    public $caracteristique;

    /**
     * Constructeur avec $db pour la connexion à la base de données
     */
    public function __construct($db)
    {
        $this->connexion = $db;
    }

    /**
     * Trouver un type par son ID
     */
    public function findOneById($id)
    {
        // On écrit la requête
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id";

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
     * Afficher la liste des types
     */
    public function read()
    {
        // On écrit la requête
        $sql = "SELECT * FROM " . $this->table; //TODO : voir mes remarques précédentes

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Afficher le détail d'un type
     */
    public function readOne()
    {
        // On écrit la requête
        $sql = "SELECT t.nom, t.caracteristique FROM " . $this->table . " t 
        LEFT JOIN Attaque_Type aty ON aty.TypeId = t.id 
        LEFT JOIN Attaque a ON a.id = aty.AttaqueId 
        WHERE t.id = :id";

        // On prépare la requête
        $queryType = $this->connexion->prepare($sql);

        // On sécurise les données
        $this->id = htmlspecialchars(strip_tags($this->id));

        // On attache l'id
        $queryType->bindParam(":id", $this->id);

        // On exécute la requête
        $queryType->execute();

        // on récupère la ligne
        return $queryType->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Ajouter un type
     */
    public function create()
    {
        $sql = "INSERT INTO Type (nom, caracteristique) VALUES (:nom, :caracteristique)";
        $query = $this->connexion->prepare($sql);

        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->caracteristique = htmlspecialchars(strip_tags($this->caracteristique));

        $query->bindValue(":nom", $this->nom);
        $query->bindValue(":caracteristique", $this->caracteristique);

        // Exécution de la requête
        if ($query->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Modifier un type
     */
    public function update()
    {
        // On écrit la requête
        $sql = "UPDATE " . $this->table . " SET nom = :nom, caracteristique = :caracteristique WHERE id = :id";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On sécurise les données
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->caracteristique = htmlspecialchars(strip_tags($this->caracteristique));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // On attache les variables
        $query->bindValue(":nom", $this->nom);
        $query->bindValue(":caracteristique", $this->caracteristique);
        $query->bindValue(':id', $this->id);

        // On exécute
        if ($query->execute()) {
            return true;
        }

        return false;
    }

    /**
     * Supprimer un type
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

    /**
     * Définir à NULL le type des pokémons
     */
    public function deleteTypeOfPokemon()
    {
        // On écrit la requête
        $sql = "UPDATE Pokemon p SET typeId = NULL WHERE typeId = :id";

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
