<?php 

class Equipments {

    private $id; 
    public $type, $size, $rate, $equipment;

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

    public function CheckSize($equipment) {

        $query = "SELECT size FROM equipments WHERE type = '".$equipment."'";
        $checksize = $this->connexion->prepare($query);
        $checksize->setFetchMode(PDO::FETCH_ASSOC);
        $checksize->execute();

        $getchecksize = $checksize->fetchall();
        
        $size = intval($getchecksize[0]['size']);

        echo ($size);
        
        return $size;

        
    }

    public function ModifRate($rate) {


    }
}