<<<<<<< HEAD
<?php
  ///ETML
  ///Author      : Sacha Hunacek - Florian Tauxe
  ///Date        : 19.04.2021
  ///Description : Affiche les contacts des devéloppeurs
  
  session_start();

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
      <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
          <h1 class="fw-light">Qui sommes-nous ?</h1>
          <p class="lead text-muted">Nous sommes une petite équipe de 2 jeunes apprentis en CFC informaticien, qui avons choisi de développer
          ce site web dans le but de démontrer notre motivation & aussi de pouvoir développer nos connaissances géographiques et informatique tout en s'amusant !</p>
        </div>
      </div>
      <div class="album py-5 bg-light">
        <div class="container-f">
          <div style="justify-content: space-evenly; gap: 10px;"class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 boxQuiz">

              <div class="card">
                <p class="textCard">Sacha Hunacek</p>
                <div style="display:flex; justify-content: center;">
                  <img class="michel" src="../img/contact/sachunacek.jpg" alt="Lausanne"/>
                </div>
                <div class="card-body">
                  <p class="card-text">Email : <a href="mailto:sebastien.voide@eduvaud.ch" class="mail">sacha.hunacek@eduvaud.ch</a></p>
                  <p class="card-text">tel : +41 78 608 37 27</p>
                  <div class="text-muted-1">
                  </div>
                </div>
              </div>
              <div class="card">
                <p class="textCard">Florian Tauxe</p>
                <div style="display:flex; justify-content: center;">
                    <img class="michel" src="../img/contact/flotauxe.jpg" alt="Lausanne"/>
                </div>
                <div class="card-body">
                  <p class="card-text">Email : <a href="mailto:sebastien.voide@eduvaud.ch" class="mail">florian.tauxe@eduvaud.ch</a></p>
                  <p class="card-text">tel : +41 79 845 53 57</p>
                  <div class="text-muted-1">
                  </div>
                </div>
              </div>
              <div class="card">
                <p class="textCard">Sebastien Voide</p>
                <div style="display:flex; justify-content: center;">
                    <img class="michel" src="../img/contact/sebvoide.jpg" alt="Lausanne"/>
                </div>
                <div class="card-body">
                  <p class="card-text">Email : <a href="mailto:sebastien.voide@eduvaud.ch" class="mail">sebastien.voide@eduvaud.ch</a><br><br>Merci à Sebastien Voide pour son aide précieuse 🍫❤️.</p>
                  <div class="text-muted-1">
                  </div>
                </div>
              </div>
              <div class="card">
                <p class="textCard">Dorian Capelli</p>
                <div style="display:flex; justify-content: center;">
                    <img class="michel" src="../img/contact/dorcapelli.jpg" alt="Lausanne"/>
                </div>
                <div class="card-body">
                  <p class="card-text">Email : <a href="mailto:dorian.capelli@eduvaud.ch" class="mail">dorian.capelli@eduvaud.ch</a></p>
                  <p class="card-text">tel : +41 79 198 92 00</p>
                  <div class="text-muted-1">
                  </div>
                </div>
              </div>
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
        <p class="mb-1">Conseil: Pour répondre correctement aux questions écrivez le pays en entier !</p>
        <a href="https://discord.com/channels/620946075099856926/621286351471509504"><img src="../img/icon/discord.png" alt="discord"/></a>
        <a href="https://www.instagram.com/terracoast_quiz/?hl=fr"><img src="../img/icon/instagram.png" alt="instagram"/></a>
      </div>
    </footer>
  </body>
</html>
=======
<?php
  ///ETML
  ///Author      : Sacha Hunacek - Florian Tauxe
  ///Date        : 19.04.2021
  ///Description : Affiche les contacts des devéloppeurs
  
  session_start();

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
          <a href="index.php" class="navbar-brand d-flex align-items-center">
            <img class="logoNavbar" src="../img/icon/logo-trans2.png" alt="logo de la terre">
            <strong class="fw-light">TerraCoast</strong>
          </a>
          <div class="container-1">
            <?php
              if(isset($_SESSION["isConnected"]))
              {
                echo'
                  <a href="classement.php" class="navbar-brand d-flex align-items-center">
                    <strong styles="padding-left: 3rem;" class="fw-light escape-navbar">Classement</strong>
                  </a>
                ';
              }
              else
              {
                echo' ';
              }
            ?>
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
                      <input type="submit" name="btnDisconnect" class="btnAll" value="Déconnexion">
                      <input type="submit" name="btnDelete" class="btnDelete" value="Suppression">
                    </div>
                  </form>
                ';
              }
              else
              {
                echo'
                  <form method="post" action="login.php">
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
          <h1 class="fw-light">Qui sommes-nous ?</h1>
          <p class="lead text-muted">Nous sommes une petite équipe de 2 jeunes apprentis en CFC informaticien, qui avons choisi de développer
          ce site web dans le but de démontrer notre motivation & aussi de pouvoir développer nos connaissances géographiques et informatique tout en s'amusant !</p>
        </div>
      </div>
      <div class="album py-5 bg-light">
        <div class="container-f">
          <div style="justify-content: space-evenly; gap: 10px;"class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 boxQuiz">

              <div class="card">
                <p class="textCard">Sacha Hunacek</p>
                <div style="display:flex; justify-content: center;">
                  <img class="michel" src="../img/contact/sachunacek.jpg" alt="Lausanne"/>
                </div>
                <div class="card-body">
                  <p class="card-text">Email : <a href="mailto:sebastien.voide@eduvaud.ch" class="mail">sacha.hunacek@eduvaud.ch</a></p>
                  <p class="card-text">tel : +41 78 608 37 27</p>
                  <div class="text-muted-1">
                  </div>
                </div>
              </div>
              <div class="card">
                <p class="textCard">Florian Tauxe</p>
                <div style="display:flex; justify-content: center;">
                    <img class="michel" src="../img/contact/flotauxe.jpg" alt="Lausanne"/>
                </div>
                <div class="card-body">
                  <p class="card-text">Email : <a href="mailto:sebastien.voide@eduvaud.ch" class="mail">florian.tauxe@eduvaud.ch</a></p>
                  <p class="card-text">tel : +41 79 845 53 57</p>
                  <div class="text-muted-1">
                  </div>
                </div>
              </div>
              <div class="card">
                <p class="textCard">Sebastien Voide</p>
                <div style="display:flex; justify-content: center;">
                    <img class="michel" src="../img/contact/sebvoide.jpg" alt="Lausanne"/>
                </div>
                <div class="card-body">
                  <p class="card-text">Email : <a href="mailto:sebastien.voide@eduvaud.ch" class="mail">sebastien.voide@eduvaud.ch</a><br><br>Merci à Sebastien Voide pour son aide précieuse 🍫❤️.</p>
                  <div class="text-muted-1">
                  </div>
                </div>
              </div>
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
        <p class="mb-1">Conseil: Pour répondre correctement aux questions écrivez le pays en entier !</p>
        <a href="https://discord.com/channels/620946075099856926/621286351471509504"><img src="../img/icon/discord.png" alt="discord"/></a>
        <a href="https://www.instagram.com/terracoast_quiz/?hl=fr"><img src="../img/icon/instagram.png" alt="instagram"/></a>
      </div>
    </footer>
  </body>
</html>
>>>>>>> 52483df8747c43191efbd10f394b24588eb337aa
