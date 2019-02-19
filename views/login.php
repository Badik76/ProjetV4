<?php
// Start the session
session_start();
require_once '../controllers/loginController.php';
?>
<!DOCTYPE html>
<html lang="fr">
    <?php    include_once '../includes/header.php'; ?>
        <div id="logUser" class="card-panel">                
            <?php if ($logError) { ?>
                <h2 class="center"> Erreur de connexion ! </h2>
            <?php } if (isset($_SESSION['userLog'])) { ?>
                <?php if ($logSuccess) { ?>
                    <h2 class="center"> Connexion établie ! </h2>
                    <?php
                }
            } else {
                ?>
                <form  action="login.php" method="POST">
                    <fieldset>
                        <legend>Connexion</legend>
                        <div>
                            <label for="users_email">Email : (ex: mail@mail.fr)</label>
                            <div>
                                <span class="error"><?= isset($errorArray['users_email']) ? $errorArray['users_email'] : ''; ?></span>
                            </div>   
                            <input name="users_email" type="email" id="users_email" required class="validate" />
                        </div>
                        <div>
                            <label for="users_password">Mot de Passe : </label>
                            <div>
                                <span class="error"><?= isset($errorArray['users_password']) ? $errorArray['users_password'] : ''; ?></span>
                            </div>
                            <input name="users_password" type="password" id="users_password" required class="validate" pattern=".{6,}+" value="" />                                
                        </div>
                        <div class="modal-footer">
                            <label for="remember">Se souvenir de moi ? </label>
                            <input type="checkbox" checked="checked" name="remember" id="remember" class="filled-in" />
                            <input type="submit" class="btn" name="logButton" value="Se connecter" />
                        </div>
                    </fieldset>
                </form>
            <?php } ?>  
        </div>
        <!-- fin formulaire inscription-->
    <?php   include_once '../includes/footer.php'; ?>     
    </body>
</html> 