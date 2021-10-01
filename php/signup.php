<?php  
  //ETML
  //Author      : Sacha Hunacek - Florian Tauxe
  //Date        : 21.06.2021
  //Description : Page de login elle permet de se connecter au site avec un compte admin ou utilsateur et vérifie le mot de passe et le nom de d'utilisateur

  /**
  * On check les regex par rapport au mot de passe
  * @return string|bool Si ok bool si erreur string
  */
  function checkPasswordRegex($password) {
    $output = [];
    //Si on ne match pas on retourne une erreur
    if(!preg_match("/(?=.*[a-z])/m", $password)) {
      $output[] = "de minuscule";
    }
    //Si on ne match pas on retourne une erreur
    if(!preg_match("/(?=.*[A-Z])/m", $password)) {
      $output[] = "de majuscule";
    }
    //Si on ne match pas on retourne une erreur
    if(!preg_match("/[^a-zA-Z0-9]/i", $password)) {
      $output[] = "de caractère spécial";
    }
    //Si on ne match pas on retourne une erreur
    if(!preg_match("/.{8,}/i", $password)) {
      $output[] = "minimum 8 caractères";
    }
    //Return true
    return $output;
  }

  session_start();

  include 'manageDB.php';
  $connection = new Database();

  //Contrôle si le btnCreate est pressé
  if(isset($_POST['btnCreate']))
  { 
    $nameUser = $_POST['login'];
    $password = $_POST['password'];
    $connect = $connection->connect($nameUser);

    if(isset($checkbox)){
      $checkbox = $_POST['RGPD'];
      //Contrôle que le nom d'utilisateur ne commence pas par un espace et compte la longueur du strings
      if(strlen(trim($nameUser)) >= 1) {
        if(count($connect) == 0) {
          //Appel la fonction checkPasswordRegex
          $confim = checkPasswordRegex($password);

          //Contrôle si le mdp correspond à la regex
          if(count($confim) == 0)
          {
            $textSucecss = " ";
            $_POST["inscriptionSuccess"] = $textSucecss;
            //Envoie les données dans la db et Hachage du mdp
            $connection->createAccount($nameUser,password_hash($password,PASSWORD_BCRYPT));
          }
          //Mise en place des erreurs du mot de passe
          else
          {
            $text = "Il n'y a pas ";
            for($i = 0; $i < count($confim); ++$i)
            {
              if($i != 0) {
                $text .= ", ";
              }
              $text .= $confim[$i];
            }
            $_POST['inscriptionError'][] = $text;
          }
        }
        else
        {
          $_POST['inscriptionError'][] = "Le login est déjà utilisé";
        }
      }
      else
      {
        $_POST['inscriptionError'][] = "Le login ne doit pas commencer par un espace";
      }
    }
    else
    {
      $_POST['inscriptionError'][] = "La politique de confidentialité n'est pas accepté";
    }
  }
?>

<!Doctype html>
<html lang="fr">
  <head>

    <meta charset="utf-8">
    <title>TerraCoast - Sign Up</title>
    <link href="../css/signin.css" rel="stylesheet">

  </head>
  <body class="text-center">
    <main class="form-signin">
      
        <?php
          //Affichage des erreurs du mot de passe
          if(isset($_POST['inscriptionError']))
          {
            echo"
              <div class='alert-error'>
                <p class='titleError'>Erreur</p>
              </div>
              <div class='error'>
            ";
            foreach($_POST['inscriptionError'] as $err) {
              echo $err;
            }
            echo"</div>";
          }
          elseif(isset($_POST["inscriptionSuccess"]))
          {
            $_SESSION['isConnected'] = true;

            $connect = $connection->connect($_POST['login']);
            $_SESSION['idUser'] = $connect[0]['idUser'];
            header("Location:index");
          }
        ?>
      
      <form method="post" action="#">

        <h1 class="h3 mb-3 fw-normal">Créer ton compte !</h1>

        <label for="inputEmail" class="visually-hidden"></label>
        <input type="text" name="login" id="inputEmail" class="form-control" placeholder="Nom d'utilisateur" required autofocus>

        <label for="inputPassword" class="visually-hidden"></label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Mot de passe" required>

        <input type="checkbox" name="RGPD" value="oui" required><strong>
        <label class="h3 mb-3 fw-normal">Accepter notre <a herf="#.pdf">politique de confidentialité</a></label></strong>

        <a href="index"><button class="btn" name="btnCreate" type="submit">Créer</button></a>
        <a class="mt-5 mb-3 text-muted" href="login"><p>Déjà un compte ?</p></a>
        <a class="mt-5 mb-3 text-muted" href="index"><p>Revenir à la page d'accueil</p></a>
        <p class="mt-5 mb-3 text-muted">&copy; Copyright 2021</br>-</br>Sacha Hunacek & Florian Tauxe</p>

      </form>

    </main>
  </body>
</html>
