<?php
    ///ETML
    ///Author      : Sacha Hunacek - Florian Tauxe
    ///Date        : 19.04.2021
    ///Description : Cette classe permet de lister la totalité des quiz de la bd

    session_start();

    include "manageDB.php";
    $database = new Database();
    $quizzes = $database->getLastQuiz();
    $quiz = $database->getFirstQuiz();

     //If the user has deleted a account
    if(isset($_GET['delete']) && $_GET['delete'] == true){
      echo "<script>alert('votre compte a bien été supprimer')</script>";
      header("Location:index.php");
    }

    //Si l'utilisateur a pressé sur le bouton se deconnecter
    if(isset($_POST['btnDisconnect']))
    {
      session_destroy();
      header('location:#');
    }

    if(isset($_POST['btnDelete']))
    {
      header('location:delete.php');
    }
?>

<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.83.1">
    <title>TerraCoast</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/album/">
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet">
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }
      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
  </head>
  <body>
    <header>  
      <div class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container container-2">
          <a href="index" class="navbar-brand d-flex align-items-center">
          <img class="logoNavbar" src="../img/icon/logo-trans2.png" alt="logo de la terre">
            <strong class="fw-light">TerraCoast</strong>
          </a>
          <div class="container-1">
          	<?php
              if(isset($_SESSION["isConnected"]))
              {
                echo'
                  <a href="classement" class="navbar-brand d-flex align-items-center">
                  	<strong styles="padding-left: 3rem;" class="fw-light escape-navbar">Classement</strong>
              	  </a>
                ';
              }
              else
              {
                echo' ';
              }
            ?>
            <a href="list-quiz" class="navbar-brand d-flex align-items-center">
              <strong styles="padding-left: 3rem;" class="fw-light escape-navbar">Quiz</strong>
            </a>
            <a href="contact" class="navbar-brand d-flex align-items-center">
            	<strong class="fw-light fw-light-1">Contact</strong>
            </a>

            <?php
              if(isset($_SESSION["isConnected"]))
              {
                echo'
                  <form method="post" action="#">
                    <div class="connexion">
                      <input type="submit" name="btnDisconnect" class="btnAll" value="Déconnexion">
                      <input type="submit" name="btnDelete" class="btnDelete" value="Suppression">
                    </div>
                  </form>
                ';
              }
              else
              {
                echo'
                  <form method="post" action="login">
                    <div class="connexion">
                      <input type="submit" name="btnLogin" class="btnAll" value="Connexion">
                    </div>
                  </form>
                ';
              }
            ?>
          </div>
        </div>  
      </div>
    </header>
    <section class="py-5 text-center container">
      <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
          <img class="logoPage" src="../img/icon/logo-trans2.png" alt="logo de la terre">
          <p class="fw-light-2">TerraCoast</p>
          <p class="lead text-muted">Pour vous culturer !</p>
        </div>
      </div>
      <div class="album py-5 bg-light">
        <div class="container-f">
          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 boxQuiz">

            <?php
              foreach ($quizzes as $quizs)
              {
	            echo"
                    <div class='card'>
                      <a href='quiz/".$quizs['quiLien']."'>
                        <p class='textCard'>".$quizs['quiTitre']."</p>
                        <img class='imgCapital' src='../img/imgQuiz/".$quizs['idQuiz'].".png' alt='Lausanne'/>
                        <div class='card-body'>
                          <p class='card-text'>".$quizs['quiDescription']."</p>
                          <div class='text-muted-1'>
                            <small>".$quizs['quiDifficulte']."</small>
                            <small>".$quizs['quiTemps']."</small>
                          </div>
                        </div>
                      </a>
                    </div>
                  ";
              }

              foreach ($quiz as $qui)
              {
	            echo"
                    <div class='card'>
                      <a href='quiz/".$qui['quiLien']."'>
                        <p class='textCard'>".$qui['quiTitre']."</p>
                        <img class='imgCapital' src='../img/imgQuiz/".$qui['idQuiz'].".png' alt='Lausanne'/>
                        <div class='card-body'>
                          <p class='card-text'>".$qui['quiDescription']."</p>
                          <div class='text-muted-1'>
                            <small>".$qui['quiDifficulte']."</small>
                            <small>".$qui['quiTemps']."</small>
                          </div>
                        </div>
                      </a>
                    </div>
                  ";
              }
            ?>

          </div>
        </div>
      </div>
    </section>
    <footer class="text-muted py-5">
      <div class="container">
        <p class="float-end mb-1">
          <a href="#" class="buttonUp">Back to top</a>
        </p>
        <p class="mb-1">Sacha Hunacek et Florian Tauxe &copy; Tous droits reservés. Site créé pour le projet DemoMot 2021.</p>
      </div>
    </footer>
  </body>
</html>