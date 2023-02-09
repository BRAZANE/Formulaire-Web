<?php 
      session_start();
      include 'database.php'; 
     
      if(isset($_SESSION['email'])){
            header('Location: Acces.php');
            exit();
      }

?>

<?php    
    
    if (isset($_POST['formulaireInscription'])){
       

        $identifiant = htmlspecialchars(strtolower(trim($_POST['identifiant'])));
        $email = htmlspecialchars(strtolower(trim($_POST['email'])));
        $mdp= htmlspecialchars(trim($_POST['mdp']));
    

        
        if (!empty($email) && !empty($_POST['email2']) && !empty($mdp) && !empty($_POST['mdp2'])) {
            if(filter_var($email, FILTER_VALIDATE_EMAIL)) { 
                if ($email == $_POST['email2']){ 
                   
                   $reqmail = $bd->prepare('SELECT * from utilisateurs where email = ?');
                   $reqmail->execute([$email]);
                   $mailexist = $reqmail->fetch();
                   if (!$mailexist) { 
                      if (iconv_strlen($mdp,"UTF-8")>= 8){ 
                          if ($mdp == $_POST['mdp2']){ 
                            $options = [
                              'cost' => 13,  
                            ];

                            $hashmdp = password_hash($mdp, PASSWORD_BCRYPT, $options); 
                         
                            $req = $bd-> prepare("INSERT INTO utilisateurs(identifiant,email,mdp) VALUES (:identifiant,:email,:mdp)");
                            $req->execute(array(
                              'identifiant' => $identifiant,
                              'email' => $email,
                              'mdp' => $hashmdp,            
                            ));
                              header('Location:Connexion.php');
                              exit;
                             
                          }
                          else {
                              $erreur = "ce n'est pas le méme mot de passe .";
                          }
                      }
                      else{
                         $erreur = "Votre mot de passe doit contenir au minimum 8 caractères";
                      }                

                   }
                   else {
                        $erreur = "Utilisez une autre adresse email.";
                   }
                
                }
                else {
                  $erreur = "Les deux emails ne sont pas identique.";
                }
            }
            else {
                  $erreur = "L'adresse mail n'est pas bonne";
            }
        }
        else {
          $erreur = "vous devez remplir tous les champs";
        }
    }
        
?>
  

<html>
    <head>
       <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="Ressources_css/inscription.css" media="screen" type="text/css" />
        <title>Ajout d'un compte</title>
    </head>
    <body>
        <div style='margin-left: 43%; margin-bottom:-150px;'>
               <img src="./img/login.png" alt="Mon logo" style=' width: 250px;
        height:150px;'>
        </div>
        <div id="container">
            <!-- zone d'inscription' -->
            
            <form action="inscription.php" method="POST">
                <h1>Inscription</h1>

                <span><label><b>Identifiant </b></label></span>
                <input type="text" name="identifiant" placeholder="saisir votre identifiant" required value="<?php if(isset($identifiant)){ echo $identifiant;}?>">

                 <span><label><b>Email</b></label></span>
                 <input type="text" name="email" placeholder="Tapez votre email" required value="<?php if(isset($email)){ echo $email;}?>">

                 <span><label><b>Confirmation Email</b></label></span>
                 <input type="text" name="email2" placeholder="Confirmez votre email" required>

                <br>
                <span><label><b>Mot de passe (minimum 8 caractère) </b></label></span>
                <input type="password" placeholder="tapez le mot de passe" name="mdp" required>

                <span><label><b>Confirmation du mot de passe </b></label></span>
                <input type="password" name="mdp2" placeholder="Confirmez votre mot de passe" required>

                 <?php if (isset($erreur)) {
                    echo'<p><font color="#A50505">'. $erreur. '</font> </p>';
                }?>

                <input type="submit" id='submit_inscription' value="INSCRIPTION" name="formulaireInscription" href="connexion.php" >
                
            </form>
        </div>
    </body>
