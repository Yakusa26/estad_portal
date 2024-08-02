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
    $query = "SELECT mot_de_passe, pseudo, nom, prenom, role_id, profession FROM `utilisateurs` WHERE pseudo = :pseudo;";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->execute();

    // Récupérer le résultat
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $db_mot_de_passe = $row['mot_de_passe']; 
    $pseudo = $row['pseudo']; 
    $nom = $row['nom']; 
    $prenom = $row['prenom']; 
    $role_id = $row['role_id']; 
    $profession = $row['profession']; 

    if ($mot_de_passe == $db_mot_de_passe) {
      //Commencer la session
      session_start();
      $_SESSION['pseudo'] = $pseudo;
      $_SESSION['nom'] = $nom;
      $_SESSION['prenom'] = $prenom;
      $_SESSION['role_id'] = $role_id;
      $_SESSION['profession'] = $profession;
      header ("location:eu_admin.php");
    }
    else
      header ("location:login.php?state=error");
 
  
    }   

    
 ?>