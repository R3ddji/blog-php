<?php 
    session_start();

    require 'bdd.php';

    if(isset($_POST['connexion']))
    {
        $usernameconnect = htmlspecialchars($_POST['usernameconnect']);
        $passwordconnect = md5($_POST['passwordconnect']);

        if(!empty($usernameconnect) AND !empty($passwordconnect)) 
        {
            $requser = $bdd->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
            $requser->execute(array($usernameconnect, $passwordconnect));
            $userexist = $requser->rowCount();

            if($userexist == 1) 
            {
                $userinfo = $requser->fetch();
                $_SESSION['id'] = $userinfo['id'];
                $_SESSION['username'] = $userinfo['username'];
                $_SESSION['avatar'] = $userinfo['avatar'];
                $_SESSION['email'] = $userinfo['email'];
                header("Location: index.php");
            } 
            else 
            {
                $erreur = "Mauvaises Informations !";
            }
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
        <title>Forum - Connexion</title>
    </head>
    <body>
        <div class="login_form">

            <h2>Connexion</h2>

            <form method="POST" action="">
                <div class="login_box">
                    <input type="text" placeholder="Pseudo" name="usernameconnect" id="usernameconnect">
                </div>

                <div class="login_box">
                    <input type="password" placeholder="Mot de passe" name="passwordconnect" id="passwordconnect">
                </div>
                
                <input class="submit" type="submit" name="connexion" value="Se connecter">
            </form>

            <p>Pas de compte ? Inscrivez-vous <a href="register.php">ici</a> !</p>

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