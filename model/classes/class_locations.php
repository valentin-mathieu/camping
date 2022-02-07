<?php 

class Locations {

    private $id;
    public $name, $spaces, $location, $connexion;

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

    public function CalculSpaces($spaces){
        
        
        

    }

    public function CheckSpaces($location){

        $query = "SELECT spaces FROM locations WHERE name='".$location."'";
        $checkspaces = $this->connexion->prepare($query);
        $checkspaces->setFetchMode(PDO::FETCH_ASSOC);
        $checkspaces->execute();

        $getcheckspaces = $checkspaces->fetchall();

        $availablespaces = $getcheckspaces[0]['spaces'];
        return $availablespaces;

    }

}