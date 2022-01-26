<?php 
    session_start();

    require 'bdd.php';

    if(empty($_SESSION['id']))
    {
        header("Location: login.php");
    }

    if(isset($_GET['id']) AND $_GET['id'] > 0)
    {
        $getid = intval($_GET['id']);
        $requser = $bdd->prepare('SELECT * FROM users WHERE id = ?');
        $requser->execute(array($getid));
        $userinfo = $requser->fetch();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <title>Forum- Profil</title>
    </head>
    <body>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="account.php?id=<?php echo  $_SESSION['id']; ?>">Profil</a></li>
                <li><a href="disconnection.php">Se déconnecter</a></li>
                <li><p><?php echo  $_SESSION['username'];?></p></li>
                <li><img class="avatar" src="img/avatars/<?php echo $_SESSION['avatar'];?>" width="150"></li>
            </ul>
        </nav>

        <img id="img-home" src="img/img-home.png" alt="">

        <div id="div-add-article">
            <a id="add-article" href="new.php">+ Nouvel Article</a>
        </div>

        <div class="title-with-border">
            <h1>Profil</h1>
        </div>

        <div class="card-profil">
                <div class="card-body">
                    <div class="card-date">
                        <time><a style="text-decoration: underline;" href="editionprofile.php">Editer le profil</a> </time>
                    </div>

                    <div class="card-title">
                        <h3>Pseudo : <?php echo  $_SESSION['username'];?></h3>
                        <h3>Email : <?php echo  $_SESSION['email'];?></h3>
                    </div>

                    <img id="account-img" src="img/avatars/<?php echo $_SESSION['avatar'];?>">
                </div>
            </a>
        </div>

        <div class="title-with-border">
            <h1>Vos articles</h1>
        </div>

        <?php 
        $idsession = $_SESSION['id'];
        $querry = $bdd->prepare("SELECT * FROM articles WHERE author = $idsession ORDER BY publication_date DESC");
        $querry->execute();
        $fetch = $querry->fetchAll();

        $i = 0;

        while ($fetch && $i<count($fetch))
        {
        ?>

        <div class="card">
        <a href="details.php?id=<?php echo utf8_encode($fetch[$i]['articleId']); ?>">
                <div class="card-body">

                    <div class="card-date">
                        <time><?php echo utf8_encode($fetch[$i]['publication_date']); ?></time>
                    </div>

                    <div class="card-title">
                        <h3><?=ucwords(utf8_encode($fetch[$i]['title'])); ?></h3>
                    </div>

                    <div class="card-excerpt">
                        <p><?php echo utf8_encode($fetch[$i]['description']);?></p>
                    <div>
                        <p>Auteur : <?php echo utf8_encode($fetch[$i]['author_username']);?></p>
                    </div>

                    <?php if($fetch[$i]['author'] == $_SESSION['id'] OR $_SESSION['username'] == "admin") { ?>
                <a class="button-suppr" href="suppr-article.php?id=<?php echo utf8_encode($fetch[$i]['articleId']); ?>"><span>Supprimer<span></a>
            <?php }?>
                </div>
            </a>
        </div>

        <?php 
        $i++;
        } ?>
    </body>
</html>

<?php
}
?>