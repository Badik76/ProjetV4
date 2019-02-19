<!--controller register-->
<?php
require_once '../models/database.php';
require_once '../models/users.php';
require_once '../models/productcategory.php';
require_once '../models/products.php';

// On instancie un nouvel $users objet comme classe patients
$users = new octopus_users();
// On instancie un nouvel $productcategory objet comme classe productcategory
$productcategory = new productcategory();
// On instancie un nouvel $products objet comme classe products
$products = new products();

// j'attribue la valeur du valeur $_GET à l'attribue idProdCat de l'objet $users et l'attribue idUser de l'objet $daterdv
if (isset($_GET['productCategory_id'])) {
    $products->productCategory_id = $_GET['productCategory_id'];
    $productcategory->productCategory_id = $_GET['productCategory_id'];
};

// On appel la methode showCatProd dans l'objet $showCatProd
$showCatProd = $productcategory->showCatProd();
// On appel la methode getProductByIdCat dans l'objet $findCatProd
$findProd = $products->getProductByIdCat();
?>