<?php
if (isset($_SESSION['users_id'])) {
    $req = $users->getUserById($_SESSION['users_id']);
    $_SESSION['users_id'] = $req->users_id;
    $_SESSION['users_lastname'] = $req->users_lastname;
    $_SESSION['users_firstname'] = $req->users_firstname;
    $_SESSION['users_phone'] = $req->users_phone;
    $_SESSION['users_email'] = $req->users_email;
    $_SESSION['users_birthdate'] = $req->users_birthdate;
    $_SESSION['typeUsers_id'] = $req->typeUsers_id;
}
?>


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
    <link type="text/css" rel="stylesheet" href="../assets/import/SweetAlert2/sweetalert2.min.css"  media="screen" />
    <!-- Import personnal stylesheet -->
    <link type="text/css" rel="stylesheet" href="../assets/css/style.css" />
    <!--Let browser know website is optimized for mobile-->
</head>
<body>
    <header>
        <!--navbar-->
        <div class="navbar-fixed">
            <nav class="backgroundcolor">
                <div class="nav-wrapper">
                    <a href="../index.php#!"><img src="../assets/img/logo.png" class="logo left" alt="logo" title="logo" /></a>
                    <a href="../index.php#" data-target="mobile-demo" class="sidenav-trigger right"><i class="material-icons">menu</i></a>
                    <ul class="left hide-on-med-and-down">
                        <li><a href="../index.php"><b>Wellness Reiki</b></a></li>
                    </ul> 
                    <ul class="right hide-on-med-and-down">
                        <li class="<?= isset($productPageTrue) ? $productPageTrue : '' ?>"><a href="product.php?productCategory_id=1">Produits</a></li>
                        <li class="<?= isset($learnMorePageTrue) ? $learnMorePageTrue : '' ?>"><a href="learnmore.php">Plus d'Info</a></li>                        
                        <?php if (isset($_SESSION['userLog'])) { ?> 
                            <li class="<?= isset($userPageTrue) ? $userPageTrue : '' ?>"><a href="userPage.php">Mon Espace</a></li>
                            <?php
                        }
                        if (isset($_SESSION['isAdmin'])) {
                            ?>                                
                            <li class="<?= isset($adminPageTrue) ? $adminPageTrue : '' ?>"><a href="AdminPage.php">PanelAdmin</a></li>
                            <?php
                        }
                        if (isset($_SESSION['userLog'])) {
                            ?> 
                            <li><a href="logout.php">Déconnexion</a></li> 

                        <?php } else {
                            ?>
                            <!-- Dropdown Structure -->
                            <li class="<?= isset($EspCPageTrue) ? $EspCPageTrue : '' ?>">
                                <a class="dropdown-trigger" href="#!" data-target="dropdown1">Espace Client
                                    <i class="material-icons right">arrow_drop_down</i>
                                </a>
                            </li>

                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </nav>
        </div>

        <ul id="dropdown1" class="dropdown-content">
            <li><a class="waves-effect waves-light" href="register.php">Inscription</a></li>
            <li class="divider"></li>
            <li><a class="waves-effect waves-light" href="login.php">Connexion</a></li>
        </ul>  

        <ul id="mobile-demo" class="sidenav">          
            <li><a class="subheader"><img  id="logonavmob" src="../assets/img/logo.png">Wellness Reiki</a></li>
            <li><div class="divider"></div></li>
            <li><a href="../index.php"><i class="material-icons">home</i>Accueil</a></li>
            <li><a href="product.php?productCategory_id=1"><i class="material-icons">shopping_basket</i>Produits</a></li>
            <li><a href="learnmore.php"><i class="material-icons">lightbulb</i>Plus d'Info</a></li>
            <?php if (isset($_SESSION['userLog'])) { ?> 
                <li><a href="userPage.php"><i class="material-icons">spa</i>Mon Espace</a></li>
                <?php
            }
            if (isset($_SESSION['isAdmin'])) {
                ?>   
                <li><a href="AdminPage.php"><i class="material-icons">dashboard</i>Panel Admin</a></li>
                <?php
            }
            ?> 
            <li><div class="divider"></div></li>
            <li><a class="subheader">Espace personnel</a></li>
            <li><div class="divider"></div></li>
            <?php
            if (isset($_SESSION['userLog'])) {
                ?> 
                <li><a class="waves-effect" href="logout.php"><i class="material-icons">close</i> Déconnexion</a></li>

            <?php } else {
                ?>
                <li><a class="waves-effect" href="register.php"><i class="material-icons">add</i> Inscription</a></li>
                <li><a class="waves-effect" href="login.php"><i class="material-icons">input</i> Connexion</a></li>
                    <?php
                }
                ?>  
        </ul>        
        <!--end navbar-->
    </header>