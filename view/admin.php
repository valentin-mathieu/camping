<?php

session_start();


?>


<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Compte</title> 
        <link rel="stylesheet" type="text/css" href="style/compte.css">
    </head>

    <body>

      <?php require('header.php')?>

        <main>

            <form action="compte.php" method="post">

                <div><label for="login" class="userlabel">Login</label></div>
                <div><input type="text" class="userinput" name="login"></div>

                <div><label for="password" class="userlabel">Mot de passe</label></div>
                <div><input type="password" class="userinput" name="password"></div>

                <div class="button"><input type="submit" name="connexion" class="usersubmit" value="Se connecter"></div>

            </form>


        </main>

        <?php require('footer.php'); ?>
    
    </body>
</html>