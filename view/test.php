<?php

require('../model/bdd.php');

$firstname = "Thomas";
$lastname = "Serdjebi ";

$query = "SELECT id FROM users WHERE firstname = '".$firstname."' AND lastname = '".$lastname."' ";
$get_id_user = $bdd->prepare($query);
$get_id_user->setFetchMode(PDO::FETCH_ASSOC);
$get_id_user->execute();
$fetch_id_user = $get_id_user->fetchAll();

var_dump($fetch_id_user);
?>



