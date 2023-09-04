<?php

require "functions.php";
check_login();

$errors = array();
$success = false;

if($_SERVER['REQUEST_METHOD'] == "POST")
{

	$errors = products($_POST);

    if (count($errors) == 0) {
        $success = true;
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
    
    <form class="add-expense-form" method="post">
        <h2>Add Product</h2>
        
        <label for="productName">Product Name:</label>
        <input type="text" id="productName" name="productName" required><br>
        <!-- <p>y kwao</p> -->

        <label for="productCost">Product Cost:</label>
        <input type="number"  min="0" id="productCost" name="productCost" required ><br>

        <label for="productPrice">Product Price:</label>
        <input type="number"  min="0" id="productPrice" name="productPrice" required><br>

        <label for="productUnit">Product Unit:</label>
        <input type="number" id="productUnit" min="0" name="productUnit" required><br>

        <label for="saleUnit">Sale Price:</label>
        <input type="number" id="saleUnit"  min="0" name="saleUnit" required><br>

        <button type="submit" name="products">Add Product</button>
    </form>
</div>
    <div id="popup" class="popup">
    <div class="popup-content">
        <h2>Success</h2>
        <p>Your product has been added successfully.</p>
        <button id="popup-close">OK</button>
    </div>
</div>
<script>
    // JavaScript to show and hide the popup
    document.addEventListener("DOMContentLoaded", function () {
        const popup = document.getElementById("popup");
        const popupClose = document.getElementById("popup-close");

        // Show popup when form is successfully submitted
        <?php if ($success) { ?>
        popup.style.display = "block";
        <?php } ?>

        // Close popup when "OK" button is clicked
        popupClose.addEventListener("click", function () {
            popup.style.display = "none";
        });
    });
</script>