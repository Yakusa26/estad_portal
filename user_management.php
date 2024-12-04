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

// Ajouter un utilisateur
if(isset($_POST['add_user'])) {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $pseudo = $_POST['pseudo'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $profession = $_POST['profession'];
    $role = $_POST['role'];

    if(!empty($prenom) && !empty($nom) && !empty($pseudo) && !empty($mot_de_passe)) {
        $query = "INSERT INTO utilisateurs (prenom, nom, profession, role_id, pseudo, mot_de_passe) VALUES (:prenom, :nom, :profession, :role, :pseudo, :mot_de_passe);";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':profession', $profession);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe);
        echo $query;
        if($stmt->execute()) {
            $message = 'Utilisateur ajouté avec succès';
        } else {
            $error = 'Erreur lors de l\'ajout de l\'utilisateur'. $prenom . $nom . $profession . $role . $pseudo . $mot_de_passe;
        }
    } else {
        $error = 'Veuillez remplir tous les champs';
    }
}

// Supprimer un utilisateur
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM utilisateurs WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    if($stmt->execute()) {
        $message = 'Utilisateur supprimé avec succès';
    } else {
        $error = 'Erreur lors de la suppression de l\'utilisateur';
    }
}

// Requête pour récupérer les utilisateurs
$query = "SELECT u.id id, nom, prenom, profession, role_id, pseudo, r.libelle libelle FROM utilisateurs u INNER JOIN role r on r.id = u.role_id";
$stmt = $db->prepare($query);
$stmt->execute();

$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs - ESTAD</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/user_management.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>EU-DASHBOARD</h2>
            <ul>
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
                <h1>Gestion des utilisateurs</h1>
            </header>
            <div class="content">
                <?php if($message): ?>
                    <div class="message"><?php echo $message; ?></div>
                <?php endif; ?>
                <?php if($error): ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>

                <h2>Ajouter un utilisateur</h2>
                <form method="post" action="user_management.php">
                    <input type="text" name="prenom" placeholder="Prénom">
                    <input type="text" name="nom" placeholder="Nom">
                    <input type="text" name="pseudo" placeholder="Pseudo">
                    <input type="password" name="mot_de_passe" placeholder="Mot de passe">
                    <input type="text" name="profession" placeholder="Profession">
                    <select name="role">
                        <option value="1">Super Administrateur</option>
                        <option value="2">Administrateur</option>
                    </select>
                    <button type="submit" name="add_user">Ajouter</button>
                </form>

                <h2>Liste des utilisateurs</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom & Prénom</th>
                            <th>Profession</th>
                            <th>Rôle</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($utilisateurs as $utilisateur): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($utilisateur['id']); ?></td>
                            <td><?php echo htmlspecialchars($utilisateur['prenom'] . ' ' . $utilisateur['nom']); ?></td>
                            <td><?php echo htmlspecialchars($utilisateur['profession']); ?></td>
                            <td><?php echo htmlspecialchars($utilisateur['libelle']); ?></td>
                            <td>
                                <a href="edit_user.php?id=<?php echo htmlspecialchars($utilisateur['id']); ?>">Modifier</a>
                                <a href="user_management.php?delete=<?php echo htmlspecialchars($utilisateur['id']); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur?')">Supprimer</a>
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
