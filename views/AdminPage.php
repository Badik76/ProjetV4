<?php
// Start the session
session_start();
require_once '../controllers/AdminPageController.php';
?>
<!DOCTYPE html>
<html lang="fr">
    <?php include_once '../includes/header.php'; ?>
    <div class="container-fluid center">
        <ul class="collapsible">
            <li id="colUser" class="<?= $showme ?>">
                <div class="collapsible-header">
                    <h2><i class="material-icons">group</i> Gestion des Clients <i class="material-icons">group</i></h2>
                </div>
                <div class="collapsible-body">
                    <p class="center-align"><?= $superUserOK ? 'L\'utilisateur est un superUser' : '' ?><p>
                    <p class="center-align"><?= $superUserDEL ? 'L\'utilisateur n\'est plus superUser' : '' ?><p>
                    <p class="center-align"><?= $deleteOk ? 'L\'utilisateur a été supprimé' : '' ?><p>
                        <?php if ($noMatch) { ?>
                        <p class="center-align"><?= $noMatchMessage ?></p>
                    <?php } else { ?>
                        <table class="centered highlight responsive-table">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Anniversaire</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Modif</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($listUsers AS $users) { ?>
                                    <tr>
                                        <td><?= $users->users_lastname ?></td>
                                        <td><?= $users->users_firstname ?></td>
                                        <td><?= $users->users_birthdate ?></td>
                                        <td><?= $users->users_email ?></td>
                                        <td>0<?= $users->users_phone ?></td>
                                        <td>
                                            <a class="btn red darken-1 collUser" href="AdminPage.php?deleteThis=<?= $users->users_id ?>" name="action">Delete
                                                <i class="large material-icons right">cancel</i>
                                            </a>
                                            <?php if ($users->typeUsers_id !== '2') { ?>
                                                <a class="btn collUser" href="AdminPage.php?GetUserSuperUser=<?= $users->users_id ?>" name="action">SuperUser
                                                    <i class="large material-icons right">grade</i>
                                                </a>
                                            <?php } else { ?>
                                                <a class="btn collUser" href="AdminPage.php?DelSuperUser=<?= $users->users_id ?>" name="action">DelSuperUser</a> 
                                            <?php } ?>                                                
                                    </tr>
                                <?php } ?><!-- fin de la boucle for each -->
                            </tbody>
                        </table>
                        <?php if ($page > 1) { ?>
                            <a href="AdminPage.php?page=<?= $page - 1 ?>" class="waves-effect waves-light btn collUser"><i class="material-icons left">arrow_back</i></a>                        
                            <?php
                        };
                        for ($pageNumber = 1; $pageNumber <= $pagesMax; $pageNumber++) {
                            ?>
                            <a href="AdminPage.php?page=<?= $pageNumber ?>" class="waves-effect waves-light btn collUser"><?= $pageNumber ?></a>
                            <?php
                        };
                        if ($page < $pagesMax) {
                            ?>
                            <a href="AdminPage.php?page=<?= $page + 1 ?>" class="waves-effect waves-light btn collUser"><i class="material-icons right">arrow_forward</i></a>
                        <?php }; ?>
                        <p>Page actuelle : <?= $page . ' / ' . $pagesMax ?></p>
                    <?php }; ?>
                    <!-- fin du if -->
                </div>
            </li>
            <li class="<?= $showme2 ?>">
                <div class="collapsible-header">
                    <h2><i class="material-icons">spa</i> Gestion des RDV's <i class="material-icons">spa</i></h2>
                </div>
                <div class="collapsible-body">                        
                    <ul class="collapsible col l12">
                        <?php foreach ($listPrestations AS $prestations) { ?>
                            <li class="<?= $showrdvcat ?>">
                                <div class="collapsible-header">
                                    <i class="material-icons">filter_drama</i>
                                    <?= $prestations->prestations_name ?>
                                    <span class="badge">if Resa.id +1 = count!= Resa.id.length echo Resa</span></div>
                                <div class="collapsible-body row">
                                    <?php
                                    foreach ($resultList AS $daterdv) {
                                        if ($prestations->prestations_id !== $daterdv->prestations_id) {
                                            
                                        } else {
                                            ?>
                                            <div class="col s2 m2 l2">
                                                <div class="card horizontal">
                                                    <div class="card-content">
                                                        <p><?= $daterdv->prestations_name ?> <?= $daterdv->users_lastname ?>  <?= $daterdv->users_firstname ?> 
                                                            0<?= $daterdv->users_phone ?> <?= $daterdv->dateRDV_dateRDV ?> <?= $daterdv->timeRDV_timeRDV ?> </p>
                                                        <a class="green darken-1" href="AdminPage.php?ValideRDV=<?= $daterdv->dateRDV_id ?>" name="action">
                                                            <i class="material-icons right green-text">check</i>
                                                        </a>
                                                        <a href="AdminPage.php?DeleteRDV=<?= $daterdv->users_id ?>" name="action">
                                                            <i class="material-icons right red-text">cancel</i>                                                           
                                                        </a>
                                                    </div>                                                            
                                                </div>                                            
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </li>
            <li class="<?= $showme3 ?>">
                <div class="collapsible-header">                        
                    <h2><i class="material-icons">lightbulb_outline</i>Gestion des Produits<i class="material-icons">lightbulb_outline</i></h2>
                </div>
                <div class="collapsible-body">
                    <div class="col m12 l6">
                        <form name="insertcategory" action="AdminPage.php" method="POST">
                            <fieldset>
                                <legend>Ajouter/Modifier/Supprimer</legend>
                                <p class="center-align"><?= $productcategoryDEL ? 'La catégorie est supprimée ' : '' ?><p>
                                <p class="center-align"><?= $productDEL ? 'Le produit est supprimée ' : '' ?><p>
                                <ul class="collapsible">
                                    <li>
                                        <div class="collapsible-header">
                                            <i class="material-icons">filter_drama</i>
                                            Catégories
                                            <a class="waves-effect waves-light btn modal-trigger right btnright" href="#modalAddCat">Ajouter</a>
                                        </div>
                                        <div class="collapsible-body row">
                                            <!-- Modal Trigger AddCat -->

                                            <?php foreach ($showCatProd AS $productcategory) { ?>
                                                <div class="col s2 m2 l2">
                                                    <div class="card horizontal">
                                                        <div class="card-content">
                                                            <!-- Modal Trigger UpCat -->
                                                            <a class="modal-trigger" href="#modalUpCat<?= $productcategory->productCategory_id ?>"><?= $productcategory->productCategory_name ?></a>
                                                        </div>
                                                        <div class="card-action">
                                                            <a class="red darken-1" href="AdminPage.php?DeleteCatProd=<?= $productcategory->productCategory_id ?>" name="action">
                                                                <i class="material-icons right">cancel</i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal Structure AddCat-->
                                                <div id="modalAddCat" class="modal">
                                                    <div class="modal-content">
                                                        <form name="addCatProd" action="AdminPage.php" method="POST" >
                                                            <fieldset>
                                                                <legend>Ajouter Catégorie</legend>
                                                                <p class="center-align"><?= $addCatSuccess ? 'La catégorie est ajoutée ' : '' ?><p>
                                                                <div>
                                                                    <label for="productCategory_name">Nom : </label>
                                                                    <input name="productCategory_name" type="text" id="productCategory_name" required class="validate" value="<?= isset($_POST['productCategory_name']) ? $_POST['productCategory_name'] : ''; ?>" />
                                                                    <div>
                                                                        <span class="error"><?= isset($errorArray['productCategory_name']) ? $errorArray['productCategory_name'] : ''; ?></span>
                                                                    </div>
                                                                </div>
                                                                <input type="submit" class="btn modal-close" name="addCatProd" />
                                                            </fieldset>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- Modal Structure UpCat-->
                                                <div id="modalUpCat<?= $productcategory->productCategory_id ?>" class="modal">
                                                    <div class="modal-content">
                                                        <form name="UpCatProd" action="AdminPage.php?idCatToUpdate=<?= $productcategory->productCategory_id ?>" method="POST" >
                                                            <fieldset>
                                                                <legend>Modifier Catégorie</legend>
                                                                <p class="center-align"><?= $upCatSuccess ? 'La catégorie est modifiée ' : '' ?><p>
                                                                <div>
                                                                    <label for="update">Nom : </label>
                                                                    <input name="update" type="text" id="update" required class="validate" value="<?= $productcategory->productCategory_name ?>" />
                                                                    <div>
                                                                        <span class="error"><?= isset($errorArray['update']) ? $errorArray['update'] : ''; ?></span>
                                                                    </div>
                                                                </div>
                                                                <input name="updateCatButton" type="submit" class="btn modal-close" value="Modifier"/>
                                                            </fieldset>
                                                        </form>
                                                    </div>
                                                </div>
                                            <?php } ?> 
                                        </div>
                                    </li>
                                    <li>
                                        <div class="collapsible-header">
                                            <i class="material-icons">place</i>
                                            Produits
                                            <a class="waves-effect waves-light btn modal-trigger right btnright" href="#modalAddProd">Ajouter</a>
                                        </div>
                                        <div class="collapsible-body row">
                                            <!-- Modal Trigger AddProd -->                                            
                                            <?php foreach ($showProd AS $products) { ?>
                                                <div class="col s2 m2 l2">
                                                    <div class="card horizontal">
                                                        <div class="card-image">
                                                            <img src="../assets/img/<?= $products->products_image ?>" alt="<?= $products->products_description ?>">
                                                        </div>
                                                        <div class="card-stacked">
                                                            <div class="card-content">
                                                                <!-- Modal Trigger UpProd -->
                                                                <a class="modal-trigger" href="#modalUpProd<?= $products->products_id ?>"><?= $products->products_name ?></a>
                                                            </div>
                                                            <div class="card-action">
                                                                <a class="red darken-1" href="AdminPage.php?DeleteProd=<?= $products->products_id ?>" name="action">
                                                                    <i class="material-icons right">cancel</i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal Structure AddProd-->
                                                <div id="modalAddProd" class="modal">
                                                    <div class="modal-content">
                                                        <form name="AddProd" action="AdminPage.php" method="POST">
                                                            <fieldset>
                                                                <legend>Ajouter produits</legend>
                                                                <p class="center-align"><?= $addProdSuccess ? 'Le produit est ajouté ' : '' ?><p>
                                                                <div>
                                                                    <label for="products_name">Nom : </label>
                                                                    <input name="products_name" type="text" id="products_name" required class="validate" value="<?= isset($_POST['products_name']) ? $_POST['products_name'] : ''; ?>" />
                                                                    <div>
                                                                        <span class="error"><?= isset($errorArray['products_name']) ? $errorArray['products_name'] : ''; ?></span>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <label for="products_image">Image : </label>
                                                                    <input name="products_image" type="text" id="products_image" required class="validate" value="<?= isset($_POST['products_image']) ? $_POST['products_image'] : ''; ?>" />
                                                                    <div>
                                                                        <span class="error"><?= isset($errorArray['products_image']) ? $errorArray['products_image'] : ''; ?></span>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <label for="products_description">Description : </label>
                                                                    <input name="products_description" type="text" id="products_description" required class="validate" value="<?= isset($_POST['products_description']) ? $_POST['products_description'] : ''; ?>" />
                                                                    <div>
                                                                        <span class="error"><?= isset($errorArray['products_description']) ? $errorArray['products_description'] : ''; ?></span>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <label for="products_prix">Prix : </label>
                                                                    <input name="products_prix" type="text" id="products_prix" required class="validate" value="<?= isset($_POST['products_prix']) ? $_POST['products_prix'] : ''; ?>" />
                                                                    <div>
                                                                        <span class="error"><?= isset($errorArray['products_prix']) ? $errorArray['products_prix'] : ''; ?></span>
                                                                    </div>
                                                                </div>
                                                                <div class="input-field">
                                                                    <label for="productCategory_id">Catégorie : </label>
                                                                    <select id="productCategory_id" name="productCategory_id">
                                                                        <option value="0" disabled selected>Choix de la Catégorie</option>
                                                                        <?php foreach ($showCatProd AS $productcategory) { ?>
                                                                            <option value="<?= $productcategory->productCategory_id ?>"><?= $productcategory->productCategory_name ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <p class="error"><?= isset($errorArray['productCategory_id']) ? $errorArray['productCategory_id'] : '' ?></p>
                                                                </div>
                                                                <input type="submit" class="btn " name="AddProdButt" />
                                                            </fieldset>
                                                        </form>                                                            
                                                    </div>
                                                </div>
                                                <!-- Modal Structure UpProd-->
                                                <div id="modalUpProd<?= $products->products_id ?>" class="modal">
                                                    <div class="modal-content">
                                                        <form name="UpProd" action="AdminPage.php?idProdToUpdate=<?= $products->products_id ?>" method="POST">
                                                            <fieldset>
                                                                <legend>Modifier produits</legend>
                                                                <p class="center-align"><?= $upProdSuccess ? 'Le produit est modifié ' : '' ?><p>
                                                                <div>
                                                                    <label for="products_name">Nom : </label>
                                                                    <input name="products_name" type="text" id="products_name" required class="validate" value="<?= $products->products_name ?>" />
                                                                    <div>
                                                                        <span class="error"><?= isset($errorArray['products_name']) ? $errorArray['products_name'] : ''; ?></span>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <label for="products_image">Image : </label>
                                                                    <input name="products_image" type="text" id="products_image" required class="validate" value="<?= $products->products_image ?>" />
                                                                    <div>
                                                                        <span class="error"><?= isset($errorArray['products_image']) ? $errorArray['products_image'] : ''; ?></span>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <label for="products_description">Description : </label>
                                                                    <input name="products_description" type="text" id="products_description" required class="validate" value="<?= $products->products_description ?>" />
                                                                    <div>
                                                                        <span class="error"><?= isset($errorArray['products_description']) ? $errorArray['products_description'] : ''; ?></span>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <label for="products_prix">Prix : </label>
                                                                    <input name="products_prix" type="text" id="products_prix" required class="validate" value="<?= $products->products_prix ?>" />
                                                                    <div>
                                                                        <span class="error"><?= isset($errorArray['products_prix']) ? $errorArray['products_prix'] : ''; ?></span>
                                                                    </div>
                                                                </div>
                                                                <div class="input-field">
                                                                    <label for="productCategory_id">Catégorie : </label>
                                                                    <select id="productCategory_id" name="productCategory_id">
                                                                        <option value="0" disabled selected>Choix de la Catégorie</option>
                                                                        <?php foreach ($showCatProd AS $productcategory) { ?>
                                                                            <option value="<?= $products->productCategory_id ?>"><?= $productcategory->productCategory_name ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <p class="error"><?= isset($errorArray['productCategory_id']) ? $errorArray['productCategory_id'] : '' ?></p>
                                                                </div>
                                                                <div>
                                                                    <span class="error"><?= isset($errorArray['add']) ? $errorArray['add'] : ''; ?></span>
                                                                </div>
                                                                <input type="submit" class="btn " name="UpProdButt" />
                                                            </fieldset>
                                                        </form>                                                            
                                                    </div>
                                                </div>
                                            <?php } ?> 
                                        </div>
                                    </li>
                                </ul>
                            </fieldset>
                        </form>
                        <!--fin du col-->
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <?php include_once '../includes/footer.php'; ?>    
</body>
</html>