
<?php
session_start();

// Inclure le fichier de connexion
include_once 'db_connection.php';

// Créer une instance de la classe Database
$database = new Database();
$db = $database->getConnection();

// Récupérer la formation à modifier
$id = isset($_GET['id']) ? $_GET['id'] : die('ID Formation non trouvé.');
$query = "SELECT * FROM typesformation WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();

$typesformation = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier si la formation existe
if(!$typesformation) {
    die('Formation non trouvé.');
}

// Mettre à jour la Formation
if(isset($_POST['update_formation'])) {
    $typesformation = $_POST['libelle'];

    if(!empty($typesformation )) {
        $query = "UPDATE typesformation SET libelle = :libelle, WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':libelle', $typesformation);
        $stmt->bindParam(':id', $id);
        if($stmt->execute()) {
            header('Location: type_of_formation.php');
            exit();
        } else {
            $error = 'Erreur lors de la mise à jour de la formation';
        }
    } else {
        $error = 'Veuillez a nouveau remplir le champs';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'utilisateur - ESTAD</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/user_management.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>EU-ESTAD</h2>
            <ul>
                <li><a href="eu_admin.php">Accueil</a></li>
                <li><a href="student_list.php">Les étudiants</a></li>
                <li><a href="user_management.php">Les utilisateurs</a></li>
                <li> <a href="type_of_formations">Les formations</a> </li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </div>
        <div class="main-content">
            <header>
                <h1>Modifier la Formation</h1>
            </header>
            <div class="content">
                <?php if(isset($error) && $error): ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="post" action="edit_formation.php?id=<?php echo htmlspecialchars($id); ?>">
                    <input type="text" name="libelle" placeholder="Libelle" value="<?php echo htmlspecialchars($typesformation['libelle']); ?>">
                    <button type="submit" name="update_formation">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
    <footer>
        <div><img src="assets/images/chapeau.png" alt="Logo ESTAD"></div>
        <span>copyright&copy; 2024 ESTAD University</span>
    </footer>
</body>
</html>
