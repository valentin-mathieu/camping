<?php

session_start();


?>

<html lang=fr>
    <head>
        <meta charset="utf-8">
        <title>Tarifs</title>
        <link rel="stylesheet" href="style/tarifs.css">
    </head>

    <body>
        
        <?php require('header.php') ?>

        <main>

            <section class="content_tarif">
            
            <h2 class="titre">Tarifs du camping pour 2022 (par jour)</h2> 

            <ul class="liste_tarif">
                <li>⇾ Tente : 10€</li>
                <li>⇾ Camping-car : 20€</li>
            </ul>

            <h5 class="titre">Vous pouvez sélectionner plusieurs options durant votre séjour :</h5>
            <ul class="liste_tarif">
                <li>⇾ Accès à la borne électrique : 2€</li>
                <li>⇾ Accès à notre Disco-Club "Les Girelles Dansantes" : 17€</li>
                <li>⇾ Accès aux activités (Yoga, Frisbee, Ski Nautique) : 30€</li>
            </ul>            

            <div id="container1">
                <img src="assets/paiement1.png" alt="cb">
                <img src="assets/paiement2.png" alt="cash">
            </div>

            </section>

        </main>

        <?php require('footer.php'); ?>

    </body>
</html>