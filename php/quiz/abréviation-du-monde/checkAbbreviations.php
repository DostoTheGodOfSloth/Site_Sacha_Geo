<?php
    ///ETML
    ///Author      : Sacha Hunacek - Florian Tauxe
    ///Date        : 19.04.2021
    ///Description : Cette classe permet de communiquer avec la base de données

    session_start();
    
    include "../../manageDB.php";
    $database = new Database();

    /**
     * Calcule la différence de temps entre deux date
     */
    function dateDiff(){
        // Declare and define two dates
        $date1 = strtotime($_SESSION['times']); 
        $date2 = strtotime(date('Y-m-d H:i:s')); 
        
        // Formulate the Difference between two dates
        $diff = abs($date2 - $date1);
    
        return $diff;
    }

    /**
    * Permet d'afficher le temps en mode chrononmètre
    */
    function showDiff($diff) {
        $tmp = $diff;
        $second = $tmp % 60;
    
        $tmp = floor( ($tmp - $second) /60 );
        $minute = $tmp % 60;
    
        $tmp = floor( ($tmp - $minute)/60 );
        $hour = $tmp % 24;

        return substr("0" . $hour, -2) . ":" . substr("0" . $minute, -2) . ":" . substr("0" . $second, -2);
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
        <link href="../../../css/bootstrap.min.css" rel="stylesheet">
        <link href="../../../css/styles.css" rel="stylesheet">
        <style>
            .bd-placeholder-img 
            {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }
            @media (min-width: 768px) 
            {
                .bd-placeholder-img-lg 
                {
                    font-size: 3.5rem;
                }
            }
        </style>
    </head>
    <body>
        <header>  
            <div class="navbar navbar-dark bg-dark shadow-sm">
                <div class="container container-2">
                    <a href="../../index.php" class="navbar-brand d-flex align-items-center">
                        <img class="logoNavbar" src="../../../img/icon/logo-trans2.png" alt="logo de la terre">
                        <strong class="fw-light">TerraCoast</strong>
                    </a>
                    <div class="container-1">
                        <a href="../../list-quiz.php" class="navbar-brand d-flex align-items-center">
                            <strong styles="padding-left: 3rem;" class="fw-light escape-navbar">Quiz</strong>
                        </a>
                        <a href="../../contact.php" class="navbar-brand d-flex align-items-center">
                            <strong class="fw-light">Contact</strong>
                        </a>
                    </div>
                </div>  
            </div>
        </header>
        <section class="py-5 text-center container">
            <div class="album py-5 bg-light">
                <div class="container-f">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 boxQuiz-1">
                        <div class="titleResult">
                            <a href="../../list-quiz.php"><img class="arrowLeft" src="../../../img/icon/arrow.png" alt="flèche de retour"/></a>
                            <p class="timer">
                                <?php 
                                    $timer = dateDiff();
                                    echo showDiff($timer);
                                ?>
                            </p>
                            <div class="titleResult-1">
                                <p class="titleQuiz">Résultats :</p>
                            </div>
                        </div>
                        <div class="flexForm">
                            <?php
                                function removeAccents($string) {
                                    return strtolower(preg_replace('~[^0-9a-z]+~i', '-', preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8'))));
                                }

                                /*Check si les élements existent*/
                                if(isset($_POST['btnCheck']) && isset($_POST["abbreviation"]) && isset($_SESSION["pays"]))
                                {
                                    $score = 0;
                                    /*Prend aussi l'index pour récupérer les capitales de l'autre page*/
                                    foreach($_POST["abbreviation"] as $index => $namePays)
                                    {
                                        $pay = $_SESSION["pays"][$index];
                                        /*met en miniscule l'insertion et la db pour la correlation */
                                        if(removeAccents(trim($namePays)) == removeAccents(trim($pay["payAbreviation"])))
                                        {
                                            $score++;
                                            echo "
                                                <div class=' cardQuiz-1'>
                                                    <p class='textCard'>" .$pay['payNom'] . "</p>
                                                    <img src='../../../img/drap/" .$pay['idPays'] .".png' class='imgCapital-quiz' alt='Drapeau d'un pays'>
                                                    <div class='form__group field'>
                                                        <input type='input' class='form__field right' value='".$pay['payAbreviation']."' disabled/>
                                                        <label for='name' class='form__label-1'>Nom</label>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        else
                                        {
                                            echo "
                                                <div class=' cardQuiz-1'>
                                                    <p class='textCard'>" .$pay['payNom'] . "</p>
                                                    <img src='../../../img/drap/" .$pay['idPays'] .".png' class='imgCapital-quiz' alt='Drapeau d'un pays'>
                                                    <div class='form__group field'>
                                                        <input type='input' class='form__field wrong' value='".$pay['payAbreviation']."' disabled/>
                                                        <label for='name' class='form__label-1'>Nom</label>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                    }
                                    echo"<div class='score'>";
                                        echo"<div class='score-1'>";
                                            echo $score."/12";
                                        echo"</div>";
                                        echo"<div class='score-2'>";
                                            echo"<a href='abbreviations.php' class='buttonUp-1'>Recommencez</a>";
                                        echo"</div>";
                                    echo"</div>";

                                    if(isset($_SESSION['idUser']))
                                    {
                                        $database->addScore($_SESSION['idUser'], '4', strval($score), $timer);
                                    }
                                }
                            ?>
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
            </div>
        </footer>
    </body>
</html>
