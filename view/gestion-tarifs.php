<?php

session_start();

require('../model/classes/class_reservations.php');
require('../model/classes/class_admin.php');
require('../model/classes/class_rates.php');
require('../controller/update-ratesController.php');

$get_site_rate = new Rates;
$site_rate = $get_site_rate->DisplaySiteRate(); 

$get_options_rate = new Rates;
$options_rate = $get_options_rate->DisplayOptionsRate();

$option1_rate = $options_rate[0]['rate'];
$option2_rate = $options_rate[1]['rate'];
$option3_rate = $options_rate[2]['rate'];


?>

<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Gestion des tarifs</title> 
        <link rel="stylesheet" type="text/css" href="style/compte.css">
    </head>

    <body>

      <?php require('header.php')?>

        <main>

            <h1 id="tarifs_title">Gestion des Tarifs</h1>


            <section class="container">

                <div class="container1">
                <form action ="gestion-tarifs.php" method="post">
                    <label for="day_site_rate">Emplacement / jour<label>
                    <input type="number" id="rate" name="rate" value="<?php echo $site_rate ?>">
                    <?php if (isset($err_password_1)) { echo '<div class="err_form">'.$err_password_1.'</div>' ;} ?>
                    <input type="password" name="password" placeholder="Confirmez avec votre mot de passe administrateur">
                    <input type="submit" value="Modifier" name="update_site_rate">
                    
                </form>

                <form action ="gestion-tarifs.php" method="post">
                    <label for="option1_rate">Borne électrique / jour <label>
                    <input type="number" id="option1_rate" name="option1_rate" value="<?php echo $option1_rate ;?>">
                    <?php if (isset($err_password_2)) { echo '<div class="err_form"><br>'.$err_password_2.'</div>' ;} ?>
                    <input type="password" name="password" placeholder="Confirmez avec votre mot de passe administrateur">
                    <input type="submit" value="Modifier" name="update_option1_rate">
                  
                </form>
                </div>
                
                <div class="container2">
                <form action ="gestion-tarifs.php" method="post">
                    <label for="option2_rate">Accès DiscoClub / jour <label>
                    <input type="number" id="option2_rate" name="option2_rate" value="<?php echo $option2_rate ;?>">
                    <?php if (isset($err_password_3)) { echo '<div class="err_form"><br>'.$err_password_3.'</div>' ;} ?>
                    <input type="password" name="password" placeholder="Confirmez avec votre mot de passe administrateur">
                    <input type="submit" value="Modifier" name="update_option2_rate">
                    
                </form>

                <form action ="gestion-tarifs.php" method="post">
                    <label for="option3_rate">Pack activités / jour<label>
                    <input type="number" id="option3_rate" name="option3_rate" value="<?php echo $option3_rate ;?>">
                    <?php if (isset($err_password_4)) { echo '<div class="err_form"><br>'.$err_password_4.'</div>' ;} ?> 
                    <input type="password" name="password" placeholder="Confirmez avec votre mot de passe administrateur">
                    <input type="submit" value="Modifier" name="update_option3_rate">
                    
                </form>
                </div>

            </section>
        </main>

        <?php require('footer.php'); ?>

    </body>
</html>

