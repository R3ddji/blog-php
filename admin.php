<?php 
    session_start();

    require 'bdd.php';

    if($_SESSION['username'] != "admin")
    {
        header("Location: index.php");
    }

    if(empty($_SESSION['id']))
    {
        header("Location: login.php");
    }
?> 

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <title>Forum - Panel Admin</title>
    </head>
    <body>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="account.php?id=<?php echo  $_SESSION['id']; ?>">Profil</a></li>
                <li><a href="disconnection.php">Se déconnecter</a></li>
                <li><a href="account.php?id=<?php echo  $_SESSION['id']; ?>"><p><?php echo  $_SESSION['username'];?></p></a></li>
                <li><a href="account.php?id=<?php echo  $_SESSION['id']; ?>"><img src="img/avatars/<?php echo $_SESSION['avatar'];?>"></a></li>
            </ul>
        </nav>

        <img id="img-home" src="img/img-home.png" alt="">
        
        <div id="div-add-article-admin">
            <a id="add-article" href="new.php">+ Nouvel Article</a>
        </div> 
        
        <div class="title-with-border">
            <h1>Administrations</h1>
        </div>

        <div class="admin-links">
            <a href="admin-articles.php">Articles</a>

            <a href="admin-users.php">Utilisateurs</a>
        </div>
    </body>
</html>