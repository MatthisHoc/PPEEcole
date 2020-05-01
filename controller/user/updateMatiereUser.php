<?php
    include(__DIR__."/../commandesBdd.php");
    $params =
    [
        new BindParam('id_matiere', $_GET['id_matiere'], PDO::PARAM_INT)
    ];
    CommandesBdd::updateElement('user', $params, [new BindParam('id', $_GET['id'], PDO::PARAM_INT)]);
    redirect("empty");
?>