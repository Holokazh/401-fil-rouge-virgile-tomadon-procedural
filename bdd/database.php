<?php

class Database
{
    // Propriétés de la base de données
    private $host = "localhost";
    private $db_name = "pokemon";
    private $username = "root";
    private $password = "";
    public $connexion;

    // getter pour la connexion
    public function getConnection()
    {
        // On commence par fermer la connexion si elle existait
        $this->connexion = null;

        // On essaie de se connecter
        try {
            // On instancie la connexion à mysql
            $mysql = new PDO("mysql:host=" . $this->host . ";" . $this->db_name, $this->username, $this->password);

            // On prépare la requète SQL pour créer la base de données puis on l'execute
            $pstatement = $mysql->prepare("CREATE DATABASE IF NOT EXISTS $this->db_name");
            $pstatement->execute();

            // On établie la connexion à la base de données
            $this->connexion = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);

            // On force les transactions en UTF-8
            $this->connexion->exec("set names utf8");
        } catch (PDOException $exception) {

            // On récupère les erreurs éventuelles puis on les affiches
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        // On retourne la connexion
        return $this->connexion;
    }
}
