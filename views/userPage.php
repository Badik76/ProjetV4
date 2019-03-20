<?php
// Start the session
session_start();
//appel du controller userPage
require_once '../controllers/userPageController.php'
?>
<!DOCTYPE html>
<html lang="fr">
    <!--include de la navbar-->
    <?php
    include_once '../includes/header.php';
//on verif si l'utilisateur est connecté
    if (isset($_SESSION['userLog'])) {
        ?>    
        <div class="container-fluid row center">          
            <div class="card col m12 l8"> 
                <?php
                //on vérif si l'utilisateur a été trouvé.
                if ($userIsFind) {
                    ?>
                    <div class="card-title groundcolor"><h2><i class="material-icons">spa</i> Mes prochains RDV's <i class="material-icons">spa</i></h2></div>                 
                    <div><a href="../index.php#presta">Prendre un rdv</a></div>
                    <div class="card-content">
                        <table class="centered highlight responsive-table">
                            <?php
                            if ($rdvFind) {
                                if ($daterdv->users_id !== $users->users_id) {
                                    
                                } else {
                                    ?>
                                    <thead>
                                        <tr>
                                            <th>Soin</th>
                                            <th>Date</th>
                                            <th>Heure</th>
                                            <th>Modif</th>
                                        </tr>
                                    </thead>
                                    <?php foreach ($rdvidUserList as $daterdv) { ?>
                                        <!-- Modal Structure DELRDV-->
                                        <div id="modalDelRDV<?= $daterdv->dateRDV_id ?>" class="modal">
                                            <div id="MODAL1" class="modal-content">
                                                <div>
                                                    <h2 class="card-title red-text">Attention la suppression est définitive.</h2>
                                                    <a  class="btn" href="userPage.php?DeleteRDV=<?= $daterdv->dateRDV_id ?>">Supprimer le rdv</a>
                                                </div>                              
                                            </div>
                                        </div>
                                        <!-- Modal Structure upRDV-->
                                        <div id="modalID<?= $daterdv->dateRDV_id ?>" class="modal">
                                            <div class="modal-content">
                                                <form id="upRDV" action="userPage.php?dateRDV_id=<?= $daterdv->dateRDV_id ?>" method="POST" novalidate="">
                                                    <fieldset>
                                                        <legend>Modifier mon RDV <?= $prestations->prestations_name ?></legend>
                                                        <p class="center-align"><?= $upRDVSuccess ? 'Le rdv est enregistré' : '' ?></p>
                                                        <p><b><?= $prestations->prestations_description ?></b></p>
                                                        <p class="left">Temps de la séance : 1 heure</p>
                                                        <p class="right">Prix à domicile : 35 €</p>
                                                        <div>                         
                                                            <label for="dateRDV_dateRDV">Sélectionner la date et l'heure.</label>
                                                            <input name="dateRDV_dateRDV" type="text" id="dateRDV_dateRDV" required class="validate datepicker" value="<?= $daterdv->dateRDV_dateRDV ?>" />
                                                        </div>
                                                        <div class="input-field row">

                                                            <?php foreach ($showTimeRDV AS $timerdv) { ?>
                                                                <p class="col s3 m3 l3">
                                                                    <label>
                                                                        <input value="<?= $timerdv->timeRDV_id ?>" name="timeRDV_id" type="radio" />
                                                                        <span><?= $timerdv->timeRDV_timeRDV ?></span>
                                                                    </label>
                                                                </p>
                                                            <?php } ?>    
                                                            <p class="error"><?= isset($errorArray['timeRDV_id']) ? $errorArray['timeRDV_id'] : '' ?></p>
                                                        </div>
                                                        <input name="updateRDVButton" type="submit" class="btn" value="Modifier le RDV" /> 
                                                    </fieldset>
                                                </form>                                     
                                            </div>
                                        </div>
                                        <tbody> 
                                            <tr>
                                                <td><?= $daterdv->prestations_name ?></td>
                                                <td><?= $daterdv->dateRDV_dateRDV ?></td>
                                                <td><?= $daterdv->timeRDV_timeRDV ?></td>
                                                <td><a class="modal-trigger" href="#modalID<?= $daterdv->dateRDV_id ?>" name="action">
                                                        <i class="material-icons green-text">autorenew</i>
                                                    </a>
                                                    <a class="modal-trigger" href="#modalDelRDV<?= $daterdv->dateRDV_id ?>" name="action">
                                                        <i class="material-icons red-text">cancel</i>
                                                    </a>                                                    
                                                </td>
                                            </tr>
                                        </tbody>                                    
                                    <?php } ?>  
                                </table>
                            </div> 
                        <?php } ?>
                    <?php } ?>  
                    <div class="divider"></div>
                    <div class="card-title groundcolor"><h2><i class="material-icons">spa</i> Mes anciens RDV's <i class="material-icons">spa</i></h2></div>
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
                            <?php
                            foreach ($showrdv AS $daterdv) {
                                if ($daterdv->users_id !== $users->users_id) {
                                    
                                } else {
                                    ?>
                                    <tbody>
                                        <tr>
                                            <td><?= $daterdv->prestations_name ?></td>
                                            <td><?= $daterdv->dateRDV_dateRDV ?></td>
                                            <td><?= $daterdv->timeRDV_timeRDV ?></td>
                                            <?php if ($daterdv->dateRDV_validate == 1) { ?>
                                                <!-- Modal Trigger AddComment -->
                                                <td><a class="waves-effect waves-light btn modal-trigger right" href="#modaladdComment<?= $daterdv->dateRDV_id ?>">Commenter rdv</a></td>                                                
                                    <?php } ?>  
                                                <!-- Modal Structure AddCat-->
                                        <div id="modaladdComment<?= $daterdv->dateRDV_id ?>" class="modal">
                                            <div class="modal-content">
                                                <form name="addComment" action="userPage.php?addComment=<?= $daterdv->dateRDV_id ?>" method="POST" novalidate="">
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
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>                
                <div class="card col m12 l4"> 
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
                                    <label for="users_lastname">Nom : (Dupont)</label>
                                    <div>
                                        <span class="error"><?= isset($errorArray['users_lastname']) ? $errorArray['users_lastname'] : ''; ?></span>
                                    </div>
                                    <input name="users_lastname" type="text" id="users_lastname" required class="validate" value="<?= isset($_POST['users_lastname']) ? $_POST['users_lastname'] : $users->users_lastname ?>" pattern="[a-zA-Zàáâãäåçèéêëìíîïðòóôõöùúûüýÿ-]+"  />
                                </div>
                                <div>
                                    <label for="users_firstname">Prénom : (ex: Jean)</label>
                                    <div>
                                        <span class="error"><?= isset($errorArray['users_firstname']) ? $errorArray['users_firstname'] : ''; ?></span>
                                    </div>
                                    <input name="users_firstname" type="text" id="users_firstname" required class="validate" value="<?= isset($_POST['users_firstname']) ? $_POST['users_firstname'] : $users->users_firstname ?>" pattern="[a-zA-Zàáâãäåçèéêëìíîïðòóôõöùúûüýÿ-]+" />
                                </div>
                                <div>
                                    <label for="users_phone">Numéro de téléphone : (ex: 0602030405)</label>
                                    <div>
                                        <span class="error"><?= isset($errorArray['users_phone']) ? $errorArray['users_phone'] : '' ?></span>
                                    </div>
                                    <input id="users_phone" name="users_phone" type="tel" class="validate" required pattern="((\+)33|0)[1-9](\d{2}){4}" value="0<?= isset($_POST['users_phone']) ? $_POST['users_phone'] : $users->users_phone ?>" />
                                </div>
                                <div>
                                    <label for="users_email">Email : (ex: monemail@fournisseur.ext)</label>
                                    <div>
                                        <span class="error"><?= isset($errorArray['users_email']) ? $errorArray['users_email'] : ''; ?></span>
                                    </div>   
                                    <input name="users_email" type="email" id="users_email" required class="validate"  value="<?= isset($_POST['users_email']) ? $_POST['users_email'] : $users->users_email ?>" />
                                </div>
                                <div>
                                    <label for="users_birthdate">Date de naissance (ex: 23/05/2000).</label>
                                    <div>
                                        <span class="error"><?= isset($errorArray['users_birthdate']) ? $errorArray['users_birthdate'] : '' ?></span>
                                    </div>
                                    <input id="users_birthdate" name="users_birthdate" type="text" class="datepicker" value="<?= isset($_POST['users_birthdate']) ? $_POST['users_birthdate'] : $users->users_birthdate ?>" />
                                </div>                            
                                <div class="card-action">
                                    <div id="modalDelUsers<?= $users->users_id ?>" class="modal">
                                        <div id="MODAL1" class="modal-content">
                                            <div>
                                                <h2 class="card-title red-text">Attention la suppression du profil est définitive.</h2>
                                                <a  class="btn" href="userPage.php?deleteThis=<?= $users->users_id ?>">Supprimer mon profil</a>
                                            </div>                              
                                        </div>
                                    </div>
                                    <input name="updateButton" type="submit" class="waves-effect waves-light btn white-text" value="Mettre à jour mon profil"/>
                                    <a class="btn red darken-1 modal-trigger" href="#modalDelUsers<?= $users->users_id ?>" name="action">Supprimer profil</a>
                                    <div>
                                        <p class="error"><?= isset($errorArray['update']) ? $errorArray['update'] : '' ?></p>
                                    </div>
                                    <p class="badge red-text text-darken-1">Cette action est irreversible.</p>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php
    } else {
        header("Location: http://proprojetpro/index.php");
        exit();
    }
    ?>
    <?php include_once '../includes/footer.php'; ?>    
</body>
</html>