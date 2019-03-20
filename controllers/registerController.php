<!--controller register-->
<?php
require_once '../models/database.php';
require_once '../models/users.php';

// On instancie un nouvel $users objet comme classe users
$users = new octopus_users();

//déclaration des regexs   
$regexName = '/^[a-zA-Zàáâãäåçèéêëìíîïðòóôõöùúûüýÿ-]+$/';
$regexBirthdate = '/^(0[1-9]|([1-2][0-9])|3[01])\/(0[1-9]|1[012])\/((19|20)[0-9]{2})$/';
$regexPhoneNumber = '/^[0-9]{10,10}$/';
$regexPassword = "/^.{6,}+$/";

// créa tableau pour error
$errorArray = [];

//Initialise $addSuccess en False pour afficher l'ajout de l'user
$addSuccess = false;
$EspCPageTrue = 'active';
//On test la valeur lastname dans l'array $_POST, si elle existe via premier if
if (isset($_POST['users_lastname'])) {
    // Variable lastname qui vérifie que les caractères speciaux soit converties en entité html via htmlspecialchars = protection
    $users->users_lastname = htmlspecialchars($_POST['users_lastname']);
    // On test que la variable n'est pas égale à la regeX
    if (!preg_match($regexName, $users->users_lastname)) {
        // je crée le message d'erreur suivant dans le tableau d'erreur
        $errorArray['users_lastname'] = 'Votre nom ne doit contenir que des lettres';
    }
    // Si le post lastname n'est pas rempli (donc vide)
    if (empty($users->users_lastname)) {
        // je crée le message d'erreur suivant dans le tableau d'erreur
        $errorArray['users_lastname'] = 'Champs obligatoire';
    }
}

//On test la valeur firstname dans l'array $_POST, si elle existe via premier if
if (isset($_POST['users_firstname'])) {
    // Variable firstname qui vérifie que les caractères speciaux soit converties en entité html via htmlspecialchars = protection
    $users->users_firstname = htmlspecialchars($_POST['users_firstname']);
    // On test que la variable n'est pas égale à la regeX
    if (!preg_match($regexName, $users->users_firstname)) {
        // J'affiche l'erreur
        $errorArray['users_firstname'] = 'Votre prénom ne doit contenir que des lettres';
    }
    // Si le post est vide
    if (empty($users->users_firstname)) {
        // J'affiche le message d'erreur
        $errorArray['users_firstname'] = 'Champs obligatoire';
    }
}

//On test la valeur phone dans l'array $_POST, si elle existe via premier if

if (isset($_POST['users_phone'])) {
    // Variable phone qui vérifie que les caractères speciaux soit converties en entité html via htmlspecialchars = protection
    $users->users_phone = htmlspecialchars($_POST['users_phone']);
    // On test que la variable n'est pas égale à la regeX
    if (!preg_match($regexPhoneNumber, $users->users_phone)) {
        // J'affiche l'erreur
        $errorArray['users_phone'] = 'Votre numéro de téléphone doit contenir 10 chiffres et doit être de type 0620300405';
    }
    // Si le post est vide
    if (empty($users->users_phone)) {
        // J'affiche le message d'erreur
        $errorArray['users_phone'] = 'Champs obligatoire';
    }
}

//On test la valeur email dans l'array $_POST, si elle existe via premier if
if (isset($_POST['users_email'])) {
    // Variable mail qui vérifie que les caractères speciaux soit converties en entité html
    $users->users_email = filter_var($_POST['users_email'], FILTER_SANITIZE_EMAIL);
    // On test que la variable n'est pas égale à la regeX
    if (!filter_var($users->users_email, FILTER_VALIDATE_EMAIL)) {
        // J'affiche l'erreur
        $errorArray['users_email'] = 'Votre mail doit être du type mail@mail.com';
    }
    // Si le post est vide
    if (empty($users->users_email)) {
        // J'affiche le message d'erreur
        $errorArray['users_email'] = 'Champs obligatoire';
    }
}

//On test la valeur password dans l'array $_POST, si elle existe via premier if
if (isset($_POST['users_password'])) {
    // Variable password qui vérifie que les caractères speciaux soit converties en entité html via password_hash = protection
    $users->users_password = ($_POST['users_password']);
    // On test que la variable n'est pas égale à la regex
    if (!preg_match($regexPassword, $users->users_password)) {
        // J'affiche l'erreur
        $errorArray['users_password'] = 'Mot de passe à 6 caractères minimum';
    } //puis vérif si vide
    if (empty($users->users_password)) {
        // J'affiche le message d'erreur
        $errorArray['users_password'] = 'Veuillez saisir un mot de passe';
    }
}

//On test la valeur confirm_password dans l'array $_POST, si elle existe via premier if
if (isset($_POST['users_confirm_password'])) {
    //puis vérif si vide
    if (empty($_POST['users_confirm_password'])) {
        // J'affiche l'erreur
        $errorArray['users_confirm_password'] = 'Veuillez saisir un mot de passe';
    }
    if ($users->users_password != $_POST['users_confirm_password']) {
        // J'affiche l'erreur
        $errorArray['users_confirm_password'] = 'Mot de passe différents';
    }
}

//on vérifie que nous avons crée une entrée submit dans l'array $_POST, si présent on éxécute la méthide addPatient()

if (count($errorArray) == 0 && isset($_POST['addButton'])) {
    $users->users_password = password_hash($_POST['users_password'], PASSWORD_DEFAULT);
    if (!$users->addUser()) {
        $errorArray['add'] = 'l\'envoie du formulaire à échoué';
    } else {
        $addSuccess = true;
    }
}