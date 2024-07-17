<?php
class Database {
    // Propriétés de connexion à la base de données
    private $host = "localhost"; // Nom de l'hôte
    private $db_name = "Estad_db"; // Nom de la base de données
    private $username = "root"; // Nom d'utilisateur
    private $password = ""; // Mot de passe
    public $conn;

    // Méthode de connexion à la base de données
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8"); // Encodage UTF-8
        } catch(PDOException $exception) {
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
