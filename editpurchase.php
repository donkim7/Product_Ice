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
    $purchase_id = filter_var($_POST['purchase_id'], FILTER_SANITIZE_NUMBER_INT);
    $purchaseDate = filter_var($_POST['purchaseDate'], FILTER_SANITIZE_STRING);
    $itemsPurchased = filter_var($_POST['itemsPurchased'], FILTER_SANITIZE_STRING);
    $purchasePrice = filter_var($_POST['purchasePrice'], FILTER_SANITIZE_STRING);
    $purchaseQuantity = filter_var($_POST['purchaseQuantity'], FILTER_SANITIZE_STRING);

    // Validate input fields
    if (empty($purchaseDate)) {
        $errors[] = 'full name is required';
    }
    

    // If no errors, update the $purchase in the database
    if (empty($errors)) {
        $purchase = array(
            'purchase_id' => $purchase_id ,
            'purchaseDate' => $purchaseDate,
            'itemsPurchased' => $itemsPurchased,
            'purchasePrice' => $purchasePrice,
            'purchaseQuantity' => $purchaseQuantity,
        );
        update_purchase($purchase);
        header('Location: purchase history.php');
        die();
    }
}
    else {
        // If not submitted, get the purchase data from the database
        $purchase_id = filter_var($_GET['purchase_id'], FILTER_SANITIZE_NUMBER_INT);
        $purchase = get_purchases_by_id($purchase_id);
        if (!$purchase) {
            header('Location: purchase history.php');
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
            <form method="post" class="add-espense-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <h2>Edit purchase</h2>
    <input type="hidden" name="purchase_id" value="<?php echo $purchase->purchase_id; ?>">

        <label for="purchaseDate">Date:</label>
        <input type="date" id="purchaseDate" name="purchaseDate" required value="<?php echo htmlspecialchars($purchase->purchaseDate); ?>" ><br>
        <!-- <p>y kwao</p> -->

        <label for="purchaseCost">Items Purchased:</label>
        <input type="text" id="purchaseCost"   name="itemsPurchased" required value="<?php echo htmlspecialchars($purchase->itemsPurchased); ?>"><br>

        <label for="purchasePrice">Price:</label>
        <input type="number"  min="0" id="purchasePrice" name="purchasePrice" required value="<?php echo htmlspecialchars($purchase->purchasePrice); ?>"><br>
        
        <label for="purchaseQuantity">Quantity:</label>
        <input type="number" id="purchaseQuantity" step="10" min="0" name="purchaseQuantity" required  value="<?php echo htmlspecialchars($purchase->purchaseQuantity); ?>"><br>

        <button type="submit" name="update_purchase">Add purchase</button>
    </form>
</div>
</div>
    <div id="popup" class="popup">
    <div class="popup-content">
        <h2>Success</h2>
        <p>Your purchase has been edited successfully.</p>
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