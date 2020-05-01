<?php
    include_once(__DIR__."/connect.php");
    include_once(__DIR__."/roles/rolesFunctions.php");


    class BindParam
    {
        private $fieldName;
        private $value;
        private $typeParam;

        function __construct(string $fieldName, $value, int $typeParam)
        {
            $this->fieldName = $fieldName;
            $this->value = $value;
            $this->typeParam = $typeParam;
        }

        function getFieldName() : string { return $this->fieldName; }
        function getValue() { return $this->value; }
        function getTypeParam() : int { return $this->typeParam; }
    }

    class CommandesBdd
    {
        static private function bindParam(Bdd $bdd, BindParam $param)
        {
            $bdd->bindParam(':'.$param->getFieldName(), $param->getValue(), $param->getTypeParam());
        }

        /**
         * Formate une requete avec un tableau de BindParam en séparant chaque terme par une chaîne de transition
         * Termine la requete par une chaine spécifiée
         * @$params: Tableau de BindParam
         * @$paramEquals: Determine si chaque nom de champ doit être suivi d'un operateur de comparaison avec une valeur à bind
         * @$preStr: Chaine qui figure avant le nom de champ
         * @$transitionStr: Chaine entre deux champs
         * @$endStr: Chaine figurant après tous les champs
         */
        static private function writeRequest(&$request, array $params, bool $paramEquals, string $preStr,string $transitionStr, string $endStr)
        {
            $max = count($params);
            for($i = 0; $i < $max; ++$i)
            {
                $request = $request.$preStr.$params[$i]->getFieldName();
                if ($paramEquals)
                {
                    $request = $request.'=:'.$params[$i]->getFieldName();
                }

                if ($i < $max - 1)
                {
                    $request = $request.$transitionStr;
                }
                else
                {
                    $request = $request.$endStr;
                }
            }
        }

        static public function deleteElement(string $table, BindParam $id) : bool
        {
            $fn = $id->getFieldName();
            $request = 'DELETE FROM '.$table.' WHERE '.$fn.' = :'.$fn.';';
            $bdd = new Bdd();
            $bdd->requete($request);
            self::bindParam($bdd, $id);
            if($bdd->execute())
            {
                return true;
            }
            return false;
        }

        /**
         * @$params: Tableau de BindParam
         */
        static public function insertElement(string $table, array $params) : bool
        { 
            $request = 'INSERT INTO '.$table.' (';
            // Champs à inserer
            self::writeRequest($request, $params, false, '', ', ', ')');
            $request = $request.' VALUES (';
            self::writeRequest($request, $params, false, ':', ', ', ');');
            
            $bdd = new Bdd();
            $bdd->requete($request);
            // Bind parametres
            foreach($params as $param)
            {
                self::bindParam($bdd, $param);
            }

            if ($bdd->execute())
            {
                return true;
            }

            return false;
        }

        /**
         * Renvoie vrai si aucun élément existe dans la table fournie avec les paramètres comme condition
         * @$params: Tableau de BindParam
         * @$outelem: Le premier objet trouvé sous forme de tableau
         */
        static public function checkIfEmpty(string $table, array $params, &$outelem) : bool
        {
            $request = 'SELECT * FROM '.$table.' WHERE ';
            self::writeRequest($request, $params, true, '', ' AND ', ';');
            $bdd = new Bdd();
            $bdd->requete($request);
            // Bind parametres
            foreach($params as $param)
            {
                self::bindParam($bdd, $param);
            }
            if ($bdd->execute())
            {
                if ($bdd->getStmt()->rowCount() <= 0)
                {
                    $outelem = null;
                    return true;
                }
            }
            
            $outelem = $bdd->getStmt()->fetch(PDO::FETCH_ASSOC);
            return false;
        }

        static public function updateElement(string $table, array $params, array $conditionsParams) : bool
        {
            $request = 'UPDATE '.$table.' SET ';
            // Ecrire les champs à modifier
            self::writeRequest($request, $params, true, '', ', ', ' WHERE ');
            self::writeRequest($request, $conditionsParams, true, '', ' AND ', ';');
            $bdd = new Bdd();
            $bdd->requete($request);
            // Bind les parametres
            foreach($params as $param)
            {
                self::bindParam($bdd, $param);
            }
            foreach($conditionsParams as $param)
            {
                self::bindParam($bdd, $param);
            }

            if($bdd->execute())
            {
                return true;
            }
            
            return false;
        }

        static public function getFirstValidElement(string $table)
        {
            $request = "SELECT * FROM ".$table;
            $bdd = new Bdd();
            $bdd->requete($request);

            if ($bdd->execute())
            {
                return $bdd->getStmt()->fetch(PDO::FETCH_ASSOC);
            }

            return null;
        }

        static public function getRoleName($roleId) : string
        {
            $bdd = new Bdd();
            $request = "SELECT type FROM roles WHERE id = :id";
            $bdd->requete($request);
            $bdd->bindParam(":id", $roleId, PDO::PARAM_STR);

            if ($bdd->execute())
            {
                $fetch = $bdd->getStmt()->fetch(PDO::FETCH_ASSOC);
                return $fetch['type'];
            }
        }

        static public function getMatiereName($matId) : string
        {
            $bdd = new Bdd();
            $request = "SELECT libelle FROM matiere WHERE id = :id";
            $bdd->requete($request);
            $bdd->bindParam(":id", $matId, PDO::PARAM_INT);

            if ($bdd->execute())
            {
                $fetch = $bdd->getStmt()->fetch(PDO::FETCH_ASSOC);
                return $fetch['libelle'];
            }
        }

        static public function getClasseName($classeId) : string
        {
            $bdd = new Bdd();
            $request = "SELECT libelle FROM classe WHERE id = :id";
            $bdd->requete($request);
            $bdd->bindParam(":id", $classeId, PDO::PARAM_INT);

            if ($bdd->execute())
            {
                $fetch = $bdd->getStmt()->fetch(PDO::FETCH_ASSOC);
                return $fetch['libelle'];
            }
        }

        static public function insererClasseProf($idProf, $idClasse) : bool
        {
            $bdd = new Bdd();
            $request = "INSERT INTO enseigner (id_classe, id_prof) VALUES (:id_classe, :id_prof)";
            $bdd->requete($request);
            $bdd->bindParam(":id_classe", $idClasse, PDO::PARAM_INT);
            $bdd->bindParam(":id_prof", $idProf, PDO::PARAM_INT);

            if ($bdd->execute())
            {
                return true;
            }
            return false;
        }

        static public function deleteClasseProf($idProf, $idClasse) : bool
        {
            $bdd = new Bdd();
            $request = "DELETE FROM enseigner WHERE id_classe = :id_classe AND id_prof = :id_prof";
            $bdd->requete($request);
            $bdd->bindParam(":id_classe", $idClasse, PDO::PARAM_INT);
            $bdd->bindParam(":id_prof", $idProf, PDO::PARAM_INT);

            if ($bdd->execute())
            {
                return true;
            }
            return false;
        }

        static public function getLastInsertId() : int
        {
            return Bdd::getPDO()->lastInsertId();
        }

        static public function getProfClasses($idProf)
        {
            $bdd = new Bdd();
            $request = "SELECT classe.id FROM classe
            JOIN enseigner ON enseigner.id_classe = classe.id
            JOIN user ON enseigner.id_prof = user.id
            WHERE user.id = :id_prof";
            $bdd->requete($request);
            $bdd->bindParam(':id_prof', $idProf, PDO::PARAM_INT);

            if ($bdd->execute())
            {
                return $bdd->getStmt()->fetchAll(PDO::FETCH_COLUMN);
            }
            
            return null;
        }

        static public function getProfMatiere($idClasse, $idMatiere)
        {
            $bdd = new Bdd();
            $request = "SELECT user.id, nom, prenom FROM user
            JOIN enseigner ON enseigner.id_prof = user.id
            WHERE id_matiere = :id_matiere AND enseigner.id_classe = :id_classe AND id_role = 'ROLE_PROF'";
            $bdd->requete($request);

            $bdd->bindParam(":id_matiere", $idMatiere, PDO::PARAM_INT);
            $bdd->bindParam(":id_classe", $idClasse, PDO::PARAM_INT);

            if ($bdd->execute())
            {
                return $bdd->getStmt()->fetchAll(PDO::FETCH_ASSOC);
            }

            return null;
        }

        static public function getUserCount(string $role) : int
        {
            $bdd = new Bdd();
            $request = "SELECT COUNT(id) FROM user WHERE id_role = :id_role";
            $bdd->requete($request);
            $bdd->bindParam(":id_role", $role, PDO::PARAM_STR);

            if ($bdd->execute())
            {
                return (int)$bdd->getStmt()->fetch(PDO::FETCH_COLUMN);
            }

            return 0;
        }

        static public function selectCours(string $date, string $debut, string $fin, array $classes, string $idProf = '') : int
        {
            $bdd = new Bdd();
            $request = "SELECT id FROM cours WHERE
            date = :date 
            AND debut >= :debut
            AND fin <= :fin";

            if (count($classes) > 0)
            {
                $request = $request." AND ( ";
            }
            for ($i = 0; $i < count($classes); ++$i)
            {
                $request = $request."id_classe = :id_classe".$i;

                if ($i == count($classes) - 1)
                {
                    $request = $request.")";
                }
                else
                {
                    $request = $request." OR ";
                }
            }

            if ($idProf != '')
            {
                $request = $request.' AND id_prof = :id_prof';
            }

            $bdd->requete($request);
            $bdd->bindParam(":date", $date, PDO::PARAM_STR);
            $bdd->bindParam(":debut", $debut, PDO::PARAM_STR);
            $bdd->bindParam(":fin", $fin, PDO::PARAM_STR);
            for ($i = 0; $i < count($classes); ++$i)
            {
                $bdd->bindParam(":id_classe".$i, $classes[$i], PDO::PARAM_INT);
            }
            if ($idProf != '')
            {
                $bdd->bindParam(":id_prof", $idProf, PDO::PARAM_INT);
            }

            if ($bdd->execute())
            {
                $result = $bdd->getStmt()->fetch(PDO::FETCH_COLUMN);
                if ($result)
                {
                    return $result;
                }
                else
                {
                    return 0;
                }
            }

            return 0;
        }
        
        static private function selectCoursIdEtu($id)
        {
            $bdd = new Bdd();
            $request = "SELECT user.nom AS nom, cours.debut as debut, cours.fin AS fin, matiere.libelle AS libelle, matiere.id AS id_matiere, cours.id AS id FROM cours 
            JOIN user ON user.id = cours.id_prof
            JOIN matiere ON matiere.id = user.id_matiere
            WHERE cours.id = :id";

            $bdd->requete($request);
            $bdd->bindParam(":id", $id, PDO::PARAM_INT);

            if ($bdd->execute())
            {
                return $bdd->getStmt()->fetchAll(PDO::FETCH_ASSOC);
            }

            return null;
        }

        static private function selectCoursIdProf($id)
        {
            $bdd = new Bdd();
            $request = "SELECT classe.libelle as classe, cours.debut as debut, cours.fin AS fin, matiere.id AS id_matiere, cours.id AS id FROM cours 
            JOIN classe ON classe.id = cours.id_classe
            JOIN user ON user.id = cours.id_prof
            JOIN matiere ON matiere.id = user.id_matiere
            WHERE cours.id = :id";

            $bdd->requete($request);
            $bdd->bindParam(":id", $id, PDO::PARAM_INT);

            if ($bdd->execute())
            {
                return $bdd->getStmt()->fetchAll(PDO::FETCH_ASSOC);
            }

            return null;
        }

        static private function selectCoursIdAdmin($id)
        {
            $bdd = new Bdd();
            $request = "SELECT user.nom AS nom, cours.debut as debut, cours.fin AS fin, matiere.libelle AS libelle, matiere.id AS id_matiere, classe.libelle AS classe, cours.id AS id FROM cours 
            JOIN user ON user.id = cours.id_prof
            JOIN classe ON classe.id = cours.id_classe
            JOIN matiere ON matiere.id = user.id_matiere
            WHERE cours.id = :id";

            $bdd->requete($request);
            $bdd->bindParam(":id", $id, PDO::PARAM_INT);

            if ($bdd->execute())
            {
                return $bdd->getStmt()->fetchAll(PDO::FETCH_ASSOC);
            }

            return null;
        }

        static public function selectCoursId($id)
        {
            if(!session_id())
            {
                session_start();
            }

            if (isAdmin())
            {
                return self::selectCoursIdAdmin($id);
            }
            else if (isProf())
            {
                return self::selectCoursIdProf($id);
            }
            else
            {
                return self::selectCoursIdEtu($id);
            }
        }

        static public function selectHorairesCoursProf($idProf, $date)
        {
            $bdd = new Bdd();
            $requete = "SELECT debut, fin FROM cours WHERE id_prof = :id_prof AND date = :date";
            $bdd->requete($requete);
            $bdd->bindParam(":id_prof", $idProf, PDO::PARAM_INT);
            $bdd->bindParam(":date", $date, PDO::PARAM_STR);

            if ($bdd->execute())
            {
                return $bdd->getStmt()->fetchAll(PDO::FETCH_NUM | PDO::FETCH_NAMED);
            }

            return null;
        }

        static public function selectHorairesCoursClasse($idClasse, $date)
        {
            $bdd = new Bdd();
            $requete = "SELECT debut, fin FROM cours WHERE id_classe = :id_classe AND date = :date";
            $bdd->requete($requete);
            $bdd->bindParam(":id_classe", $idClasse, PDO::PARAM_INT);
            $bdd->bindParam(":date", $date, PDO::PARAM_STR);

            if ($bdd->execute())
            {
                return $bdd->getStmt()->fetchAll(PDO::FETCH_NUM | PDO::FETCH_NAMED);
            }

            return null;
        }
    }
?>