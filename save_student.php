<?php
// Inclure le fichier de connexion
include_once 'db_connection.php';

// Fonction pour nettoyer les entrées
function cleanInput($data) {
    return htmlspecialchars(strip_tags($data));
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Créer une instance de la classe Database et obtenir la connexion
    $database = new Database();
    $db = $database->getConnection();

    // Récupérer et nettoyer les données du formulaire
    $prenom = cleanInput($_POST['prenom']);
    $deuxieme_prenom = cleanInput($_POST['deuxieme_prenom']);
    $nom_de_famille = cleanInput($_POST['nom_de_famille']);
    $sexe = cleanInput($_POST['sexe']);
    $date_de_naissance = cleanInput($_POST['date_de_naissance']);
    $quartier = cleanInput($_POST['quartier']);
    $ville = cleanInput($_POST['ville']);
    $departement = cleanInput($_POST['departement']);
    $code_postal = cleanInput($_POST['code_postal']);
    $email = cleanInput($_POST['email']);
    $telephone = cleanInput($_POST['telephone']);
    $nationalite = cleanInput($_POST['nationalite']);
    $type_formation = cleanInput($_POST['type_formation']);
    $niveau = isset($_POST['niveau']) ? cleanInput($_POST['niveau']) : null;
    $filiere = isset($_POST['filiere']) ? cleanInput($_POST['filiere']) : null;
    $specialite = isset($_POST['specialite']) ? cleanInput($_POST['specialite']) : null;
    $annee = date("Y") . '/' . (date("Y") + 1);
    switch ($niveau) {
        case 'BT1':
        case 'BTS2':
            $cycle = 'BTS';
            break;
        case 'L3':
            $cycle = 'Licence';
            break;
        case 'M1':
        case 'M2':
            $cycle = 'Master';
            break;
        case 'D1':
        case 'D2':
        case 'D3':
            $cycle = 'Doctorat';
            break;
        default:
            $cycle = 'BTS';
            break;
    }

    $statut = "En attente";
    try {
        // Préparer et exécuter la requête SQL pour compter le nombre d'étudiants pour l'année en cours et le type de formation
        $query = "SELECT COUNT(*) AS nombre_etudiants FROM Etudiants WHERE annee = :annee AND type_formation_id = :type_formation";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':annee', $annee);
        $stmt->bindParam(':type_formation', $type_formation);
        $stmt->execute();

        // Récupérer le résultat
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $nombre_etudiants = $row['nombre_etudiants'];
        $numero_enregistrement = str_pad($nombre_etudiants + 1, 4, '0', STR_PAD_LEFT);

        // Générer le matricule
        $matricule = 'EU' . $type_formation . substr(date("Y"), -2) . $numero_enregistrement;
        $numero_ordre = ($numero_enregistrement +1) . date("Y") . (date("Y") + 1);

        // Préparer la requête SQL pour l'insertion des données
        $query = "INSERT INTO Etudiants (prenom, deuxieme_prenom, nom_de_famille, sexe, date_de_naissance, adresse, ville, departement, code_postal, email, telephone, nationalite, type_formation_id, filiere_id, specialite_id, niveau, cycle, annee, numero_ordre, matricule)
                  VALUES (:prenom, :deuxieme_prenom, :nom_de_famille, :sexe, :date_de_naissance, :adresse, :ville, :departement, :code_postal, :email, :telephone, :nationalite, :type_formation, :filiere, :specialite, :niveau, :cycle, :annee, :numero_ordre, :matricule)";

        $stmt = $db->prepare($query);

        // Lier les valeurs
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':deuxieme_prenom', $deuxieme_prenom);
        $stmt->bindParam(':nom_de_famille', $nom_de_famille);
        $stmt->bindParam(':sexe', $sexe);
        $stmt->bindParam(':date_de_naissance', $date_de_naissance);
        $stmt->bindParam(':adresse', $quartier);
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':departement', $departement);
        $stmt->bindParam(':code_postal', $code_postal);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':nationalite', $nationalite);
        $stmt->bindParam(':type_formation', $type_formation);
        $stmt->bindParam(':filiere', $filiere);
        $stmt->bindParam(':specialite', $specialite);
        $stmt->bindParam(':niveau', $niveau);
        $stmt->bindParam(':cycle', $cycle);
        $stmt->bindParam(':annee', $annee);
        $stmt->bindParam(':numero_ordre', $numero_ordre);
        $stmt->bindParam(':matricule', $matricule);

        // Exécuter la requête
        if ($stmt->execute()) {
            // Récupérer l'ID de l'enregistrement
            $last_id = $db->lastInsertId();
            // Rediriger vers la page de confirmation
            header("Location: print.php?id=$last_id");
            exit();
        } else {
            echo "Erreur lors de l'enregistrement.";
        }
    } catch (PDOException $e) {
        // En cas d'erreur, afficher un message d'erreur
        echo "Erreur : " . $e->getMessage();
    }
}
?>
