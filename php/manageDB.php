<<<<<<< HEAD
<?php
    ///ETML
    ///Author      : Sacha Hunacek - Florian Tauxe
    ///Date        : 19.04.2021
    ///Description : Cette classe permet de communiquer avec la base de données

    class Database{
        
        // Variable de classe
        private $connector;

        /**
         * Se connecter via PDO et utilise la variable de classe $connector
         */
        public function __construct()
        {
            try
            {
                $this->connector = new PDO("mysql:host=localhost;dbname=db_terracoast;charset=utf8" , "root", "root");
            }
            catch (PDOException $e)
            {
            die('Erreur : ' . $e->getMessage());
            }
        }

        /**
        * Cela permet de préparer et d’exécuter une requête de type simple (sans where)
        * @return => Requête executée, formatée ou -1 si erreur
        */
        private function querySimpleExecute($query)
        {
            //On crée la requête
            $rows = $this->connector->query($query);

            //Retourne la requête
            return $this->formatData($rows);
        }

        /**
        * Cela permet de préparer, de binder et d’exécuter une requête (select avec where ou insert, update et delete)
        * @return => Requête executée, formatée et bindé ou -1 si erreur
        */
        private function queryPrepareExecute($query, $binds)
        {
            //On prépare la requête
            $req = $this->connector->prepare($query);

            //On met les arguments sous la bonne forme
            foreach($binds as $key => $value)
            {
                //On check les valeurs pour set les bons parametres
                if(is_int($value))
                    $param = PDO::PARAM_INT;
                elseif(is_bool($value))
                    $param = PDO::PARAM_BOOL;
                elseif(is_null($value))
                    $param = PDO::PARAM_NULL;
                elseif(is_string($value))
                    $param = PDO::PARAM_STR;
                else
                    $param = false;
                //Si il y a un parametre
                if($param)
                    $req->bindValue(":$key", $value, $param);
            }
                //On execute
                $req->execute();

                //On retourne la réponse formaté
                return $this->formatData($req);
        }

        /**
        * On traite les données pour les retourner par exemple en tableau associatif (avec PDO::FETCH_ASSOC) et on unset la requête
        * @return => Requête formatée
        */
        private function formatData($req)
        {
            //On récupére le résultat
            $result = $req->fetchAll(PDO::FETCH_ASSOC);

            //On ferme la requête
            $this->unsetData($req);

            //Return le résultat
            return $result;
        }

        /**
        * On vide le jeu d’enregistrement
        * @param req => Requête à unset
        * @return void
        */
        private function unsetData($req)
        {
            //On ferme la requête
            $req->closeCursor();
        }

        /**
         * récupère la liste de tous les pays de la BD
         */
        public function getAllPays(){

            //Requête SQL pour recupérer les données d'une recette et execute la requête
            return $this->querySimpleExecute('SELECT * FROM t_pays');
        }

        /**
         * récupère la liste de tous les quiz de la BD
         */
        public function getAllQuiz(){

            //Requête SQL pour recupérer les données d'une recette et execute la requête
            return $this->querySimpleExecute('SELECT * FROM t_quiz');
        }

        /**
         * récupère la liste de tous les canotons de la BD
         */
        public function getAllCantons(){

            //Requête SQL pour recupérer les données d'une recette et execute la requête
            return $this->querySimpleExecute('SELECT * FROM t_canton');
        }

        /**
         * On ajoute un score
         */
        public function getAllPaysContinent($idContinent) 
        {
            //Requête SQL pour créer un utilisateur
            return $this->queryPrepareExecute(
                "SELECT * FROM t_pays WHERE fkContinent = :idContinent",
                ['idContinent' => $idContinent],
            );
        }
        
        /**
         * récupère la liste des informations pour un pays
         */
        public function getOnePays($id)
        {
            //Requête SQL pour recupérer les données d'une recette
            return $this->queryPrepareExecute(
                "SELECT idPays, payNom, payAbreviation, payCapitale FROM t_pays WHERE idPays = :id LIMIT 1",
                ['id' => $id],
            );
        }

        /**
         * récupère la liste des informations pour un utilisateur
         */
        public function getOneUser($id)
        {
            //Requête SQL pour recupérer les données d'une recette
            $result = $this->queryPrepareExecute(
                "SELECT * FROM t_user WHERE idUser = :id LIMIT 1",
                ['id' => $id],
            );

            return $result != -1 && count($result) >= 1 ? $result[0] : -1;
        }

        /**
        * permet de se connecter un compte avec un nom d'utilisateur et mot de passe
        */
        public function connect($useNom)
        {
            //Requête SQL pour créer un utilisateur
            return $this->queryPrepareExecute(
                "SELECT * FROM t_user WHERE useNom = :useNom LIMIT 1",
                ['useNom' => $useNom],
            );
        }

        /**
        * permet de créer un compte avec un nom d'utilisateur et mot de passe
        */
        public function createAccount($useNom, $useMdp)
        {
            //Requête SQL pour créer un utilisateur
            return $this->queryPrepareExecute(
                "INSERT INTO t_user (useNom, useMdp) VALUES (:useNom, :useMdp)",
                ['useNom' => $useNom, 'useMdp' => $useMdp],
            );
        }

        /**
         * On récupére le classement par rapport 
         */
        public function getClassement($idQuiz) {
            return $this->queryPrepareExecute(
                "SELECT * FROM t_score WHERE fkQuiz = :idQuiz ORDER BY scoScore DESC, scoTemps ASC LIMIT 10",
                ['idQuiz' => $idQuiz],
            );
        }

        /**
         * On ajoute un score
         */
        public function addScore($fkUser, $fkQuiz, $scoScore,$scoTemps) {
            //Requête SQL pour créer un utilisateur
            $result = $this->queryPrepareExecute(
                "SELECT * FROM t_score WHERE fkUser = :fkUser AND fkQuiz = :fkQuiz",
                ['fkUser' => $fkUser, 'fkQuiz' => $fkQuiz],
            );

            //Si il y a déjà un score ajouté
            if($result != -1 && count($result) >= 1) {
                //Si le score est plus grand
                if($scoScore > (float)$result[0]['scoScore'] || ($scoScore == (float)$result[0]['scoScore'] && $scoTemps < (float)$result[0]['scoTemps'])) {
                    //On retourne si il y a une erreur
                    return $this->queryPrepareExecute(
                        "UPDATE t_score SET scoScore = :scoScore, scoTemps = :scoTemps WHERE fkUser = :fkUser AND fkQuiz = :fkQuiz",
                        ['scoScore' => $scoScore,'scoTemps' => $scoTemps, 'fkUser' => $fkUser, 'fkQuiz' => $fkQuiz],
                    );
                }
            }
            else
            {
                //On retourne si il y a une erreur
                return $this->queryPrepareExecute(
                    "INSERT INTO t_score (scoScore,scoTemps,fkUser,fkQuiz) VALUES (:scoScore,:scoTemps,:fkUser,:fkQuiz)",
                    ['scoScore' => $scoScore,'scoTemps' => $scoTemps, 'fkUser' => $fkUser, 'fkQuiz' => $fkQuiz],
                );
            }
        }

        public function recherche()
        {
            if (isset($_GET["s"]) && $_GET["s"] == "Rechercher")
            {
                $_GET["terme"] = htmlspecialchars($_GET["terme"]); //pour sécuriser le formulaire contre les failles html
                $terme = $_GET["terme"];
                $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
                $terme = strip_tags($terme); //pour supprimer les balises html dans la requête 
            }
        
            if (isset($terme))
            {
                $terme = strtolower($terme);
                $select_terme = $database->queryPrepareExecute("SELECT quiTitle FROM t_quiz WHERE quiTitle LIKE ? OR contenu LIKE ?");
                $database->queryPrepareExecute("SELECT quiTitle FROM t_quiz WHERE quiTitle LIKE ? OR contenu LIKE ?")->execute(array("%".$terme."%", "%".$terme."%"));
            }
            else
            {
                $message = "Vous devez entrer votre requete dans la barre de recherche";
            }
            
            while($terme_trouve = $select_terme->fetch())
            {
                echo "<div><h2>".$terme_trouve['quiTitle']."</h2></div>";
            }
            $select_terme->closeCursor();
        }
    }
=======
<?php
    ///ETML
    ///Author      : Sacha Hunacek - Florian Tauxe - Dorian Capelli
    ///Date        : 19.04.2021
    ///Description : Cette classe permet de communiquer avec la base de données

    class Database{
        
        // Variable de classe
        private $connector;

        /**
         * Se connecter via PDO et utilise la variable de classe $connector
         */
        public function __construct()
        {
            try
            {
                $this->connector = new PDO("mysql:host=localhost;dbname=db_terracoast;charset=utf8" , "root", "root");
            }
            catch (PDOException $e)
            {
            die('Erreur : ' . $e->getMessage());
            }
        }

        /**
        * Cela permet de préparer et d’exécuter une requête de type simple (sans where)
        * @return => Requête executée, formatée ou -1 si erreur
        */
        private function querySimpleExecute($query)
        {
            //On crée la requête
            $rows = $this->connector->query($query);

            //Retourne la requête
            return $this->formatData($rows);
        }

        /**
        * Cela permet de préparer, de binder et d’exécuter une requête (select avec where ou insert, update et delete)
        * @return => Requête executée, formatée et bindé ou -1 si erreur
        */
        private function queryPrepareExecute($query, $binds)
        {
            //On prépare la requête
            $req = $this->connector->prepare($query);

            //On met les arguments sous la bonne forme
            foreach($binds as $key => $value)
            {
                //On check les valeurs pour set les bons parametres
                if(is_int($value))
                    $param = PDO::PARAM_INT;
                elseif(is_bool($value))
                    $param = PDO::PARAM_BOOL;
                elseif(is_null($value))
                    $param = PDO::PARAM_NULL;
                elseif(is_string($value))
                    $param = PDO::PARAM_STR;
                else
                    $param = false;
                //Si il y a un parametre
                if($param)
                    $req->bindValue(":$key", $value, $param);
            }
                //On execute
                $req->execute();

                //On retourne la réponse formaté
                return $this->formatData($req);
        }

        /**
        * On traite les données pour les retourner par exemple en tableau associatif (avec PDO::FETCH_ASSOC) et on unset la requête
        * @return => Requête formatée
        */
        private function formatData($req)
        {
            //On récupére le résultat
            $result = $req->fetchAll(PDO::FETCH_ASSOC);

            //On ferme la requête
            $this->unsetData($req);

            //Return le résultat
            return $result;
        }

        /**
        * On vide le jeu d’enregistrement
        * @param req => Requête à unset
        * @return void
        */
        private function unsetData($req)
        {
            //On ferme la requête
            $req->closeCursor();
        }

        /**
         * récupère la liste de tous les pays de la BD
         */
        public function getAllPays(){

            //Requête SQL pour recupérer les données d'une recette et execute la requête
            return $this->querySimpleExecute('SELECT * FROM t_pays');
        }

        /**
         * récupère la liste de tous les quiz de la BD
         */
        public function getAllQuiz(){

            //Requête SQL pour recupérer les données d'une recette et execute la requête
            return $this->querySimpleExecute('SELECT * FROM t_quiz');
        }

        /**
         * récupère la liste de tous les canotons de la BD
         */
        public function getAllCantons(){

            //Requête SQL pour recupérer les données d'une recette et execute la requête
            return $this->querySimpleExecute('SELECT * FROM t_canton');
        }

        /**
         * On ajoute un score
         */
        public function getAllPaysContinent($idContinent) 
        {
            //Requête SQL pour créer un utilisateur
            return $this->queryPrepareExecute(
                "SELECT * FROM t_pays WHERE fkContinent = :idContinent",
                ['idContinent' => $idContinent],
            );
        }
        
        /**
         * récupère la liste des informations pour un pays
         */
        public function getOnePays($id)
        {
            //Requête SQL pour recupérer les données d'une recette
            return $this->queryPrepareExecute(
                "SELECT idPays, payNom, payAbreviation, payCapitale FROM t_pays WHERE idPays = :id LIMIT 1",
                ['id' => $id],
            );
        }

        /**
         * récupère la liste des informations pour un utilisateur
         */
        public function getOneUser($id)
        {
            //Requête SQL pour recupérer les données d'une recette
            $result = $this->queryPrepareExecute(
                "SELECT * FROM t_user WHERE idUser = :id LIMIT 1",
                ['id' => $id],
            );

            return $result != -1 && count($result) >= 1 ? $result[0] : -1;
        }

        /**
        * permet de se connecter un compte avec un nom d'utilisateur et mot de passe
        */
        public function connect($useNom)
        {
            //Requête SQL pour créer un utilisateur
            return $this->queryPrepareExecute(
                "SELECT * FROM t_user WHERE useNom = :useNom LIMIT 1",
                ['useNom' => $useNom],
            );
        }

        /**
        * permet de créer un compte avec un nom d'utilisateur et mot de passe
        */
        public function createAccount($useNom, $useMdp)
        {
            //Requête SQL pour créer un utilisateur
            return $this->queryPrepareExecute(
                "INSERT INTO t_user (useNom, useMdp) VALUES (:useNom, :useMdp)",
                ['useNom' => $useNom, 'useMdp' => $useMdp],
            );
        }

        /**
         * On récupére le classement par rapport 
         */
        public function getClassement($idQuiz) {
            return $this->queryPrepareExecute(
                "SELECT * FROM t_score WHERE fkQuiz = :idQuiz ORDER BY scoScore DESC, scoTemps ASC LIMIT 10",
                ['idQuiz' => $idQuiz],
            );
        }

        /**
         * On ajoute un score
         */
        public function addScore($fkUser, $fkQuiz, $scoScore,$scoTemps) {
            //Requête SQL pour créer un utilisateur
            $result = $this->queryPrepareExecute(
                "SELECT * FROM t_score WHERE fkUser = :fkUser AND fkQuiz = :fkQuiz",
                ['fkUser' => $fkUser, 'fkQuiz' => $fkQuiz],
            );

            //Si il y a déjà un score ajouté
            if($result != -1 && count($result) >= 1) {
                //Si le score est plus grand
                if($scoScore > (float)$result[0]['scoScore'] || ($scoScore == (float)$result[0]['scoScore'] && $scoTemps < (float)$result[0]['scoTemps'])) {
                    //On retourne si il y a une erreur
                    return $this->queryPrepareExecute(
                        "UPDATE t_score SET scoScore = :scoScore, scoTemps = :scoTemps WHERE fkUser = :fkUser AND fkQuiz = :fkQuiz",
                        ['scoScore' => $scoScore,'scoTemps' => $scoTemps, 'fkUser' => $fkUser, 'fkQuiz' => $fkQuiz],
                    );
                }
            }
            else
            {
                //On retourne si il y a une erreur
                return $this->queryPrepareExecute(
                    "INSERT INTO t_score (scoScore,scoTemps,fkUser,fkQuiz) VALUES (:scoScore,:scoTemps,:fkUser,:fkQuiz)",
                    ['scoScore' => $scoScore,'scoTemps' => $scoTemps, 'fkUser' => $fkUser, 'fkQuiz' => $fkQuiz],
                );
            }
        }

        public function recherche()
        {
            if (isset($_GET["s"]) && $_GET["s"] == "Rechercher")
            {
                $_GET["terme"] = htmlspecialchars($_GET["terme"]); //pour sécuriser le formulaire contre les failles html
                $terme = $_GET["terme"];
                $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
                $terme = strip_tags($terme); //pour supprimer les balises html dans la requête 
            }
        
            if (isset($terme))
            {
                $terme = strtolower($terme);
                $select_terme = $database->queryPrepareExecute("SELECT quiTitle FROM t_quiz WHERE quiTitle LIKE ? OR contenu LIKE ?");
                $database->queryPrepareExecute("SELECT quiTitle FROM t_quiz WHERE quiTitle LIKE ? OR contenu LIKE ?")->execute(array("%".$terme."%", "%".$terme."%"));
            }
            else
            {
                $message = "Vous devez entrer votre requete dans la barre de recherche";
            }
            
            while($terme_trouve = $select_terme->fetch())
            {
                echo "<div><h2>".$terme_trouve['quiTitle']."</h2></div>";
            }
            $select_terme->closeCursor();
        }

        public function deleteAccount($useNom)
        {
            $user = $this->queryPrepareExecute(
                "SELECT * FROM t_user WHERE useNom = :useNom",
                ['useNom' => $useNom],
            );

            $idUser = $user[0]['idUser'];

            $this->queryPrepareExecute(
                "DELETE FROM t_score WHERE fkUser = :fkUser",
                ['fkUser' => $idUser],
            );            

            $this->queryPrepareExecute(
                "DELETE FROM t_user WHERE idUser = :idUser",
                ['idUser' => $idUser],
            );
        }

        public function searchQuiz($nomQuizz)
        {
            $search = "%$nomQuizz%";

            return $this->queryPrepareExecute(
                "SELECT * FROM t_quiz WHERE quiTitre LIKE :search",
                ['search' => $search],
            );
        }

        public function getLastQuiz(){

            //Requête SQL pour recupérer les données d'une recette et execute la requête
            return $this->querySimpleExecute('SELECT * FROM t_quiz ORDER BY idQuiz DESC LIMIT 2');
        }

        public function getFirstQuiz(){

            //Requête SQL pour recupérer les données d'une recette et execute la requête
            return $this->querySimpleExecute('SELECT * FROM t_quiz ORDER BY idQuiz ASC LIMIT 1');
        }
    }
>>>>>>> 52483df8747c43191efbd10f394b24588eb337aa
?>