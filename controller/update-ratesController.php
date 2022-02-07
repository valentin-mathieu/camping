<?php

    require('../model/bdd.php');


    if (isset($_POST['update_site_rate'])) {

        $table = "equipments";
        $rate = $_POST['rate'];
        $id = '1';
        $query = "UPDATE $table SET rate = :rate WHERE id = :id ";
        $password = htmlspecialchars($_POST['password']);
        $login = $_SESSION['login'];
        

        $data_pass = [
            'login' => $login,
            'password'=> md5($password),
        ] ;

        $sql = "SELECT * FROM users WHERE login=:login && password=:password";
        $check_password = $bdd->prepare($sql);
        $check_password->setFetchMode(PDO::FETCH_ASSOC);
        $check_password->execute($data_pass);

        $checking = $check_password->fetchAll();
    
        if($checking) {

            // Modifie le prix de location d'emplacement au jour avec la tente

            $update_site_rate = new Rates ;
            $update_site_rate->UpdateRate($query, $table, $rate, $id);

            // Modifie le prix de location d'emplacement au jour avec le campingcar(donc deux emplacements soit le meme que la tente *2)

            $rate = $rate*2;
            $id = '2';

            $update_site_rate = new Rates ;
            $update_site_rate->UpdateRate($query, $table, $rate, $id) ;
        }

        else $err_password_1 = "Le mot de passe est incorrect.";
    }


    if (isset($_POST['update_option1_rate'])) {

        $table = "options";
        $rate = $_POST['option1_rate'];
        $id = '1';
        $query = "UPDATE $table SET rate = :rate WHERE id = :id ";
        $password = htmlspecialchars($_POST['password']);
        $login = $_SESSION['login'];
        

        $data_pass = [
            'login' => $login,
            'password'=> md5($password),
        ] ;

        $sql = "SELECT * FROM users WHERE login=:login && password=:password";
        $check_password = $bdd->prepare($sql);
        $check_password->setFetchMode(PDO::FETCH_ASSOC);
        $check_password->execute($data_pass);

        $checking = $check_password->fetchAll();
    
        if($checking) {

            // Modifie le prix de location d'emplacement au jour avec la tente

            $update_option_rate = new Rates ;
            $update_option_rate->UpdateRate($query, $table, $rate, $id);

        }

        else $err_password_2 = "Le mot de passe est incorrect.";
    }

    
    if (isset($_POST['update_option2_rate'])) {

        $table = "options";
        $rate = $_POST['option2_rate'];
        $id = '2';
        $query = "UPDATE $table SET rate = :rate WHERE id = :id ";
        $password = htmlspecialchars($_POST['password']);
        $login = $_SESSION['login'];
        
        echo $query;

        $data_pass = [
            'login' => $login,
            'password'=> md5($password),
        ] ;

        $sql = "SELECT * FROM users WHERE login=:login && password=:password";
        $check_password = $bdd->prepare($sql);
        $check_password->setFetchMode(PDO::FETCH_ASSOC);
        $check_password->execute($data_pass);

        $checking = $check_password->fetchAll();
    
        if($checking) {

            // Modifie le prix de location d'emplacement au jour avec la tente

            $update_option_rate = new Rates ;
            $update_option_rate->UpdateRate($query, $table, $rate, $id);

        }

        else $err_password_3 = "Le mot de passe est incorrect.";
    }

    
    if (isset($_POST['update_option3_rate'])) {

        $table = "options";
        $rate = $_POST['option3_rate'];
        $id = '3';
        $query = "UPDATE $table SET rate = :rate WHERE id = :id ";
        $password = htmlspecialchars($_POST['password']);
        $login = $_SESSION['login'];
        

        $data_pass = [
            'login' => $login,
            'password'=> md5($password),
        ] ;

        $sql = "SELECT * FROM users WHERE login=:login && password=:password";
        $check_password = $bdd->prepare($sql);
        $check_password->setFetchMode(PDO::FETCH_ASSOC);
        $check_password->execute($data_pass);

        $checking = $check_password->fetchAll();
    
        if($checking) {

            // Modifie le prix de location d'emplacement au jour avec la tente

            $update_option_rate = new Rates ;
            $update_option_rate->UpdateRate($query, $table, $rate, $id);

        }

        else $err_password_4 = "Le mot de passe est incorrect.";
    }


?>