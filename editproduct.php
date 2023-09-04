<?php

include('functions.php');
check_login();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();
    
    // Sanitize input fields
    $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_NUMBER_INT);
    $productName = filter_var($_POST['productName'], FILTER_SANITIZE_STRING);
    $productCost = filter_var($_POST['productCost'], FILTER_SANITIZE_STRING);
    $productPrice = filter_var($_POST['productPrice'], FILTER_SANITIZE_STRING);
    $productUnit = filter_var($_POST['productUnit'], FILTER_SANITIZE_STRING);
    $saleUnit= filter_var($_POST['saleUnit'], FILTER_SANITIZE_STRING);

    // Validate input fields
    if (empty($productName)) {
        $errors[] = 'full name is required';
    }


    
    

    // If no errors, update the $product in the database
    if (empty($errors)) {
        $product = array(
            'product_id' => $product_id ,
            'productName' => $productName,
            'productCost' => $productCost,
            'productPrice' => $productPrice,
            'productUnit' => $productUnit,
            'saleUnit' => $saleUnit,
        );
        update_product($product);
        header('Location: product history.php');
        die();
    }
}
    else {
        // If not submitted, get the product data from the database
        $product_id = filter_var($_GET['product_id'], FILTER_SANITIZE_NUMBER_INT);
        $product = get_products_by_id($product_id);
        if (!$product) {
            header('Location: product history.php');
            die();
        }
    } 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
   <link rel="stylesheet" href="styles.css">
    <title>Management Website</title>
</head>
<body>
<?php include "sidebar.php" ?>


<div class="content">
    <?php if (!empty($errors)) { ?>
        <div class="errors">
            <ul>
                <?php foreach ($errors as $error) { ?>
                    <li><?php echo $error; ?></li>
                <?php } ?>
            </ul>
        </div>
        <?php } ?>
        <form method="post" class="add-expense-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <h2>Edit Product</h2>
    <input type="hidden" name="product_id" value="<?php echo $product->product_id; ?>">

        <label for="productName">Product Name:</label>
        <input type="text" id="productName" name="productName" required value="<?php echo htmlspecialchars($product->productName); ?>" ><br>
        <!-- <p>y kwao</p> -->

        <label for="productCost">Product Cost:</label>
        <input type="number"  min="0" id="productCost" name="productCost" required value="<?php echo htmlspecialchars($product->productCost); ?>"><br>

        <label for="productPrice">Product Price:</label>
        <input type="number"  min="0" id="productPrice" name="productPrice" required value="<?php echo htmlspecialchars($product->productPrice); ?>"><br>
        
        <label for="productUnit">Product Unit:</label>
        <input type="number" id="productUnit"  min="0" name="productUnit" required  value="<?php echo htmlspecialchars($product->productUnit); ?>"><br>

        <label for="saleUnit">Sale Price:</label>
        <input type="number" id="saleUnit"  min="0" name="saleUnit" required  value="<?php echo htmlspecialchars($product->productUnit); ?>"><br>

        <button type="submit" name="update_product">Add Product</button>
    </form>
</div>
</div>
    <div id="popup" class="popup">
    <div class="popup-content">
        <h2>Success</h2>
        <p>Your product has been edited successfully.</p>
        <button id="popup-close">OK</button>
    </div>
</div>
<script>
        // JavaScript to show and hide the popup
    document.addEventListener("DOMContentLoaded", function () {
        const popup = document.getElementById("popup");
        const popupClose = document.getElementById("popup-close");

        // Show popup when form is successfully submitted
        <?php if (count($errors) == 0) { ?>
        popup.style.display = "block";
        <?php } ?>

        // Close popup when "OK" button is clicked
        popupClose.addEventListener("click", function () {
            popup.style.display = "none";
        });
    });
</script>