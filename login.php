<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="login.css"> 
    <title>Connection</title>
</head>
<body>
<?php
 if (isset($_GET['id'])) {
    $etat = htmlspecialchars(strip_tags($_GET['state']));
}

?>
<header>
        <div><img src="chapeau.png" alt="Logo ESTAD"></div>
        <span>ESTAD<span style="font-size: 12px;">(Ecole Supérieur des Techniques Avancées pour le
                Developpement)</span></span>
    </header>


    <div class="A1"> 
 <form  action="check_rights.php" method="post">
 <label  class="Q1" for="">Pseudo</label> <br>
   <div class="D1"><input name="pseudo" type="text" placeholder="Entrer votre pseudo"> </div> <br>
    <label  class="Q2" for="">Mot de passe</label> <br>
   <div class="D2"><input name="mot_de_passe" type="password" placeholder="Entrer mot de passe"></div>  <br>
   <button type="submit">Se connecter</button><br>
 </form>
 </div>
   
 
    <footer>
        <div><img src="chapeau.png" alt="Logo ESTAD"></div>
        <span>copyrigth&copy; 2024 ESTAD University</span>
    </footer>
</body>

</html>