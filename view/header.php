<head>
    <link rel="stylesheet" type="text/css" href="style/header.css">
</head>
  
<header>
        <div class="nav-wrapper">
            <div class="logo-container">
                <img class="logo" src="assets/logo.png" alt="Logo">
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
                        <li class="nav-tab"><a href="../index.php">Accueil</a></li>
                        <li class="nav-tab"><a href="compte.php">Mon Compte</a></li>
                        <li class="nav-tab"><a href="lecamping.php">Le Camping</a></li>
                        <li class="nav-tab"><?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == '0') { ?><a href="reserver.php">Réserver</a> <?php } else { ?><a href="reservations.php">Réservations</a><?php } ?></li>
                        <li class="nav-tab"><a href="tarifs.php">Tarifs</a></li>
                        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == '1') { ?><li class="nav-tab"><a href="planning.php">Planning</a></li><?php } ?>
                        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == '1') { ?><li class="nav-tab"><a href="gestion-tarifs.php">Gestion tarifs</a></li><?php } ?>
                        <?php if(isset($_SESSION['login'])){?><li class="nav-tab"><a href="../model/deconnexion.php">Déconnexion</a><?php }?></li> 
                    </ul>
                </div>
            </nav>
        </div>
    </header>