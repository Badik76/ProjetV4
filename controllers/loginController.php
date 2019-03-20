<!--controller login-->
<?php
require_once '../models/database.php';
require_once '../models/users.php';

// On instancie un nouvel $users objet comme classe patients
$users = new octopus_users();

//déclaration des regexs   
$regexEmail = '/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,6}$/'; // regex date au format yyyy-mm-dd
$regexPassword = "/^.{6,}+$/";

// créa tableau pour error
$errorArray = [];

//Initialise $logSuccess en False pour afficher la connexion de l'user
$logSuccess = false;
//Initialise $isSuperUser en false pour afficher superuser template.
$isSuperUser = false;
//Initialise $isSuperUser en false pour afficher superuser template.
$isAdmin = false;
$userLog = false;
$logError = false;
$EspCPageTrue = 'active';

//On test la valeur email dans l'array $_POST, si elle existe via premier if
if (isset($_POST['users_email'])) {
    $users_email = htmlspecialchars($_POST['users_email']);
    // Si le post est vide
    if (empty($users_email)) {
        // J'affiche le message d'erreur
        $errorArray['users_email'] = 'Veuillez saisir votre email pour vous connecter';
    }
}

//On test la valeur password dans l'array $_POST, si elle existe via premier if
if (isset($_POST['users_password'])) {
    $users_password = htmlspecialchars($_POST['users_password']);
    // Si le post est vide
    if (empty($users_password)) {
        // J'affiche le message d'erreur
        $errorArray['users_password'] = 'Veuillez saisir votre password';
    }
}


//vérification du password pour connexion session
if (count($errorArray) == 0 && isset($_POST['logButton'])) {
    $infoUser = $users->verifUser($users_email);
    $logSuccess = true;
    if (is_object($infoUser)) {
        if (password_verify($users_password, $infoUser->users_password)) {
            $_SESSION['users_id'] = $infoUser->users_id;
            $_SESSION['typeUsers_id'] = $infoUser->typeUsers_id;
            $_SESSION['userLog'] = true;
        }
    } else {
        session_destroy();
        $logSuccess = false;
        $logError = true;
    }
    if (isset($_SESSION['typeUsers_id'])) {
//on vérifie le type de l'user
        if ($_SESSION['typeUsers_id'] == 3) {
            $_SESSION['isUser'] = true;
        }
        //on vérifie que l'user est un superuser
        if ($_SESSION['typeUsers_id'] == 2) {
            $_SESSION['isSuperUser'] = true;
        }
//on vérifie que l'user est un admin
        if ($_SESSION['typeUsers_id'] == 1) {
            $_SESSION['isAdmin'] = true;
        }
    }
}
