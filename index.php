<?php
// Start the session
session_start();
require_once 'controllers/indexController.php';
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Wellness Reiki</title>
        <link rel="shortcut icon" href="./assets/img/logo.png"/>
        <meta name="author" content="Badik76" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" />
        <link href="https://fonts.googleapis.com/css?family=Thasadith" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="./assets/import/Materialize/css/materialize.min.css"  media="screen" />
        <link type="text/css" rel="stylesheet" href="./assets/import/SweetAlert2/sweetalert2.min.css"  media="screen" />
        <!-- Import personnal stylesheet -->
        <link type="text/css" rel="stylesheet" href="./assets/css/style.css" />
        <!--Let browser know website is optimized for mobile-->
    </head>
    <body>
        <header>
            <!--navbar-->
            <div class="navbar-fixed">
                <nav class="backgroundcolor">
                    <div class="nav-wrapper">
                        <a href="index.php"><img src="./assets/img/logo.png" class="logo left" alt="logo" title="logo" /></a>
                        <a data-target="slide-out" class="sidenav-trigger right"><i class="material-icons">menu</i></a>
                        <ul id="left-nav" class="left hide-on-med-and-down">
                            <li class="active"><a href="index.php"><b>Wellness Reiki</b></a></li>
                        </ul>  
                        <ul id="right-nav" class="right hide-on-med-and-down">
                            <li><a href="views/product.php?productCategory_id=1">Produits</a></li>
                            <li><a href="views/learnmore.php">Plus d'Info</a></li>
                            <?php if (isset($_SESSION['userLog'])) { ?> 
                                <li><a href="views/userPage.php">Mon Espace</a></li>
                            <?php } if (isset($_SESSION['isAdmin'])) { ?>                                
                                <li><a href="views/AdminPage.php">PanelAdmin</a></li>
                            <?php } if (isset($_SESSION['userLog'])) { ?> 
                                <li><a href="views/logout.php">Déconnexion</a></li> 
                            <?php } else { ?><!-- Dropdown Structure -->
                                <li><a class="dropdown-trigger" href="#!" data-target="dropdown1">Espace Client<i class="material-icons right">arrow_drop_down</i></a></li>
                            </ul>                           
                        <?php } ?>  
                    </div>
                    <ul id="dropdown1" class="dropdown-content">
                        <li><a class="waves-effect waves-light" href="views/register.php">Inscription</a></li>
                        <li class="divider"></li>
                        <li><a class="waves-effect waves-light" href="views/login.php">Connexion</a></li>
                    </ul>
                </nav>   
            </div>
            <ul id="slide-out" class="sidenav">          
                <li><a class="subheader"><img  id="logonavmob" src="./assets/img/logo.png"><b>Wellness Reiki</b></a></li>
                <li><div class="divider"></div></li>
                <li><a href="index.php"><i class="material-icons">home</i>Accueil</a></li>
                <li><a href="views/product.php?productCategory_id=1"><i class="material-icons">shopping_basket</i>Produits</a></li>
                <li><a href="views/learnmore.php"><i class="material-icons">lightbulb</i>Plus d'Info</a></li>
                <?php if (isset($_SESSION['userLog'])) { ?> 
                    <li><a href="views/userPage.php"><i class="material-icons">spa</i>Mon Espace</a></li>
                <?php } if (isset($_SESSION['isAdmin'])) { ?>   
                    <li><a href="views/AdminPage.php"><i class="material-icons">dashboard</i>Panel Admin</a></li>
                <?php } ?> 
                <li><div class="divider"></div></li>
                <li><a class="subheader">Espace personnel</a></li>
                <li><div class="divider"></div></li>
                <?php if (isset($_SESSION['userLog'])) { ?> 
                    <li><a class="waves-effect" href="views/logout.php"><i class="material-icons">close</i> Déconnexion</a></li>
                <?php } else {
                    ?>
                    <li><a class="waves-effect" href="views/register.php"><i class="material-icons">add</i> Inscription</a></li>
                    <li><a class="waves-effect" href="views/login.php"><i class="material-icons">input</i> Connexion</a></li>
                <?php } ?>  
            </ul>        
            <!--end navbar-->
        </header>
        <!--carou-->
        <section class="carousel carousel-slider center container" >
            <ul class="slides">
                <div class="carousel-item" href="#one!">
                    <li>
                        <div class="carousel-fixed-item center justify container">
                            <h1><b>Wellness Reiki</b></h1>
                            <p><b>Découvert et développé à partir de 1922 par Mikao Usui, le Reiki est une technique de relaxation japonaise qui se pratique par apposition des mains (notamment sur les centres énergétiques,
                                    les "chakras"). Cette énergie va ensuite se diriger sur les endroits de votre corps qui en ont le plus besoin.</b></p>
                        </div>
                        <img src="./assets/img/carou1.jpeg" alt="Présentation" title="Reiki" id="slide1"/>
                    </li>
                </div>
                <div class="carousel-item" href="#two!">
                    <li>
                        <div class="carousel-fixed-item center justify container">
                            <h1><b>Effets Ressentis</b></h1>
                            <p><b>Les effets bénéfiques (calme, détente, libération des tensions, blocages, etc.…) se font généralement ressentir dès la première séance.
                                    Les effets sont tant au niveau du mental, des émotions que du physique.
                                    En dénouant les blocages énergétiques et émotionnels, il est possible que des émotions refoulées réapparaissent.</b></p>
                        </div>
                        <img src="./assets/img/carou2.jpeg" alt="Effets" title="Wellness" id="slide2"/>
                    </li>
                </div>
                <div class="carousel-item" href="#three!">
                    <li>
                        <div class="carousel-fixed-item center justify container">
                            <h1><b>Auto-guérison</b></h1>
                            <p><b>Une séance ressource, détend, libère les blocages énergétiques, renforce le système immunitaire, diminue la douleur et élimine les toxines du corps.
                                    Il est évident que rien n'est imposé, ni figé ! Toutes les décisions seront libres et prises par vous !</b></p>
                        </div>
                        <img src="./assets/img/carou3.jpeg" alt="Wellness" title="Wellness" id="slide3"/>
                    </li>
                </div>
            </ul>
        </section>
        <!--end carou-->
        <!-- prestation-->         
        <div id="presta" class="container-fluid">
            <h2 class="center">Mes Prestations</h2>
            <div  class="row">
                <div class="hide" id="Presta"></div>
                <?php foreach ($listPrestations AS $prestation) { ?>
                    <div class="col s12 m4 l4">
                        <div class="card">
                            <div class="card-image">
                                <img id="presta<?= $prestation->prestations_id ?>" src="./assets/img/<?= $prestation->prestations_image ?>">
                                <span class="card-title"><?= $prestation->prestations_name ?></span>
                                <?php if (isset($_SESSION['userLog'])) { ?> 
                                    <!-- Modal Trigger AddRDVbyPresta -->
                                    <a class="btn-floating halfway-fab waves-effect pulse waves-light backgroundcolor modal-trigger" href="#modalID<?= $prestation->prestations_id ?>"><i class="material-icons">add</i></a>
                                <?php } ?>
                            </div>
                            <div id="prestacard" class="card-content brdbot">
                                <p class="<?php if (isset($_SESSION['userLog'])) { ?> truncate <?php } ?>">
                                    <?= $prestation->prestations_description ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Structure AddRDVbyPresta-->
                    <div id="modalID<?= $prestation->prestations_id ?>" class="modal">
                        <div class="modal-content modrdv">
                            <form id="addRDV" action="index.php?prestations_id=<?= $prestation->prestations_id ?>" method="POST">
                                <fieldset>
                                    <legend>Prendre un RDV <?= $prestation->prestations_name ?></legend>
                                    <p class="center-align"><?= $addRDVSuccess ? 'Le rdv est enregistré' : '' ?><p>
                                    <p><b><?= $prestation->prestations_description ?></b></p>
                                    <p class="left">Temps de la séance : 1 heure</p>
                                    <p class="right">Prix à domicile : 35 €</p>
                                    <div>                                        
                                        <input name="dateRDV_dateRDV" type="text" id="dateRDV_dateRDV" required class="validate datepicker" value="<?= isset($_POST['dateRDV_dateRDV']) ? $_POST['dateRDV_dateRDV'] : 'Date du RDV'; ?>" />
                                    </div>
                                    <div class="input-field row">
                                        <?php foreach ($showTimeRDV AS $timerdv) { ?>
                                            <p class="col s6 m3 l3">
                                                <label>
                                                    <input value="<?= $timerdv->timeRDV_id ?>" name="timeRDV_id" type="radio" />
                                                    <span><?= $timerdv->timeRDV_timeRDV ?></span>
                                                </label>
                                            </p>
                                        <?php } ?>    
                                        <p class="error"><?= isset($errorArray['timeRDV_id']) ? $errorArray['timeRDV_id'] : '' ?></p>
                                    </div>                                  
                                    <div class="input-field">
                                        <input name="addButton" type="submit" class="waves-effect waves-light btn white-text teal" value="Ajouter le RDV"/>
                                        <?php foreach ($errorArray AS $error) { ?>
                                            <p class="error"><?= $error ?></p>
                                        <?php } ?>                            
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!--end  prestation-->

        <!-- créer en dessus card avec les coms laissés -->
        <div class="row">
            <h2 class="center">Vos Avis</h2>
            <?php foreach ($commentsList AS $comments) { ?>
                <div class="col s12 m4 l4">
                    <div class="card horizontal">
                        <div class="card-stacked">    
                            <div id="endCom" class="card-content brdbot">
                                <b><?= $comments->users_firstname ?> <?= $comments->users_lastname ?></b>: "<span class="comment"><?= $comments->comments_comment ?></span>"
                                <p class="comment2">le <?= $comments->dateRDV_dateRDV ?> <?= $comments->prestations_name ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <!-- end avis -->
        <nav class="navbar-fixed footer-copyright black">
            <div class="container-fluid rem10 nav-wrapper row">        
                <ul class="left-nav">
                    <li> Copyright © 2019 WELLNESS REIKI</li>
                </ul>
                <ul class="right">     
                    <li><a href="views/mentionlegale.php">Mentions légales</a></li>
                    <li><a href="views/cgu.php">Conditions Générale d'Utilisation</a></li>
                </ul>
            </div>
        </nav>
        <!--end coryright-->
        <!--Scripts-->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="assets/import/Materialize/js/materialize.min.js"></script>
        <script src="assets/import/SweetAlert2/sweetalert2.all.min.js"></script>
        <script src="assets/js/script.js"></script>