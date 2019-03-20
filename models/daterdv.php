<?php

/* On crée une class daterdv qui hérite de la classe database via extends
 * La classe daterdv va nous permettre d'accéder à la table daterdv
 */

class daterdv extends database {

    // Création d'attributs qui correspondent à chacun des champs de la table daterdv

    public $dateRDV_id;
    public $dateRDV_dateRDV;
    public $dateRDV_validate;
    public $users_id;
    public $prestations_id;
    public $timeRDV_id;

    // on crée une methode magique __construct()
    public function __construct() {
        // On appelle le __construct() du parent via "parent::""
        parent::__construct();
    }

    /**
     * On crée une methode qui insert une date dans la table daterdv
     * @return type EXECUTE
     */
    public function addRDV() {
        // Insertion des données du rdv à l'aide d'une requête préparée avec un INSERT INTO et le nom des champs de la table 
        // Insertion des valeurs des variables via les marqueurs nominatifs, ex :dateRDV).
        //Nous allons utiliser la fonction prépare pour mettre en place des bindValue pour récupérer les valeurs de l'objet, une fois les valeurs récupérées, nous exécutons la requête.
        $query = 'INSERT INTO `octopus_dateRDV` ( `dateRDV_dateRDV`, `users_id`, `prestations_id`, `timeRDV_id`)'
                . 'VALUES (:dateRDV_dateRDV, :users_id, :prestations_id, :timeRDV_id)';
        $addRDV = $this->dataBase->prepare($query);
        // on attribue les valeurs via bindValue et on récupère les attributs de la classe via $this
        $addRDV->bindValue(':dateRDV_dateRDV', $this->dateRDV_dateRDV, PDO::PARAM_STR);
        $addRDV->bindValue(':users_id', $this->users_id, PDO::PARAM_STR);
        $addRDV->bindValue(':prestations_id', $this->prestations_id, PDO::PARAM_STR);
        $addRDV->bindValue(':timeRDV_id', $this->timeRDV_id, PDO::PARAM_STR);
        // on utilise la méthode execute() via un return
        return $addRDV->execute();
    }

    /**
     * On crée un methode qui retourne la liste des rdv de la table daterdv
     * @return type ARRAY -> WARNING -> is_object ?
     */
    public function showRDV() {
        // On met notre requète dans la variable $query qui selectionne tous les champs de la table Produits
        $query = 'SELECT `octopus_dateRDV`.`dateRDV_id`,`octopus_dateRDV`.`prestations_id`,'
                . '`octopus_dateRDV`.`users_id`,DATE_FORMAT(`octopus_dateRDV`.`dateRDV_dateRDV`, "%d/%m/%Y") AS `dateRDV_dateRDV`,'
                . '`octopus_users`.`users_lastname`, `octopus_users`.`users_firstname`,'
                . '`octopus_users`.`users_phone`,`octopus_timeRDV`.`timeRDV_timeRDV`,'
                . '`octopus_prestations`.`prestations_id`, `octopus_prestations`.`prestations_name`'
                . 'FROM `octopus_dateRDV`'
                . 'INNER JOIN `octopus_users` ON `octopus_dateRDV`.`users_id` = `octopus_users`.`users_id`'
                . 'INNER JOIN `octopus_prestations` ON `octopus_dateRDV`.`prestations_id` = `octopus_prestations`.`prestations_id`'
                . 'INNER JOIN `octopus_timeRDV` ON `octopus_dateRDV`.`timeRDV_id` = `octopus_timeRDV`.`timeRDV_id`'
                . 'WHERE `octopus_dateRDV`.`prestations_id` = `octopus_prestations`.`prestations_id`'
                . 'ORDER BY `octopus_dateRDV`.`prestations_id`';
        // On crée un objet $result qui exécute la méthode query() avec comme paramètre $query
        $showresult = $this->dataBase->query($query);
        // On crée un objet $resultList qui est un tableau.
        // La fonction fetchAll permet d'afficher toutes les données de la requète dans un tableau d'objet via le paramètre (PDO::FETCH_OBJ)
        $resultList = $showresult->fetchAll(PDO::FETCH_OBJ);
        // On retourne le resultat
        return $resultList;
    }

    /**
     * On crée un methode qui retourne la liste des rdv de la table daterdv
     * @return type ARRAY -> WARNING -> is_object ?
     */
    public function showRDVbefore($users_id) {
        // On met notre requète dans la variable $query qui selectionne tous les champs de la table Produits
        $query = 'SELECT `octopus_dateRDV`.`dateRDV_id`, `octopus_dateRDV`.`dateRDV_validate`,'
                . '`octopus_dateRDV`.`users_id`, DATE_FORMAT(`dateRDV_dateRDV`, "%d/%m/%Y") AS `dateRDV_dateRDV`,'
                . '`octopus_timeRDV`.`timeRDV_timeRDV`,'
                . '`octopus_prestations`.`prestations_name`'
                . 'FROM `octopus_dateRDV`'
                . 'INNER JOIN `octopus_users` ON `octopus_dateRDV`.`users_id` = `octopus_users`.`users_id`'
                . 'INNER JOIN `octopus_prestations` ON `octopus_dateRDV`.`prestations_id` = `octopus_prestations`.`prestations_id`'
                . 'INNER JOIN `octopus_timeRDV` ON `octopus_dateRDV`.`timeRDV_id` = `octopus_timeRDV`.`timeRDV_id`'
                . 'WHERE `octopus_dateRDV`.`users_id` = `octopus_users`.`users_id`'
                . 'AND `octopus_dateRDV`.`dateRDV_dateRDV` <= NOW()'
                . 'ORDER BY `octopus_dateRDV`.`dateRDV_dateRDV`'; //
        // On crée un objet $result qui exécute la méthode query() avec comme paramètre $query
        $showresult = $this->dataBase->prepare($query);
        // On crée un objet $resultList qui est un tableau.
        $showresult->execute(array($users_id));
        // La fonction fetchAll permet d'afficher toutes les données de la requète dans un tableau d'objet via le paramètre (PDO::FETCH_OBJ)
        $resultList = $showresult->fetchAll(PDO::FETCH_OBJ);
        // On retourne le resultat
        return $resultList;
    }

    /**
     * On crée un methode qui retourne un tableau qui contient les informations d'un rdv selon l'idPresta de la table daterdv
     * @return BOOLEAN
     */
    public function getRDVByidUser($users_id) {
        // On met notre requète dans la variable $query qui selectionne tous les champs de la table users l'id est egal à :id via marqueur nominatif sur id
        $query = 'SELECT `octopus_dateRDV`.`dateRDV_id`, `octopus_dateRDV`.`users_id`, `octopus_dateRDV`.`dateRDV_validate`,'
                . '`octopus_dateRDV`.`timeRDV_id`, `octopus_dateRDV`.`prestations_id`,'
                . 'DATE_FORMAT(`octopus_dateRDV`.`dateRDV_dateRDV`, "%d/%m/%Y") AS `dateRDV_dateRDV`,'
                . '`octopus_timeRDV`.`timeRDV_timeRDV`,`octopus_prestations`.`prestations_name`'
                . 'FROM `octopus_dateRDV`'
                . 'INNER JOIN `octopus_users` ON `octopus_dateRDV`.`users_id` = `octopus_users`.`users_id`'
                . 'INNER JOIN `octopus_prestations` ON `octopus_dateRDV`.`prestations_id` = `octopus_prestations`.`prestations_id`'
                . 'INNER JOIN `octopus_timeRDV` ON `octopus_dateRDV`.`timeRDV_id` = `octopus_timeRDV`.`timeRDV_id`'
                . 'WHERE `octopus_dateRDV`.`users_id` = ?'
                . 'AND `octopus_dateRDV`.`dateRDV_dateRDV` > NOW()'
                . 'ORDER BY `octopus_dateRDV`.`prestations_id`';
        // On crée un objet $findProfil qui utilise la fonction prepare avec comme paramètre $query        
        $result = $this->dataBase->prepare($query);
        // on attribue la valeur via bindValue et on recupère les attributs de la classe via $this
//        $result->bindValue(':users_id', $this->users_id, PDO::PARAM_INT);
        $result->execute(array($users_id));
        // On crée un objet $resultList qui est un tableau.
        // La fonction fetchAll permet d'afficher toutes les données de la requète dans un tableau d'objet via le paramètre (PDO::FETCH_OBJ)
        $rdvidUserList = $result->fetchAll(PDO::FETCH_OBJ);
        return $rdvidUserList;
    }

    public function getRDVByid($users_id) {
        $rdvFind = false;
        // On met notre requète dans la variable $query qui selectionne tous les champs de la table users l'id est egal à :id via marqueur nominatif sur id
        $query = 'SELECT `octopus_dateRDV`.`dateRDV_id`, `octopus_dateRDV`.`users_id`, `octopus_dateRDV`.`dateRDV_validate`,'
                . '`octopus_dateRDV`.`timeRDV_id`, `octopus_dateRDV`.`prestations_id`,'
                . 'DATE_FORMAT(`octopus_dateRDV`.`dateRDV_dateRDV`, "%d/%m/%Y") AS `dateRDV_dateRDV`,'
                . '`octopus_timeRDV`.`timeRDV_timeRDV`,`octopus_prestations`.`prestations_name`'
                . 'FROM `octopus_dateRDV`'
                . 'INNER JOIN `octopus_users` ON `octopus_dateRDV`.`users_id` = `octopus_users`.`users_id`'
                . 'INNER JOIN `octopus_prestations` ON `octopus_dateRDV`.`prestations_id` = `octopus_prestations`.`prestations_id`'
                . 'INNER JOIN `octopus_timeRDV` ON `octopus_dateRDV`.`timeRDV_id` = `octopus_timeRDV`.`timeRDV_id`'
                . 'WHERE `octopus_dateRDV`.`users_id` = ? ';
        // On crée un objet $findProfil qui utilise la fonction prepare avec comme paramètre $query        
        $result = $this->dataBase->prepare($query);
//        $result->bindValue(':users_id', $this->users_id, PDO::PARAM_INT); 
        if ($result->execute(array($users_id))) {
            $profil = $result->fetch(PDO::FETCH_OBJ);
            // if imbriqué pour hydrater les valeurs
            // si $profil est un objet(existe dans la table), on attribue directement les valeurs de l'objet $profil
            if (is_object($profil)) {
                $this->users_id = $profil->users_id;
                $this->dateRDV_id = $profil->dateRDV_id;
                $this->prestations_name = $profil->prestations_name;
                $this->timeRDV_timeRDV = $profil->timeRDV_timeRDV;
                $this->dateRDV_dateRDV = $profil->dateRDV_dateRDV;
                $this->prestations_id = $profil->prestations_id;
                $this->timeRDV_id = $profil->timeRDV_id;
                $rdvFind = true;
            }
        }
        return $rdvFind;
    }

    /**
     * On crée un methode qui supprime une ligne de la table ainsi que les lignes de la table appointments associée
     * Contrôle de la QUERY via un commit et rollback
     * @return EXECUTE QUERY
     */
    public function deleteRDVbyID() {
        // on met en place les attributs du PDO $dataBase avec ATTR_ERRMODE et ERRMODE_EXCEPTION pour genérer des message en cas d'erreur
        $this->dataBase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $this->dataBase->beginTransaction();
            // On crée notre requête pour effacer le user
            $deleterdvQuery = 'DELETE FROM `octopus_dateRDV` WHERE `dateRDV_id` = :dateRDV_id';
            // on prépare la requete avec un marqueur nominatif qui récuperera la valeur de l'id  
            $deleterdv = $this->dataBase->prepare($deleterdvQuery);
            $deleterdv->bindValue(':dateRDV_id', $this->dateRDV_id, PDO::PARAM_INT);
            // on execute la requete pour effacer le user
            $deleterdv->execute();
            // si tout s'est bien déroule on valide la transaction via un commit
            $this->dataBase->commit();
        } catch (Exception $errorMessage) { // en cas d'erreur on stock le message dans $errorMessage
            // Si erreur, on annule la transaction via un rollback
            $this->dataBase->rollback();
            echo 'Erreur : ' . $errorMessage->getMessage(); // On affiche le message d'erreur avec la methode getMessage
        }
    }

    /**
     * On crée un methode qui supprime une ligne de la table ainsi que les lignes de la table appointments associée
     * Contrôle de la QUERY via un commit et rollback
     * @return EXECUTE QUERY
     */
    public function deleteRDVbyIDUSER() {
        // on met en place les attributs du PDO $dataBase avec ATTR_ERRMODE et ERRMODE_EXCEPTION pour genérer des message en cas d'erreur
        $this->dataBase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $this->dataBase->beginTransaction();
            // On crée notre requête pour effacer le user
            $deleterdvuserQuery = 'DELETE FROM `octopus_dateRDV` WHERE `users_id` = :users_id';
            // on prépare la requete avec un marqueur nominatif qui récuperera la valeur de l'id  
            $deleterdvuser = $this->dataBase->prepare($deleterdvuserQuery);
            $deleterdvuser->bindValue(':users_id', $this->users_id, PDO::PARAM_INT);
            // on execute la requete pour effacer le user
            $deleterdvuser->execute();
            // si tout s'est bien déroule on valide la transaction via un commit
            $this->dataBase->commit();
        } catch (Exception $errorMessage) { // en cas d'erreur on stock le message dans $errorMessage
            // Si erreur, on annule la transaction via un rollback
            $this->dataBase->rollback();
            echo 'Erreur : ' . $errorMessage->getMessage(); // On affiche le message d'erreur avec la methode getMessage
        }
    }

    /*
     * Création d'une méthode qui validera le rdv.
     */

    public function putRDVvalidate() {
        // Insertion des données du patient à l'aide d'une requête préparée avec un INSERT INTO et le nom des champs de la table
        // Insertion des valeurs des variables via les marqueurs nominatifs, ex :lastname).
        $query = 'UPDATE `octopus_dateRDV` SET `dateRDV_validate` = 1 '
                . 'WHERE `dateRDV_id`=:dateRDV_id';
        $putRDVvalidate = $this->dataBase->prepare($query);
        // on attribue les valeurs via bindValue et on recupère les attributs de la classe via $this
        $putRDVvalidate->bindValue(':dateRDV_id', $this->dateRDV_id, PDO::PARAM_INT);
        // on utilise la méthode execute() via un return
        return $putRDVvalidate->execute();
    }

    /*
     * Création d'une méthode qui archivera le rdv.
     */

    public function putRDVarchivate($dateRDV_id) {
        // Insertion des données du patient à l'aide d'une requête préparée avec un INSERT INTO et le nom des champs de la table
        // Insertion des valeurs des variables via les marqueurs nominatifs, ex :lastname).
        $query = 'UPDATE `octopus_dateRDV` SET `dateRDV_validate` = 0 '
                . 'WHERE `dateRDV_id`= ?';
        $putRDVvalidate = $this->dataBase->prepare($query);
        // on utilise la méthode execute() via un return
        return $putRDVvalidate->execute(array($dateRDV_id));
    }

    public function updaterdv($dateRDV_id, $dateRDV_dateRDV, $timeRDV_id) {
        // MAJ des données de user à l'aide d'une requête préparée avec un UPDATE et le nom des champs de la table
        // Insertion des valeurs des variables via ?
        $query = $this->dataBase->prepare('UPDATE octopus_dateRDV SET dateRDV_dateRDV = ?, timeRDV_id = ? WHERE dateRDV_id = ?');
        // on utilise la méthode execute() via un return
        return $query->execute([$dateRDV_dateRDV, $timeRDV_id, $dateRDV_id]);
    }

    public function __destruct() {
        // On appelle le destruct du parent
        parent::__destruct();
    }

}
