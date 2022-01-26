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

    $querry = $bdd->prepare("SELECT * FROM articles ORDER BY publication_date DESC");
    $querry->execute();
    $fetch = $querry->fetchAll();

    $i = 0;
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

        <?php 
        while ($fetch && $i<count($fetch))
        {
        ?>

        <div class="card-admin">
            <a href="details.php?id=<?php echo utf8_encode($fetch[$i]['articleId']); ?>">
                <h3><?=ucwords(utf8_encode($fetch[$i]['title'])); ?></h3>
                <p><?php echo utf8_encode($fetch[$i]['description']);?></p>
                <p><?php echo utf8_encode($fetch[$i]['author_username']);?></p>
                <p><?php echo utf8_encode($fetch[$i]['publication_date']);?></p>
            </a>
            <?php if($fetch[$i]['author'] == $_SESSION['id'] OR $_SESSION['username'] == "admin") { ?>
                <a class="button-suppr" href="suppr-article.php?id=<?php echo utf8_encode($fetch[$i]['articleId']); ?>"><span>Supprimer<span></a>
            <?php }?>
        </div>
        <?php 
        $i++;
        } ?>   
    </body>
</html>