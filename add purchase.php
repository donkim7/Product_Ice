<?php

require "functions.php";
check_login();


$errors = array();
$success = false;

if($_SERVER['REQUEST_METHOD'] == "POST")
{

	$errors = purchases($_POST);

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
        <h2>Add Purchase</h2>
        <label for="purchaseDate">Date:</label>
        <input type="date" id="purchaseDate" name="purchaseDate" required>

        <label for="itemsPurchased">Items Purchased:</label>
        <input type="text" id="itemsPurchased" name="itemsPurchased" required>

        <label for="purchasePrice">Price:</label>
        <input type="number"  min="0" id="purchasePrice" name="purchasePrice" required>

        <label for="purchaseQuantity">Quantity:</label>
        <input type="number"  min="0" id="purchaseQuantity" name="purchaseQuantity" required>

        <button type="submit" name="purchases" >Add Purchase</button>
    </form>
</div>
</div>
    <div id="popup" class="popup">
    <div class="popup-content">
        <h2>Success</h2>
        <p>Your purchase has been added successfully.</p>
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