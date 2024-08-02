<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche d'inscription ESTAD</title>
    <link rel="stylesheet" href="assets/css/print.css">
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
        $query = "SELECT et.id, prenom, deuxieme_prenom, nom_de_famille, sexe, date_de_naissance, adresse, ville, departement, code_postal, email, telephone, s.libelle specialite, nationalite, matricule, tf.libelle formation, niveau, cycle, annee, numero_ordre, f.libelle filiere 
                    FROM Etudiants et 
                    LEFT JOIN specialites s on s.id = et.specialite_id 
                    LEFT JOIN typesformation tf on tf.id = et.type_formation_id 
                    LEFT JOIN filieres f on f.id = et.filiere_id 
                    WHERE et.id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "ID non spécifié.";
        exit();
    }
    ?>
    <div class="buttons">
        <button onclick="window.location.href='index.php'">Retour à l'accueil</button>
        <button onclick="window.print()">Imprimer</button>
    </div>
    <div class="a4-container">
        <div class="inner-border">
            <div class="header">
                <div class="left">
                    <div class="text-box no-border">
                        <h4>République du Cameroun</h4>
                        <p>Paix-Travail-Patrie</p>
                        <p>Ministère de l’Enseignement Supérieur</p>
                        <p>École Supérieure des Techniques Avancées pour le Développement</p>
                        <p>BP : 14601 Yaoundé</p>
                        <p>Tél : (+237) 682 29 12 12/ 696 98 48 48/ 690 02 80 61</p>
                        <p>Site Web : <a href="http://www.estad-university.com">www.estad-university.com</a></p>
                        <p>Email : <a
                                href="mailto:secretariat@estad-university.com">secretariat@estad-university.com</a></p>
                    </div>
                </div>
                <div class="center">
                    <img src="assets/images/logo.png" alt="Logo" class="logo">
                </div>
                <div class="right">
                    <div class="text-box no-border">
                        <h4>Republic of Cameroon</h4>
                        <p>Peace – Work – Fatherland</p>
                        <p>Ministry of Higher Education</p>
                        <p>Higher School of Advanced Technologies Adapted For Development</p>
                        <p>P.O. Box: 14601 Yaoundé</p>
                        <p>Tel : (+237) 682 29 12 12/ 696 98 48 48/ 690 02 80 61</p>
                        <p>Website : <a href="http://www.estad-university.com">www.estad-university.com</a></p>
                        <p>Email : <a href="mailto:secretariat@estad-university.com">secretariat@estad-university.com</a></p>
                    </div>
                </div>
            </div>
            <div class="info-line">
                <div class="left-info">
                    <p>N°<span class="red"><?php echo htmlspecialchars($etudiant['numero_ordre'])?></span>/ESTAD/CSC</p>
                    <p class="bold">FICHE D’INSCRIPTION DE L’ÉCOLE SUPÉRIEURE DES TECHNIQUES AVANCÉES POUR LE
                        DÉVELOPPEMENT</p>
                    <p class="italic">REGISTRATION FORM FOR HIGHER SCHOOL OF ADVANCED TECHNOLOGIES ADAPTED FOR
                        DEVELOPMENT</p>
                </div>
                <div class="right-photo">
                    <div class="photo-frame">
                        <p>PHOTO</p>
                    </div>
                </div>
            </div>
            <div class="main">
                <h5>INFORMATIONS PERSONNELLES</h3>
                    <table>
                        <tr>
                            <td class="label">Nom (s) / Name</td>
                            <td colspan="3"><?php echo htmlspecialchars ($etudiant ['nom_de_famille']); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Prénom (s) / Surname</td>
                            <td colspan="3"><?php echo htmlspecialchars ($etudiant['prenom']); ?></td>
                            
                        </tr>
                        <tr>
                            <td class="label">Née le/ Born on</td>
                            <td><?php echo htmlspecialchars($etudiant['date_de_naissance']); ?></td>
                            <td class="label middle">À/ At</td>
                            <td><?php echo htmlspecialchars($etudiant['ville']); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Sexe/Sex</td>
                            <td colspan="3"><?php echo htmlspecialchars($etudiant['sexe']); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Nationalité/Nationality</td>
                            <td colspan="3"><?php echo htmlspecialchars($etudiant['nationalite']); ?></td>
                        </tr>
                    </table>

                    <h5>INFORMATIONS ACADÉMIQUES</h3>
                        <table>
                            <tr>
                                <td class="label">Matricule/Registration N°</td>
                                <td><?php echo htmlspecialchars($etudiant['matricule']); ?></td>
                            </tr>
                            <tr>
                                <td class="label">Formation/Training</td>
                                <td><?php echo htmlspecialchars($etudiant['formation']); ?></td>
                            </tr>
                            <tr>
                                <td class="label">Cycle /Cycle</td>
                                <td>
                                    <?php 
                                        if (isset($etudiant['cycle']) && !is_null($etudiant['cycle'])) {
                                            echo htmlspecialchars($etudiant['cycle']);
                                        } else {
                                            echo "N/A";  // Ou un autre message par défaut
                                        }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Filière/Série</td>
                                <td>
                                    <?php 
                                        if (isset($etudiant['filiere']) && !is_null($etudiant['filiere'])) {
                                            echo htmlspecialchars($etudiant['filiere']);
                                        } else {
                                            echo "N/A";  // Ou un autre message par défaut
                                        }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Spécialité/Speciality</td>
                                <td>
                                    <?php 
                                    if (isset($etudiant['specialite']) && !is_null($etudiant['specialite'])) {
                                        echo htmlspecialchars($etudiant['specialite']);
                                    } else {
                                        echo "N/A";  // Ou un autre message par défaut
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Niveau/Level</td>
                                <td>
                                    <?php 
                                        if (isset($etudiant['niveau']) && !is_null($etudiant['niveau'])) {
                                            echo htmlspecialchars($etudiant['niveau']);
                                        } else {
                                            echo "N/A";  // Ou un autre message par défaut
                                        }
                                    ?>
                                </td>
                            <tr>
                                <td class="label">Année/Year</td>
                                <td><?php echo htmlspecialchars($etudiant['annee']); ?></td>
                            </tr>
                           
                        </table>
                        <div class="sign">
                            <div class="sign-content">
                                <p>Fait à Yaoundé, le _______________________</p>
                                <p>La Chargée de la Scolarité</p>
                            </div>
                        </div>


            </div>
        </div>
        <div class="footer">
            <p>Autorisation MINESUP N°20-06511 ; NIU : M092018457187L</p>
            <p>Sous la tutelle académique de l’Université de Douala (Udo) et sous la tutelle Scientifique de l’École
                Nationale Supérieure Polytechnique de Douala (ENSPD)</p>
        </div>
    </div>
</body>

</html>
