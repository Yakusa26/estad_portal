<?php
session_start();
$greeting = '';
if(isset($_SESSION['nom']) && isset($_SESSION['prenom'])) {
    $greeting = 'Bienvenue ' . $_SESSION['prenom'] . ' ' . $_SESSION['nom'];
} else {
    $greeting = 'Les variables de session ne sont pas définies.';
}

// Inclure le fichier de connexion
include_once 'db_connection.php';

// Créer une instance de la classe Database
$database = new Database();
$db = $database->getConnection();

// Requête pour récupérer les étudiants
$query = "
    SELECT 
        e.id, 
        e.prenom, 
        e.deuxieme_prenom, 
        e.nom_de_famille, 
        e.sexe, 
        e.date_de_naissance, 
        e.email, 
        e.telephone, 
        s.libelle AS specialite, 
        e.nationalite, 
        e.matricule, 
        e.annee, 
        e.numero_ordre, 
        e.cycle, 
        e.niveau, 
        tf.libelle AS type_formation, 
        f.libelle AS filiere
    FROM 
        etudiants e
    LEFT JOIN 
        specialites s ON e.specialite_id = s.id
    LEFT JOIN 
        typesformation tf ON e.type_formation_id = tf.id
    LEFT JOIN 
        filieres f ON e.filiere_id = f.id
";
$stmt = $db->prepare($query);
$stmt->execute();

$etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des étudiants - ESTAD</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/student_list.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>EU-DASHBOARD</h2>
            <ul>
                <li><a href="eu_admin.php">Accueil</a></li>
                <li><a href="student_list.php">Les étudiants</a></li>
                <li><a href="#">Les formations</a></li>
                <li><a href="#">Les filières</a></li>
                <li><a href="#">Les spécialités</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </div>
        <div class="main-content">
            <header>
                <h1><?php echo 'Gestions des étudiants'; ?></h1>
            </header>
            <div class="content">
                <h1>Liste des étudiants d'ESTAD</h1>
                <table>
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nom & Prénom</th>
                            <th>Matricule</th>
                            <th>Type de formation</th>
                            <th>Filière</th>
                            <th>Spécialité</th>
                            <th>Cycle</th>
                            <th>Niveau</th>
                            <th>Sexe</th>
                            <th>Date de naissance</th>
                            <th>E-mail</th>
                            <th>Téléphone</th>
                            <th>Nationalité</th>
                            <th>Année</th>
                            <th>Numéro d'ordre</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($etudiants as $etudiant): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($etudiant['id']); ?></td>
                            <td><?php echo htmlspecialchars($etudiant['prenom'] . ' ' . $etudiant['deuxieme_prenom'] . ' ' . $etudiant['nom_de_famille']); ?></td>
                            <td><?php echo htmlspecialchars($etudiant['matricule']); ?></td>
                            <td><?php echo htmlspecialchars($etudiant['type_formation']); ?></td>
                            <td><?php echo htmlspecialchars($etudiant['filiere']); ?></td>
                            <td><?php echo htmlspecialchars($etudiant['specialite']); ?></td>
                            <td><?php echo htmlspecialchars($etudiant['cycle']); ?></td>
                            <td><?php echo htmlspecialchars($etudiant['niveau']); ?></td>
                            <td><?php echo htmlspecialchars($etudiant['sexe']); ?></td>
                            <td><?php echo htmlspecialchars($etudiant['date_de_naissance']); ?></td>
                            <td><?php echo htmlspecialchars($etudiant['email']); ?></td>
                            <td><?php echo htmlspecialchars($etudiant['telephone']); ?></td>
                            <td><?php echo htmlspecialchars($etudiant['nationalite']); ?></td>
                            <td><?php echo htmlspecialchars($etudiant['annee']); ?></td>
                            <td><?php echo htmlspecialchars($etudiant['numero_ordre']); ?></td>
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
