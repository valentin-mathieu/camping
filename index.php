<?php

session_start();

?>

<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Accueil</title> 
        <link rel="stylesheet" href="view/style/header.css">
        <link rel="stylesheet" href="view/style/index.css">
        <link rel="stylesheet" href="view/style/footer.css">
    </head>

    <body>

        <header>
            <div class="nav-wrapper">
                <div class="logo-container">
                    <img class="logo" src="view/assets/logo.png" alt="Logo">
                </div>
                
                <nav>
                    <input class="hidden" type="checkbox" id="menuToggle">
                        <label class="menu-btn" for="menuToggle">
                            <div class="menu"></div>
                            <div class="menu"></div>
                            <div class="menu"></div>
                        </label>

                    <div class="nav-container">
                        <ul class="nav-tabs">
                            <li class="nav-tab"><a href="index.php">Accueil</a></li>
                            <li class="nav-tab"><a href="view/compte.php">Mon Compte</a></li>
                            <li class="nav-tab"><a href="view/lecamping.php">Le Camping</a></li>
                            <li class="nav-tab"><?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == '0') { ?><a href="view/reserver.php">Réserver</a> <?php } else { ?><a href="view/reservations.php">Réservations</a><?php } ?></li>
                            <li class="nav-tab"><a href="view/tarifs.php">Tarifs</a></li>
                            <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == '1') { ?><li class="nav-tab"><a href="view/planning.php">Planning</a></li><?php } ?>
                            <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == '1') { ?><li class="nav-tab"><a href="view/gestion-tarifs.php">Gestion tarifs</a></li><?php } ?>
                            <?php if(isset($_SESSION['login'])){?><li class="nav-tab"><a href="model/deconnexion.php">Déconnexion</a><?php }?></li>
                        </ul>
                    </div>
                  
                </nav>
            </div>
        </header>

        <main>

            <section class="container">

                <h1>Camping <br> Happy Sardines</h1>
                
                <p> Installez vous chez Happy Sardines</br>
                    et découvrez le coeur de la FRENCH RIVIERA.</br>
                    Découvrez le site <a href="view/lecamping.php">ici</a>.
                </p>

            </section>

        </main>

        <footer>

            <div class="footerboxes">

                <div class="footerleftboxes">

                    <div> Ce site Web a été conçu par : </div>
                    <div> Thomas <b>Serdjebi</b> </div>
                    <div> Valentin <b>Mathieu</b> </div>
                    <div> Etudiants à l'école du numérique La Plateforme_ </div>
                    <div> Retrouvez le projet sur : <a class="lienfooter" href="https://github.com/thomas-serdjebi" target="blank">le GitHub de Thomas</a> et <a class="lienfooter" href="https://github.com/valentin-mathieu" target="blank">le Github de Valentin<a/>.</div>

                </div>

                <div class="footerrightboxes">

                    <div id="rdvfoot"> Retrouvez toutes les infos sur <a href="https://laplateforme.io/" target="_blank" class="lienfooter">La Plateforme_</a></div>

                    <div><a href="https://laplateforme.io/" class="lienfooter"><img src="view/assets/logo_lp.png" alt="logoplateforme" class="logoplateforme"></div>

                        <div class="footersocialboxes">

                            <div><a href="https://www.facebook.com/LaPlateformeIO" target="_blank"><img src="view/assets/logo_fb.JPG" alt="logofacebook"  class="logosocial"></a></div>

                            <div><a href="https://www.linkedin.com/school/laplateformeio/" target="_blank"><img src="view/assets/logo_linkedin.JPG" alt="logolinkedin" class="logosocial"></a></div>

                            <div><a href="https://twitter.com/LaPlateformeIO" target="_blank"><img src="view/assets/logo_twitter.JPG" alt="logotwitter" class="logosocial"></a></div>

                            <div><a href="https://www.instagram.com/LaPlateformeIO/" target="_blank"><img src="view/assets/logo_insta.JPG" alt="logoinstagram" class="logosocial"></a></div>

                        </div>
                    </div>
                </div>
            </div>

        </footer>
    
    </body>
</html>