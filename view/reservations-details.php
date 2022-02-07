<?php

session_start();

require('../model/classes/class_reservations.php');
require('../model/classes/class_admin.php');

$check_admin = new Admin;
$check_admin->CheckAdmin();







?>

<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Infos Réservation</title> 
        <link rel="stylesheet" type="text/css" href="style/reservations-details.css">
    </head>

    <body>

      <?php require('header.php')?>

        <main>

            <section id="section_flex">
                <?php 
                    $get_reservation_details = new Reservations ;
                    $get_reservation_details->GetReservationsDetails();
                ?>

                <form action="update-booking.php" type="post">
                    <input type="submit" name="updatebookingform" value="Modifier la réservation" class="submitbtn">
                </form>

                <form action="cancel-booking.php" type="post">
                    <input type="submit" name="cancelbooking" value="Annuler la réservation" class="submitbtn">
                </form>


            </section>

        </main>

        <?php require('footer.php'); ?>
        
    </body>
</html>





