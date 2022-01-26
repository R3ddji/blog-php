<?php 
    require 'bdd.php';

    $inscriptioncheck = false;

    if(isset($_POST['inscription']))
    {
        $username = htmlspecialchars($_POST['username']);    
        $email = htmlspecialchars($_POST['email']);
        $password = md5($_POST['password']);   
        $confirmpassword = md5($_POST['confirmpassword']);  

        if(!empty($_POST['username']) AND !empty($_POST['email']) AND !empty($_POST['password']) AND !empty($_POST['confirmpassword'])) 
        {   
            $usernamelength = strlen($username);
            if($usernamelength <= 255) 
            {
                if(filter_var($email, FILTER_VALIDATE_EMAIL)) 
                {
                    $reqemail = $bdd->prepare("SELECT * FROM users WHERE email = ?");
                    $reqemail->execute(array($email));
                    $emailexist = $reqemail->rowCount();

                    $requsername = $bdd->prepare("SELECT * FROM users WHERE username = ?");
                    $requsername->execute(array($username));
                    $usernameexist = $requsername->rowCount();

                    if($usernameexist == 0){
                        if($emailexist == 0) 
                        {
                            if($password == $confirmpassword) 
                            {
                                $insertuser = $bdd->prepare("INSERT INTO users(username, email, password, avatar) VALUES(?,?,?,?)");
                                $insertuser->execute(array($username, $email, $password, "default.png"));
                                header('Location: login.php');
                            } else {
                                $erreur = "Mot de passe ne corespondent pas !";
                            }
                        } else 
                        {
                            $erreur = "Adresse mail déjà utilisée !"; 
                        }
                    } else 
                    {
                        $erreur = "Pseudo déjà utilisé !";
                    }
                }
            } else {
                $erreur = "Pseudo trop long !";
            }
        } 
        else 
        {
            $erreur = "Tous les champs doivent être remplis !";
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
    <title>Forum- Inscription</title>
</head>
<body>
    <div class="login_form">
        <form method="POST" action="">
            <h2>Inscription</h2>
            <div class="login_box">
                <input type="text" placeholder="Pseudo" name="username" id="username" value="<?php if(isset($username)) {echo $username;}?>">
            </div>

            <div class="login_box">
                <input type="email" placeholder="Email" name="email" id="email" value="<?php if(isset($email)) {echo $email;}?>">
            </div>

            <div class="login_box">
                <input type="password" placeholder="Mot de passe" name="password" id="password">
            </div>

            <div class="login_box">
                <input type="password" placeholder="Mot de passe" name="confirmpassword" id="confirmpassword">
            </div>
            
                <input class="submit" type="submit" name="inscription" value="Envoyer">
        </form>
        <p>Déjà un compte ? Connectez-vous <a href="login.php">ici</a> !</p>

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