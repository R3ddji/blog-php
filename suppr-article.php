<?php 
    session_start();

    require 'bdd.php';

    if(empty($_SESSION['id']))
    {
        header("Location: login.php");
    }

    if(isset($_GET['id']) AND !empty($_GET['id'])) {
        $get_id = htmlspecialchars($_GET['id']);
        $article = $bdd->prepare('DELETE FROM articles WHERE articleId = ?');
        $article->execute(array($get_id));

        header("Location: index.php");
    }
?>