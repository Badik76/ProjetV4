
<!--controller login-->
<?php
require_once '../models/database.php';
require_once '../models/users.php';
require_once '../models/daterdv.php';
require_once '../models/comments.php';

// On instancie un nouvel $users objet comme classe patients
$users = new octopus_users();
// On instancie un nouvel $daterdv objet comme classe daterdv
$daterdv = new daterdv();
// On instancie un nouvel $comments objet comme classe comments
$comments = new comments();

// j'attribue la valeur du valeur $_GET à l'attribue id de l'objet $users et l'attribue idUser de l'objet $daterdv
if (isset($_GET['users_id'])) {
    $users->users_id = $_GET['users_id'];
    $daterdv->users_id = $_GET['users_id'];
    $comments->users_id = $_GET['users_id'];
};
/* on execute la méthode getProfilById qui va hydrater les valeurs dans patients
 * elle va également nous retourner un boolean qui nous indiquera si la requête s'est bien executée
 */
$userIsFind = $users->getUsersById();

/* on execute la méthode getRDVByidUser qui va hydrater les valeurs dans daterdv
 * elle va également nous retourner un boolean qui nous indiquera si la requête s'est bien executée
 */

$rdvidUserList = $daterdv->getRDVByidUser();
$rdvFind = $daterdv->getRDVByid();



//déclaration des regexs   
$regexName = '/^[a-zA-Zàáâãäåçèéêëìíîïðòóôõöùúûüýÿ-]+$/';
$regexBirthdate = '/^(0[1-9]|([1-2][0-9])|3[01])\/(0[1-9]|1[012])\/((19|20)[0-9]{2})$/';// regex date au format yyyy-mm-dd
$regexEmail = '/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,6}$/'; 
$regexPhoneNumber = '/^[0-9]{10,10}$/';
$regexPassword = "/^.{6,}+$/";

// créa tableau pour error
$errorArray = [];

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
//Initialise $idSU en false pour afficher icone superuser.
$idSU = false;
$rdvalide = false;
$addCommentSuccess = false;


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
}
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

//On test la valeur birthdate dans l'array $_POST, si elle existe via premier if
if (isset($_POST['users_birthdate'])) {
    // Variable birthdate qui vérifie que les caractères speciaux soit converties en entité html via htmlspecialchars = protection
    $users->users_birthdate = $_POST['users_birthdate'];
    // On test que la variable n'est pas égale à la regeX
    if (!preg_match($regexBirthdate, $users->users_birthdate)) {
        // J'affiche l'erreur
        $errorArray['users_birthdate'] = 'Votre date de naissance doit être de type 30/10/1985';
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
    $users->users_email = $_POST['users_email'];
    // On test que la variable n'est pas égale à la regeX
    if (!preg_match($regexEmail, $users->users_email)) {
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
    }
}


//commentaires
//ADD - On test la valeur name dans l'array $_POST, si elle existe via premier if
if (isset($_POST['comments_comment'])) {
    // Variable lastname qui vérifie que les caractères speciaux soit converties en entité html via htmlspecialchars = protection
    $comments->comments_comment = htmlspecialchars($_POST['comments_comment']);
    // On test que la variable n'est pas égale à la regeX
    if (!preg_match($regexName, $comments->comments_comment)) {
        // je crée le message d'erreur suivant dans le tableau d'erreur
        $errorArray['comments_comment'] = 'Votre nom ne doit contenir que des lettres';
    }
    // Si le post lastname n'est pas rempli (donc vide)
    if (empty($comments->comments_comment)) {
        // je crée le message d'erreur suivant dans le tableau d'erreur
        $errorArray['comments_comment'] = 'Champs obligatoire';
    }
}
if (count($errorArray) == 0 && isset($_POST['addComment'])) {
    $comments->dateRDV_id = $daterdv ->dateRDV_id ;
    if (!$comments->addComment()) {
        $errorArray['add'] = 'l\'envoie du formulaire à échoué';
    } else {
        $addCommentSuccess = true;
    }
}
//on vérifie que l'user est un superuser

if ($users->typeUsers_id == 2) {
    $idSU = true;
}

/* on test que $_GET['DeleteCatProd'] n'est pas vide
 * si non vide, on attribue à $productcategory id la valeur du get avec un htmlspecialchars pour la protection
 * et on applique la methode deleteCatProd pour del la productcategory
 */
if (!empty($_GET['DeleteRDV'])) {
    $daterdv->users_id = htmlspecialchars($_GET['DeleteRDV']);
    $daterdv->deleteRDVbyID();
    $daterdvDEL = true;
}

//on compte l'array $appointmentsList pour savoir s'il est vide, si vide on donne la valeur true à $NoAppointment
if (count($rdvidUserList) == 0){
    $noRDV = true;
}
?>