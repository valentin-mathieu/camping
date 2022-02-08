<?php

require('../model/bdd.php');

require('../model/classes/class_reservations.php');

require('../model/classes/class_locations.php');

require('../model/classes/class_equipments.php');

$calculrate = 0;

// CONTROLLER FUNCTION BOOKING

if (!empty($_POST)) {
    extract($_POST);

    if (isset($_POST['calculate'])) {

        $arrival = $_POST['arrival'];
        $departure = $_POST['departure'];
        $equipment = $_POST['equipments'];
        $location = $_POST['location'];
        $id_user = $_SESSION['id'];

        if (isset($_POST['option_borne'])){
            $option_borne = 1;
        }

        else {
            $option_borne = 0;
        }
        
        if (isset($_POST['option_discoclub'])){
            $option_discoclub = 1;
        }

        else {
            $option_discoclub = 0;
        }

        if (isset($_POST['option_activities'])) {
            $option_activities = 1;
        }

        else {
            $option_activities = 0;
        }

        $today_date = date('Y-m-d');
        $tomorrow = strtotime($today_date . "+1day");
        $tomorrow_date = date('Y-m-d', $tomorrow);

        $valid = (boolean) true;

        // Check if all necessary fields are fulfilled

        if(empty($arrival) || empty($departure) || empty($equipment) || empty($location)) {
            $valid = false;
            $err_field = "Les champs avec (*) doivent être remplis.";
        }

        // Check if arrival date is at least one day after today

        elseif($arrival < $today_date ) {
            $valid = false;
            $err_date = "La date d'arrivée ne peut être antérieure à celle du jour.";
        }

        // Check if departure date is at least one day after arrival

        elseif(!empty($arrival) && !empty ($departure) && $arrival > $departure) {
            $valid = false;
            $err_date = "La date de départ ne peut pas être antérieure à l'arrivée.";
        }

        elseif(!empty($arrival) && !empty ($departure) && ($arrival == $departure)) {
            $valid = false;
            $err_date ="La réservation doit être au moins d'une nuit.";
        }

        $booking_id_location = new Reservations ();
        $id_location = $booking_id_location->GetIdLocation("$location");
    
        $booking_id_equipment = new Reservations ();
        $id_equipment = $booking_id_equipment->GetIdEquipment("$equipment");
    
        // On check s'il reste des places disponibles selon le lieu choisi.
        // par exemple pour une réservation du 10 au 20 du mois 
        // - il existe 7 cas de réservations qui pourraient chevaucher la période choisie par l'utilisateur.
        // - cas 1 :avec une arrivée = $arrivée et un départ =$départ  (ex: du 10 au 20)
        // - cas 2 : avec une arrivée < $arrivée et un départ < $départ et un départ > $arrivée (ex: du 5 au 15)
        // - cas 3 : avec une arrivée > $arrivée et un départ > $départ  une arrivée < $ départ(ex: du 15 au 25)
        // - cas 4 : avec une arrivée < $arrivée et un départ > $départ (ex: du 5 au 25)
        // - cas 5 : avec une arrivée > $arrivée et un départ < $départ (ex: du 11 au 19)
        // - cas 6 : avec une arrivée = $arrivée et un départ < $départ (ex: du 10 au 25)
        // - cas 7 : avec une arrivée > $arrivée et un départ = $départ (ex: du 5 au 20)

    
        // sont donc exclues les réservations avec :
        // - une arrivée < $arrivée et un départ <$arrivée (ex: du 5 au 9) car hors des dates choisies par le client
        // - une arrivée > $départ et un départ > $départ (ex: du 21 au 25) car hors des dates choisie par le client
    
    
        $query_1 = "SELECT * FROM reservations
        WHERE ( id_location = '".$id_location."') AND 
        (
        (arrival = '$arrival' AND departure = '$departure') OR                                 
        (arrival < '$arrival' AND departure < '$departure' AND departure > '$arrival') OR       
        (arrival > '$arrival' AND departure > '$departure' AND arrival < '$departure' ) OR                                     
        (arrival < '$arrival' AND departure > '$departure')OR
        (arrival > '$arrival' AND departure < '$departure') OR
        (arrival = '$arrival' AND departure < '$departure') OR 
        (arrival > '$arrival' AND departure = '$departure')                                  
        )";

        // création du tableau des réservations chevauchants la période choisie par l'utilisateur

        $select_res = $bdd->prepare($query_1);
        $select_res->SetFetchMode(PDO::FETCH_ASSOC);
        $select_res->execute();

        $assoc = $select_res->fetchAll();

        var_dump($assoc);

        if (!empty($assoc)) {

            // durée en jours de la réservation choisie par l'utilisateur, soit pour une résa du 10 au 20, 10 jours.

            $booking_length = new Reservations ();
            $length_result = $booking_length->CalculLength("$arrival", "$departure");
            $length = (int)$length_result;

            echo " durée choisi utilisateur $length <br>";


            // récupération de la place prise par les équipements soit 2 places pour un camping car.

            if($id_equipment == 1) { $equipment_space = 1 ; } else { $equipment_space = 2 ; }


            // pour une réservation de 10 jours, l'espace disponible de base est donc de 4x 10 soit 40.

            $location_space_time = 4*$length;

            echo " espace dispo de base sur l'emplacement pendant le séjour chois par l'utilisateur $location_space_time <br>" ;


            // pour une réservation de 10 jours avec un camping car, il va donc falloir 10(durée)x2(taille camping car) = 20 emplacements sur cette périodes.

            $spaces_needed = (int) ($length * $equipment_space) ;

            echo " espace nécessaire pendant le séjour chois par l'utilisateur $spaces_needed <br>" ;




            // on créé une table qui va stocker les emplacements déjà pris sur la durée du séjour des réservations déjà enresgistrées.

            $query_2 = "CREATE TABLE `camping`.`unavailable_space` ( `id` INT NOT NULL AUTO_INCREMENT , `space` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;";
            $table = $bdd->prepare($query_2);
            $table->execute();

            $query_3 = "INSERT INTO unavailable_space (space) VALUES (:unavailable_space)";
            $insert = $bdd->prepare($query_3);

            for($i = 0 ; isset($assoc[$i]) ; $i++) { // on parcours le tableau

                // l'espace requis sur la totalité du séjour et la durée * l'espace de l'équipment

                // l'id equipment 1 = tente soit une place, l'id equipement 2 = camping car soit deux places

                if ( $assoc[$i]['id_equipment'] == '1' ) { 
                    $equipment_space = 1 ; 

                } 
                
                elseif ($assoc[$i]['id_equipment'] == '2' ) { 
                    $equipment_space = 2 ; 
                }

                // CAS 1 : dans le cas ou on a comme l'utilisateur, une arrivée au 10 et un départ au 20 avec un camping car, on a donc 10x2 = 20 emplacements pris.
                if( ($assoc[$i]['arrival'] == $arrival) && ($assoc[$i]['departure'] == $departure) ) {

                    $firstDate  = new DateTime($arrival);
                    $secondDate = new DateTime($departure);
                    $intvl = $firstDate->diff($secondDate);

                    $length = $intvl->days;
                    $length = $length+1;

                    echo " CAS 1 <br>";

                    echo " premier jour '".$firstDate->format('Y-m-d')."' <br> ";
                    echo " dernier jour '".$secondDate->format('Y-m-d')."' <br>" ;
                    echo "durée $length  <br>"; 


                    $unavailable_space= $length * $equipment_space ;

                    echo " durée $length fois equipmenet $equipment_space égal espace déjà pris  $unavailable_space <br>";


                    $insert->execute(['unavailable_space'=>$unavailable_space]);
                }

                // CAS 2 : dans le cas d'une réservation du 5 au 15 avec un camping car, on ne retient que du 10 au 15 et l'espace pris sur la période chevauchante est donc de 5x2 = 10;
                if ( ($assoc[$i]['arrival'] < $arrival) && ($assoc[$i]['departure'] < $departure) && ($assoc[$i]['departure'] > $arrival) ) {

                    $firstDate  = new DateTime($arrival);
                    $secondDate = new DateTime($assoc[$i]['departure']);
                    $intvl = $firstDate->diff($secondDate);
                    
                    $length = $intvl->days;
                    $length = $length+1;


                    echo " CAS 2 <br>";

                    echo " premier jour '".$firstDate->format('Y-m-d')."' <br> ";
                    echo " dernier jour '".$secondDate->format('Y-m-d')."' <br>" ;
                    echo "durée $length  <br>"; 

                    $unavailable_space = $length * $equipment_space ;

                    echo " durée $length fois equipmenet $equipment_space égal espace déjà pris  $unavailable_space <br>";

                    $insert->execute(['unavailable_space'=>$unavailable_space]);
                }

                // CAS 3 :dans le cas d'une réservation du 15 au 25 avec un campingcar, on ne retient que du 15 au 20 et l'espace pris sur la période chevauchante est donc de 5x2 = 10

                if ( ($assoc[$i]['arrival'] > $arrival) && ($assoc[$i]['departure'] > $departure) && ($assoc[$i]['arrival'] < $departure) )  {

                    $firstDate  = new DateTime($assoc[$i]['arrival']);
                    $secondDate = new DateTime($departure);
                    $intvl = $firstDate->diff($secondDate);
                    
                    $length = $intvl->days;
                    $length = $length+1;

                    echo " CAS 3 <br>";

                    echo " premier jour '".$firstDate->format('Y-m-d')."' <br> ";
                    echo " dernier jour '".$secondDate->format('Y-m-d')."' <br>" ;
                    echo "durée $length  <br>"; 


                    $unavailable_space = $length * $equipment_space ;

                    echo " durée $length fois equipmenet $equipment_space égal espace déjà pris  $unavailable_space <br>";

                    $insert->execute(['unavailable_space'=>$unavailable_space]);
                }

                // CAS 4 dans le cas d'une réservation du 5 au 25 avec un camping car, on ne retient que du 10 au 20 comme l'utilisateur donc 10x2

                if ( ($assoc[$i]['arrival'] < $arrival) && ($assoc[$i]['departure'] > $departure) ) {

                    $firstDate  = new DateTime($arrival);
                    $secondDate = new DateTime($departure);
                    $intvl = $firstDate->diff($secondDate);

                    $length = $intvl->days;
                    $length = $length+1;

                    echo " CAS 4 <br>";

                    echo " premier jour '".$firstDate->format('Y-m-d')."' <br> ";
                    echo " dernier jour '".$secondDate->format('Y-m-d')."' <br>" ;
                    echo "durée $length  <br>"; 

                    $unavailable_space= $length * $equipment_space ;

                    echo " durée $length fois equipmenet $equipment_space égal espace déjà pris  $unavailable_space <br>";

                    $insert->execute(['unavailable_space'=>$unavailable_space]);
                } 

                
                // CAS 5 dans le cas d'une réservation du 11 au 19 avec un camping car, on retient tout le séjour déjà enregistré 

                if ( ($assoc[$i]['arrival'] > $arrival) && ($assoc[$i]['departure'] < $departure) ) {

                    $firstDate  = new DateTime($assoc[$i]['arrival']);
                    $secondDate = new DateTime($assoc[$i]['departure']) ;

                    $intvl = $firstDate->diff($secondDate);
                    $length = $intvl->days;
                    $length = $length+1;

                    
                    echo " CAS 5 <br>";

                    echo " premier jour '".$firstDate->format('Y-m-d')."' <br> ";
                    echo " dernier jour '".$secondDate->format('Y-m-d')."' <br>" ;
                    echo "durée $length  <br>"; 


                    $unavailable_space= $length * $equipment_space ;

                    echo " durée $length fois equipmenet $equipment_space égal espace déjà pris  $unavailable_space <br>";

                    $insert->execute(['unavailable_space'=>$unavailable_space]);
                } 

                // CAS 6 dans le cas d'une réservation du 10 au 25 avec un camping car, on retient du 10 au 20 

                if ( ($assoc[$i]['arrival'] == $arrival) && ($assoc[$i]['departure'] < $departure) ) {

                    $firstDate  = new DateTime($arrival);
                    $secondDate = new DateTime($assoc[$i]['departure']) ;

                    $intvl = $firstDate->diff($secondDate);

                    $length = $intvl->days;
                    $length = $length+1;

                    
                    echo " CAS 6 <br>";

                    echo " premier jour '".$firstDate->format('Y-m-d')."' <br> ";
                    echo " dernier jour '".$secondDate->format('Y-m-d')."' <br>" ;
                    echo "durée $length  <br>"; 


                    $unavailable_space= $length * $equipment_space ;

                    echo " durée $length fois equipmenet $equipment_space égal espace déjà pris  $unavailable_space <br>";

                    $insert->execute(['unavailable_space'=>$unavailable_space]);
                } 

                // CAS 7 dans le cas d'une réservation du 5 au 20 avec un camping car, on retient du 10 au 20 

                if ( ($assoc[$i]['arrival'] > $arrival) && ($assoc[$i]['departure'] == $departure) ) {

                    $firstDate  = new DateTime($assoc[$i]['arrival']);
                    $secondDate = new DateTime($departure) ;

                    $intvl = $firstDate->diff($secondDate);

                    $length = $intvl->days;
                    $length = $length+1;

                    
                    echo " CAS 7 <br>";

                    echo " premier jour '".$firstDate->format('Y-m-d')."' <br> ";
                    echo " dernier jour '".$secondDate->format('Y-m-d')."' <br>" ;
                    echo "durée $length  <br>"; 


                    $unavailable_space= $length * $equipment_space ;

                    echo " durée $length fois equipmenet $equipment_space égal espace déjà pris  $unavailable_space <br>";

                    $insert->execute(['unavailable_space'=>$unavailable_space]);
                } 


            }

            // on récupère les sommes stockées dans la table éphémères pour les additionner.

            $query_4 = "SELECT SUM(space) FROM unavailable_space";
            $sum = $bdd->prepare($query_4);
            $sum->setFetchMode(PDO::FETCH_ASSOC);
            $sum->execute();

            $result = $sum->fetchAll();

            var_dump($result) ;

            // on fait la différence entre l'espace du terrain et la somme des espaces pris par les réservations déjà enregistrées sur la période
            // choisie par l'utilisateur pour obtenir les places encore disponibles.


            $spaces_available = (int) ($location_space_time - $result[0]['SUM(space)']) ;

            echo "espaces encore disponibles = $spaces_available <br>" ;

            // ensuite on soustrait à l'espace disponible l'espace nécessaire à la réservation de l'utilisateur

            $substraction = $spaces_available - $spaces_needed;

            echo "résultat de la soustraction  espaces disponibles $spaces_available - espaces requis $spaces_needed égal $substraction<br>" ;


            // si le résultat est inférieur à 0 alors l'espace nécessaire est insuffisant.
            if ($substraction < 0) {
                $valid = false;
                $err_reservation = "Il n'y a plus de places disponibles dans le lieu choisi avec votre équipement pour cette période.";
            }

            // on supprime la table éphémère.;

            $drop_shortlived_table = new Reservations();
            $drop_shortlived_table->DROPTABLE();
        }
    

        if($valid == true) {

            $calculrate = 1;
            // getting the length
            $booking_length = new Reservations ();
            $length = $booking_length->CalculLength("$arrival", "$departure");

            //getting ids

            $booking_id_location = new Reservations ();
            $id_location = $booking_id_location->GetIdLocation("$location");

            $booking_id_equipment = new Reservations ();
            $id_equipment = $booking_id_equipment->GetIdEquipment("$equipment");

            // getting the rate 
            $booking_rate = new Reservations ();
            $rate = $booking_rate->CalculRate("$equipment", "$option_borne", "$option_discoclub", "$option_activities", "$length");
            
            $_SESSION['arrival'] = $arrival; 
            $_SESSION['departure'] = $departure;
            $_SESSION['id_equipment'] = $id_equipment; 
            $_SESSION['id_location'] = $id_location; 
            $_SESSION['length'] = $length;
            $_SESSION['option_borne'] = $option_borne;
            $_SESSION['option_discoclub'] = $option_discoclub;
            $_SESSION['option_activities'] = $option_activities;
            $_SESSION['rate'] = $rate;
        }

    }
}

?>