<?php

$bdd = new PDO('mysql:host=localhost;dbname=camping', 'root', '');

try {
    $bdd = new PDO('mysql:host=localhost;dbname=camping', 'root', '');

}

catch (PDOException $e) {
    echo $e->getMessage();
    die();
}

?>

