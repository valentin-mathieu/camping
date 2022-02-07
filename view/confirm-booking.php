<?php 

session_start();

require('../model/bdd.php');

require('../model/classes/class_reservations.php');

if (isset($_POST['nobook'])){
    header('Location:reserver.php');
}

if (isset($_POST['book'])){ 

$arrival = $_SESSION['arrival'];
$departure = $_SESSION['departure'];
$length = $_SESSION['length'];
$option_borne = $_SESSION['option_borne'];
$option_discoclub = $_SESSION['option_discoclub'];
$option_activities = $_SESSION['option_activities'];
$rate = $_SESSION['rate'];
$id_user = $_SESSION['id'];
$id_equipment = $_SESSION['id_equipment'];
$id_location = $_SESSION['id_location'];

// booking in BDD
$booking = new Reservations ();
$booking->Booking("$arrival", "$departure", "$length", "$option_borne", "$option_discoclub", "$option_activities", "$rate", "$id_user", "$id_location", "$id_equipment");

unset($_SESSION['arrival']);
unset($_SESSION['departure']);
unset($_SESSION['length']);
unset($_SESSION['option_borne']);
unset($_SESSION['option_discoclub']);
unset($_SESSION['option_activities']);
unset($_SESSION['rate']);
unset($_SESSION['id_equipment']);
unset($_SESSION['id_location']); ?>

<html>

    <head>
        <meta charset="utf-8">
        <title>Réservation</title>
        <link rel="stylesheet" href="style/reserver.css">
    </head>

    <body>  

        <?php require("header.php"); ?>

        <main>

            <p class="intro">Votre réservation est confirmée. Redirection en cours...</p> 
            <?php header("Refresh: 3 ; url=compte.php"); ?>
        
        </main>

        <?php require('footer.php'); ?>
        
    </body>
</html>

<?php }
