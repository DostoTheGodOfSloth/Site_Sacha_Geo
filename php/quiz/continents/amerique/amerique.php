<?php
    ///ETML
    ///Author      : Sacha Hunacek - Florian Tauxe
    ///Date        : 19.04.2021
    ///Description : Cette classe permet de communiquer avec la base de données

    session_start();
    
    include "../../../manageDB.php";
    $database = new Database();
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
        <link href="../../../../css/bootstrap.min.css" rel="stylesheet">
        <link href="../../../../css/styles.css" rel="stylesheet">
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
                    <a href="../../../index.php" class="navbar-brand d-flex align-items-center">
                        <img class="logoNavbar" src="../../../../img/icon/logo-trans2.png" alt="logo de la terre">
                        <strong class="fw-light">TerraCoast</strong>
                    </a>
                    <div class="contianer-1">
                        <a href="../../../list-quiz.php" class="navbar-brand d-flex align-items-center">
                            <strong styles="padding-left: 3rem;" class="fw-light escape-navbar">Quiz</strong>
                        </a>
                        <a href="../../../contact.php" class="navbar-brand d-flex align-items-center">
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
                            <a href="../../../list-quiz.php"><img class="arrowLeft" src="../../../../img/icon/arrow.png" alt="flèche de retour"/></a>
                            <a href="amerique.php"><img class="btnReload" src="../../../../img/icon/reload.png" alt="refresh"/></a>
                            <p id="text" class="timer"></p>
                            <div class="titleResult-1">
                                <p class="titleQuiz">Quels sont ces pays d'Amérique ?</p>
                            </div>
                        </div>
                        <form method="post" action="checkAmerique.php" enctype="multipart/form-data" >
                            <div class="flexForm">
                                <?php
                                    $pays = $database->getAllPaysContinent('3');

                                    /*reset la variable $_SESSION["pays"]*/
                                    unset($_SESSION["pays"]);

                                    for ($i=0; $i < min(12, count($pays)); $i++)
                                    {
                                        /*random sur la bd entière*/
                                        $rnd = rand(0, count($pays) - 1);

                                        /**stockage du random */
                                        $pay = $pays[$rnd];

                                        /*Mettre les pays sélectionné par le random dans un tableau qu'on met dans une variable de session pour pouvoir l'utiliser sur l'autre page*/
                                        $_SESSION["pays"][] = $pay;
                                            echo "
                                                <div class=' cardQuiz'>
                                                    <p class='textCard'>" .$pay['payCapitale'] . "</p>
                                                    <img src='../../../../img/drap/" .$pay['idPays'] .".png' class='imgCapital-quiz' alt='Drapeau d'un pays'>
                                                    <div class='form__group field'>
                                                        <input type='input' class='form__field' placeholder='Réponse...' name='name[]' id='name'/>
                                                        <label for='name' class='form__label'>Nom</label>
                                                    </div>
                                                </div>
                                            ";
                                        /* Efface et remplace une portion du tableau $pays */
                                        array_splice($pays, $rnd, 1);
                                    }
                                    /*Récupéreation du temps du jeu */
                                    $_SESSION["times"] = date('Y-m-d H:i:s');
                                ?>
                            </div>
                            <div>
                                <input type='submit' class='btnCheck' value='Vérifier' name='btnCheck' id='btnCheck'/>
                            </div>
                        </form>
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
        <script src="../../../../js/timer.js"></script>
    </body>
</html>
