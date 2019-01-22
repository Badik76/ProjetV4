<!--controller register-->
<?php
require_once '../models/database.php';
require_once '../models/users.php';
require_once '../models/prestations.php';
require_once '../models/timerdv.php';
require_once '../models/productcategory.php';

// On instancie un nouvel $users objet comme classe users
$users = new users();
// On instancie un nouvel $prestations objet comme classe prestations
$prestations = new prestations();
// On instancie un nouvel $timerdv objet comme classe timerdv
$timerdv = new timerdv();
// On instancie un nouvel $productcategory objet comme classe productcategory
$productcategory = new productcategory();

// On appel la methode getAppointmentsList dans l'objet $listAppointments
$listPrestations = $prestations->getPrestationsList();
// On appel la methode ShowTimeRDV dans l'objet $showTimeRDV
$showTimeRDV = $timerdv->ShowTimeRDV();
// On appel la methode showCatProd dans l'objet $showCatProd
$showCatProd = $productcategory->showCatProd();


//déclaration des regexs   
$regexName = '/^[a-zA-Zàáâãäåçèéêëìíîïðòóôõöùúûüýÿ-]+$/';

// créa tableau pour error
$errorArray = [];

//Initialise $superUserOK et $superUserDEL en False pour afficher la modification et la suppression en superuser
$superUserOK = false;
$superUserDEL = false;
//Initialise $productcategoryDEL, $addCatSuccess et $upCatSuccess en False pour afficher l'ajout, la modification et la suppression d'une category de produit
$addCatSuccess = false;
$productcategoryDEL = false;
$upCatSuccess  = false;
/**
 * On créer $$openCollapsible en False pour Afficher le collpase au moment du clic sur Pagination
 */
$openCollapsible = false;
/* on crée une variable $noMatch qu'on initialise à false,  
 * on se servira de cette variable pour afficher un message si nous ne trouvons pas de correspondance lors de la recherche
 */
$noMatch = false;
/* on crée un variable $deleteOk qu'on initialise à false
 * cette variable va nous permettre d'afficher un message lors de la suppression d'un patient
 */
$deleteOk = false;


// on crée les variables page, limit et start pour définir la page sur laquelle nous nous trouvons, la limite de patients à afficher et à partir de quelle ligne.
$page = (!empty($_GET['page']) ? htmlspecialchars($_GET['page']) : 1); // on utilise une ternaire pour définir la valeur de page
$limit = 5; // on souhaite afficher 5 patients par page
$start = ($page - 1) * $limit; // on définit la valeur de $start via un simple calcul
// on definit le nombre de page via la fonction ceil qui arrondit à l'entier supérieur
$totalArray = $users->GetNumberTotalRows();
$total = $totalArray->totalRows;
$pagesMax = ceil($total / $limit);
/* on test que $_GET['deleteThis'] n'est pas vide
 * si non vide, on attribue à $patients id la valeur du get avec un htmlspecialchars pour la protection
 * et on applique la methode deletePatientAndAppointmentsById pour effacer le patient
 */
if (!empty($_GET['deleteThis'])) {
    $users->id = htmlspecialchars($_GET['deleteThis']);
    $users->deleteUser();
    $deleteOk = true;
}
/* on test que $_GET['search'] et qu'il n'est pas vide
 * si ok, on crée un tableau avec la methode findPatientsBySearch avec comme paramètre $_GET['search']
 * on fait un si imbrique pour tester si le tableau est vide via un count, si vide crée un message d'erreur pour $noMatchMessage
 */
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $listUsers = $users->findUsersBySearch(htmlspecialchars($_GET['search']));
    if (count($listUsers) == 0) {
        $noMatch = true;
        $noMatchMessage = 'Nous ne trouvons aucune correspondance pour : ' . $_GET['search'];
    }
} else {
    // sinon on crée la tableau à l'aide de la méthode GetSomePatients
    $listUsers = $users->GetSomeUsers($start, $limit);
}

/* on test que $_GET['GetUserSuperUser'] n'est pas vide
 * si non vide, on attribue à $users id la valeur du get avec un htmlspecialchars pour la protection
 * et on applique la methode putUserSuperUser pour upper l'user
 */
if (!empty($_GET['GetUserSuperUser'])) {
    $users->id = htmlspecialchars($_GET['GetUserSuperUser']);
    $users->putUserSuperUser();
    $superUserOK = true;
}
/* on test que $_GET['DelSuperUser'] n'est pas vide
 * si non vide, on attribue à $users id la valeur du get avec un htmlspecialchars pour la protection
 * et on applique la methode delSuperUser pour deupper l'user
 */
if (!empty($_GET['DelSuperUser'])) {
    $users->id = htmlspecialchars($_GET['DelSuperUser']);
    $users->delSuperUser();
    $superUserDEL = true;
}


//On test la valeur idTimeRDV l'array $_POST pour savoir si elle existe
//Si nous attribuons à idTimeRDV la valeur du $_POST
if (isset($_POST['idTimeRDV'])) {
    $timerdv->id = $_POST['idTimeRDV'];
    // OU si le formulaire a été validé mais que il n'y a pas d'élément sélectionné dans le menu déroulant
    // on crée un message d'erreur pour pouvoir l'afficher
    if (is_nan($timerdv->id)) {
        $errorArray['idTimeRDV'] = '*Veuillez sélectionner uniquement une heure de la liste';
    }
} else if (isset($_POST['addButton']) && !array_key_exists('idTimeRDV', $_POST)) {
    $errorArray['idTimeRDV'] = '*Veuillez sélectionner une heure';
}
//CatégoryProduct
//ADD - On test la valeur name dans l'array $_POST, si elle existe via premier if
if (isset($_POST['name'])) {
    // Variable lastname qui vérifie que les caractères speciaux soit converties en entité html via htmlspecialchars = protection
    $productcategory->name = htmlspecialchars($_POST['name']);
    // On test que la variable n'est pas égale à la regeX
    if (!preg_match($regexName, $productcategory->name)) {
        // je crée le message d'erreur suivant dans le tableau d'erreur
        $errorArray['name'] = 'Votre nom ne doit contenir que des lettres';
    }
    // Si le post lastname n'est pas rempli (donc vide)
    if (empty($productcategory->name)) {
        // je crée le message d'erreur suivant dans le tableau d'erreur
        $errorArray['name'] = 'Champs obligatoire';
    }
}

if (count($errorArray) == 0 && isset($_POST['addCatProd'])) {
    if (!$productcategory->addCatProd()) {
        $errorArray['add'] = 'l\'envoie du formulaire à échoué';
    } else {
        $addCatSuccess = true;
    }
}

//on vérifie que nous avons crée une entrée submit dans l'array $_POST, si présent on éxécute la méthide updateUserById()

if (count($errorArray) == 0 && isset($_POST['updateCatButton'])) {
    if (!$productcategory->updateCatProdById()) {
        $errorArray['update'] = 'La mise à jour à échoué';
    } else {
        $upCatSuccess = true;
    }
}
/* on test que $_GET['DeleteCatProd'] n'est pas vide
 * si non vide, on attribue à $productcategory id la valeur du get avec un htmlspecialchars pour la protection
 * et on applique la methode deleteCatProd pour del la productcategory
 */
if (!empty($_GET['DeleteCatProd'])) {
    $productcategory->id = htmlspecialchars($_GET['DeleteCatProd']);
    $productcategory->deleteCatProd();
    $productcategoryDEL = true;
}

?>