<?php

require_once "bdd/database.php";
//TODO : je ne comprends pas le nom de la classe, ça ne resemble pas du tout à un contrôleur
class DataController
{
    public function initBdd()
    {
        // J'instancie un objet db
        $db = new Database;
        $bdd = $db->getConnection();

        // Je récupère le contenu de mon fichier puis je l'execute
        $sql = file_get_contents("bdd/bdd-pokemon-vierge.sql");
        $bdd->query($sql);

        // Je récupère les données de l'API types depuis son url puis je les décode car c'est du JSON
        $arrayTypes = file_get_contents("https://filrouge.uha4point0.fr/V2/pokemon/types");
        $types = json_decode($arrayTypes, true);

        // J'ajoute les données de mon tableau types à ma table Type en bouclant dessus
        foreach ($types as $type) {
            $sql = "INSERT INTO Type (id, nom, caracteristique) VALUES (:id, :nom, :caracteristique)";
            $query = $bdd->prepare($sql);
            $query->bindValue(":id", htmlspecialchars($type['id']));
            $query->bindValue(":nom", htmlspecialchars($type['nom']));
            $query->bindValue(":caracteristique", htmlspecialchars($type['caracteristique']));
            $query->execute();
            $query->closeCursor();

            // J'ajoute les données de mon tableau d'attaques dans mon tableau types dans la table Attaque en bouclant dessus
            foreach ($type['attaques'] as $typeAttaque) {
                $sql = "INSERT IGNORE INTO Attaque (nom) VALUES (:nom)";
                $query = $bdd->prepare($sql);
                $query->bindValue(":nom", htmlspecialchars($typeAttaque));
                $query->execute();
                $query->closeCursor();

                // Je récupère les données de ma table Attaque
                $attaques = $bdd->query("SELECT id, nom FROM Attaque")->fetchAll();

                // Puis je boucle dans le tableau d'attaques de ma table Attaque
                foreach ($attaques as $attaque) {
                    // Et si le nom d'une attaque du tableau d'attaques du type est égale au nom d'une attaque de ma table Attaque
                    if ($typeAttaque == $attaque['nom']) {
                        // J'insère les données
                        $sql = "INSERT INTO Attaque_Type (Attaqueid, Typeid) VALUES (:attaqueid, :typeid)";
                        $query = $bdd->prepare($sql);
                        $query->bindValue(":attaqueid", htmlspecialchars($attaque['id']));
                        $query->bindValue(":typeid", htmlspecialchars($type['id']));
                        $query->execute();
                        $query->closeCursor();
                    }
                }
            }
        }

        // Je récupère les données de l'API pokémons depuis son url puis je les décode car c'est du JSON
        $arrayPokemons = file_get_contents("https://filrouge.uha4point0.fr/V2/pokemon/pokemons");
        $pokemons = json_decode($arrayPokemons, true);

        // J'ajoute les données de mon tableau pokemons à ma table Pokemon en bouclant dessus
        foreach ($pokemons as $pokemon) {
            $sql = "INSERT INTO Pokemon (nom, numero, typeId, image) VALUES (:nom, :numero, :typeId, :image)";
            $query = $bdd->prepare($sql);
            $query->bindValue(":nom", htmlspecialchars($pokemon['nom']));
            $query->bindValue(":numero", htmlspecialchars($pokemon['numero']));
            $query->bindValue(":typeId", htmlspecialchars($pokemon['type']));
            $query->bindValue(":image", htmlspecialchars($pokemon['image']));
            $query->execute();
            $query->closeCursor();
        }

        // Je ramène l'utilisateur à l'accueil grâce à la redirection de mon index
        header("location: index.php");
    }
}
