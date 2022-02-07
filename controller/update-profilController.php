<?php

require('../model/bdd.php');

require('../model/classes/class_user.php');

$success_infos = 0;
$success_password = 0;
$success_mail = 0;

// CONTROLLER FUNCTION UPDATEINFOS

if (isset($_POST)){
    extract($_POST);

    if (isset($_POST['updateinfos'])) {

        $newlogin = trim($_POST['newlogin']);
        $newfirstname = trim(ucwords(strtolower($_POST['newfirstname'])));
        $newlastname = trim(ucwords(strtolower($_POST['newlastname'])));
        $password = $_POST['password'];

        $data = [
            'login'=>$newlogin,
            'lastname'=>$newlastname,
            'firstname'=>$newfirstname,
        ];

        $valid = (boolean) true;


        // check LOGIN -------------

        $reqlog = $bdd->prepare("SELECT * FROM users WHERE login ='".$newlogin."' AND id!='".$_SESSION['id']."'");
        $reqlog->setFetchMode(PDO::FETCH_ASSOC);
        $reqlog->execute();

        $resultlog = $reqlog->fetch();


        if (empty($newlogin)) {
            $valid = false;
            $err_login = "Renseignez votre login.";
        }

        elseif (strlen($newlogin)<6 || strlen($newlogin)>20) {
            $valid = false;
            $err_login = "Le login doit contenir entre 6 et 20 caractères.";
            $login="";
        }

        elseif (!preg_match("#^[a-z0-9A-Z]+$#" ,$newlogin)) {
            $valid = false;
            $err_login = "Le login doit uniquement contenir des lettres minuscules et des chiffres.";
            $login="";
        }

        elseif ($resultlog) {
            $valid = false;
            $err_login = "Ce login est déjà utilisé.";
            $login ="";
        }


        // check firstname/lastname ------

        if (empty($newfirstname)) {
            $valid = false;
            $err_firstname = "Renseignez votre prénom.";
        }

        elseif (!preg_match("#^[a-zA-Z]+$#", $newfirstname)) {
            $valid = false;
            $err_firstname ="Votre prénom ne doit pas contenir de chiffres ou de caractères spéciaux.";
            $firstname ="";
        }

        if (empty($newlastname)) {
            $valid = false;
            $err_lastname = "Renseignez votre nom.";
        }

        elseif (!preg_match("#^[a-zA-Z]+$#", $newlastname)) {
            $valid = false;
            $err_lastname = "Votre nom ne doit pas contenir de chiffres ou de caractères spéciaux.";
            $lastname ="";
        }

        // check PASSWORD  ------

        $reqpassword = $bdd->prepare("SELECT * FROM users WHERE id='".$_SESSION['id']."' && password ='".md5($password)."'");
        $reqpassword->setFetchMode(PDO::FETCH_ASSOC);
        $reqpassword->execute();

        $resultpassword = $reqpassword->fetch();

        if($resultpassword == false ) {
            $valid = false;
            $err_passwordinfos = "Le mot de passe est incorrect.";
        }

        if($valid==true) {
            $updateinfos_user = new User();
            $updateinfos_user->UpdateInfos("$newlogin", "$newfirstname", "$newlastname");
            $success_infos = 1;
        }
    }
}

// CONTROLLER FUNCTION UPDATEPASSWORD

if (!empty($_POST)){
    extract($_POST);

    if (isset($_POST['updatepassword'])) {

        $password = $_POST['actualpassword'];
        $newpassword = $_POST['newpassword'];
        $checkpassword = $_POST['checkpassword'];

        $valid = (boolean) true;

        $reqpassword = $bdd->prepare("SELECT * FROM users WHERE login='".$_SESSION['login']."' AND password ='".md5($password)."'");
        $reqpassword->setFetchMode(PDO::FETCH_ASSOC);
        $reqpassword->execute();

        $resultpassword = $reqpassword->fetch();

        if(empty($password)) {
            $valid = false;
            $err_actualpassword = "Renseignez votre mot de passe actuel.";
        }

        elseif($resultpassword == false) {
            $valid = false;
            $password = '';
            $err_actualpassword = "Le mot de passe actuel est incorrect.";
        }

        if(empty($newpassword)) {
            $valid = false;
            $err_newpassword = "Renseignez votre nouveau mot de passe.";
        }

        elseif (strlen($newpassword)<8) {
            $valid = false;
            $newpassword ='';
            $err_newpassword ="Le mot de passe doit contenir au moins 8 caractères.";
        }

        elseif(empty($checkpassword)) {
            $valid = false;
            $err_checkpassword = "Confirmez votre mot de passe.";

        }

        elseif($newpassword !== $checkpassword) {
            $valid = false;
            $err_passwords = "Les mots de passe ne correspondent pas.";
        }

        if ($valid == true) {

            $updatepassword_user = new User();
            $updatepassword_user->UpdatePassword("$newpassword");
            $success_password = 1;

        }
    }
}

// CONTROLLER FUNCTION UPDATEEMAIL


if (!empty($_POST)) {
    extract($_POST);

    if(isset($_POST['updateemail'])) {

        $newemail = trim($_POST['newemail']);
        $checkemail = trim($_POST['checkemail']);
        $passwword = trim($_POST['password']);

        $valid = (boolean) true;

        // check EMAIL ----------

        $reqmail = $bdd->prepare("SELECT * FROM users WHERE email ='".$newemail."'");
        $reqmail->setFetchMode(PDO::FETCH_ASSOC);
        $reqmail->execute();

        $resultmail = $reqmail->fetch();

        if (empty($newemail)) {
            $valid=false;
            $err_email = "Renseignez l'email.";
        }

        elseif(filter_var($newemail, FILTER_VALIDATE_EMAIL) == false) {
            $valid=false;
            $err_email = "Votre email n'est pas au bon format";
            $email="";
        }
        
        elseif ($resultmail) {
            $valid = false;
            $err_email = "Cette adresse mail est déjà utilisée.";
            $email ="";
        }

        elseif (empty($checkemail)) {
            $valid = false;
            $err_checkemail = "Veuillez confirmer votre email.";
        }

        elseif ($checkemail !== $newemail) {
            $valid = false;
            $err_checkemail = "Les emails ne correspondent pas.";
            $checkemail = "";
        }

       // check PASSWORD  ------

       $reqpassword = $bdd->prepare("SELECT * FROM users WHERE login='".$_SESSION['login']."' && password ='".md5($password)."'");
       $reqpassword->setFetchMode(PDO::FETCH_ASSOC);
       $reqpassword->execute();

       $resultpassword = $reqpassword->fetch();

       if(empty($password)) {
           $valid = false;
           $err_password = "Renseignez votre mot de passe.";
       }

        elseif($resultpassword == false ) {
           $valid = false;
           $err_password = "Le mot de passe est incorrect.";
           echo "Le mot de passe est incorrect.";
        }

        if($valid==true) {
            $updateemail = new User ();
            $updateemail->UpdateEmail($newemail);
            $success_mail = 1;
        }
    }
}

    
?>