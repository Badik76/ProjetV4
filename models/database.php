<?php
// On crée une class database
class database {
    // On crée un attribut $DataBase qui sera disponible dans ses enfants car on la mis en public
    public $dataBase;
    // On crée la méthode magique __construct pour se connecter à la base de donnée mySQL
    public function __construct() {
        // On essaye de se connecter en instanciant un nouvelle objet PDO
        try {
            $this->dataBase = new PDO('mysql:host=localhost;dbname=Wellness_Reili_octopus;charset=utf8', 'admin', 'primin');
            // Si erreur, on "attrape" l'exception que l'on stock dans $e et on arrête le script PHP.
        } catch (Exception $errorMessage) {
            die('Erreur : ' . $errorMessage->getMessage()); // On affiche le message d'erreur avec la methode getMessage;
        }
    }
    // on crée la méthode magique __destruct qui nous permet de nous déconnecter de la base de donnée
    public function __destruct() {
        $this->DataBase = NULL;
    }
}