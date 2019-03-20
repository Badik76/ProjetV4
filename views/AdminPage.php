<?php
// Start the session
session_start();
require_once '../controllers/AdminPageController.php';
?>
<!DOCTYPE html>
<html lang="fr">
    <?php include_once '../includes/header.php'; ?>
    <?php
    if (isset($_SESSION['isAdmin'])) {
        ?>
        <div class="container center">
            <ul class="collapsible expandable ">
                <li id="colUser" class="<?= $showme ?>">
                    <div class="collapsible-header center">
                        <h2><i class="material-icons">group</i>Carnet Clients<i class="material-icons">group</i></h2>
                    </div>
                    <div class="collapsible-body">
                        <p class="center-align"><?= $superUserOK ? 'L\'utilisateur est un superUser' : '' ?><p>
                        <p class="center-align"><?= $superUserDEL ? 'L\'utilisateur n\'est plus superUser' : '' ?><p>
                        <p class="center-align"><?= $deleteOk ? 'L\'utilisateur a été supprimé' : '' ?><p>
                            <?php if ($noMatch) { ?>
                            <p class="center-align"><?= $noMatchMessage ?></p>
                        <?php } else { ?>
                            <table class="highlight responsive-table">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Anniversaire</th>
                                        <th>Email</th>
                                        <th>Téléphone</th>
                                        <th>Super Utilisateur</th>
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
                                                <?php if ($users->typeUsers_id !== '2') { ?>
                                                    <a class="btn collUser" href="AdminPage.php?GetUserSuperUser=<?= $users->users_id ?>" name="action">Mettre
                                                        <i class="large material-icons right">mood</i>
                                                    </a>
                                                <?php } else { ?>
                                                    <a class="btn orange" href="AdminPage.php?DelSuperUser=<?= $users->users_id ?>" name="action">Enlever
                                                        <i class="large material-icons right">mood_bad</i>
                                                    </a> 
                                                <?php } ?>                                                    
                                                <a class="btn red darken-1 collUser" href="AdminPage.php?deleteThis=<?= $users->users_id ?>" name="action">Supprimer
                                                    <i class="large material-icons right">cancel</i>
                                                </a>                                                
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

                <li class="<?= $showme5 ?>">
                    <div class="collapsible-header">
                        <h2><i class="material-icons">group</i>Calendrier<i class="material-icons">group</i></h2>
                    </div>          
                    <div class="collapsible-body">
                        <form action="AdminPage.php" method="POST">
                            <?php
                            //création d'un tableau correspondant au mois de l'année
                            $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
                            ?>
                            <select name="month">
                                <?php
                                $indice = 1;
                                foreach ($months as $month) {
                                    ?>
                                    <option 
                                    <?php
                                    if (empty($_POST['month'])) {
                                        echo '';
                                    } elseif ($_POST['month'] == $indice) {
                                        // Selected permet de garder en mémoire l'année ou le mois séléctionné.
                                        echo 'selected';
                                    };
                                    ?> value="<?php echo $indice++ ?>">
                                        <?php echo $month; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <select name="years">
                                <?php
                                // implémentation des années comprises dans le calendrier.
                                for ($year = 2019; $year <= 2150; $year++) {
                                    ?>
                                    <option <?php
                                    // si aucun choix affichage de l'année en cours
                                    if (empty($_POST['years']) && ($year == date('Y'))) {
                                        echo 'selected';
                                        //si selection affichage de la date sélectionée
                                    } elseif (!empty($_POST['years']) && $_POST['years'] == $year) {
                                        // Selected garde en mémoire la date sélectionée.
                                        echo 'selected';
                                    };
                                    ?> value="<?php echo $year ?>"><?php echo $year; ?></option>
                                        <?php
                                    }
                                    ?>
                            </select>
                            <input class="btn btn-primary" name="CalendarButt" type="submit" value="Valider"/>
                        </form>
                        <div class="container">                            
                            <?php
                            //si le mois et l'année ne sont pas vide :
                            if (isset($_POST['month']) && isset($_POST['years'])) {
                                // cal_days_in_month compte le nombre de jours dans un mois.
                                // CAL_GREGORIAN est une référence au calendrier grégorien.
                                $calendar = cal_days_in_month(CAL_GREGORIAN, $_POST['month'], $_POST['years']);
                                // tableau des jours de la semaine.
                                $daysOfWeek = ['LUNDI', 'MARDI', 'MERCREDI', 'JEUDI', 'VENDREDI', 'SAMEDI', 'DIMANCHE'];
                                //$firstDay = le premier jour du mois.
                                $firstDay = date('w', mktime(0, 0, 0, $_POST['month'], 1, $_POST['years']));
                                //$lastDay = le dernier jour du mois.
                                $lastDay = date('w', mktime(0, 0, 0, $_POST['month'], $calendar, $_POST['years']));
                                //$differenceLastDay = différence des jours restant dans la dernière semaine.
                                $differenceInWeek = 7 - $lastDay;
                                ?>
                                <table>
                                    <?php
                                    if (isset($_POST['month']) && isset($_POST['years'])) {
                                        ?>
                                        <h2><?php echo $months[$_POST['month'] - 1] . ' ' . $_POST['years']; ?></h2>
                                        <?php
                                    }
                                    ?>
                                    <tr>
                                        <?php
                                        foreach ($daysOfWeek as $inWeek) {
                                            ?>
                                            <th class="col-lg-1"><?php echo $inWeek; ?></th>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                    // dimanche est égal au jour 7 de la semaine vu que date() le considère comme le premier
                                    if ($firstDay == 0) {
                                        $firstDay = 7;
                                    }
                                    $days = 1;
                                    // création du tableau
                                    for ($i = 1; $i <= $calendar + ($firstDay - 1); $i++) {
                                        if ($i % 7 == 1) {
                                            ?>
                                            <tr> 
                                                <?php
                                            }
                                            if ($i >= $firstDay) {
                                                ?>
                                                <td><?php
                                                    echo $days;
                                                    $days++;
                                                    ?></td>
                                                <?php
                                            } else {
                                                ?>
                                                <td class="noDays"></td>
                                                <?php
                                            }
                                        }
                                        // Calcul des derniers jours du mois si vide.
                                        for ($a = 1; $a <= $differenceInWeek; $a++) {
                                            if ($a < $calendar && $lastDay != 0) {
                                                ?>
                                                <td></td>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                            </table>
                        </div>
                    </div>
                </li>

                <li class="<?= $showme2 ?>">
                    <div class="collapsible-header">
                        <h2><i class="material-icons">spa</i>RDV's à Valider<i class="material-icons">spa</i></h2>
                    </div>
                    <div class="collapsible-body">                        
                        <ul class="collapsible col l12">
                            <?php foreach ($listPrestations AS $prestations) { ?>
                                <li class="<?= $showrdvcat ?>">
                                    <div class="collapsible-header">
                                        <i class="material-icons">filter_drama</i>
                                        <p><?= $prestations->prestations_name ?></p>
                                        <span class="badge">if Resa.id +1 = count!= Resa.id.length echo Resa</span></div>
                                    <div class="collapsible-body row">
                                        <?php
                                        foreach ($resultList AS $daterdv) {
                                            if ($prestations->prestations_id !== $daterdv->prestations_id) {
                                                
                                            } else {
                                                ?>
                                                <div class="col s6 m3 l3">
                                                    <div class="card horizontal">
                                                        <div class="card-content">
                                                            <p><b><?= $daterdv->dateRDV_dateRDV ?></b> de <?= $daterdv->timeRDV_timeRDV ?>
                                                                <?= $daterdv->users_firstname ?>  <?= $daterdv->users_lastname ?> 
                                                                0<?= $daterdv->users_phone ?>  <?= $daterdv->prestations_name ?></p>
                                                            <a href="AdminPage.php?DeleteRDV=<?= $daterdv->users_id ?>" name="action">
                                                                <i class="material-icons left red-text">cancel</i>                                                           
                                                            </a>
                                                            <a class="green darken-1" href="AdminPage.php?ValideRDV=<?= $daterdv->dateRDV_id ?>" name="action">
                                                                <i class="material-icons right green-text">check</i>
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
                        <h2><i class="material-icons">shopping_basket</i>Gestion des Produits<i class="material-icons">shopping_basket</i></h2>
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
                                                <p>Catégories</p>                                                
                                            </div>
                                            <div class="collapsible-body row">
                                                <!-- Modal Trigger AddCat -->
                                                <?php foreach ($showCatProd AS $productcategory) { ?>
                                                    <div class="col s6 m3 l3">
                                                        <div class="card">
                                                            <div class="card-content">
                                                                <!-- Modal Trigger UpCat -->
                                                                <a class="modal-trigger btn " href="#modalUpCat<?= $productcategory->productCategory_id ?>"><?= $productcategory->productCategory_name ?></a>                                                                
                                                                <a class="red darken-1 btn" href="AdminPage.php?DeleteCatProd=<?= $productcategory->productCategory_id ?>" name="action">
                                                                    <i class="material-icons">cancel</i>
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
                                                <div class="col s6 m2 l2">
                                                    <div class="card">
                                                        <div class="card-content">
                                                            <!-- Modal Trigger UpCat -->
                                                            <a class="waves-effect waves-light btn modal-trigger btnright" href="#modalAddCat">Ajouter</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="collapsible-header">
                                                <i class="material-icons">place</i>
                                                <p>Produits <p>                                              
                                            </div>
                                            <div class="collapsible-body row">

                                                <?php foreach ($showProd AS $products) { ?>
                                                    <div class="col s6 m3 l3">
                                                        <div class="card horizontal">
                                                            <div class="card-image">
                                                                <img src="../assets/img/<?= $products->products_image ?>" alt="<?= $products->products_description ?>">
                                                            </div>
                                                            <div class="card-stacked">
                                                                <div class="card-content">
                                                                    <!-- Modal Trigger UpProd -->
                                                                    <a class="modal-trigger btn" href="#modalUpProd<?= $products->products_id ?>"><?= $products->products_name ?></a>
                                                                </div>
                                                                <div class="card-action">
                                                                    <a class="red darken-1 btn" href="AdminPage.php?DeleteProd=<?= $products->products_id ?>" name="action">
                                                                        <i class="material-icons">cancel</i>
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
                                                                        <?php foreach ($showCatProd AS $productcategory) { ?>
                                                                            <p class="col s6 m3 l3">
                                                                                <label>
                                                                                    <input value="<?= $productcategory->productCategory_id ?>" name="productCategory_id" type="radio" />
                                                                                    <span><?= $productcategory->productCategory_name ?></span> 
                                                                                </label>
                                                                            </p>
                                                                        <?php } ?>
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
                                                                        <?php foreach ($showCatProd AS $productcategory) { ?>
                                                                            <p class="col s6 m3 l3">
                                                                                <label>
                                                                                    <input value="<?= $productcategory->productCategory_id ?>" name="productCategory_id" type="radio" />
                                                                                    <span><?= $productcategory->productCategory_name ?></span> 
                                                                                </label>
                                                                            </p>
                                                                        <?php } ?>
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
                                                <div class="col s6 m2 l2">
                                                    <div class="card">
                                                        <div class="card-content">
                                                            <!-- Modal Trigger AddProd --> 
                                                            <a class="waves-effect waves-light btn modal-trigger btnright" href="#modalAddProd">Ajouter</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </fieldset>
                            </form>
                            <!--fin du col-->
                        </div>
                    </div>
                <li class="<?= $showme4 ?>">
                    <div class="collapsible-header">                        
                        <h2><i class="material-icons">comment</i>Gestion des Commentaires<i class="material-icons">comment</i></h2>
                    </div>
                    <div class="collapsible-body">
                        <p class="center-align"><?= $deletecommentOk ? 'Le commentaire est effacé' : '' ?><p>
                        <table class="highlight responsive-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Commentaire</th>
                                    <th>Valider</th>
                                    <th>Supprimer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($commentsList AS $comments) { ?>
                                    <tr>
                                        <td><?= $comments->dateRDV_dateRDV ?></td>
                                        <td><?= $comments->users_lastname ?></td>
                                        <td><?= $comments->users_firstname ?></td>
                                        <td><?= $comments->comments_comment ?></td>
                                        <td>
                                            <a class="btn darken-1" href="AdminPage.php?ValideComment=<?= $comments->comments_id ?>" name="action"> Valider
                                                <i class="material-icons right">check</i>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn red darken-1 collUser" href="AdminPage.php?deleteComment=<?= $comments->comments_id ?>" name="action">Supprimer
                                                <i class="large material-icons right">cancel</i>
                                            </a>                                        
                                        </td>        
                                    </tr>
                                <?php } ?><!-- fin de la boucle for each -->
                            </tbody>
                        </table>
                    </div>
                </li>
            </ul>
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
