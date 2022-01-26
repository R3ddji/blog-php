<?php 
    session_start();

    require 'bdd.php';

    if(empty($_SESSION['id']))
    {
        header("Location: login.php");
    }
    
    if(isset($_POST['newarticle']))
    {
        $title = htmlspecialchars($_POST['title']);
        $description = htmlspecialchars($_POST['description']);
        $content = htmlspecialchars($_POST['content']);
        $creation_date = htmlspecialchars($_POST['creation_date']);

        if(!empty($title) AND !empty($description) AND !empty($content) AND !empty($creation_date)) 
        {
            $insertarticle = $bdd->prepare("INSERT INTO articles(title, description, content, publication_date, author_username, author) VALUES(?,?,?,?,?,?)");
            $insertarticle->execute(array($title, $description, $content, $creation_date, $_SESSION['username'], $_SESSION['id']));
            header('Location: index.php');
        } 
        else {
            $erreur = "Tous les champs ne sont pas rempli !";
        }
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Forum - New</title>
</head>
<body>
    <div class="login_form">
    <h2>Nouvel Article</h2>
    <form method="POST" action="">
        <div class="login_box">
            <input type="text" placeholder="Titre" name="title" id="title">
        </div>

        <div class="login_box">
            <input type="text" placeholder="Description" name="description" id="description">
        </div>

        <div class="login_box">
            <input type="text" placeholder="Texte" name="content" id="content" style="width:200px; height:200px;">
        </div>

        <div class="login_box">
            <input type="text" placeholder="00/00/0000" name="creation_date" id="creation_date">
        </div>
        
        <input class="submit" type="submit" name="newarticle" value="Créer">

        <a class="return-home" href="index.php">Retour</a>
    </form>
    <p style="color: white;">
            <?php 
                if(isset($erreur)) {
                    echo $erreur;
                }
            ?>
        </p>
    </div>
</body>
</html>