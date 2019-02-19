<!--controller register-->
<?php
require_once 'models/database.php';
require_once 'models/users.php';
require_once 'models/prestations.php';
require_once 'models/timerdv.php';
require_once 'models/daterdv.php';
require_once 'models/comments.php';

// On instancie un nouvel $prestations objet comme classe $prestations
$prestations = new prestations();
// On instancie un nouvel $prestations objet comme classe $prestations
$daterdv = new daterdv();
// On instancie un nouvel $prestations objet comme classe $prestations
$timerdv = new timerdv();
// On instancie un nouvel $prestations objet comme classe $prestations
$users = new octopus_users();
// On instancie un nouvel $prestations objet comme classe $prestations
$comments = new comments();

// On appel la methode getAppointmentsList dans l'objet $listAppointments
$listPrestations = $prestations->getPrestationsList();
// On appel la methode ShowTimeRDV dans l'objet $showTimeRDV
$showTimeRDV = $timerdv->ShowTimeRDV();
// On appel la methode showRDV dans l'objet $resultList
$resultList = $daterdv->showRDV();
// On appel la methode GetSomeUsers dans l'objet $listUsers
$listUsers = $users->getUsersList();
// On appel la methode GetSomeUsers dans l'objet $listUsers
$commentsList = $comments->showComment();

//Initialise $addRDVSuccess en False pour afficher l'ajout de rdv
$addRDVSuccess = false;

//Création des regex pour controler les données du formulaire
$regexDate = '/^(0[1-9]|([1-2][0-9])|3[01])\/(0[1-9]|1[012])\/((19|20)[0-9]{2})$/';
// créa tableau pour error
$errorArray = [];

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
}

//On test la valeur idTimeRDV l'array $_POST pour savoir si elle existe
//Si nous attribuons à idTimeRDV la valeur du $_POST
if (isset($_POST['timeRDV_id'])) {
    $timerdv->timeRDV_id = $_POST['timeRDV_id'];
    // OU si le formulaire a été validé mais que il n'y a pas d'élément sélectionné dans le menu déroulant
    // on crée un message d'erreur pour pouvoir l'afficher
    if (is_nan($timerdv->timeRDV_id)) {
        $errorArray['timeRDV_id'] = '*Veuillez sélectionner uniquement une heure de la liste';
    }
} else if (isset($_POST['addButton']) && !array_key_exists('timeRDV_id', $_POST)) {
    $errorArray['timeRDV_id'] = '*Veuillez sélectionner une heure';
}

// On compte le nombre de valeur dans $formError et On vérifie que nous avons crée une entrée addButton dans l'array $_POST,
// Si tout est réuni :
// On formate la date en dateUS
// On concatène les valeurs de date et de hour, puis on éxécute la méthode addAppointment()
if (count($errorArray) == 0 && isset($_POST['addButton']) && isset($_GET['prestations_id'])) {
    $daterdv->prestations_id = $_GET['prestations_id'];
    $date = DateTime::createFromFormat('d/m/Y', $_POST['dateRDV_dateRDV']);
    $dateUs = $date->format('Y-m-d');
    $daterdv->dateRDV_dateRDV = $dateUs;
    $daterdv->timeRDV_id = $_POST['timeRDV_id'];
    $daterdv->users_id = $_SESSION['users_id'];
    if (!$daterdv->addRDV()) {
        $errorArray['add'] = 'l\'enregistrement a échoué';
    } else {
        // sinon, on execute notre requête pour enregistrer le RDV
        $addRDVSuccess = true;
    }
}
