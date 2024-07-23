<?php
session_start();

// Inclure le fichier de connexion
include_once 'db_connection.php';

// Créer une instance de la classe Database
$database = new Database();
$db = $database->getConnection();

// Récupérer l'utilisateur à modifier
$id = isset($_GET['id']) ? $_GET['id'] : die('ID utilisateur non trouvé.');
$query = "SELECT * FROM utilisateurs WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();

$utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier si l'utilisateur existe
if(!$utilisateur) {
    die('Utilisateur non trouvé.');
}

// Mettre à jour l'utilisateur
if(isset($_POST['update_user'])) {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $profession = $_POST['profession'];
    $role = $_POST['role'];
    $pseudo = $_POST['pseudo'];
    $mot_de_passe = $_POST['mot_de_passe'];

    if(!empty($prenom) && !empty($nom) && !empty($pseudo) && !empty($mot_de_passe)) {
        $query = "UPDATE utilisateurs SET prenom = :prenom, nom = :nom, profession = :profession, role_id = :role, pseudo = :pseudo, mot_de_passe = :mot_de_passe WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':profession', $profession);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe);
        $stmt->bindParam(':id', $id);
        if($stmt->execute()) {
            header('Location: user_management.php');
            exit();
        } else {
            $error = 'Erreur lors de la mise à jour de l\'utilisateur';
        }
    } else {
        $error = 'Veuillez remplir tous les champs';
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
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </div>
        <div class="main-content">
            <header>
                <h1>Modifier l'utilisateur</h1>
            </header>
            <div class="content">
                <?php if(isset($error) && $error): ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="post" action="edit_user.php?id=<?php echo htmlspecialchars($id); ?>">
                    <input type="text" name="prenom" placeholder="Prénom" value="<?php echo htmlspecialchars($utilisateur['prenom']); ?>">
                    <input type="text" name="nom" placeholder="Nom" value="<?php echo htmlspecialchars($utilisateur['nom']); ?>">
                    <input type="text" name="profession" placeholder="Profession" value="<?php echo htmlspecialchars($utilisateur['profession']); ?>">
                    <input type="text" name="pseudo" placeholder="Pseudo" value="<?php echo htmlspecialchars($utilisateur['pseudo']); ?>">
                    <input type="password" name="mot_de_passe" placeholder="Mot de passe" value="<?php echo htmlspecialchars($utilisateur['mot_de_passe']); ?>">
                    <select name="role">
                        <option value="1" <?php echo $utilisateur['role_id'] == '1' ? 'selected' : ''; ?>>Super Administrateur</option>
                        <option value="2" <?php echo $utilisateur['role_id'] == '2' ? 'selected' : ''; ?>>Administrateur</option>
                    </select>
                    <button type="submit" name="update_user">Mettre à jour</button>
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
