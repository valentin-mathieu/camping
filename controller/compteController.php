<?php

require('../model/classes/class_user.php');
require('../model/classes/class_reservations.php');

// FUNCTION CONNECT CONTROLLER

if (!empty($_POST)){
    extract($_POST);
    
    if (isset($_POST['connexion'])) {

        $login = $_POST['login'];
        $password = $_POST['password'];

        $valid = (boolean) true;

        if (empty($login)) {
            $valid = false;
            $err_login = "Veuillez renseigner votre login.";
        }

        if (empty($password)) {
            $valid = false;
            $err_password = "Veuillez renseigner votre mot de passe.";
        }

        if($valid == true) {

            $connect_user = new User ;
            $connect_user->Connect("$login", "$password");

            if($connexion == 0){

                $err_connexion = "Le login et/ou le mot de passe sont incorrects.";

            }
        }

    }
}

// FUNCTION GETINFOS CONTROLLER

if (isset($_SESSION['login'])) {
    $getinfos_user = new User;
    $getinfos_user->GetInfos();
}

// REDIRECTION PAGE INSCRIPTION

if (isset($_POST['suscribe'])) {
    header ('Location: ../view/inscription.php');
}

// REDIRECTION COMPTE




?>


