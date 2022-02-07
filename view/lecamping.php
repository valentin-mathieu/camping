<?php

session_start();

?><html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Le Camping</title> 
        <link rel="stylesheet" type="text/css" href="style/lecamping.css">
    </head>

    <body>

      <?php require('header.php')?>

        <main>

            <h1> Découvrez le Camping<br><span id="camping_name">Happy Sardines</span> ! </h1>

            <article>

                <section>

                    <img height="300px" width="500px" src="assets/pins.JPG" id="pins_flex_image" alt="les_pins">
                    <div class="text_image">
                        <h2>Les Pins</h2>
                        <p>Profitez d'un emplacement sous la protection <br>des pins, garantissant ombre et fraîcheur. <br>
                        Vous serez à proximité de toutes les commodités du camping, dans un milieu ressourçant !
                        </p>
                    </div>    
                
                </section>

                <section>

                    <img height="300px" width="500px" src="assets/plage.JPG"  class="flex_image" alt="la_plage">
                    <div class="text_image">
                        <h2>La Plage</h2>
                        <p>Venez vous installer au bord de l'eau, avec le bruit des vagues qui bercent votre sommeil. <br>
                        Pouvoir aller piquer une tête en 30 secondes depuis son chez-soi, c'est quand même le pied !
                        </p>
                    </div>

                </section>
                
                <section>

                    <img height="300px" width="500px" src="assets/maquis.PNG" class="flex_image"alt="le_maquis">
                    <div class="text_image">
                        <h2>Le Maquis</h2>
                        <p>Venez profiter de l'emplacement le plus <br>diversifié en terme de paysages ! <br>
                            Vous vous réveillerez avec les senteurs de la Provence et au centre de sa riche faune & flore. </p>
                    </div>

                </section>
            </article>
        </main>

        <?php require('footer.php'); ?>
    
    </body>
</html>