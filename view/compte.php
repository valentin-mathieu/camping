<?php

session_start();
require('../controller/compteController.php');





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

            <?php if (!isset($_SESSION['login'])) { ?>

        
                <section class="container">

                    <div class="box">

                        <div><h2 class="boxtitle">J'ai déjà un compte</h2></div>

                        <form action="compte.php" method="post">

                            <div><label for="login">Login</label></div>
                            <?php if (isset($err_login)) {echo "<p class='err_form'> $err_login<p>";}?>
                            <div><input type="text" name="login"></div>

                            <div><label for="password">Mot de passe</label></div>
                            <?php if(isset($err_password)){echo "<p class='err_form'> $err_password<p>";} if(isset($err_connexion)){echo"<p class='err_form'> $err_connexion<p>";}?>
                            <div><input type="password" name="password"></div>

                            <input type="submit" name="connexion" value="Se connecter"></div>

                        </form>
                    </div>

                    <div class="box">

                        <div><h2 class="boxtitle">Je créé un compte</h2><div>

                        <div class="textbox">Je peux réserver un séjour chez Happy Sardines.</div>
                        <div class="textbox">Je peux consulter et modifier mes réservations.</div>
                        <div class="textbox">Je peux consulter et modifier mes informations.</div>

                        <form action="compte.php" method="post">
                            <input type="submit" name="suscribe" value="Inscription">
                        </form>


                    </div>

                    


                </div>
            <?php } ?>

            <!--  AFFICHAGE DU COMPTE SI CONNECTE  -->

            <?php if(isset($_SESSION['login'])) { ?> 
            
            <section class="container">

                <div class="box">

                    <div><h2 class="boxtitle"> Vos informations </h2></div>

                    <table border="1">
                        <tr>
                            <td>Login</td>
                            <td><?php echo $getinfos_user->login;?></td>
                        </tr>
                        <tr>
                            <td>Nom de famille</td>
                            <td><?php echo $getinfos_user->lastname;?></td>
                        </tr>
                        <tr>
                            <td>Prénom</td>
                            <td><?php echo $getinfos_user->firstname;?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><?php echo $getinfos_user->email;?></td>
                        </tr>
                    </table>

                    <form action="update-profil.php" method="post">
                        <input type="submit" name="updateprofil" value="Modifier">
                    </form>

                </div>

                <div class="box">

                    <div><h2 class="boxtitle"> Vos réservations </h2></div>

                    <div><?php 
                        $test = new Reservations;
                        $test->ListingUserBookings();
                    ?></div>

                </div>
            </section>

            <?php } ?>


        </main>

        <?php require('footer.php'); ?>
    
    </body>
</html>


