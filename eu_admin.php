<?php
    // Démarrer la session
    session_start();

    // Vérifier si les variables de session existent et les afficher
    $greeting = '';
    if(isset($_SESSION['nom']) && isset($_SESSION['prenom'])) {
        $greeting = 'Bienvenue ' . $_SESSION['prenom'] . ' ' . $_SESSION['nom'];
    } else {
        header ("location:login.php");
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ESTAD</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>EU-ESTAD</h2>
            <ul>
                <li><a href="#">Accueil</a></li>
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
                <h1><?php echo $greeting; ?></h1>
            </header>
            <div class="content">
                <!-- Contenu principal du dashboard -->
                <p>Bienvenue sur votre tableau de bord.</p>
            </div>
        </div>
    </div>
</body>
</html>
