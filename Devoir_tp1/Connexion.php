<?php 
      session_start();
      include 'database.php'; 
      if(isset($_SESSION['email'])){
          header('Location: Acces.php');
          exit();
      }


      if (isset($_POST['formulaireConnexion'])){
          $email_formulaire = htmlspecialchars(trim($_POST['email']));
          $mdp_formulaire= htmlspecialchars(trim($_POST['mdp']));

          if (!empty($email_formulaire) && !empty($mdp_formulaire)) {
               

                $req = $bd-> prepare("SELECT mdp from utilisateurs where email = :email ");
                $req ->bindValue(':email',$email_formulaire);
                $req->execute();
                $res = $req->fetch(PDO::FETCH_ASSOC);
                 
                
                if($res) {
                  
                 
                  if(password_verify($mdp_formulaire,$res['mdp'])){
                      
                      

                      $_SESSION['connecte'] = true;
                      $_SESSION['email'] = $email_formulaire;
                      $_SESSION['mdp'] = $mdp_formulaire;  
                      if ($_SESSION['email'] == $email_formulaire) {
                      
                        header('Location: Acces.php');
                        exit();
                      }
                      else {
                        header('Location: Connexion.php');
                        exit();
                      }

                  }
                  else{
                      $erreur = 'Your Credentials are incorrect';
                      
                  } 
              }
              else{
                      $erreur = 'Your Credentials are incorrect'; 
                      
                  } 
            
        }
        else {
            $erreur = 'You must fill in all the fields';
        }

    }
?>



<html>
    <head>
       <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="Ressources_css/connexion.css" media="screen" type="text/css" />
        <title>Formulaire d'identification</title>
    </head>
    <body>
        <div style='margin-left: 40%; margin-bottom:-100px;'>
            <img src="./img/login.jpeg" alt="Mon logo" style=' width: 250px;
    height:150px;'>
        </div>

        <div id="container">
            <!-- zone de connexion -->
            
            <form action="Connexion.php" method="POST">
                <h1>Formulaire</h1>
                
                <label><b>Email: </b></label>
                <input type="text" placeholder="Entrer l'email de l'utilisateur" name="email">

                <label><b>Mot de passe: </b></label>
                <input type="password" placeholder="Entrer le mot de passe" name="mdp" >
                
                  <?php if (isset($erreur)) {
                      echo'<p><font color="#A50505">'. $erreur. '</font> </p>';
                  }?>
                <input type="reset" value="reset">
                <input type="submit" id='submit' value='VALIDER' name="formulaireConnexion" >
                
            </form>
            <div><a href="Inscription.php"><input type="submit" id='submit_inscription' value='AJOUT COMPTE' name="formulaireInscription"></a> </div>
        </div>
    </body>