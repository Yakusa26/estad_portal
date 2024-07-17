<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="HOME.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESTAD - Formulaire d'inscription</title>
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <?php
    // Inclure le fichier de connexion
    include_once 'db_connection.php';

    class DataFetcher {
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function fetchSpecialites() {
            $query = "SELECT s.id, s.libelle, s.filiere_id FROM specialites s";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function fetchTypesFormation() {
            $query = "SELECT id, libelle FROM typesformation";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function fetchFilieres() {
            $query = "SELECT id, libelle, ftf.type_formation_id FROM filieres f 
                        left join FilieresParTypesFormation ftf on ftf.filiere_id = f.id;";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    // Créer une instance de la classe Database
    $database = new Database();
    $db = $database->getConnection();
    $dataFetcher = new DataFetcher($db);

    // Récupérer les données
    $typesFormation = $dataFetcher->fetchTypesFormation();
    $specialites = $dataFetcher->fetchSpecialites();
    $filieres = $dataFetcher->fetchFilieres();
    ?>

    <header>
        <div><img src="chapeau.png" alt="Logo ESTAD"></div>
        <span>ESTAD<span style="font-size: 12px;">(Ecole Supérieur des Techniques Avancées pour le Developpement)</span></span>
    </header>

    <main>
        <h1>Formulaire d'inscription étudiants</h1>
        <p>Remplissez soigneusement le formulaire d'inscription</p>
        <form id="registrationForm" action="save_student.php" method="post">
            <div>
                <p>Nom complet</p>
                <input type="text" name="prenom" placeholder="Prénom" required>
                <input type="text" name="deuxieme_prenom" placeholder="Deuxième prénom">
                <input type="text" name="nom_de_famille" placeholder="Nom de famille" required>
            </div>
            <div>
                <p>Sexe</p>
                <select name="sexe" required>
                    <option value="Masculin">Masculin</option>
                    <option value="Feminin">Feminin</option>
                </select>
            </div>
            <div>
                <p>Date de naissance</p>
                <input type="date" name="date_de_naissance" required>
            </div>
            <div>
                <p>Adresse</p>
                <input type="text" name="quartier" placeholder="Quartier" required>
                <input type="text" name="ville" placeholder="Ville" required>
                <input type="text" name="departement" placeholder="Département" required>
                <input type="text" name="code_postal" placeholder="Code postal" required>
            </div>
            <div>
                <p>Contact</p>
                <input type="email" name="email" placeholder="Email" required>
                <input type="tel" name="telephone" placeholder="Numéro de téléphone" required>
            </div>
            <div>
                <p>Nationalité</p>
                <input type="text" name="nationalite" placeholder="Nationalité" required>
            </div>
            <div>
                <p>Choisissez votre Formation</p>
                <select name="type_formation" id="type_formation" required>
                    <option value="" disabled selected>Choisissez</option>
                    <?php foreach ($typesFormation as $type) : ?>
                        <option value="<?= htmlspecialchars($type['id']) ?>"><?= htmlspecialchars($type['libelle']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
            <div id="niveau-container" class="hidden">
                <p>Choisissez votre Niveau</p>
                <select name="niveau" id="niveau" required>
                    <option value="" disabled selected >Choisissez</option>
                    <option value="BTS1" >Niveau 1 (BTS)</option>
                    <option value="BTS2" >Niveau 2 (BTS)</option>
                    <option value="L3" >Niveau 3 (Licence)</option>
                    <option value="M1" >Niveau 4 (Master)</option>
                    <option value="M2" >Niveau 5 (Master)</option>
                    <option value="D1" >Niveau 6 (Doctorat)</option>
                    <option value="D2" >Niveau 7 (Doctorat)</option>
                    <option value="D3" >Niveau 8 (Doctorat)</option>
                </select>
            </div>
            <div id="filiere-container" class="hidden">
                <p>Choisissez votre Filière</p>
                <select name="filiere" id="filiere" required>
                    <option value="" disabled selected>Choisissez</option>
                </select>
            </div>
            <div id="specialite-container" class="hidden">
                <p>Choisissez votre Spécialité</p>
                <select name="specialite" id="specialite" required>
                    <option value="" disabled selected>Choisissez</option>
                    <!-- Options chargées dynamiquement avec JavaScript -->
                </select>
            </div>
            <div class="actions">
                <button type="button" onclick="printForm()">Imprimer</button>
                <button type="submit">Soumettre l'inscription</button>
            </div>
        </form>
    </main>

    <footer>
        <div><img src="chapeau.png" alt="Logo ESTAD"></div>
        <span>copyright&copy; 2024 ESTAD University</span>
    </footer>

    <script>
        function printForm() {
            window.print();
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Charger les données depuis PHP
            var specialites = <?php echo json_encode($specialites, JSON_HEX_TAG); ?>;
            var filieres = <?php echo json_encode($filieres, JSON_HEX_TAG); ?>;

            var typeFormationSelect = document.getElementById('type_formation');
            var filiereSelect = document.getElementById('filiere');
            var specialiteSelect = document.getElementById('specialite');
            var filiereContainer = document.getElementById('filiere-container');
            var specialiteContainer = document.getElementById('specialite-container');
            var niveauContainer = document.getElementById('niveau-container');

            function updateFiliereOptions() {
                var selectedTypeFormationId = typeFormationSelect.value;

                console.log('selectedTypeFormationId', selectedTypeFormationId);
                console.log('filieres', filieres);

                // Filtrer les filières en fonction du type de formation sélectionné
                var filteredFilieres = filieres.filter(function(filiere) {
                    return filiere.type_formation_id == selectedTypeFormationId;
                });
                console.log('filteredFilieres', filteredFilieres);

                // Mettre à jour les options du sélecteur de filières
                filiereSelect.innerHTML = '<option value="" disabled selected>Choisissez</option>';
                filteredFilieres.forEach(function(filiere) {
                    var option = document.createElement('option');
                    option.value = filiere.id;
                    option.textContent = filiere.libelle;
                    filiereSelect.appendChild(option);
                });
                var formationLibelle = typeFormationSelect.options[typeFormationSelect.selectedIndex].textContent;
                if (formationLibelle === 'Formations Initiales' || formationLibelle === 'Formations Continues'){
                    niveauContainer.classList.remove('hidden');
                }
                else{
                    niveauContainer.classList.add('hidden');
                }

                // Afficher le conteneur des filières
                if (filteredFilieres.length > 0) {
                    filiereContainer.classList.remove('hidden');
                } else {
                    filiereContainer.classList.add('hidden');
                }
            }

            function updateSpecialiteOptions() {
                var selectedFiliereId = filiereSelect.value;

                console.log("selectedFiliereId", selectedFiliereId);
                console.log("specialites", specialites);

                // Filtrer les spécialités en fonction de la filière sélectionnée
                var filteredSpecialites = specialites.filter(function(specialite) {
                    return specialite.filiere_id == selectedFiliereId;
                });
                console.log("filteredSpecialites", filteredSpecialites);

                // Mettre à jour les options du sélecteur de spécialités
                specialiteSelect.innerHTML = '<option value="" disabled selected>Choisissez</option>';
                filteredSpecialites.forEach(function(specialite) {
                    var option = document.createElement('option');
                    option.value = specialite.id;
                    option.textContent = specialite.libelle;
                    specialiteSelect.appendChild(option);
                });

                // Afficher le conteneur des spécialités
                if (filteredSpecialites.length > 0) {
                    specialiteContainer.classList.remove('hidden');
                } else {
                    specialiteContainer.classList.add('hidden');
                }
            }

            typeFormationSelect.addEventListener('change', function() {
                // Réinitialiser les sélecteurs
                filiereSelect.selectedIndex = 0;
                specialiteSelect.selectedIndex = 0;

                // Masquer le sélecteur de spécialités
                specialiteContainer.classList.add('hidden');

                // Mettre à jour les filières en fonction du type de formation sélectionné
                updateFiliereOptions();
            });

            filiereSelect.addEventListener('change', function() {
                // Réinitialiser le sélecteur de spécialités
                specialiteSelect.selectedIndex = 0;

                // Mettre à jour les spécialités en fonction de la filière sélectionnée
                updateSpecialiteOptions();
            });
        });
    </script>
</body>

</html>
