<?php

/* On crée une class users qui hérite de la classe database via extends
 * La classe users va nous permettre d'accéder à la table users
 */

class octopus_users extends database {

    // Création d'attributs qui correspondent à chacun des champs de la table users

    public $users_id;
    public $users_lastname;
    public $users_firstname;
    public $users_phone;
    public $users_email;
    public $users_password;
    public $users_birthdate;
    public $typeUsers_id;

    // on crée une methode magique __construct()
    public function __construct() {
        // On appelle le __construct() du parent via "parent::""
        parent::__construct();
    }

    /**
     * On crée une methode qui insert un user dans la table users
     * @return type EXECUTE
     */
    public function addUser() {
        // Insertion des données du patient à l'aide d'une requête préparée avec un INSERT INTO et le nom des champs de la table
        // Insertion des valeurs des variables via les marqueurs nominatifs, ex :lastname).
        $query = 'INSERT INTO `octopus_users`'
                . '(`users_lastname`, `users_firstname`, `users_phone`, `users_email`, `users_password`)'
                . 'VALUES (:users_lastname, :users_firstname, :users_phone, :users_email, :users_password)';
        $addUser = $this->dataBase->prepare($query);
        // on attribue les valeurs via bindValue et on recupère les attributs de la classe via $this
        $addUser->bindValue(':users_lastname', $this->users_lastname, PDO::PARAM_STR);
        $addUser->bindValue(':users_firstname', $this->users_firstname, PDO::PARAM_STR);
        $addUser->bindValue(':users_phone', $this->users_phone, PDO::PARAM_STR);
        $addUser->bindValue(':users_email', $this->users_email, PDO::PARAM_STR);
        $addUser->bindValue(':users_password', $this->users_password, PDO::PARAM_STR);
        // on utilise la méthode execute() via un return
        return $addUser->execute();
    }

    /**
     * On crée un methode qui retourne la liste des users de la table users
     * @return type ARRAY
     */
    public function getUsersList() {
        // On met notre requète dans la variable $query qui selectionne tous les champs de la table users
        $query = 'SELECT `users_id`, `users_lastname`, `users_firstname`, '
                . '`users_phone`, `users_email` '
                . 'FROM `octopus_users` ORDER BY `users_lastname`';
        // On crée un objet $result qui exécute la méthode query() avec comme paramètre $query
        $result = $this->dataBase->query($query);
        // On crée un objet $resultList qui est un tableau.
        // La fonction fetchAll permet d'afficher toutes les données de la requète dans un tableau d'objet via le paramètre (PDO::FETCH_OBJ)
        $resultList = $result->fetchAll(PDO::FETCH_OBJ);
        // On retourne le resultat
        return $resultList;
    }

    /**
     * On crée un methode qui retourne la liste des users de la table users
     * @return type ARRAY
     */
    public function getUserById($users_id) {    
        $req = $this->dataBase->prepare('SELECT * FROM octopus_users WHERE users_id = ?');
        $req->execute([$users_id]);
        $user = false;
        if($req->rowCount() > 0) {
            $user = $req->fetch(PDO::FETCH_OBJ);
        }
        return $user;
    }

    /**
     * On crée un methode qui retourne un tableau qui contient les informations d'un user selon l'id de la table users
     * @return BOOLEAN
     */
    public function getUsersById() {
        $isCorrect = false;
        // On met notre requète dans la variable $query qui selectionne tous les champs de la table users l'id est egal à :id via marqueur nominatif sur id
        $query = 'SELECT `users_id`, `users_lastname`, `users_firstname`,'
                . 'DATE_FORMAT(`users_birthdate`, "%d/%m/%Y") AS `users_birthdate`,'
                . '`users_phone`, `users_email`, `typeUsers_id` '
                . 'FROM `octopus_users`'
                . 'WHERE `users_id` = :users_id';
        // On crée un objet $findProfil qui utilise la fonction prepare avec comme paramètre $query        
        $findProfil = $this->dataBase->prepare($query);
        // on attribue la valeur via bindValue et on recupère les attributs de la classe via $this
        $findProfil->bindValue(':users_id', $this->users_id, PDO::PARAM_INT);
        if ($findProfil->execute()) {
            $profil = $findProfil->fetch(PDO::FETCH_OBJ);
            // if imbriqué pour hydrater les valeurs
            // si $profil est un objet(existe dans la table), on attribue directement les valeurs de l'objet $profil
            if (is_object($profil)) {
                $this->users_lastname = $profil->users_lastname;
                $this->users_firstname = $profil->users_firstname;
                $this->users_birthdate = $profil->users_birthdate;
                $this->users_phone = $profil->users_phone;
                $this->users_email = $profil->users_email;
                $this->typeUsers_id = $profil->typeUsers_id;
                $isCorrect = true;
            }
        }
        return $isCorrect;
    }

    /**
     * On crée un methode met à jour les informations d'un user selon l'id de la table users
     * @return BOOLEAN
     */
    public function updateUserById() {
        // MAJ des données de user à l'aide d'une requête préparée avec un UPDATE et le nom des champs de la table
        // Insertion des valeurs des variables via les marqueurs nominatifs, ex :lastname).
//        $query = 'UPDATE `octopus_users` '
//                . 'SET `users_lastname` = :users_lastname,'
//                . ' `users_firstname` = :users_firstname,'
//                . ' `users_phone` = :users_phone,'
//                . ' `users_email` = :users_email,'
//                . ' `users_birthdate` = :users_birthdate'
//                . ' WHERE `users_id` = :users_id';
//        $updateUser = $this->dataBase->prepare($query);
//        // on attribue les valeurs via bindValue et on recupère les attributs de la classe via $this
//        $updateUser->bindValue(':users_lastname', $_POST['users_lastname'], PDO::PARAM_STR);
//        $updateUser->bindValue(':users_firstname', $_POST['users_firstname'], PDO::PARAM_STR);
//        $updateUser->bindValue(':users_phone', $_POST['users_phone'], PDO::PARAM_STR);
//        $updateUser->bindValue(':users_email', $_POST['users_email'], PDO::PARAM_STR);
//        $updateUser->bindValue(':users_birthdate', $_POST['users_birthdate'], PDO::PARAM_STR);
//        $updateUser->bindValue(':users_id', $this->users_id, PDO::PARAM_STR);
//        // on utilise la méthode execute() via un return
//        return $updateUser->execute();
        
    $date = DateTime::createFromFormat('d/m/Y', $_POST['users_birthdate']);
    $dateUs = $date->format('Y-m-d');
        $req = $this->dataBase->prepare('UPDATE octopus_users SET users_lastname = ?, users_firstname = ?, users_phone = ?, users_email = ?, users_birthdate = ? WHERE users_id = ?');
        return $req->execute([$_POST['users_lastname'], $_POST['users_firstname'], $_POST['users_phone'], $_POST['users_email'], $dateUs, $_SESSION['users_id']]);
    }

    /**
     * On crée un methode qui supprime une ligne de la table ainsi que les lignes de la table appointments associée
     * Contrôle de la QUERY via un commit et rollback
     * @return EXECUTE QUERY
     */
    public function deleteUser() {
        // on met en place les attributs du PDO $dataBase avec ATTR_ERRMODE et ERRMODE_EXCEPTION pour genérer des message en cas d'erreur
        $this->dataBase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $this->dataBase->beginTransaction();
            // On crée notre requête pour effacer le user
            $deleteUserQuery = 'DELETE FROM `octopus_users` WHERE `users_id` = :users_id';
            // on prépare la requete avec un marqueur nominatif qui récuperera la valeur de l'id  
            $deleteUser = $this->dataBase->prepare($deleteUserQuery);
            $deleteUser->bindValue(':users_id', $this->users_id, PDO::PARAM_INT);
            // on execute la requete pour effacer le user
            $deleteUser->execute();
            // si tout s'est bien déroule on valide la transaction via un commit
            $this->dataBase->commit();
        } catch (Exception $errorMessage) { // en cas d'erreur on stock le message dans $errorMessage
            // Si erreur, on annule la transaction via un rollback
            $this->dataBase->rollback();
            echo 'Erreur : ' . $errorMessage->getMessage(); // On affiche le message d'erreur avec la methode getMessage
        }
    }

    /**
     * On crée un methode qui va effectuer une recherche de users dans la table users
     * @return ARRAY
     */
    public function findUsersBySearch($search) {
        // On met notre requète dans la variable $query qui selectionne tous les champs de la table users
        // On utilise un LIKE qui nous permettra d'afficher la liste selon un critère non précis
        $query = 'SELECT `users_id`, `users_lastname`, `users_firstname`,'
                . 'DATE_FORMAT(`users_birthdate`, "%d/%m/%Y") AS `users_birthdate`,'
                . '`users_phone`, `users_email`, `typeUsers_id`'
                . 'FROM `octopus_users`'
                . 'WHERE `users_lastname` LIKE :search'
                . 'ORDER BY `users_lastname`';
        // On crée un objet $result qui exécute la méthode query() avec comme paramètre $query
        $result = $this->dataBase->prepare($query);
        // nous attribuons au marqueur nominatif search la valeur de $search
        $result->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $result->execute();
        // On crée un objet $resultList qui est un tableau.
        // La fonction fetchAll permet d'afficher toutes les données de la requète dans un tableau d'objet via le paramètre (PDO::FETCH_OBJ)
        $resultList = $result->fetchAll(PDO::FETCH_OBJ);
        // On retourne le resultat
        return $resultList;
    }

    /**
     * On crée un methode qui va effectuer une recherche d'users dans la table users selon un début et une limite
     * @return ARRAY
     */
    // Création d'une function GetSomeUsers avec 2 paramètres de fonction $debut et $limit
    public function GetSomeUsers($start, $limit) {
        // On met notre requète dans la variable $query qui selectionne tous les champs de la table users
        // On utilise LIMIT et OFFSET qui nous permettra d'afficher la liste via une pagination
        $query = 'SELECT `users_id`, `users_lastname`, `users_firstname`,'
                . 'DATE_FORMAT(`users_birthdate`, "%d/%m/%Y") AS `users_birthdate`,'
                . '`users_phone`, `users_email`, `typeUsers_id`'
                . 'FROM `octopus_users`'
                . 'ORDER BY `users_lastname`'
                . 'LIMIT :limit OFFSET :start';
        // On crée un objet $result qui exécute la méthode query() avec comme paramètre $query
        $result = $this->dataBase->prepare($query);
        // nous attribuons au marqueur nominatif limit et start leurs valeurs respectifs via les paramètres de fonction
        $result->bindValue(':start', $start, PDO::PARAM_INT);
        $result->bindValue(':limit', $limit, PDO::PARAM_INT);
        $result->execute();
        // On crée un objet $resultList qui est un tableau.
        // La fonction fetchAll permet d'afficher toutes les données de la requète dans un tableau d'objet via le paramètre (PDO::FETCH_OBJ)
        $resultList = $result->fetchAll(PDO::FETCH_OBJ);
        // On retourne le resultat
        return $resultList;
    }

    /**
     * On crée un methode qui va calculer le nombre de ligne de la table users
     * @return ARRAY contenant la valeur du nombre de ligne dans le champ totalRows
     */
    public function GetNumberTotalRows() {
        // on crée un requête pour calculer le nombre total de ligne de la table users
        $query = 'SELECT COUNT(`users_id`) AS `totalRows` FROM `octopus_users`';
        $totalRows = $this->dataBase->query($query);
        $result = $totalRows->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function putUserSuperUser() {
        // Insertion des données du patient à l'aide d'une requête préparée avec un INSERT INTO et le nom des champs de la table
        // Insertion des valeurs des variables via les marqueurs nominatifs, ex :lastname).
        $query = 'UPDATE `octopus_users` SET `typeUsers_id` = 2 WHERE `users_id`=:users_id';
        $putUserSuperUser = $this->dataBase->prepare($query);
        // on attribue les valeurs via bindValue et on recupère les attributs de la classe via $this
        $putUserSuperUser->bindValue(':users_id', $this->users_id, PDO::PARAM_INT);
        // on utilise la méthode execute() via un return
        return $putUserSuperUser->execute();
    }

    public function delSuperUser() {
        // Insertion des données du patient à l'aide d'une requête préparée avec un INSERT INTO et le nom des champs de la table
        // Insertion des valeurs des variables via les marqueurs nominatifs, ex :lastname).
        $query = 'UPDATE `octopus_users` SET `typeUsers_id` = 3 WHERE `users_id`=:users_id';
        $putUserSuperUser = $this->dataBase->prepare($query);
        // on attribue les valeurs via bindValue et on recupère les attributs de la classe via $this
        $putUserSuperUser->bindValue(':users_id', $this->users_id, PDO::PARAM_INT);
        // on utilise la méthode execute() via un return
        return $putUserSuperUser->execute();
    }

    public function verifUser($users_email) {
        // Insertion des données du patient à l'aide d'une requête préparée avec un INSERT INTO et le nom des champs de la table
        // Insertion des valeurs des variables via les marqueurs nominatifs, ex :lastname).
        $queryVerifemail = 'SELECT * FROM `octopus_users` WHERE `users_email` = :users_email';
        $verifUser = $this->dataBase->prepare($queryVerifemail);
        // on attribue les valeurs via bindValue et on recupère les attributs de la classe via $this
        $verifUser->bindValue(':users_email', $users_email, PDO::PARAM_STR);
        $verifUser->execute();
        $infoUser = $verifUser->fetch(PDO::FETCH_OBJ);
        return $infoUser;
    }

    public function __destruct() {
        // On appelle le destruct du parent
        parent::__destruct();
    }

}
