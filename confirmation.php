<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="confirmation.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation Inscription</title>
</head>
<body>
    <?php
    // Inclure le fichier de connexion
    include_once 'db_connection.php';

    // Vérifier si l'ID est passé en paramètre
    if (isset($_GET['id'])) {
        $id = htmlspecialchars(strip_tags($_GET['id']));

        // Créer une instance de la classe Database
        $database = new Database();
        $db = $database->getConnection();

        // Requête pour récupérer les détails de l'étudiant
        $query = "SELECT id, prenom, deuxieme_prenom, nom_de_famille, sexe, date_de_naissance, adresse, ville, departement, code_postal, email, telephone, specialite,nationalite,matricule,formation,cycle,niveau,annee FROM Etudiants WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "ID non spécifié.";
        exit();
    }
    ?>
    <header>
        <div><img src="chapeau.png" alt="Logo ESTAD"></div>
        <span>ESTAD<span style="font-size: 12px;">(Ecole Supérieur des Techniques Avancées pour le
                Developpement)</span></span>
    </header>

    <section>
        <main>
            <div class="logo-container"><img src="chapeau.png" height="80px" alt="Logo"></div>
            <h1>Confirmation d'enregistrement</h1>
            <div class="details">Les détails de l'étudiant enregistré :</div>
            <div class="form-container">
                <p><strong>ID :</strong> <?php echo htmlspecialchars($etudiant['id']); ?></p>
                <p><strong>Nom :</strong> <?php echo htmlspecialchars($etudiant['nom_de_famille']); ?></p>
                <p><strong>Prénom :</strong> <?php echo htmlspecialchars($etudiant['prenom']); ?></p>
                <p><strong>Deuxième prénom :</strong> <?php echo htmlspecialchars($etudiant['deuxieme_prenom']); ?></p>
                <p><strong>Sexe :</strong> <?php echo htmlspecialchars($etudiant['sexe']); ?></p>
                <p><strong>Date de naissance :</strong> <?php echo htmlspecialchars($etudiant['date_de_naissance']); ?></p>
                <p><strong>Adresse :</strong> <?php echo htmlspecialchars($etudiant['adresse']); ?></p>
                <p><strong>Ville :</strong> <?php echo htmlspecialchars($etudiant['ville']); ?></p>
                <p><strong>Département :</strong> <?php echo htmlspecialchars($etudiant['departement']); ?></p>
                <p><strong>Code postal :</strong> <?php echo htmlspecialchars($etudiant['code_postal']); ?></p>
                <p><strong>E-mail :</strong> <?php echo htmlspecialchars($etudiant['email']); ?></p>
                <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($etudiant['telephone']); ?></p>
                <p><strong>Spécialité :</strong> <?php echo htmlspecialchars($etudiant['specialite']); ?></p>
                <p><strong>Nationalité :</strong> <?php echo htmlspecialchars($etudiant['nationalite']); ?></p>
                <p><strong>Matricule :</strong> <?php echo htmlspecialchars($etudiant['matricule']); ?></p>
                <p><strong>Formation :</strong> <?php echo htmlspecialchars($etudiant['formation']); ?></p>
                <p><strong>Cycle :</strong> <?php echo htmlspecialchars($etudiant['cycle']); ?></p>
                <p><strong>Niveau :</strong> <?php echo htmlspecialchars($etudiant['niveau']); ?></p>
                <p><strong>Annee :</strong> <?php echo htmlspecialchars($etudiant['annee']); ?></p>
            </div>
            <div class="actions">
                <button onclick="window.location.href='index.php'">Retour à l'accueil</button>
                <button onclick="window.print()">Imprimer la demande</button>
            </div>
        </main>
    </section>

    <footer>
        <div><img src="chapeau.png" alt="Logo ESTAD"></div>
        <span>copyrigth&copy; 2024 ESTAD University</span>
    </footer>
</body>
</html>
