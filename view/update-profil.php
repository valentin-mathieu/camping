<?php

session_start();

require('../controller/update-profilController.php');

// récupération des infos pour préremplissage du formulaire

$getinfos_user = new User;
$getinfos_user->Getinfos();

?>

<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Compte</title> 
        <link rel="stylesheet" href="style/update-profil.css">
    </head>

    <body>

        <?php require('header.php') ?>

        <main>
            
            <section id="centralbox">

                <div class="form">

                    <h2 class="boxtitle">Modifier vos informations</h2>
                
                    <form action="update-profil.php" method="post">

                        <label for="newlogin">Nouveau login</label>
                        <?php if(isset($err_login)){ echo"<p class='err_form'> $err_login</p>";}?>
                        <div><input type="text" name="newlogin" placeholder="login" value="<?php if (isset($newlogin)) { echo $newlogin ;} else echo $getinfos_user->login ;?>"></div>

                        <label for="newfirstname">Nouveau prénom</label>
                        <?php if(isset($err_firstname)){echo"<p class='err_form'> $err_firstname</p>";}?>
                        <div><input type="text" name="newfirstname" placeholder="firstname" value="<?php if (isset($newfirstname)) { echo $newfirstname ;} else echo $getinfos_user->firstname ; ?>"></div>

                        <label for="newlastname">Nouveau nom de famille</label>
                        <?php if(isset($err_lastname)){echo"<p class='err_form'> $err_lastname</p>";}?>
                        <div><input type="text" name="newlastname" placeholder="lastname" value="<?php if (isset($newlastname)) { echo $newlastname ;} else echo $getinfos_user->lastname ?>"></div>

                        <label for="password">Mot de passe pour confirmation</label>
                        <?php if(isset($err_passwordinfos)){echo"<p class='err_form'> $err_passwordinfos</p>";}?>
                        <div><input type="password" name="password" placeholder="Confirmez avec votre mot de passe."></div>

                        <input type="submit" name="updateinfos" value="Changer les informations">

                        <?php if($success_infos == 1){ ?>
                            <p>Vos informations ont été modifiées avec succès.</p>
                        <?php } ?>

                    </form>

                </div>

                <div class="form">

                    <h2 class="boxtitle">Modifier votre adresse email</h2>
                    <?php if (isset($message)) { echo $message;}?>

                        <form action="update-profil.php" method="post">

                            <label for="newemail">Nouvelle adresse e-mail</label>
                            <?php if(isset($err_email)){echo"<p class='err_form'> $err_email</p>";}?>
                            <div><input type="text" name="newemail" placeholder="email" value="<?php if (isset($newemail)) { echo $newemail; }?>"></div>
                            
                            <label for="checkemail">Confirmez votre nouvel e-mail</label>
                            <?php if(isset($err_checkemail)){echo"<p class='err_form'> $err_checkemail</p>";}?>
                            <div><input type="text" name="checkemail" placeholder="Confirmer l'email" value="<?php if(isset($checkemail)){echo $checkemail;} ?>"></div>
                        
                            <label for="password">Mot de passe pour confirmation</label>
                            <?php if(isset($err_password)){echo"<p class='err_form'> $err_password</p>";}?>
                            <div><input type="password" name="password" placeholder="Confirmer avec votre mot de passe."></div>

                            <input type="submit" name="updateemail" value="Changer l'email">
                            
                            <?php if($success_mail == 1){ ?>
                                <p>Vos informations ont été modifiées avec succès.</p>
                            <?php } ?>

                        </form>
                    
                </div>
                

                

                <div class="form">

                    <h2 class="boxtitle">Modifier votre mot de passe</h2>
                    <?php if (isset($message)) { echo $message;}?>

                        <form action="update-profil.php" method="post">

                            <label for="actualpassword">Mot de passe actuel</label>
                            <?php if(isset($err_actualpassword)){echo"<p class='err_form'> $err_actualpassword</p>";}?>
                            <div><input type="password" name="actualpassword" placeholder="Mot de passe actuel"></div>
                            
                            <label for="newpassword">Nouveau mot de passe</label>
                            <?php if(isset($err_newpassword)){echo"<p class='err_form'> $err_newpassword</p>";}?>
                            <div><input type="password" name="newpassword" placeholder="Nouveau mot de passe"></div>
                
                            <label for="checkpassword">Confirmez votre nouveau mot de passe</label>
                            <?php if(isset($err_checkpassword)){echo"<p class='err_form'> $err_checkpassword</p>";} if(isset($err_passwords)){echo"<p class='err_form'> $err_passwords</p>";}?>
                            <div><input type="password" name="checkpassword" placeholder="Confirmer le mot de passe"></div>
                            
                            <input type="submit" name="updatepassword" value="Changer le mot de passe">
                            
                            <?php if($success_password == 1){ ?>
                                <p>Vos informations ont été modifiées avec succès.</p>
                            <?php } ?>

                        </form>
                    
                </div>

            </section>

        </main>

        <?php require('footer.php'); ?>
    
    </body>
</html>
