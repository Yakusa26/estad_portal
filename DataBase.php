<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="Database.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESTAD</title>
    
</head>

<body>
    <?php
    // Inclure le fichier de connexion
    include_once 'db_connection.php';

    // Créer une instance de la classe Database
    $database = new Database();
    $db = $database->getConnection();

    // Requête pour récupérer les étudiants
    $query = "SELECT id, prenom, deuxieme_prenom, nom_de_famille, sexe, date_de_naissance, email, telephone, specialite,nationalite,matricule,formation,cycle,niveau,annee,numero_ordre FROM Etudiants";
    $stmt = $db->prepare($query);
    $stmt->execute();

    $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

<header>
        <div><img src="chapeau.png" alt="Logo ESTAD"></div>
        <span>ESTAD<span style="font-size: 12px;">(Ecole Supérieur des Techniques Avancées pour le
                Developpement)</span></span>
    </header>


    <section>
        <main>
            <h1>Base de données des étudiants d'ESTAD</h1>
            <table>
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nom & Prénom</th>
                        <th>Sexe</th>
                        <th>Date de naissance</th>
                        <th>E-mail</th>
                        <th>Téléphone</th>
                        <th>Spécialité</th>
                        <th>nationalite</th>
                        <th>matricule</th>
                        <th>formation</th>
                        <th>cycle</th>
                        <th>niveau</th>
                        <th>annee</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($etudiants as $etudiant): ?>
                    <tr>
                        <td>
                            <?php echo htmlspecialchars($etudiant['id']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($etudiant['prenom'] . ' ' . $etudiant['deuxieme_prenom'] . ' ' . $etudiant['nom_de_famille']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($etudiant['sexe']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($etudiant['date_de_naissance']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($etudiant['email']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($etudiant['telephone']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($etudiant['specialite']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($etudiant['nationalite']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($etudiant['matricule']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($etudiant['formation']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($etudiant['cycle']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($etudiant['niveau']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($etudiant['annee']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($etudiant['numero_odre']); ?>
                        </td>
                        
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </section>

    <footer>
        <div><img src="chapeau.png" alt="Logo ESTAD"></div>
        <span>copyrigth&copy; 2024 ESTAD University</span>
    </footer>
</body>

</html>