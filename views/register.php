<?php
// Start the session
session_start();
require_once '../controllers/registerController.php';
?>
<!DOCTYPE html>
<html lang="fr">
    <?php include_once '../includes/header.php'; ?>      
    <div class="container">
        <div id="AddUser" class="card-panel">
            <?php if ($addSuccess) { ?>
                <h2 class="center"> Profil enregistré ! </h2>
                <a class="center" href="login.php">Se Connecter</a>
            <?php } else { ?>                             
                <!-- form inscription-->
                <form id="addUser" action="register.php" method="POST" novalidate="">
                    <fieldset>
                        <legend>Inscription</legend>
                        <div>
                            <label for="users_lastname">Nom : (ex: Dupont)</label>
                            <div>
                                <span class="error"><?= isset($errorArray['users_lastname']) ? $errorArray['users_lastname'] : ''; ?></span>
                            </div>
                            <input name="users_lastname" type="text" id="users_lastname" required class="validate" value="<?= isset($_POST['users_lastname']) ? $_POST['users_lastname'] : ''; ?>" pattern="[a-zA-Zàáâãäåçèéêëìíîïðòóôõöùúûüýÿ-]+"  />
                        </div>
                        <div>
                            <label for="users_firstname">Prénom : (ex: Jean)</label>
                            <div>
                                <span class="error"><?= isset($errorArray['users_firstname']) ? $errorArray['users_firstname'] : ''; ?></span>
                            </div>
                            <input name="users_firstname" type="text" id="users_firstname" required class="validate" value="<?= isset($_POST['users_firstname']) ? $_POST['users_firstname'] : ''; ?>" pattern="[a-zA-Zàáâãäåçèéêëìíîïðòóôõöùúûüýÿ-]+" />
                        </div>
                        <div>
                            <label for="users_phone">Numéro de téléphone : (ex: 0602030405)</label>
                            <div>
                                <span class="error"><?= isset($errorArray['users_phone']) ? $errorArray['users_phone'] : '' ?></span>
                            </div>
                            <input id="users_phone" name="users_phone" type="tel" class="validate" required pattern="((\+)33|0)[1-9](\d{2}){4}" value="<?= isset($_POST['users_phone']) ? $_POST['users_phone'] : ''; ?>" />
                        </div>
                        <div>
                            <label for="users_email">Email : (ex: monemail@fournisseur.ext)</label>
                            <div>
                                <span class="error"><?= isset($errorArray['users_email']) ? $errorArray['users_email'] : ''; ?></span>
                            </div>   
                            <input name="users_email" type="email" id="users_email" required class="validate"  value="<?= isset($_POST['users_email']) ? $_POST['users_email'] : '' ?>" />
                        </div>
                        <div>
                            <label for="users_password">Mot de Passe : </label>
                            <input name="users_password" type="password" id="users_password" required class="validate" pattern=".{6,}+" value="" />
                            <div>
                                <span class="error"><?= isset($errorArray['users_password']) ? $errorArray['users_password'] : ''; ?></span>
                            </div>
                            <label for="users_confirm_password">Confirmer Mot de Passe : </label>
                            <input name="users_confirm_password" type="password" id="users_confirm_password" required class="validate" pattern=".{6,}+" value="<?= isset($_POST['confirm_password']) ? $confirm_password : ''; ?>" />
                            <div>
                                <span class="error">
                                    <?= isset($errorArray['users_confirm_password']) ? $errorArray['users_confirm_password'] : ''; ?>
                                </span>
                            </div>                        
                        </div>
                        <div class="modal-footer">
                            <input name="addButton" type="submit" class="waves-effect waves-light btn teal" value="ENREGISTRER"/> <!--ng disabled permet de cacher le bouton si champ pas rempli-->
                            <div>
                                <span class="error"><?= isset($errorArray['add']) ? $errorArray['add'] : '' ?></span>
                            </div>  
                        </div>
                    </fieldset>
                </form>
            <?php } ?>
        </div>  
    </div>
    <!-- fin formulaire inscription-->
    <?php include_once '../includes/footer.php'; ?>    
</body>
</html>