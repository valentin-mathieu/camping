<?php 

require('../model/classes/class_reservations.php');

if (isset($_SESSION['login'])){

    $consult_user_booking = new Reservations;
    $consult_user_booking->ConsultUserBooking();
    
}

?>