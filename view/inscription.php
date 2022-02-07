<?php  
session_start();

require('../controller/inscriptionController.php');

?>

<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Inscription</title> 
        <link rel="stylesheet" type="text/css" href="style/inscription.css">
    </head>

    <body>

        <?php require('header.php') ?>

        <main>
            
            <?php if ($form_register == 1){ ?>
            <h1> Créer mon compte </h1>

            <div class="box">

                <form action="inscription.php" method="post">


                    
                    <label for="login">Login</label>
                    <?php if (isset($err_login)) {echo "<div class='err_form'> $err_login<div>";}?>
                    <input type="text" name="login" placeholder="login" value="<?php if(isset($login)){echo $login;} ?>">

                    <label for="firstname">Prénom</label>
                    <?php if(isset($err_firstname)){echo "<div class='err_form'>$err_firstname </div>";}?>
                    <input type="text" name="firstname" placeholder="prenom" value="<?php if(isset($firstname)){echo $firstname;} ?>">

                    <label for="lastname">Nom</label>
                    <?php if(isset($err_lastname)){echo "<div class='err_form'> $err_lastname <div>";}?>
                    <input type="text" name="lastname" placeholder="nom" value="<?php if(isset($lastname)){echo $lastname;} ?>">

                    <label for="email">Adresse email</label>
                    <?php if(isset($err_email)){echo "<div class='err_form'> $err_email <div>";}?>
                    <input type="text" name="email" placeholder="email"value="<?php if(isset($email)){echo $email;} ?>">

                    <label for="checkemail">Confirmez l'adresse email</label>
                    <?php if(isset($err_checkemail)){echo "<div class='err_form'> $err_checkemail <div>";}?>
                    <input type="text" name="checkemail" placeholder="Confirmer l'email" value="<?php if(isset($checkemail)){echo $checkemail;} ?>">

                    <label for="password">Mot de passe</label>
                    <?php if(isset($err_password)){echo "<div class='err_form'> $err_password <div>";}?>
                    <input type="password" name="password" placeholder="Mot de passe">

                    <label for="checkpassword">Confirmez le mot de passe</label>
                    <?php if(isset($err_checkpassword)){echo "<div class='err_form'> $err_checkpassword <div>";}?>
                    <input type="password" name="checkpassword" placeholder="Confirmer le mot de passe">

                    <div><input type="submit" name="suscribe" value="Inscription"></div>

                </form>
            </div>
            
            <?php } else { ?>

                <p id="success_message">Vous êtes inscrit avec succès, redirection en cours...</p>

            <?php header("Refresh: 3 ; url=compte.php"); } ?>
            

    
        </main>

        <?php require('footer.php'); ?>
    
    </body>
</html>