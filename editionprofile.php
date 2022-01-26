<?php 
    session_start();

    require 'bdd.php';

    if(empty($_SESSION['id']))
    {
        header("Location: login.php");
    }

    if(isset($_SESSION['id']))
    { 
            $requser = $bdd->prepare("SELECT * FROM users WHERE id = ?");
            $requser->execute(array($_SESSION['id']));
            $user = $requser->fetch();

            if(isset($_POST['newusername']) AND !empty($_POST['newusername']) AND $_POST['newusername'] != $user['username'])
            {
                $newusername = htmlspecialchars($_POST['newusername']);
                $insertusernmae = $bdd->prepare("UPDATE users SET username = ? WHERE id = ?");
                $insertusernmae->execute(array($newusername, $_SESSION['id']));
                $_SESSION['username'] = $_POST['newusername'];
                header("Location: account.php?id=".$_SESSION['id']);
            } 

            if(isset($_POST['newemail']) AND !empty($_POST['newemail']) AND $_POST['newemail'] != $user['email'])
            {
                $newemail = htmlspecialchars($_POST['newemail']);
                $insertemail = $bdd->prepare("UPDATE users SET email = ? WHERE id = ?");
                $insertemail->execute(array($newemail, $_SESSION['id']));
                $_SESSION['email'] = $_POST['newemail'];
                header("Location: account.php?id=".$_SESSION['id']);
            }

            if(isset($_POST['newpassword']) AND !empty($_POST['newpassword']) AND isset($_POST['confirmnewpassword']) AND !empty($_POST['confirmnewpassword']))
            {
                $newpassword = md5($_POST['newpassword']);
                $confirmnewpassword = md5($_POST['confirmnewpassword']);

                if($newpassword == $confirmnewpassword)
                {
                    $insertpassword = $bdd->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $insertpassword->execute(array($newpassword, $_SESSION['id']));
                    header("Location: account.php?id=".$_SESSION['id']);
                } 
                else 
                {
                    $erreur = "Mot de passe ne corespondent pas !";
                }
            }

            if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) 
            {
                $tailleMax = 2097152;
                $extentionCheck = array('jpg', 'jpeg', 'gif', 'png');
                if($_FILES['avatar']['size'] <= $tailleMax) 
                {
                    $extentionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
                    if(in_array($extentionUpload, $extentionCheck)) 
                    {
                        $chemin = "img/avatars/".$_SESSION['id'].".".$extentionUpload;
                        $result = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
                        if($result) 
                        {
                            $updateAvatar = $bdd->prepare('UPDATE users SET avatar = :avatar WHERE id = :id');
                            $updateAvatar->execute(array(
                                'avatar' => $_SESSION['id'].".".$extentionUpload,
                                'id' => $_SESSION['id']
                            ));
                            $_SESSION['avatar'] = $_SESSION['id'].".".$extentionUpload;
                            header("Location: account.php?id=".$_SESSION['id']);
                        }
                        else 
                        {
                            $erreur = "Erreur lors de l'importation du fichier !";
                        }
                    }
                    else 
                    {
                        $erreur = "Photo de profil uniquement en jpg, jpeg, png, gif...";
                    }
                } else 
                {
                    $erreur = "Photo de profil trop volumineuse !";
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
        <title>Forum</title>
    </head>
    <body>

        <div class="login_form">
            <h2>Edition du profil</h2>

            <form method="POST" enctype="multipart/form-data">
                <div class="login_box">
                    <input type="file" name="avatar" id="avatar">
                </div>
                <div class="login_box">
                    <input type="text" name="newusername" id="newusername" placeholder="Pseudo" value="<?php echo $user['username'];?>">
                </div>
                <div class="login_box">
                    <input type="email" name="newemail" id="newemail" placeholder="Mail" value="<?php echo $user['email'];?>">
                </div>
                <div class="login_box">
                    <input type="password" name="newpassword" id="newpassword" placeholder="Mot de passe">
                </div>
                <div class="login_box">
                    <input type="password" name="confirmnewpassword" id="confirmnewpassword" placeholder="Mot de passe">
                </div>
                <input class="submit" type="submit" value="Mettre à jour">

                <a class="return-home" href="account.php?id=<?php echo $_SESSION['id']?>">Retour</a>
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

<?php
}
else
{
    header("Location: login.php");
};
?>
