<?php 

require('../model/classes/class_reservations.php');
require('../model/bdd.php');

$cancelled = 0;

if (isset($_POST['confirmcancel'])){

    $now = new Datetime('now');

    $sql = "SELECT arrival FROM reservations WHERE id = :id";
    $arrival = $bdd->prepare($sql);
    $arrival->setFetchMode(PDO::FETCH_ASSOC);
    $arrival->execute(['id'=> $_SESSION['id_reservation']]);

    $fetch_arrival = $arrival->fetch();

    $arrival_date = new DateTime($fetch_arrival['arrival']) ;

    $interval = $arrival_date->diff($now); 

    // permet de vérifier que le délai de 48h max avant l'annulation est respecté
    
    if($interval->format('%d days') <2 ) {
        
        $err_cancel = "Vous devez annuler votre réservation au minimum 48H avant la date de votre arrivée.";
    }

    else  {

    $cancel_booking = new Reservations;
    $cancel_booking->Cancel();
    unset ($_SESSION['id_reservation']);
    $cancelled = 1;

    }
    
}

?>