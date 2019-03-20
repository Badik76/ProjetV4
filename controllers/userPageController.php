<!--controller userPage-->
<?php
//appel du model db
require_once '../models/database.php';
//appel du model users
require_once '../models/users.php';
//appel du model daterdv
require_once '../models/daterdv.php';
//appel du model timerdv
require_once '../models/timerdv.php';
//appel du model comments
require_once '../models/comments.php';
//appel du model prestations
require_once '../models/prestations.php';

// On instancie un nouvel $users objet comme classe patients
$users = new octopus_users();
// On instancie un nouvel $daterdv objet comme classe daterdv
$daterdv = new daterdv();
// On instancie un nouvel $comments objet comme classe comments
$comments = new comments();
// On instancie un nouvel $comments objet comme classe comments
$prestations = new prestations();
// On instancie un nouvel $prestations objet comme classe $prestations
$timerdv = new timerdv();

// j'associe la valeur du $_SESSION à l'attribue users_id de l'objet $users, $daterdv, $comments
if (isset($_SESSION['users_id'])) {
    $users->users_id = $_SESSION['users_id'];
    $daterdv->users_id = $_SESSION['users_id'];
    $comments->users_id = $_SESSION['users_id'];
    /* on execute la méthode getProfilById qui va hydrater les valeurs dans patients
     * elle va également nous retourner un boolean qui nous indiquera si la requête s'est bien executée
     */
    $userIsFind = $users->getUsersById($_SESSION['users_id']);

    $rdvFind = $daterdv->getRDVByid($_SESSION['users_id']);

    $showrdv = $daterdv->showRDVbefore($_SESSION['users_id']);
}
/* on execute la méthode getRDVByidUser qui va hydrater les valeurs dans daterdv
 * elle va également nous retourner un boolean qui nous indiquera si la requête s'est bien executée
 */
$rdvidUserList = $daterdv->getRDVByidUser($_SESSION['users_id']);
// On appel la methode ShowTimeRDV dans l'objet $showTimeRDV
$showTimeRDV = $timerdv->ShowTimeRDV();

//déclaration des regexs   
$regexName = '/^[a-zA-Zàáâãäåçèéêëìíîïðòóôõöùúûüýÿ-]+$/';
$regexBirthdate = '/^(0[1-9]|([1-2][0-9])|3[01])\/(0[1-9]|1[012])\/((19|20)[0-9]{2})$/'; // regex date au format yyyy-mm-dd
//Création des regex pour controler les données du formulaire
$regexDate = '/^(0[1-9]|([1-2][0-9])|3[01])\/(0[1-9]|1[012])\/((19|20)[0-9]{2})$/';
$regexPhoneNumber = '/^[0-9]{10,10}$/';
$regexPassword = "/^.{6,}+$/";
$regexDescri = '/^[A-zÄ-ẑ\'\- \. \ 0-9]{1,}$/';
// créa tableau pour error
$errorArray = [];
$userPageTrue = 'active';
//Initialise $addSuccess en False pour afficher message
$addSuccess = false;
//Initialise $HadAppointments en False pour afficher message
$noRDV = false;
//Initialise $daterdvDEL en False pour afficher message
$daterdvDEL = false;
/* on crée un variable $deleteOk qu'on initialise à false
 * cette variable va nous permettre d'afficher un message lors de la suppression d'un patient
 */
$deleteOk = false;
//Initialise $isSuperUser en false pour afficher superuser template.
$isSuperUser = false;
$rdvalide = false;
$addCommentSuccess = false;
$upRDVSuccess = false;
//on vérifie que le rdv est validé 
if ($daterdv->dateRDV_validate == 1) {
    $rdvalide = true;
}
/* on test que $_GET['deleteThis'] n'est pas vide
 * si non vide, on attribue à $patients id la valeur du get avec un htmlspecialchars pour la protection
 * et on applique la methode deletePatientAndAppointmentsById pour effacer le patient
 */
if (!empty($_GET['deleteThis'])) {
    $users->users_id = htmlspecialchars($_GET['deleteThis']);
    $users->deleteUser();
    $deleteOk = true;
    session_unset();
}
//On test la valeur lastname dans l'array $_POST, si elle existe via premier if
if (isset($_POST['users_lastname'])) {
    // Variable lastname qui vérifie que les caractères speciaux soit converties en entité html via htmlspecialchars = protection
    $users_lastname = htmlspecialchars($_POST['users_lastname']);
    // On test que la variable n'est pas égale à la regeX
    if (!preg_match($regexName, $users_lastname)) {
        // je crée le message d'erreur suivant dans le tableau d'erreur
        $errorArray['users_lastname'] = 'Votre nom ne doit contenir que des lettres';
    }
    // Si le post lastname n'est pas rempli (donc vide)
    if (empty($users_lastname)) {
        // je crée le message d'erreur suivant dans le tableau d'erreur
        $errorArray['users_lastname'] = 'Champs obligatoire';
    }
}
//On test la valeur firstname dans l'array $_POST, si elle existe via premier if
if (isset($_POST['users_firstname'])) {
    // Variable firstname qui vérifie que les caractères speciaux soit converties en entité html via htmlspecialchars = protection
    $users_firstname = htmlspecialchars($_POST['users_firstname']);
    // On test que la variable n'est pas égale à la regeX
    if (!preg_match($regexName, $users_firstname)) {
        // J'affiche l'erreur
        $errorArray['users_firstname'] = 'Votre prénom ne doit contenir que des lettres';
    }
    // Si le post est vide
    if (empty($users_firstname)) {
        // J'affiche le message d'erreur
        $errorArray['users_firstname'] = 'Champs obligatoire';
    }
}
//On test la valeur birthdate dans l'array $_POST, si elle existe via premier if
if (isset($_POST['users_birthdate'])) {
    // Variable birthdate qui vérifie que les caractères speciaux soit converties en entité html via htmlspecialchars = protection
    $users_birthdate = $_POST['users_birthdate'];
    // On test que la variable n'est pas égale à la regeX
    if (!preg_match($regexBirthdate, $users_birthdate)) {
        // J'affiche l'erreur
        $errorArray['users_birthdate'] = 'Votre date de naissance doit être de type 30/10/1985';
    }
}
//On test la valeur phone dans l'array $_POST, si elle existe via premier if
if (isset($_POST['users_phone'])) {
    // Variable phone qui vérifie que les caractères speciaux soit converties en entité html via htmlspecialchars = protection
    $users_phone = htmlspecialchars($_POST['users_phone']);
    // On test que la variable n'est pas égale à la regeX
    if (!preg_match($regexPhoneNumber, $users_phone)) {
        // J'affiche l'erreur
        $errorArray['users_phone'] = 'Votre numéro de téléphone doit contenir 10 chiffres et doit être de type 0620300405';
    }
    // Si le post est vide
    if (empty($users_phone)) {
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

//on vérifie que nous avons crée une entrée submit dans l'array $_POST, si présent on éxécute la méthide updateUserById()
if (count($errorArray) == 0 && isset($_POST['updateButton'])) {
    if (!$users->updateUserById()) {
        $errorArray['update'] = 'La mise à jour à échoué';
    } else {
        $addSuccess = true;
        header('http://proprojetpro/views/userPage.php');
    }
}
//commentaires
//ADD - On test la valeur name dans l'array $_POST, si elle existe via premier if
if (isset($_POST['comments_comment'])) {
    // Variable lastname qui vérifie que les caractères speciaux soit converties en entité html via htmlspecialchars = protection
    $comments->comments_comment = htmlspecialchars($_POST['comments_comment']);
    // On test que la variable n'est pas égale à la regeX
    if (!preg_match($regexDescri, $comments->comments_comment)) {
        // je crée le message d'erreur suivant dans le tableau d'erreur
        $errorArray['comments_comment'] = 'Votre commentaire est invalide';
    }
    // Si le post lastname n'est pas rempli (donc vide)
    if (empty($comments->comments_comment)) {
        // je crée le message d'erreur suivant dans le tableau d'erreur
        $errorArray['comments_comment'] = 'Champs obligatoire';
    }
}
if (count($errorArray) == 0 && isset($_POST['addComment']) && isset($_GET['addComment'])) {
    $comments->dateRDV_id = htmlspecialchars($_GET['addComment']);
    $comments->users_id = $_SESSION['users_id'];
    if (!$comments->addComment()) {
        $errorArray['add'] = 'l\'envoie du commentaire à échoué';
    } else {
        $addCommentSuccess = true;
        $daterdv->putRDVarchivate($_GET['addComment']);
        header('http://proprojetpro/views/userPage.php');
    }
}

//Update RDV
//On test la valeur date l'array $_POST pour savoir si elle existe
//Si ok, nous testons la valeur
if (isset($_POST['dateRDV_dateRDV'])) {
    // si ne correspond pas à la regex, on crée un message d'erreur personnalisé dans $errorArray
    if (!preg_match($regexDate, $_POST['dateRDV_dateRDV'])) {
        // je crée le message d'erreur suivant dans le tableau d'erreur
        $errorArray['dateRDV_dateRDV'] = 'La date doit être au format 30/10/1985';
    }
    // si vide, on crée un message d'erreur personnalisé dans $formError
    if (empty($_POST['dateRDV_dateRDV'])) {
        // je crée le message d'erreur suivant dans le tableau d'erreur
        $errorArray['dateRDV_dateRDV'] = '*Champs date obligatoire';
    }
    if (strtotime('today') < strtotime($_POST['dateRDV_dateRDV'])) {
        $errorArray['dateRDV_dateRDV'] = 'La date est invalide.';
    }
}

//On test la valeur idTimeRDV l'array $_POST pour savoir si elle existe
//Si nous attribuons à idTimeRDV la valeur du $_POST
if (isset($_POST['timeRDV_id'])) {
    // OU si le formulaire a été validé mais que il n'y a pas d'élément sélectionné dans le menu déroulant
    // on crée un message d'erreur pour pouvoir l'afficher
    if (empty($_POST['timeRDV_id'])) {
        // je crée le message d'erreur suivant dans le tableau d'erreur
        $errorArray['timeRDV_id'] = '*Champs date obligatoire';
    }
}

if (count($errorArray) == 0 && isset($_GET['dateRDV_id']) && isset($_POST['updateRDVButton'])) {
    $daterdv->dateRDV_id = $_GET['dateRDV_id'];
    $daterdv->timeRDV_id = $_POST['timeRDV_id'];
    $date = DateTime::createFromFormat('d/m/Y', $_POST['dateRDV_dateRDV']);
    $dateUs = $date->format('Y-m-d');
    $daterdv->dateRDV_dateRDV = $dateUs;
    if (!$daterdv->updaterdv($daterdv->dateRDV_id, $daterdv->dateRDV_dateRDV, $daterdv->timeRDV_id)) {
        $errorArray['update'] = 'La mise à jour à échoué';
    } else {
        $upRDVSuccess = true;
        header('http://proprojetpro/views/userPage.php');
    }
}

/* on test que $_GET['DeleteCatProd'] n'est pas vide
 * si non vide, on attribue à $productcategory id la valeur du get avec un htmlspecialchars pour la protection
 * et on applique la methode deleteCatProd pour del la productcategory
 */
if (!empty($_GET['DeleteRDV'])) {
    $daterdv->users_id = $_SESSION['users_id'];
    $daterdv->deleteRDVbyID();
    $daterdvDEL = true;
    header('http://proprojetpro/views/userPage.php');
}

//on compte l'array $appointmentsList pour savoir s'il est vide, si vide on donne la valeur true à $NoAppointment
if (count($rdvidUserList) == 0) {
    $noRDV = true;
}