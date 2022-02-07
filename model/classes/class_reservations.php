<?php 

class Reservations {

    public $id, $id_user, $id_habit, $id_location, $option_activities, $option_borne, $option_discoclub;
    public $arrival, $departure, $length, $rate, $connexion, $equipment, $location, $id_reservation;
    private $equipment_space;

    public function __construct(){
        
        try {

            $bdd = new PDO('mysql:host=localhost;dbname=camping', 'root', '');
            $this->connexion=$bdd;
            
        }

        catch (PDOException $e) {

            echo $e->getMessage();
            die();
        
        }
    
    }

    // FONCTION RESERVATION 

    public function CalculLength($arrival, $departure){

        $firstDate  = new DateTime($arrival);
        $secondDate = new DateTime($departure);
        $intvl = $firstDate->diff($secondDate);
        
        $length = $intvl->days;
        
        return $length;

    }


    // FONCTION LISTE DES RESERVATIONS D'UN USER SUR SON COMPTE
    public function ListingUserBookings(){

        $id_user = $_SESSION['id'];
        $query = "SELECT reservations.id, arrival, departure, equipments.type, locations.name FROM reservations 
        INNER JOIN equipments ON reservations.id_equipment = equipments.id 
        INNER JOIN locations ON reservations.id_location = locations.id WHERE id_user=$id_user ORDER BY arrival DESC";

        $list_booking = $this->connexion->prepare($query);
        $list_booking->setFetchMode(PDO::FETCH_ASSOC);
        $list_booking->execute();
        $fetch_list_booking = $list_booking->fetchAll();


        for ($i=0; isset($fetch_list_booking[$i]); $i++){

            $arrival_timestamp = strtotime($fetch_list_booking[$i]['arrival']) ;
            $arrival = date('d-m-Y', $arrival_timestamp);

            $departure_timestamp = strtotime($fetch_list_booking[$i]['departure']) ;
            $departure = date('d-m-Y', $departure_timestamp);

            $id_reservation = $fetch_list_booking[$i]['id'];
            $equipment = $fetch_list_booking[$i]['type'];
            $location = $fetch_list_booking[$i]['name'];

            if ($equipment == 'campingcar'){
                $equipment = 'camping-car';
            }

            if ($location == 'plage'){
                $location = "La Plage";
            }

            elseif ($location == 'pins'){
                $location = 'Les Pins';
            }

            elseif ($location == 'maquis'){
                $location = 'Le Maquis';
            }

            echo "<a class='bookinglinks' href='vos-reservations.php?val=".$id_reservation."'> ➤ Votre séjour du $arrival au $departure en $equipment à l'emplacement $location <br><br></a>";

            // AJOUTER LE LIEN VERS LE BAIL DETAILLER DE LA RESERVATION

            

        }

    }

    // FONCTION AFFICHAGE RESERVATION D'UN USER
    public function ConsultUserBooking(){


        $id_user = $_SESSION['id'];
        $query = "SELECT id, arrival, departure, option_borne, option_discoclub, option_activities, rate, id_location, id_equipment FROM reservations WHERE reservations.id='".@$_GET['val']."'";
        $get_booking = $this->connexion->prepare($query);
        $get_booking->setFetchMode(PDO::FETCH_ASSOC);
        $get_booking->execute();
        $fetch_booking = $get_booking->fetch();

        $arrival_timestamp = strtotime($fetch_booking['arrival']) ;
        $arrival = date('d-m-Y', $arrival_timestamp);

        $departure_timestamp = strtotime($fetch_booking['departure']) ;
        $departure = date('d-m-Y', $departure_timestamp);
        
        $this->id_reservation = $fetch_booking['id'];
        $this->arrival = $arrival;
        $this->departure = $departure;
        $this->rate = $fetch_booking['rate'];


        $_SESSION['id_reservation'] = $fetch_booking['id'];

        if ($fetch_booking['id_equipment']=='1') {
            $this->equipment = 'Tente';
        }

        else {
            $this->equipment = 'Camping-car';
        }

        if ($fetch_booking['id_location']=='1') {
            $this->location = 'La Plage';
        }

        elseif ($fetch_booking['id_location']=='2'){
            $this->location = 'Le Maquis';
        }

        elseif ($fetch_booking['id_location']=='3'){
            $this->location = 'Les Pins';
        }

        if ($fetch_booking['option_borne']=='1') {
            $this->option_borne = 'Oui';
        }

        else {
            $this->option_borne = 'Non';
        }

        if ($fetch_booking['option_discoclub']=='1'){
            $this->option_discoclub = 'Oui';
        }

        else {
            $this->option_discoclub = 'Non';
        }

        if ($fetch_booking['option_activities']=='1'){
            $this->option_activities = 'Oui';
        }

        else {
            $this->option_activities = 'Non';
        }
    
    }

    // FONCTION ANNULATION BOOKING

    public function Cancel(){

        $id_reservation = $_SESSION['id_reservation'];
        $query = "DELETE  FROM reservations WHERE reservations.id =$id_reservation";
        $cancel = $this->connexion->prepare($query);
        $cancel->execute();

    }

    // FONCTION ADMIN AFFICHER TOUTES RESERVATIONS 

    public function ConsultAllByLocation(){

        $query = "SELECT * FROM reservations where location ='".@$_GET['location']."'";
        $consultall = $this->connexion->prepare($query);
        $consultall->setFetchMode(PDO::FETCH_ASSOC);
        $consultall->execute();

        $consultallresult =$consultall->fetchAll();


    }

    // FONCTION CALCUL PRIX SEJOUR 

    public function CalculRate ($equipment, $option_borne, $option_discoclub, $option_activities, $length) {

        // CALCUL PRIX TENTE/CAMPING CAR

        $query = "SELECT rate FROM equipments WHERE type = '".$equipment."'";
        $get_rate_equipment = $this->connexion->prepare($query);    
        $get_rate_equipment->setFetchMode(PDO::FETCH_ASSOC);
        $get_rate_equipment->execute();

        $result_rate_equipment = $get_rate_equipment->fetch();

        $rate_equipment = intval($result_rate_equipment['rate']);
        
        // CALCUL PRIX OPTIONS

       if ($option_borne==1) {
            $query_1 = "SELECT rate from options WHERE id='1'";
            $get_rate_option_1 = $this->connexion->prepare($query_1);
            $get_rate_option_1->setFetchMode(PDO::FETCH_ASSOC);
            $get_rate_option_1->execute();

            $result_rate_option_1 = $get_rate_option_1->fetchall();
            
            $rate_option_1 = intval($result_rate_option_1[0]['rate']);

        }

        else {

            $rate_option_1 = 0;
        }

        if ($option_discoclub==1) {

            $query_2 = "SELECT rate from options WHERE id='2'";
            $get_rate_option_2 = $this->connexion->prepare($query_2);
            $get_rate_option_2->setFetchMode(PDO::FETCH_ASSOC);
            $get_rate_option_2->execute();

            $result_rate_option_2 = $get_rate_option_2->fetchall();
            
            $rate_option_2 = intval($result_rate_option_2[0]['rate']);
            
        }

        else {

            $rate_option_2 = 0;

        }

        if ($option_activities==1) {

            $query_3 = "SELECT rate from options WHERE id='3'";
            $get_rate_option_3 = $this->connexion->prepare($query_3);
            $get_rate_option_3->setFetchMode(PDO::FETCH_ASSOC);
            $get_rate_option_3->execute();

            $result_rate_option_3 = $get_rate_option_3->fetchall();
            
            $rate_option_3 = intval($result_rate_option_3[0]['rate']);

        }

        else {

            $rate_option_3 = 0;

        }

        //CALCUL PRIX TOTAL SEJOUR 
        
        $rate = ($rate_equipment + $rate_option_1 + $rate_option_2 + $rate_option_3) * $length;

        return $rate;

    }

    public function GetIdLocation($location){

        $query = "SELECT id FROM locations WHERE name = '".$location."'";
        $get_id_location = $this->connexion->prepare($query);
        $get_id_location->setFetchMode(PDO::FETCH_ASSOC);
        $get_id_location->execute();
        $fetch_id_location = $get_id_location->fetch();

        return $id_location = intval(($fetch_id_location)['id']);
    }

    public function GetIdEquipment($equipment) {

        $query = "SELECT id FROM equipments WHERE type = '".$equipment."'";
        $get_id_equipment = $this->connexion->prepare($query);
        $get_id_equipment->setFetchMode(PDO::FETCH_ASSOC);
        $get_id_equipment->execute();
        $fetch_id_equipment = $get_id_equipment->fetch();

        return $id_equipment = intval(($fetch_id_equipment)['id']);

    }

 

    public function Booking($arrival, $departure, $length, $option_borne, $option_discoclub, $option_activities, $rate, $id_user,$id_location,$id_equipment){

        $data = [
            'arrival'=>$arrival,
            'departure'=>$departure,
            'length'=>intval($length),
            'option_borne'=>intval($option_borne),
            'option_discoclub'=>intval($option_discoclub),
            'option_activities'=>intval($option_activities),
            'rate'=>intval($rate),
            'id_user'=>intval($id_user),
            'id_location'=>intval($id_location),
            'id_equipment'=>intval($id_equipment),
        ];

        $query = "INSERT INTO reservations (arrival, departure, length, option_borne, option_discoclub, option_activities, rate, id_user, id_location, id_equipment) 
        VALUES (:arrival, :departure, :length, :option_borne, :option_discoclub, :option_activities, :rate, :id_user, :id_location, :id_equipment)";
        $booking = $this->connexion->prepare($query);
        $booking->execute($data);

    }

    public function ResearchReservations () {

        $param = array();

        if (isset($_POST['research'])) {
            
    
            $arrival = htmlspecialchars($_POST['arrival']);
            $departure = htmlspecialchars($_POST['departure']);
            $firstname = htmlspecialchars(strtolower(trim($_POST['firstname'])));
            $lastname = htmlspecialchars(strtolower(trim($_POST['lastname'])));
    
    
            //PREPARE THE QUERY INFORMATION FOR THE WHERE CLAUSE
            $whereParts = array();
    
            if($arrival)     { $whereParts[] = "arrival = '$arrival'"; }
            if($departure) { $whereParts[] = "departure = '$departure'"; }
            if($firstname) { $whereParts[] = "users.firstname = '$firstname'"; }
            if($lastname) { $whereParts[] = "users.lastname = '$lastname'"; }
            
            //BUILD THE QUERY

            $query = "SELECT reservations.id, reservations.arrival, reservations.departure, users.firstname, users.lastname from reservations
            INNER JOIN users on users.id = reservations.id_user ";
            $query2 = " ORDER BY reservations.id DESC";

            if(!count($whereParts)) {
                $query .= $query2;
            }
    
            if(count($whereParts)) {
                $query .= "WHERE " . implode('AND ', $whereParts).  $query2;
            }
      

            $research_reservations = $this->connexion->prepare($query);
            $research_reservations->setFetchMode(PDO::FETCH_ASSOC);
            $research_reservations->execute();
        
            $assoc = $research_reservations->fetchAll();

            foreach ($assoc as $result) {

                $arrival_timestamp = strtotime($result['arrival']) ;
                $arrival = date('d-m-Y', $arrival_timestamp);
    
                $departure_timestamp = strtotime($result['departure']) ;
                $departure = date('d-m-Y', $departure_timestamp);
                
                echo "
                <tr>
                    <td><a class='listbooking' href='reservations-details.php?val=".$result['id']." '>".$result['id']."</a></td>
                    <td><a class='listbooking' href='reservations-details.php?val=".$result['id']." '>".$result['firstname']."</a></td>
                    <td><a class='listbooking' href='reservations-details.php?val=".$result['id']." '>".$result['lastname']."</a></td>
                    <td><a class='listbooking' href='reservations-details.php?val=".$result['id']." '>".$arrival."</a></td>
                    <td><a class='listbooking' href='reservations-details.php?val=".$result['id']." '>".$departure."</a></td>
                </tr> "; 
            } 
        }

    }

    // FONCTION UPDATE BOOKING 

    public function UpdateBooking($arrival, $departure, $length, $option_borne, $option_discoclub, $option_activities, $rate, $id_user, $id_location, $id_equipment){

        $id_reservation = $_SESSION['id_reservation'];

        $data = [
            'arrival'=>$arrival,
            'departure'=>$departure,
            'length'=>$length,
            'option_borne'=>$option_borne,
            'option_discoclub'=>$option_discoclub,
            'option_activities'=>$option_activities,
            'rate'=>$rate,
            'id_user'=>$id_user,
            'id_location'=>$id_location,
            'id_equipment'=>$id_equipment,
        ];
        
        $query="UPDATE reservations 
        SET arrival=:arrival, 
        departure=:departure, 
        length=:length, 
        option_borne = :option_borne, 
        option_discoclub = :option_discoclub, 
        option_activities = :option_activities, 
        rate = :rate, 
        id_user = :id_user,
        id_location = :id_location, 
        id_equipment = :id_equipment 
        WHERE id ='".$id_reservation."'";
        $updatebooking = $this->connexion->prepare($query);
        $updatebooking->execute($data);

    }

    // SUPPRIME LA TABLE EPHEMERE PERMETTANT LE CALCUL DES PLACES DISPOS

    public function DropTable() {
        $query = " DROP TABLE IF EXISTS unavailable_space";
        $drop_table = $this->connexion->prepare($query);
        $drop_table->execute();
    }



    // LISTE LES JOURS DE RESERVATIONS ENTRE DEUX DATES POUR REMPLIR LE PLANNING

    public function BetweenDates()  {
        $query = "SELECT reservations.id, reservations.id_user, reservations.arrival, reservations.departure, reservations.id_location, users.firstname, users.lastname 
        FROM reservations 
        INNER JOIN locations on locations.id = reservations.id_location 
        INNER JOIN users on users.id = reservations.id_user
        WHERE locations.name ='".@$_GET['location']."'";
        $request = $this->connexion->prepare($query);
        $request->setFetchMode(PDO::FETCH_ASSOC);
        $request->execute();
        
        $assoc = $request->fetchAll();

        $between_dates[] = array();

        // var_dump($assoc);


        for ($i = 0 ; isset($assoc[$i]) ; $i ++) {

            $arrival = strtotime($assoc[$i]['arrival']);
            $departure = strtotime($assoc[$i]['departure']);
            $id_user = $assoc[$i]['id_user'];
            $id_reservation = $assoc[$i]['id'];
            $lastname = $assoc[$i]['lastname'];
            $firstname = $assoc[$i]['firstname'];

            for ($j = $arrival ; $j<= $departure; $j += 86400) {

                $between_dates[$i][$j]['id_reservation'] = $id_reservation;
                $between_dates[$i][$j]['id_user'] = $id_user;
                $between_dates[$i][$j]['firstname'] = $firstname;
                $between_dates[$i][$j]['lastname'] = $lastname;
                $between_dates[$i][$j]['date'] = date("Y-m-d", $j);

            }

        }

        // var_dump($between_dates);

        return $between_dates;
    }

    // AFFICHE LA RESERVATION DANS LE PLANNING 

    public function DisplayReservation ($date) {

        $get_between_dates = new Reservations;
        $between_dates = $get_between_dates->BetweenDates();

        $time = $date->format('Y-m-d');
        $timestamp = strtotime($time);

        for ($i = 0  ; isset($between_dates[$i]) ; $i ++) {

            foreach ( $between_dates[$i] as $result) {

                if ( $result['date'] == $time ) {

                    echo "<div class='planning__reservations'><a href='reservations-details.php?val=".$result['id_reservation']."'> 
                            N° ".$result['id_reservation']." -".$result['firstname']." ".$result['lastname']."
                            </a>
                        </div>"
                    ;


                }
            }

            
        }

        return $between_dates;
    }

    // AFFICHE LES DETAILS DUNE RESERVATION SUR LA PAGE RESERVATIONS-DETAILS.PHP

    public function GetReservationsDetails () {

        $query = "SELECT 
        reservations.id, 
        reservations.arrival, 
        reservations.departure, 
        reservations.id_user, 
        users.firstname, 
        users.lastname,
        reservations.id_location,
        locations.name,
        reservations.id_equipment,
        equipments.type,
        reservations.rate
        FROM reservations 
        INNER JOIN locations on locations.id = reservations.id_location 
        INNER JOIN users on users.id = reservations.id_user
        INNER JOIN equipments on equipments.id = reservations.id_equipment
        WHERE reservations.id ='".@$_GET['val']."'";

        $get_details = $this->connexion->prepare($query);
        $get_details->setFetchMode(PDO::FETCH_ASSOC);
        $get_details->execute();
        
        $assoc = $get_details->fetchAll();

        $_SESSION['id_reservation'] = $assoc[0]['id'];

        foreach ($assoc as $result) { 
    
            $arrival_timestamp = strtotime($result['arrival']) ;
            $arrival = date('d-m-Y', $arrival_timestamp);

            $departure_timestamp = strtotime($result['departure']) ;
            $departure = date('d-m-Y', $departure_timestamp);

            

            
            echo "
            
            <table>
                <thead>
                    <tr>
                        <th colspan='2'>Réservation n° '".$result['id']."'</td>
                    <tr>
                </thead>

                <tbody>

                    <tr>
                        <td>".$result['firstname']."</td>
                        <td>".$result['lastname']."</td>
                    </tr>

                    <tr>
                        <td>".$arrival."</td>
                        <td>".$departure."</td>
                    </tr>

                    <tr>
                        <td>".$result['name']."</td>
                        <td>".$result['type']."</td>
                    </tr>

                    <tr>
                        <td>".$result['rate']." €</td>
                    </tr>

                </tbody>
            </table>";


        }

        return $_SESSION['id_reservation'] = $result['id'];




    }

 

    
}