<?php
 // Inclure le fichier de connexion
include_once 'db_connection.php';

 function cleanInput($data) {
    return htmlspecialchars(strip_tags($data));
}
 // Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     // Créer une instance de la classe Database et obtenir la connexion
    $database = new Database();
    $db = $database->getConnection();

    

    // Récupérer et nettoyer les données du formulaire
    $pseudo= cleanInput($_POST['pseudo']);
    $mot_de_passe= cleanInput($_POST['mot_de_passe']);
    // Préparer et exécuter la requête SQL pour compter le nombre d'étudiants pour l'année en cours et le type de formation
    $query = "SELECT mot_de_passe, nom, prenom, profession, pseudo FROM `utilisateurs` WHERE pseudo = :pseudo;";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->execute();

    // Récupérer le résultat
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $db_mot_de_passe = $row['mot_de_passe']; 
    $db_nom = $row['nom'];
    $db_prenom = $row['prenom'];
    $db_profession = $row['profession'];
    $db_pseudo = $row['pseudo'];

    if (!empty($db_mot_de_passe) && $mot_de_passe == $db_mot_de_passe) {
        //commencer la session
     session_start();
     $_SESSION['nom'] = $db_nom;
     $_SESSION['prenom'] = $db_prenom;
     $_SESSION['profession'] = $db_profession;
     $_SESSION['pseudo'] = $db_pseudo;

        header("Location: eu_admin.php");
        exit();
    } else {
        header("Location: login.php?state=error");
        exit();
     }
    }   

 ?>