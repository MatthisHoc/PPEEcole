<?php

    include_once(__DIR__."\..\connect.php");
    include_once(__DIR__."\..\commandesBdd.php");

    function getAdresseById($id)
    {
        $bdd = new Bdd();
        $bdd->requete('SELECT * FROM adresse WHERE id = '.$id);
        
        if ($bdd->execute())
        {
            return $bdd->getStmt()->fetch(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }

    function insertUniqueAdresse(string $rue, string $ville, string $cp) : int
    {
        $params =
        [
            new BindParam('rue', $rue, PDO::PARAM_STR),
            new BindParam('ville', $ville, PDO::PARAM_STR),
            new BindParam('cp', $cp, PDO::PARAM_STR)
        ];
        $elem = null;
        if(!CommandesBdd::checkIfEmpty('adresse', $params, $elem))
        {
            return $elem['id'];
        }
        else
        {            
            // Sinon inserer une adresse et retourner l'id
            // Créer une adresse 
            if (CommandesBdd::insertElement('adresse', $params))
            {
                $bdd = new Bdd();
                return $bdd->getPDO()->lastInsertId();
            } 
            else
            {
                return -1;
            }
        }
    }

    function updateAdresse(int $id, string $rue, string $ville, string $cp) : bool
    {
        $params =
        [
            new BindParam('rue', $rue, PDO::PARAM_STR),
            new BindParam('ville', $ville, PDO::PARAM_STR),
            new BindParam('cp', $cp, PDO::PARAM_STR)
        ];
        if (CommandesBdd::updateElement('adresse', $params, [new BindParam('id', $id, PDO::PARAM_INT)]))
        {
            return true;
        }

        return false;
    }
?>