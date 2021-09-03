<?php  
  //ETML
  //Author      : Sacha Hunacek - Florian Tauxe
  //Date        : 21.06.2021
  //Description : Page qui affiche le classement des utilisateurs avec un compte par quiz

  session_start();

  include 'manageDB.php';
  $connection = new Database();

  /**
   * Permet d'afficher le temps en mode chrononmètre
   */
  function showDiff($diff) 
  {
    $tmp = $diff;
    $second = $tmp % 60;

    $tmp = floor( ($tmp - $second) /60 );
    $minute = $tmp % 60;

    $tmp = floor( ($tmp - $minute)/60 );
    $hour = $tmp % 24;

    return substr("0" . $hour, -2) . ":" . substr("0" . $minute, -2) . ":" . substr("0" . $second, -2);
  }
?>

<!Doctype html>
<html lang="fr">
<link rel="icon" href="../img/icon/logo-trans2.ico" />
<link href="../css/styles.css" rel="stylesheet">
<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.0.13/css/all.css'>
<link href="../css/bootstrap.min.css" rel="stylesheet">
  <head>
    <meta charset="utf-8">
    <title>TerraCoast - Classement</title>
  </head>
  <body class="text-center">
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
          </div>
        </div>  
      </div>
    </header>
    <main class="form-signin">
      <!--Formulaire de connexion-->
      <form method="post" action="#">
      <div class="test">
        <div class="test2">
        <select class="btnCheck-class" name="select">

            <?php
            //On récupére les quizs
            $quizs = $connection->getAllQuiz();
            

            //Si il n'y a pas d'erreur et qu'il y a plus de un quiz
            if($quizs != -1 && count($quizs) >= 1) 
            {
                foreach($quizs as $quiz) 
                {
                  if($quiz["idQuiz"] != "1")
                  {
                    $selected = isset($_POST["select"]) && $quiz['idQuiz'] == $_POST["select"] ?"selected":"";
                    echo '<option value="'. $quiz['idQuiz'] .'"'.$selected.'>'. $quiz['quiTitre'] .'</option>';
                  }
                }
            }
            ?>

        </select>
        </div>
        <div class="test2">
        <button class="btnCheck-class" type="submit" class='buttonUp-Training' name="btnShowClassement">Afficher le classement</button>
        </div>
      </form>
        </div>
        <?php
      if(isset($_POST["btnShowClassement"]) && isset($_POST["select"]))
      {
        $result = $connection->getClassement($_POST["select"]);

        if($result != -1) 
        {
          ?><table id="customers">
            <tr>
              <th>Place</th>
              <th>Nom</th>
              <th>Score</th>
              <th>Temps</th>
            </tr>
            <?php 
          $count = 1;
            foreach ($result as $value) 
            {?><tr><?php
              $user = $connection->getOneUser($value['fkUser']);

              if($user != -1) 
              {
                echo '<td>';
                if($count==1)
                  echo '<i class="fas fa-trophy fa-lg gold"></i> ';
                else if($count==2)
                  echo '<i class="fas fa-trophy fa-lg silver"></i> ';
                else if($count==3)
                  echo '<i class="fas fa-trophy fa-lg bronze"></i> ';
                else
                echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
                echo $count .'</td>';
                echo '<td>'. $user["useNom"].'</td>';
                echo '<td>'. $value['scoScore'].'</td>';
                echo '<td>'.showDiff($value['scoTemps']).'</td>';
                echo "<br>";
                
                $count++;
              }
              ?></tr><?php
            }
        }
        else
        {
          echo "Personne n'a été classé pour ce quiz.";
        }
      }
      ?>
      </table>
    </main>
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