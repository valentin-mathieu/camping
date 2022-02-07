<?php

session_start();
require('../controller/vos-reservationsController.php');

?>

<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Vos réservations</title> 
        <link rel="stylesheet" type="text/css" href="style/vos-reservations.css">
    </head>

    <body>
        
        <?php require('header.php')?>

        <main>

        <?php if (isset($_SESSION['login'])){ ?>
        
            <section id="section-flex">

                <div class="reservationsbox">

                    <h2 class="boxtitle"> Votre réservation </h2>

                    <table border="1">
                        <tr>
                            <td>Date d'arrivée</td>
                            <td><?php echo $consult_user_booking->arrival;?></td>
                        </tr>
                        <tr>
                            <td>Date de départ</td>
                            <td><?php echo $consult_user_booking->departure;?></td>
                        </tr>
                        <tr>
                            <td>Equipement</td>
                            <td><?php echo $consult_user_booking->equipment;?></td>
                        </tr>
                        <tr>
                            <td>Emplacement</td>
                            <td><?php echo $consult_user_booking->location;?></td>
                        </tr>
                        <tr>
                            <td>Option borne électrique</td>
                            <td><?php echo $consult_user_booking->option_borne;?></td>
                        </tr>
                        <tr>
                            <td>Option accès au disco-club</td>
                            <td><?php echo $consult_user_booking->option_discoclub;?></td>
                        </tr>
                        <tr>
                            <td>Option accès aux activités</td>
                            <td><?php echo $consult_user_booking->option_activities;?></td>
                        </tr>
                        <tr>
                            <td>Prix total</td>
                            <td><?php echo $consult_user_booking->rate;?></td>
                        </tr>
                    </table>

                </div>

                    <form action="update-booking.php" type="post">
                        <input type="submit" name="updatebookingform" value="Modifier votre réservation" class="submitbtn1">
                    </form>

                    <form action="cancel-booking.php" type="post">
                        <input type="submit" name="cancelbooking" value="Annuler votre réservation" class="submitbtn">
                    </form>
            </section>
                    
        <?php } ?>
        
        </main>
        
        <?php require('footer.php'); ?>
    </body>