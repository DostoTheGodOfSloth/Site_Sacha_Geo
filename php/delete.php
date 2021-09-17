<?php  
  //ETML
  //Author      : Sacha Hunacek - Florian Tauxe
  //Date        : 21.06.2021
  //Description : Page de login elle permet de se connecter au site avec un compte admin ou utilsateur et vérifie le mot de passe et le nom de d'utilisateur

  session_start();

  include 'manageDB.php';
  $connection = new Database();

 

  //Si l'utilisateur a pressé sur le bouton se connecter
  if(isset($_POST['btnDelete']))
  {
    //Vérifiez les entrées 
    if(isset($_POST['login']) and isset($_POST['password']))
    {
      $login = $_POST['login'];
      $password = $_POST['password'];

      //Récupère l'utilisateur et le mot de passe
      $connect = $connection->connect($login);

      //Vérifie le mot de passe et l'utilisateur
      if($connect && password_verify($password, $connect[0]['useMdp']))
      {
      	$connection->deleteAccount($login);

      	session_destroy();

        header("Location:index.php?delete=true");
      }
      else
      {
        $text = " ";
        $_POST['inscriptionError'] = $text;
      }
    }
  }
?>

<!Doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>TerraCoast - Login</title>
    <link href="../css/signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
    <main class="form-signin">
  
      <form method="post" action="delete.php" class="g-3">

      <?php
        //Affichage des erreurs du mot de passe
        if(isset($_POST['inscriptionError']))
        {
          echo"
          <div class='alert-error'>
            <p class='titleError'>Erreur</p>
          </div>
          <div class='error'>
            <p class='textError'>Votre nom d'utilisateur ou votre mot de passe est incorrect</p>
          </div>
        ";
        }
      ?>
        <h1 class="h3 mb-3 fw-normal">Supprimer son compte</h1>

        <label for="inputEmail" class="visually-hidden"></label>
        <input type="text" name="login" id="inputEmail" class="form-control" placeholder="Nom d'utilisateur" required autofocus>

        <label for="inputPassword" class="visually-hidden"></label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Mot de passe" required>

        <a href="index.php"><button class="btn" name="btnDelete" type="submit">Supprimer</button></a>
        <a class="mt-5 mb-3 text-muted" href="index.php"><p>Revenir à la page d'accueil</p></a>
        <p class="mt-5 mb-3 text-muted">&copy; Copyright 2021</br>-</br>Sacha Hunacek & Florian Tauxe</p>
      </form>

    </main>
  </body>
</html>