<?php
    session_start();

    require 'bdd.php';

    if(empty($_SESSION['id']))
    {
        header("Location: login.php");
    }

    if(isset($_GET['id']) AND !empty($_GET['id'])) {
        $get_id = htmlspecialchars($_GET['id']);
        $article = $bdd->prepare('SELECT * FROM articles WHERE articleId = ?');
        $article->execute(array($get_id));

        if($article->rowCount() == 1) {
            $article = $article->fetch();
            $title = $article['title'];
            $description = $article['description'];
            $contenu = $article['content']; 
            $author = $article['author_username']; 
            $date = $article['publication_date']; 
        } else {
            header("Location: index.php");
        }
    } else {
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <title>Forum - Details</title>
    </head>
    <body>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="account.php?id=<?php echo  $_SESSION['id']; ?>">Profil</a></li>
                <li><a href="disconnection.php">Se déconnecter</a></li>
                <li><p><?php echo  $_SESSION['username'];?></p></li>
                <li><img src="users/avatars/<?php echo $_SESSION['avatar'];?>"></li>
            </ul>
        </nav>

        <img id="img-home" src="img/img-home.png" alt="">
        
        <div id="div-add-article-admin">
            <a id="add-article" href="new.php">+ Nouvel Article</a>
        </div> 

        <div class="card">
            <div class="card-body-detail">
                <div class="card-date">
                    <time><?= utf8_encode($date); ?></time>
                </div>

                <div class="card-title">
                    <h3><?= ucwords(utf8_encode($title)); ?></h3>
                </div>

                <div class="card-excerpt">
                    <p><?= utf8_encode($description); ?></p>
                <div>

                <div class="card-excerpt">
                    <p><?= utf8_encode($contenu); ?></p>
                <div>
                    <p>Auteur : <?= utf8_encode($author); ?></p>
                </div>
                <?php if($author == $_SESSION['id'] OR $_SESSION['username'] == "admin") { ?>
                <a class="button-suppr" href="suppr-article.php?id=<?php echo utf8_encode($get_id); ?>"><span>Supprimer<span></a>
            <?php }?>
            </div>
        </div>
    </body>
</html>