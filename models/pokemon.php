<?php
class Pokemon
{
    // Connexion
    private $connexion;
    private $table = "Pokemon";

    // object properties
    public $id;
    public $nom;
    public $numero;
    public $typeId;
    public $image;

    /**
     * Constructeur avec $db pour la connexion à la base de données
     */
    public function __construct($db)
    {
        $this->connexion = $db;
    }

    /**
     * Trouver un pokemon par son ID
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
     * Afficher la liste des pokémons
     */
    public function read($page = 1)
    {
        $limit = 6;
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM " . $this->table . " LIMIT :limit OFFSET :offset";
        $query = $this->connexion->prepare($sql);
        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->bindValue(":offset", $offset, PDO::PARAM_INT);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Compte le nombre de pokémons
     */
    public function nbPokemon()
    {
        $sql = "SELECT COUNT(id) as nbPokemon FROM " . $this->table;
        $query = $this->connexion->prepare($sql);
        $query->execute();

        // On retourne le résultat
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Compte le nombre de pages
     */
    public function nbPage()
    {
        $limit = 6;
        $nbPokemon = self::nbPokemon(); //TODO : utiliser this
        $nbPokemon = $nbPokemon["nbPokemon"];
        return ceil($nbPokemon / $limit);
    }

    /**
     * Afficher le détail d'un pokémon
     */
    public function readOne()
    {
        // On écrit la requête
        $sql = "SELECT t.nom as nomType, p.id, p.nom, p.numero, p.typeId, p.image FROM " . $this->table . " p 
        LEFT JOIN Type t ON t.id = p.typeId 
        LEFT JOIN Attaque_Type aty ON aty.TypeId = t.id 
        LEFT JOIN Attaque a ON a.id = aty.AttaqueId 
        WHERE p.id = :id";

        // $sql = "SELECT * FROM " . $this->table . " WHERE id = :id";

        // On prépare la requête
        $queryPokemon = $this->connexion->prepare($sql);

        // On sécurise les données
        $this->id = htmlspecialchars(strip_tags($this->id));

        // On attache l'id
        $queryPokemon->bindParam(":id", $this->id);

        // On exécute la requête
        $queryPokemon->execute();

        // on récupère la ligne
        return $queryPokemon->fetch(PDO::FETCH_ASSOC);
    }

    public function readAttaquesOfType($id)
    {
        $sql2 = "SELECT a.nom FROM Attaque as a 
        JOIN Attaque_Type as aty ON aty.attaqueId = a.id
        JOIN Type as t ON aty.typeId = t.id
        WHERE t.id = :id";

        $queryAttaque = $this->connexion->prepare($sql2);

        $queryAttaque->bindParam(":id", $id);

        $queryAttaque->execute();

        return $queryAttaque->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Ajouter un pokémon
     */
    public function create()
    {
        $sql = "INSERT INTO " . $this->table . " (nom, numero, typeId, image) VALUES (:nom, :numero, :typeId, :image)";
        $query = $this->connexion->prepare($sql);

        $this->nom = htmlspecialchars(strip_tags($this->nom)); //TODO : strip_tags devrait suffire
        $this->numero = htmlspecialchars(strip_tags($this->numero));
        $this->typeId = htmlspecialchars(strip_tags($this->typeId));
        $this->image = htmlspecialchars(strip_tags($this->image));

        $query->bindValue(":nom", $this->nom);
        $query->bindValue(":numero", $this->numero);
        $query->bindValue(":typeId", $this->typeId);
        $query->bindValue(":image", $this->image);

        // Exécution de la requête
        if ($query->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Modifier un pokemon
     */
    public function update()
    {
        // On écrit la requête
        $sql = "UPDATE " . $this->table . " SET nom = :nom, numero = :numero, typeId = :typeId, image = :image WHERE id = :id";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On sécurise les données
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->numero = htmlspecialchars(strip_tags($this->numero));
        $this->typeId = htmlspecialchars(strip_tags($this->typeId));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // On attache les variables
        $query->bindValue(":nom", $this->nom);
        $query->bindValue(":numero", $this->numero);
        $query->bindValue(":typeId", $this->typeId);
        $query->bindValue(":image", $this->image);
        $query->bindValue(':id', $this->id);

        // On exécute
        if ($query->execute()) {
            return true;
        }

        return false;
    }

    /**
     * Supprimer un pokémon
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
