<?php

class User {

    

    public $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;
    public $connexion;
    public $session;
    private $admin;

    
    // DECLARATION DES METHODES 

    public function __construct() {  //VOIR POURQUOI LE CHEMIN REQUIRE FONCTIONNE PAS SA MERE
        $bdd = new PDO('mysql:host=localhost;dbname=camping', 'root', '');

        try {
            $bdd = new PDO('mysql:host=localhost;dbname=camping', 'root', '');
            $this->connexion=$bdd;
        }

        catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }
       

    // FONCTION REGISTER -----------------------------------------------------------------------------------------------

    public function Register($login, $email, $firstname, $lastname, $password) {

        $data = [
            'login'=>$login,
            'email'=>$email,
            'firstname'=>$firstname,
            'lastname'=>$lastname,
            'password'=>md5($password),
            'admin'=>'0',
        ];

        $register = $this->connexion->prepare("INSERT into users (login, email, firstname, lastname, password, admin) VALUES (:login, :email, :firstname, :lastname, :password, :admin)");
        $register->execute($data);
    
    }

    //FUNCTION CONNECT ---------------------------------------------------------------------------------------

    public function Connect($login, $password) {


        $connect = $this->connexion->prepare("SELECT * FROM users WHERE login='".$login."' && password='".md5($password)."'");
        $connect->setFetchMode(PDO::FETCH_ASSOC);
        $connect->execute();

        $connectresult = $connect->fetchall();

        if($connectresult) {

            $_SESSION['login'] = $login;
            $_SESSION['id'] = $connectresult[0]['id'];
            $_SESSION['admin'] = $connectresult[0]['admin'];
            header('Location: compte.php?val="'.$connectresult[0]['login']."'");

        }

        else {
            
            $connexion = 0;
            
        }
    }

    // GETINFOS -----------------------------------------------------------------------------------------

    public function GetInfos() {
        $getinfos = $this->connexion->prepare("SELECT * FROM users WHERE id='".$_SESSION['id']."'");
        $getinfos->setFetchMode(PDO::FETCH_ASSOC);
        $getinfos->execute();

        $getinfosresult = $getinfos->fetchall();

        $this->login = $getinfosresult[0]['login'];
        $this->email = $getinfosresult[0]['email'];
        $this->firstname = $getinfosresult[0]['firstname'];
        $this->lastname = $getinfosresult[0]['lastname'];
        $this->session=$_SESSION['login'];
    }

    //UPDATEINFOS ---------------------------------------------------------------------------------------------

    public function UpdateInfos($newlogin, $newfirstname, $newlastname) {

        $data = [
            'login'=>$newlogin,
            'firstname'=>$newfirstname,
            'lastname'=>$newlastname,
        ];

        $updateinfos = $this->connexion->prepare("UPDATE users SET
        login=:login, 
        firstname =:firstname,
        lastname =:lastname
        WHERE login ='".$_SESSION['login']."'");

        $updateinfos->execute($data);
             
        $_SESSION['login'] = $newlogin;
  
    }

    //UPDATEPASSWORD ---------------------------------------------------------------------------------------------

    public function UpdatePassword($newpassword){

        $updatepassword = $this->connexion->prepare("UPDATE users SET password='".md5($newpassword)."' WHERE login ='".$_SESSION['login']."'");
        $updatepassword->execute();

    }

    //UPDATEEMAIL ---------------------------------------------------------------------------------------------

    public function UpdateEmail($newemail){

        $updateemail = $this->connexion->prepare("UPDATE users SET email='".$newemail."' WHERE login ='".$_SESSION['login']."'");
        $updateemail->execute();

    }







}

?>