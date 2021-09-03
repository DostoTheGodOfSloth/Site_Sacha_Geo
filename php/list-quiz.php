<?php
  ///ETML
  ///Author      : Sacha Hunacek - Florian Tauxe
  ///Date        : 19.04.2021
  ///Description : Cette classe permet de lister la totalité des quuiz de la bd

  session_start();
  
  include "manageDB.php";
  $database = new Database();
  $quizzes = $database->getAllQuiz();

    //Si l'utilisateur a pressé sur le bouton se deconnecter
    if(isset($_POST['btnDisconnect']))
    {
      session_destroy();
      header('location:#');
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
          <a href="index.php" class="navbar-brand d-flex align-items-center">
          <img class="logoNavbar" src="../img/icon/logo-trans2.png" alt="logo de la terre">
            <strong class="fw-light">TerraCoast</strong>
          </a>
          <div class="contianer-1">
            <a href="list-quiz.php" class="navbar-brand d-flex align-items-center">
              <strong styles="padding-left: 3rem;" class="fw-light escape-navbar">Quiz</strong>
            </a>
            <a href="contact.php" class="navbar-brand d-flex align-items-center">
              <strong class="fw-light fw-light-1">Contact</strong>
            </a>

            <?php
              if(isset($_SESSION["isConnected"]))
              {
                echo'
                  <form method="post" action="#">
                    <div class="connexion">
                      <input type="submit" name="btnDisconnect" id="btnDisconnect" class="btnDisconnect" value="Déconnexion">
                    </div>
                  </form>
                ';
              }
              else
              {
                echo'
                  <form method="post" action="login.php">
                    <div class="connexion">
                      <input type="submit" name="btnLogin" id="btnLogin" class="btnLogin" value="Connexion">
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
      <div class="album py-5 bg-light">

        <form action="manageDB.php" method="get">
          <input type="search" name="terme">
          <input type="submit" name="s" value="Rechercher">
        </form>
        
        <div class="container-f">
          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 boxQuiz">

            <?php
            foreach ($quizzes as $quiz)
            {
              echo"
                <div class='card'>
                  <a href='quiz/".$quiz['quiLien'].".php'>
                    <p class='textCard'>".$quiz['quiTitre']."</p>
                    <img class='imgCapital' src='../img/imgQuiz/".$quiz['idQuiz'].".png' alt='Lausanne'/>
                    <div class='card-body'>
                      <p class='card-text'>".$quiz['quiDescription']."</p>
                      <div class='text-muted-1'>
                        <small>".$quiz['quiDifficulte']."</small>
                        <small>".$quiz['quiTemps']."</small>
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
