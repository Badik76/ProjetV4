<?php
// Start the session
session_start();
require_once '../controllers/userPageController.php'
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Wellness Reiki</title>
        <link rel="shortcut icon" href="../assets/img/logo.png"/>
        <meta name="author" content="Badik76" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" />
        <link href="https://fonts.googleapis.com/css?family=Thasadith" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="../assets/import/Materialize/css/materialize.min.css"  media="screen" />
        <!-- Import personnal stylesheet -->
        <link type="text/css" rel="stylesheet" href="../assets/css/style.css" />
        <!--Let browser know website is optimized for mobile-->
    </head>
    <body>
        <!--navbar-->
        <header>
            <div class="navbar-fixed">
                <nav class="backgroundcolor">
                    <div class="nav-wrapper">
                        <a href="../index.php"><img src="../assets/img/logo.png" class="logo left" alt="logo" title="logo" /></a>
                        <ul id="left-nav" class="left hide-on-med-and-down">
                            <li>Wellness Reiki</li>
                        </ul>  
                        <ul id="right-nav" class="right hide-on-med-and-down">
                            <li><a href="product.php">Produits</a></li>
                            <li><a href="userPage.php">Mes RDVs</a></li>
                            <li><a href="AdminPage.php">PanelAdmin</a></li>
                            <li><a class="dropdown-trigger" href="#!" data-target="dropdown1">Espace Client<i class="material-icons right">arrow_drop_down</i></a></li>
                            <!-- Dropdown Structure -->
                        </ul>
                        <ul id="dropdown1" class="dropdown-content">
                            <li><a class="waves-effect waves-light" href="register.php">Inscription</a>
                            </li>
                            <li class="divider"></li>
                            <li><a class="waves-effect waves-light" href="login.php">Connexion</a>
                            </li>
                        </ul>
                        <ul class="right hide-on-med-and-up show-on-medium-and-down">
                            <li><a data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a></li>
                        </ul>
                    </div>
                </nav>   
            </div>
            <ul id="slide-out" class="sidenav">          
                <li><a class="subheader"><img  id="logonavmob" src="../assets/img/logo.png">Wellness Reiki</a></li>
                <li><div class="divider"></div></li>
                <li><a href="../index.php"><i class="material-icons">home</i>Accueil</a></li>
                <li><a href="product.php"><i class="material-icons">lightbulb</i>Produits</a></li>
                <li><a href="userPage.php"><i class="material-icons">spa</i>Mes RDVs</a></li>
                <li><a href="AdminPage.php"><i class="material-icons">dashboard</i>Panel Admin</a></li>
                <li><div class="divider"></div></li>
                <li><a class="subheader">Espace personnel</a></li>
                <li><div class="divider"></div></li>
                <li><a class="waves-effect" href="register.php"><i class="material-icons">add</i> Inscription</a></li>
                <li><a class="waves-effect" href="login.php"><i class="material-icons">input</i> Connexion</a></li>
            </ul>        
            <!--end navbar-->
        </header>        

        <div class="container-fluid row center">          
            <div class="card col m12 l6"> 
                <?php
                if ($userIsFind) {
                    ?>
                    <div class="card-title groundcolor"><h2><i class="material-icons">spa</i> Mon prochain RDV <i class="material-icons">spa</i></h2></div>                 
                    <div class="card-content">
                        <table class="centered highlight responsive-table">
                            <thead>
                                <tr>
                                    <th>Soin</th>
                                    <th>Date</th>
                                    <th>Heure</th>
                                    <th>Modif</th>
                                </tr>
                            </thead>
                            <tbody> 
                                <?php if ($rdvFind) { ?>
                                    <tr>
                                        <td><?= $daterdv->prestations_name ?></td>
                                        <td><?= $daterdv->dateRDV_dateRDV ?></td>
                                        <td><?= $daterdv->timeRDV_timeRDV ?></td>
                                        <td><a href="userPage.php?idUser=<?= $users->users_id ?>&DeleteRDV=<?= $daterdv->dateRDV_id ?>" name="action">
                                                <i class="material-icons red-text">cancel</i>
                                            </a>
                                            <a class="" href="userPage.php?idUser=<?= $users->users_id ?>&updateRDV=<?= $daterdv->dateRDV_id ?>" name="action">
                                                <i class="material-icons green-text">autorenew</i>
                                            </a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                <div class="divider"></div>
                <?php if ($userIsFind) { ?>
                    <div class="card-title groundcolor"><h2><i class="material-icons">spa</i> Mes anciens RDV <i class="material-icons">spa</i></h2></div>
                    <div class="card-content">
                        <table class="centered highlight responsive-table">
                            <thead>
                                <tr>
                                    <th>Soin</th>
                                    <th>Date</th>
                                    <th>Heure</th>
                                    <th>Comments</th>
                                </tr>
                            </thead>
                            <?php foreach ($rdvidUserList AS $daterdv) { ?>
                                <tbody>
                                    <tr>
                                        <td><?= $daterdv->prestations_name ?></td>
                                        <td><?= $daterdv->dateRDV_dateRDV ?></td>
                                        <td><?= $daterdv->timeRDV_timeRDV ?></td>
                                        <?php if ($daterdv->dateRDV_validate == 1) { ?>
                                            <!-- Modal Trigger AddComment -->
                                            <td><a class="waves-effect waves-light btn modal-trigger right" href="#modaladdComment">Commenter rdv</a></td>
                                            <!-- Modal Structure AddCat-->
                                    <div id="modaladdComment" class="modal">
                                        <div class="modal-content">
                                            <form name="addComment" action="userPage.php" method="POST" >
                                                <fieldset>
                                                    <legend>Ajouter Commentaire</legend>
                                                    <p class="center-align"><?= $addCommentSuccess ? 'Commentaire enregistré. ' : '' ?><p>
                                                    <div>
                                                        <label for="comments_comment">Nom : </label>
                                                        <input name="comments_comment" type="text" id="comments_comment" required class="validate" value="<?= isset($_POST['comments_comment']) ? $_POST['comments_comment'] : ''; ?>" />
                                                        <div>
                                                            <span class="error"><?= isset($errorArray['comments_comment']) ? $errorArray['comments_comment'] : ''; ?></span>
                                                        </div>
                                                    </div>
                                                    <input type="submit" class="btn modal-close" name="addComment" />
                                                </fieldset>
                                            </form>
                                        </div>
                                    </div>
                                <?php } ?>  
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
            }
            if ($userIsFind) {
                ?>
                <div class="card col m12 l6"> 
                    <div class="card-title groundcolor">
                        <h2><i class="material-icons">group</i>
                            Mon Profil 
                            <i class="material-icons">group</i>
                        </h2>
                    </div>
                    <?php
                    if ($addSuccess) {
                        ?>
                        <p>Les modifications ont bien été prises en compte</p>.
                        <?php
                    }
                    if ($deleteOk) {
                        ?>
                        <p>Profil supprimé</p>.
                    <?php }
                    ?>               
                    <div class="card-content">
                        <form id="inscription" method="post" action="userPage.php?idUser=<?= $users->users_id ?>">
                            <fieldset>
                                <legend>Mise à Jour <?php if ($idSU) { ?>
                                        <i class="material-icons right">grade</i>
                                    <?php } ?></legend>
                                <div>
                                    <label for="users_lastname">Nom : (DelaMolleFesse)</label>
                                    <div>
                                        <span class="error"><?= isset($errorArray['users_lastname']) ? $errorArray['users_lastname'] : ''; ?></span>
                                    </div>
                                    <input name="users_lastname" type="text" id="users_lastname" required class="validate" value="<?= $users->users_lastname ?>" pattern="[a-zA-Zàáâãäåçèéêëìíîïðòóôõöùúûüýÿ-]+"  />
                                </div>
                                <div>
                                    <label for="users_firstname">Prénom : (ex: Jean-Edouard)</label>
                                    <div>
                                        <span class="error"><?= isset($errorArray['users_firstname']) ? $errorArray['users_firstname'] : ''; ?></span>
                                    </div>
                                    <input name="users_firstname" type="text" id="users_firstname" required class="validate" value="<?= $users->users_firstname ?>" pattern="[a-zA-Zàáâãäåçèéêëìíîïðòóôõöùúûüýÿ-]+" />
                                </div>
                                <div>
                                    <label for="users_phone">Numéro de téléphone : (ex: 0602030405)</label>
                                    <div>
                                        <span class="error"><?= isset($errorArray['users_phone']) ? $errorArray['users_phone'] : '' ?></span>
                                    </div>
                                    <input id="users_phone" name="users_phone" type="tel" class="validate" required pattern="((\+)33|0)[1-9](\d{2}){4}" value="0<?= $users->users_phone ?>" />
                                </div>
                                <div>
                                    <label for="users_email">Email : (ex: mail@mail.fr)</label>
                                    <div>
                                        <span class="error"><?= isset($errorArray['users_email']) ? $errorArray['users_email'] : ''; ?></span>
                                    </div>   
                                    <input name="users_email" type="email" id="users_email" required class="validate"  value="<?= $users->users_email ?>" />
                                </div>
                                <div>
                                    <label for="users_birthdate">Date de naissance (ex: 23/05/2000).</label>
                                    <div>
                                        <span class="error"><?= isset($errorArray['users_birthdate']) ? $errorArray['users_birthdate'] : '' ?></span>
                                    </div>
                                    <input id="users_birthdate" name="users_birthdate" type="text" class="validate datepicker" value="<?= $users->users_birthdate ?>" />
                                </div>
                                <div>
                                    <label for="users_adress">Addresse (ex : 12 avenue des Gobelins Boiteux 76620 Le Havre)</label>
                                    <div>
                                        <span class="error"><?= isset($errorArray['users_adress']) ? $errorArray['users_adress'] : '' ?></span>
                                    </div>
                                    <input id="users_adress" name="users_adress" type="text" class="validate" value="<?= $users->users_adress ?>" />
                                </div>
                                <div class="card-action">
                                    <a class="btn red darken-1" href="userPage.php?deleteThis=<?= $users->users_id ?>" name="action">Delete
                                        <i class="material-icons right">cancel</i>
                                    </a>
                                    <input name="updateButton" type="submit" class="waves-effect waves-light btn" value="Upgrade"/>
                                    <div>
                                        <p class="error"><?= isset($errorArray['update']) ? $errorArray['update'] : '' ?></p>
                                    </div>
                                    <p class="badge red-text text-darken-1">Cette action est irreversible.</p>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            <?php } else { ?>
                <div>
                    <p>Votre Profil n'a pas été trouvé.</p>
                </div>
            <?php } ?>
        </div>        
        <!--coryright-->
        <div class="container-fluid rem10">
            2018 - Made by Badik 🖕 with <i class="fas fa-heart red-text rem10"></i>
        </div>
        <!--end coryright-->
        <!--Scripts-->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?libraries=places&amp;key=AIzaSyDfPxtZGhz_E9iOhLl2dq0AiosS9HeFBeE"></script>
        <script src="../assets/import/Materialize/js/materialize.min.js"></script>
        <script src="../assets/import/SweetAlert/sweetalert.min.js"></script>
        <script src="../assets/js/script.js"></script>
    </body>
</html>