<?php

    function isAdmin() : bool
    {
        return !empty($_SESSION['admin']);
    }

    function isStudent() : bool
    {
        return !empty($_SESSION['etudiant']);
    }

    function isProf() : bool
    {
        return !empty($_SESSION['prof']);
    }
?>