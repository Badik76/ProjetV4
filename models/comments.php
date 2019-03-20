<?php

/* On crée une class daterdv qui hérite de la classe database via extends
 * La classe daterdv va nous permettre d'accéder à la table daterdv
 */

class comments extends database {

    // Création d'attributs qui correspondent à chacun des champs de la table daterdv

    public $comments_id;
    public $comments_comment;
    public $users_id;
    public $dateRDV_id;

    // on crée une methode magique __construct()
    public function __construct() {
        // On appelle le __construct() du parent via "parent::""
        parent::__construct();
    }

    /**
     * On crée une methode qui insert une date dans la table daterdv
     * @return type EXECUTE
     */
    public function addComment() {
        // Insertion des données du rdv à l'aide d'une requête préparée avec un INSERT INTO et le nom des champs de la table 
        // Insertion des valeurs des variables via les marqueurs nominatifs, ex :dateRDV).
        $query = 'INSERT INTO `octopus_comments` ( `comments_comment`, `users_id`, `dateRDV_id`)'
                . 'VALUES (:comments_comment, :users_id, :dateRDV_id)';
        $addRDV = $this->dataBase->prepare($query);
//        $date = DateTime::createFromFormat('d/m/Y', $this->dateRDV);
//        $dateUs = $date->format('Y-m-d');
        $addRDV->bindValue(':comments_comment', $this->comments_comment, PDO::PARAM_STR);
        $addRDV->bindValue(':users_id', $this->users_id, PDO::PARAM_STR);
        $addRDV->bindValue(':dateRDV_id', $this->dateRDV_id, PDO::PARAM_STR);
        // on utilise la méthode execute() via un return
        return $addRDV->execute();
    }

    /**
     * On crée un methode qui retourne la liste des rdv de la table daterdv
     * @return type ARRAY -> WARNING -> is_object ?
     */
    public function showComment() {
        // On met notre requète dans la variable $query qui selectionne tous les champs de la table Produits
        $query = 'SELECT `octopus_comments`.`comments_id`, `octopus_comments`.`comments_comment`,'
                . 'DATE_FORMAT(`octopus_dateRDV`.`dateRDV_dateRDV`, "%d/%m/%Y") AS `dateRDV_dateRDV`, `octopus_prestations`.`prestations_name`,'
                . '`octopus_users`.`users_lastname`, `octopus_users`.`users_firstname`'
                . 'FROM `octopus_comments`'
                . 'INNER JOIN `octopus_users` ON `octopus_comments`.`users_id` = `octopus_users`.`users_id`'
                . 'INNER JOIN `octopus_dateRDV` ON `octopus_comments`.`dateRDV_id` = `octopus_dateRDV`.`dateRDV_id`'
                . 'INNER JOIN `octopus_prestations` ON `octopus_dateRDV`.`prestations_id` = `octopus_prestations`.`prestations_id`'
                . 'WHERE `octopus_comments`.`users_id` = `octopus_users`.`users_id` '
                . 'ORDER BY `octopus_dateRDV`.`dateRDV_dateRDV`';
        // On crée un objet $result qui exécute la méthode query() avec comme paramètre $query
        $showresult = $this->dataBase->query($query);
        // On crée un objet $resultList qui est un tableau.
        // La fonction fetchAll permet d'afficher toutes les données de la requète dans un tableau d'objet via le paramètre (PDO::FETCH_OBJ)
        $commentsList = $showresult->fetchAll(PDO::FETCH_OBJ);
        // On retourne le resultat
        return $commentsList;
    }

    /**
     * On crée un methode qui retourne la liste des rdv de la table daterdv
     * @return type ARRAY -> WARNING -> is_object ?
     */
    public function showComment2() {
        // On met notre requète dans la variable $query qui selectionne tous les champs de la table Produits
        $query = 'SELECT `octopus_comments`.`comments_id`, `octopus_comments`.`comments_comment`,'
                . 'DATE_FORMAT(`octopus_dateRDV`.`dateRDV_dateRDV`, "%d/%m/%Y") AS `dateRDV_dateRDV`, `octopus_prestations`.`prestations_name`,'
                . '`octopus_users`.`users_lastname`, `octopus_users`.`users_firstname`, `octopus_users`.`users_id`'
                . 'FROM `octopus_comments`'
                . 'INNER JOIN `octopus_users` ON `octopus_comments`.`users_id` = `octopus_users`.`users_id`'
                . 'INNER JOIN `octopus_dateRDV` ON `octopus_comments`.`dateRDV_id` = `octopus_dateRDV`.`dateRDV_id`'
                . 'INNER JOIN `octopus_prestations` ON `octopus_dateRDV`.`prestations_id` = `octopus_prestations`.`prestations_id`'
                . 'WHERE `octopus_dateRDV`.`dateRDV_id` = `octopus_comments`.`dateRDV_id`';
        // On crée un objet $result qui exécute la méthode query() avec comme paramètre $query
        $showresult = $this->dataBase->query($query);
        // On crée un objet $resultList qui est un tableau.
        // La fonction fetchAll permet d'afficher toutes les données de la requète dans un tableau d'objet via le paramètre (PDO::FETCH_OBJ)
        $commentsList = $showresult->fetchAll(PDO::FETCH_OBJ);
        // On retourne le resultat
        return $commentsList;
    }

    /**
     * On crée un methode qui supprime une ligne de la table ainsi que les lignes de la table appointments associée
     * Contrôle de la QUERY via un commit et rollback
     * @return EXECUTE QUERY
     */
    public function deleteComment() {
        // on met en place les attributs du PDO $dataBase avec ATTR_ERRMODE et ERRMODE_EXCEPTION pour genérer des message en cas d'erreur
        $this->dataBase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $this->dataBase->beginTransaction();
            // On crée notre requête pour effacer le user
            $deleteCommentQuery = 'DELETE FROM `octopus_comments` WHERE `comments_id` = :comments_id';
            // on prépare la requete avec un marqueur nominatif qui récuperera la valeur de l'id  
            $deleteComment = $this->dataBase->prepare($deleteCommentQuery);
            $deleteComment->bindValue(':comments_id', $this->comments_id, PDO::PARAM_INT);
            // on execute la requete pour effacer le user
            $deleteComment->execute();
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
    public function deleteCommentbyidUser() {
        // on met en place les attributs du PDO $dataBase avec ATTR_ERRMODE et ERRMODE_EXCEPTION pour genérer des message en cas d'erreur
        $this->dataBase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $this->dataBase->beginTransaction();
            // On crée notre requête pour effacer le user
            $deleteCommentidUserQuery = 'DELETE FROM `octopus_comments` WHERE `users_id` = :users_id';
            // on prépare la requete avec un marqueur nominatif qui récuperera la valeur de l'id  
            $deleteCommentidUser = $this->dataBase->prepare($deleteCommentidUserQuery);
            $deleteCommentidUser->bindValue(':users_id', $this->users_id, PDO::PARAM_INT);
            // on execute la requete pour effacer le user
            $deleteCommentidUser->execute();
            // si tout s'est bien déroule on valide la transaction via un commit
            $this->dataBase->commit();
        } catch (Exception $errorMessage) { // en cas d'erreur on stock le message dans $errorMessage
            // Si erreur, on annule la transaction via un rollback
            $this->dataBase->rollback();
            echo 'Erreur : ' . $errorMessage->getMessage(); // On affiche le message d'erreur avec la methode getMessage
        }
    }

    public function __destruct() {
        // On appelle le destruct du parent
        parent::__destruct();
    }

}
