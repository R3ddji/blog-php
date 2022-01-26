<?php 
    session_start();

    require 'bdd.php';

    if(empty($_SESSION['id']))
    {
        header("Location: login.php");
    }

    if(isset($_GET['id']) AND !empty($_GET['id'])) {
        $get_id = htmlspecialchars($_GET['id']);
        $article = $bdd->prepare('DELETE FROM users WHERE id = ?');
        $article->execute(array($get_id));

        header("Location: admin-users.php");
    }
?>