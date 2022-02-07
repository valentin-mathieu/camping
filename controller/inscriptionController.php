<?php

require('../model/bdd.php');

require('../model/classes/class_user.php');

$form_register = 1;
// CONTROLLER FUNCTION REGISTER

if (!empty($_POST)) {
    extract($_POST);

    if (isset($_POST['suscribe'])) {

        $login = htmlspecialchars(trim($_POST['login']));
        $email = htmlspecialchars(trim($_POST['email']));
        $firstname = htmlspecialchars(trim(ucwords(strtolower($_POST['firstname']))));
        $lastname = htmlspecialchars(trim(ucwords(strtolower($_POST['lastname']))));
        $checkemail = htmlspecialchars(trim($_POST['checkemail']));
        $checkpassword = htmlspecialchars(trim($_POST['checkpassword']));
        $password = htmlspecialchars(trim($_POST['password']));


        $valid = (boolean) true;

        // CHECK LOGIN -------------

        $reqlog = $bdd->prepare("SELECT * FROM users WHERE login =:login");
        $reqlog->setFetchMode(PDO::FETCH_ASSOC);
        $reqlog->execute(['login'=> $login]);

        $resultlog = $reqlog->fetch();


        if (empty($login)) {
            $valid = false;
            $err_login = "Renseignez votre login.";
        }

        elseif ( strlen($login)<6 || strlen($login)>20) {
            $valid = false;
            $err_login = "Le login doit contenir entre 6 et 20 caractères.";
        }

        elseif (!preg_match("#^[a-z0-9A-Z]+$#" ,$login)) {
            $valid = false;
            $err_login = "Le login doit uniquement contenir des lettres minuscules et des chiffres.";
            $login="";
        }

        elseif ($resultlog) {
            $valid = false;
            $err_login = "Ce login est déjà utilisé.";
            $login ="";
        }

        // CHECK EMAIL ----------

        $reqmail = $bdd->prepare("SELECT * FROM users WHERE email =:email");
        $reqmail->setFetchMode(PDO::FETCH_ASSOC);
        $reqmail->execute(['email'=>$email]);

        $resultmail = $reqmail->fetch();

        if (empty($email)) {
            $valid=false;
            $err_email = "Renseignez l'email.";
        }

        elseif(filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
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

        elseif ($checkemail !== $email) {
            $valid = false;
            $err_checkemail = "Les emails ne correspondent pas.";
            $checkemail = "";
        }


        // CHECK FIRSTNAME/LASTNAME ------

        if (empty($firstname)) {
            $valid = false;
            $err_firstname = "Renseignez votre prénom.";
        }

        elseif (!preg_match("#^[a-zA-Z]+$#", $firstname)) {
            $valid = false;
            $err_firstname ="Votre prénom ne doit pas contenir de chiffres ou de caractères spéciaux.";
            $firstname ="";
        }

        if (empty($lastname)) {
            $valid = false;
            $err_lastname = "Renseignez votre nom.";
        }

        elseif (!preg_match("#^[a-zA-Z]+$#", $lastname)) {
            $valid = false;
            $err_lastname = "Votre nom ne doit pas contenir de chiffres ou de caractères spéciaux.";
            $lastname ="";
        }

        // check PASSWORD  ------

        if (empty($password)) {
            $valid = false;
            $err_password = "Renseignez votre mot de passe.";
        }

        elseif (strlen($password)<8) {
            $valid = false;
            $err_password = "Le mot de passe doit être de 8 caractères minimum.";
            $password="";
        }

        elseif (empty($checkpassword)) {
            $valid = false;
            $err_checkpassword = "Confirmez votre mot de passe.";
        }

        elseif ($password !== $checkpassword) {
            $valid = false;
            $err_checkpassword = "Les mots de passe ne correspondent pas.";
            $checkpassword ="";
        }

        if ($valid==true) {

            $create_user = new User();
            $create_user->Register("$login", "$email", "$firstname", "$lastname", "$password");
            $form_register = 0; 
        }
    }
}


?>