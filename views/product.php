<?php
// Start the session
session_start();
require_once '../controllers/productController.php';
?>
<!DOCTYPE html>
<html lang="fr">
    <?php include_once '../includes/header.php'; ?>  
    <div class="container center">
        <div class="row">
            <h2 class="soft-white">Notre catalogue</h2>
            <div class="row" id="categoryproductList">
                <?php foreach ($showCatProd as $productcategory) { ?>
                    <a href="product.php?productCategory_id=<?= $productcategory->productCategory_id ?>" class="waves-effect waves-dark btn backgroundcolor white-text"><?= $productcategory->productCategory_name ?></a>
                <?php } ?>
            </div> 
            <div class="row">
                <?php
                foreach ($findProd as $products) {
                    ?>
                    <div class="col s6 m4 l4">
                        <div class="card">
                            <div class="card-image">
                                <img class="responsive-img-products" src="../assets/img/<?= $products->products_image ?>" alt="<?= $products->products_description ?>" />
                            </div>
                            <p class="center-align card-title truncate dark-blue-text rem13"><?= $products->products_name ?></p>
                            <div class="divider"></div>
                            <div class="card-content">
                                <p class="truncate"><?= $products->products_description ?></p>
                            </div>
                            <div class="divider"></div>
                            <div class="card-content backgroundcolor">
                                <p class="truncate white-text"><b><?= $products->products_prix ?> €</b></p>
                                <div class="row">
<!--                                    <div class="col s6">
                                        <a class="hide btn addNewProductInCart right waves-effect waves-light dark-blue tooltipped btn-floating" data-position="top" data-tooltip="Ajouter au panier" data-item-name="${products[prods].product}"><i class="material-icons">add_shopping_cart</i></a>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>                    
            </div>
        </div>
    </div>
    <?php include_once '../includes/footer.php'; ?>    
</body>
</html>