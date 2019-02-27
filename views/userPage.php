<?php
// Start the session
session_start();
require_once '../controllers/userPageController.php'
?>
<!DOCTYPE html>
<html lang="fr">
    <?php include_once '../includes/header.php'; ?>    
    <div class="container-fluid row center">          
        <div class="card col m12 l6"> 
            <?php
            if ($userIsFind) {
                ?>
                <div class="card-title groundcolor"><h2><i class="material-icons">spa</i> Mon prochain RDV <i class="material-icons">spa</i></h2></div>                 
                <div><a href="../index.php#presta">Prendre un rdv</a></div>
                <div class="card-content">
                    <table class="centered highlight responsive-table">
                        <thead>
                            <tr>
                                <th>Soin</th>
                                <th>Date</th>
                                <th>Heure</th>
                                <th>Modif</th>
                            </tr>
                        </thead>
                        <tbody> 
                            <?php if ($rdvFind) { ?>
                                <tr>
                                    <td><?= $daterdv->prestations_name ?></td>
                                    <td><?= $daterdv->dateRDV_dateRDV ?></td>
                                    <td><?= $daterdv->timeRDV_timeRDV ?></td>
                                    <td><a href="userPage.php?DeleteRDV=<?= $daterdv->dateRDV_id ?>" name="action">
                                            <i class="material-icons red-text">cancel</i>
                                        </a>
                                        <a class="modal-trigger" href="#modalID<?= $daterdv->dateRDV_id ?>" name="action">
                                            <i class="material-icons green-text">autorenew</i>
                                        </a></td>
                                </tr>
                                <!-- Modal Structure upRDV-->
                            <div id="modalID<?= $daterdv->dateRDV_id ?>" class="modal">
                                <div class="modal-content">
                                    <form id="addRDV" action="userPage.php?dateRDV_id=<?= $daterdv->dateRDV_id ?>" method="POST">
                                        <fieldset>
                                            <legend>Modifier mon RDV <?= $prestations->prestations_name ?></legend>
                                            <p class="center-align"><?= $upRDVSuccess ? 'Le rdv est enregistré' : '' ?><p>
                                            <p><b><?= $prestations->prestations_description ?></b></p>
                                            <p class="left">Temps de la séance : 1 heure</p>
                                            <p class="right">Prix à domicile : 35 €</p>
                                            <div>                                        
                                                <input name="dateRDV_dateRDV" type="text" id="dateRDV_dateRDV" required class="validate datepicker" value="<?= $daterdv->dateRDV_dateRDV ?>" />
                                            </div>
                                            <div class="input-field">
                                                <select id="timeRDV_id" name="timeRDV_id">
                                                    <option value="0" disabled selected><?= $daterdv->timeRDV_timeRDV ?></option>
                                                    <?php foreach ($showTimeRDV AS $timerdv) { ?>
                                                        <option value="<?= $timerdv->timeRDV_id ?>"><?= $timerdv->timeRDV_timeRDV ?></option>
                                                    <?php } ?>
                                                </select>
                                                <p class="error"><?= isset($errorArray['timeRDV_id']) ? $errorArray['timeRDV_id'] : '' ?></p>
                                            </div>                                   
                                            <div class="input-field">
                                                <input name="updateRDVButton" type="submit" class="waves-effect waves-light btn teal" value="Modifier le RDV"/>
                                                <?php foreach ($errorArray AS $error) { ?>
                                                    <p class="error"><?= $error ?></p>
                                                <?php } ?>                            
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
            <div class="divider"></div>
            <?php if ($userIsFind) { ?>
                <div class="card-title groundcolor"><h2><i class="material-icons">spa</i> Mes anciens RDV <i class="material-icons">spa</i></h2></div>
                <div class="card-content">
                    <table class="centered highlight responsive-table">
                        <thead>
                            <tr>
                                <th>Soin</th>
                                <th>Date</th>
                                <th>Heure</th>
                                <th>Comments</th>
                            </tr>
                        </thead>
                        <?php foreach ($showrdv AS $daterdv) { ?>
                            <tbody>
                                <tr>
                                    <td><?= $daterdv->prestations_name ?></td>
                                    <td><?= $daterdv->dateRDV_dateRDV ?></td>
                                    <td><?= $daterdv->timeRDV_timeRDV ?></td>
                                    <?php if ($daterdv->dateRDV_validate == 1) { ?>
                                        <!-- Modal Trigger AddComment -->
                                        <td><a class="waves-effect waves-light btn modal-trigger right" href="#modaladdComment">Commenter rdv</a></td>
                                        <!-- Modal Structure AddCat-->
                                <div id="modaladdComment" class="modal">
                                    <div class="modal-content">
                                        <form name="addComment" action="userPage.php" method="POST" >
                                            <fieldset>
                                                <legend>Ajouter Commentaire</legend>
                                                <p class="center-align"><?= $addCommentSuccess ? 'Commentaire enregistré. ' : '' ?><p>
                                                <div>
                                                    <label for="comments_comment">Ajouter un Commentaire : </label>
                                                    <input name="comments_comment" type="text" id="comments_comment" required class="validate" value="<?= isset($_POST['comments_comment']) ? $_POST['comments_comment'] : ''; ?>" />
                                                    <div>
                                                        <span class="error"><?= isset($errorArray['comments_comment']) ? $errorArray['comments_comment'] : ''; ?></span>
                                                    </div>
                                                </div>
                                                <input type="submit" class="btn modal-close" name="addComment" />
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>
                            <?php } ?>  
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
        }
        if ($userIsFind) {
            ?>
            <div class="card col m12 l6"> 
                <div class="card-title groundcolor">
                    <h2><i class="material-icons">group</i>
                        Mon Profil 
                        <i class="material-icons">group</i>
                    </h2>
                </div>
                <?php
                if ($addSuccess) {
                    ?>
                    <p>Les modifications ont bien été prises en compte</p>.
                    <?php
                }
                if ($deleteOk) {
                    ?>
                    <p>Profil supprimé</p>.
                <?php }
                ?>               
                <div class="card-content">
                    <form id="inscription" method="POST" action="userPage.php">
                        <fieldset>
                            <legend>Mise à Jour <?php if (isset($_SESSION['isSuperUser'])) { ?>
                                    <i class="material-icons right">grade</i>
                                <?php } ?></legend>
                            <div>
                                <label for="users_lastname">Nom : (DelaMolleFesse)</label>
                                <div>
                                    <span class="error"><?= isset($errorArray['users_lastname']) ? $errorArray['users_lastname'] : ''; ?></span>
                                </div>
                                <input name="users_lastname" type="text" id="users_lastname" required class="validate" value="<?= $users->users_lastname ?>" pattern="[a-zA-Zàáâãäåçèéêëìíîïðòóôõöùúûüýÿ-]+"  />
                            </div>
                            <div>
                                <label for="users_firstname">Prénom : (ex: Jean-Edouard)</label>
                                <div>
                                    <span class="error"><?= isset($errorArray['users_firstname']) ? $errorArray['users_firstname'] : ''; ?></span>
                                </div>
                                <input name="users_firstname" type="text" id="users_firstname" required class="validate" value="<?= $users->users_firstname ?>" pattern="[a-zA-Zàáâãäåçèéêëìíîïðòóôõöùúûüýÿ-]+" />
                            </div>
                            <div>
                                <label for="users_phone">Numéro de téléphone : (ex: 0602030405)</label>
                                <div>
                                    <span class="error"><?= isset($errorArray['users_phone']) ? $errorArray['users_phone'] : '' ?></span>
                                </div>
                                <input id="users_phone" name="users_phone" type="tel" class="validate" required pattern="((\+)33|0)[1-9](\d{2}){4}" value="0<?= $users->users_phone ?>" />
                            </div>
                            <div>
                                <label for="users_email">Email : (ex: mail@mail.fr)</label>
                                <div>
                                    <span class="error"><?= isset($errorArray['users_email']) ? $errorArray['users_email'] : ''; ?></span>
                                </div>   
                                <input name="users_email" type="email" id="users_email" required class="validate"  value="<?= $users->users_email ?>" />
                            </div>
                            <div>
                                <label for="users_birthdate">Date de naissance (ex: 23/05/2000).</label>
                                <div>
                                    <span class="error"><?= isset($errorArray['users_birthdate']) ? $errorArray['users_birthdate'] : '' ?></span>
                                </div>
                                <input id="users_birthdate" name="users_birthdate" type="text" class="datepicker" value="<?= $users->users_birthdate ?>" />
                            </div>                            
                            <div class="card-action">
                                <a class="btn red darken-1" href="userPage.php?deleteThis=<?= $users->users_id ?>" name="action">Delete
                                    <i class="material-icons right">cancel</i>
                                </a>
                                <input name="updateButton" type="submit" class="waves-effect waves-light btn" value="Upgrade"/>
                                <div>
                                    <p class="error"><?= isset($errorArray['update']) ? $errorArray['update'] : '' ?></p>
                                </div>
                                <p class="badge red-text text-darken-1">Cette action est irreversible.</p>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        <?php } else { ?>
            <div>
                <p>Votre Profil n'a pas été trouvé.</p>
            </div>
        <?php } ?>
    </div>        
    <?php include_once '../includes/footer.php'; ?>    
</body>
</html>