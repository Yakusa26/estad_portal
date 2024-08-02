
<?php
 session_start();
 
// Inclure le fichier de connexion
include_once 'db_connection.php';

// Créer une instance de la classe Database
$database = new Database();
$db = $database->getConnection();

// Variables pour les messages
$message = '';
$error = '';

// Ajouter une Formation
if(isset($_POST['add_formation'])) {
    $typesformation = $_POST['Libelle'];

    if(!empty( $typesformation)) {
        $query = "INSERT INTO typesformation (libelle) VALUES (:libelle);";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':libelle', $typesformation);
        
        if($stmt->execute()) {
            $message = 'Formation ajouté avec succès';
        } else {
            $error = 'Erreur lors de l\'ajout de la Formation'. $typesformation ;
        }
    } else {
        $error = 'Veuillez remplir le champs';
    }
}

// Supprimer une Formation
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM typesformation WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    if($stmt->execute()) {
        $message = 'Formation supprimé avec succès';
    } else {
        $error = 'Erreur lors de la suppression de la Formation';
    }
}




// Requête pour récupérer les formations
$query = "
    SELECT id,
   libelle AS types_formation 
   FROM
    `typesformation`
";
$stmt = $db->prepare($query);
$stmt->execute();

$typesformation = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/types_of_formations.css">
    <title>Types_of_formations</title>
</head>
<body>
<div class="container">
        <div class="sidebar">
            <h2>EU-DASHBOARD</h2>
            <ul>
                <li><a href="eu_admin.php">Accueil</a></li>
                <li><a href="student_list.php">Les étudiants</a></li>
                <li><a href="user_management.php">Les utilisateurs</a></li>
                <li><a href="type_of_formation.php">Les formations</a></li>
                <li><a href="#">Les filières</a></li>
                <li><a href="#">Les filières par formation</a></li>
                <li><a href="#">Les spécialités</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </div>
        <div class="main-content">
            <header>
                <h1><?php echo 'Gestion des types de formation'; ?></h1>
            </header>
            <div class="content">
                <h1>Ajouter un type de formation</h1>

                <form method="post" action="type_of_formation.php">
                <input type="text" name="Libelle" placeholder="Libelle"> <br>
                <button type = "submit" name="add_formation">Ajouter</button>
                </form>
               
                <h1>Liste des types de formations</h1>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>libelle</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($typesformation as $types_formation): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($types_formation['id'] ?? 'N/A'); ?></td>
                           <td><?php echo htmlspecialchars($types_formation['types_formation'] ?? 'N/A'); ?></td>
                           <td>
                                <a href="edit_formation.php?id=<?php echo htmlspecialchars($types_formation['id']); ?>">Modifier</a>
                                <a href="type_of_formation.php?delete=<?php echo htmlspecialchars($types_formation['id']); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur?')">Supprimer</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <footer>
        <div><img src="assets/images/chapeau.png" alt="Logo ESTAD"></div>
        <span>copyright&copy; 2024 ESTAD University</span>
    </footer>
</body>
</html>
