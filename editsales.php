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
    $sales_id = filter_var($_POST['sales_id'], FILTER_SANITIZE_NUMBER_INT);
    $saleDate = filter_var($_POST['saleDate'], FILTER_SANITIZE_STRING);
    $saleItem = filter_var($_POST['saleItem'], FILTER_SANITIZE_STRING);
    $clientName = filter_var($_POST['clientName'], FILTER_SANITIZE_STRING);
    $saleQuantity = filter_var($_POST['saleQuantity'], FILTER_SANITIZE_STRING);
    $saleUnit = filter_var($_POST['saleUnit'], FILTER_SANITIZE_STRING);
    $salePrice = filter_var($_POST['salePrice'], FILTER_SANITIZE_STRING);

    // Validate input fields
    if (empty($saleDate)) {
        $errors[] = 'full name is required';
    }

    

    // If no errors, update the $sale in the database
    if (empty($errors)) {
        $sale = array(
            'sales_id' => $sales_id ,
            'saleDate' => $saleDate,
            'saleItem' => $saleItem,
            'clientName' => $clientName,
            'saleQuantity' => $saleQuantity,
            'saleUnit' => $saleUnit,
            'salePrice' => $salePrice,
        );
        update_sale($sale);
        header('Location: sale history.php');
        die();
    }
}
    else {
        // If not submitted, get the sale data from the database
        $sales_id = filter_var($_GET['sales_id'], FILTER_SANITIZE_NUMBER_INT);
        $sale = get_sales_by_id($sales_id);
        if (!$sale) {
            header('Location: sale history.php');
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
                <h2>Edit sale</h2>
                <input type="hidden" name="sales_id" value="<?php echo $sale->sales_id; ?>">

        <label for="saleDate">Date:</label>
        <input type="date" id="saleDate" name="saleDate" required value="<?php echo htmlspecialchars($sale->saleDate); ?>" ><br>
        <!-- <p>y kwao</p> -->

        <label for="saleCost">Items sold:</label>
        <input type="text" id="saleCost" name="saleItem" required value="<?php echo htmlspecialchars($sale->saleItem); ?>"><br>

        <label for="saleCost">Client Name:</label>
        <input type="text" id="saleCost" name="clientName" required value="<?php echo htmlspecialchars($sale->clientName); ?>"><br>
 
        <label for="saleQuantity">Quantity:</label>
        <input type="number" id="saleQuantity" step="10" min="0" name="saleQuantity" required  oninput="calculateTotalPrice()"  value="<?php echo htmlspecialchars($sale->saleQuantity); ?>"><br>

        <label for="salePrice">Unit Price:</label>
        <input type="number"  min="0" id="saleUnit" name="saleUnit" required  oninput="calculateTotalPrice()" value="<?php echo htmlspecialchars($sale->saleUnit); ?>"><br>
                
        <label for="salePrice">Total Price:</label>
        <input type="number"  id="salePrice" name="salePrice" required value="<?php echo htmlspecialchars($sale->salePrice); ?>"><br>
 
        <button type="submit" name="update_sale">Add sale</button>
    </form>
</div>
</div>
    <div id="popup" class="popup">
    <div class="popup-content">
        <h2>Success</h2>
        <p>Your Sale has been edited successfully.</p>
        <button id="popup-close">OK</button>
    </div>
</div>

<script>
function calculateTotalPrice() {
    // Get the values of saleQuantity and saleUnit
    var quantity = parseFloat(document.getElementById("saleQuantity").value);
    var unitPrice = parseFloat(document.getElementById("saleUnit").value);

    // Calculate the total price
    var totalPrice = quantity * unitPrice;

    // Update the salePrice field with the calculated total price
    document.getElementById("salePrice").value = totalPrice.toFixed(2); // Format to two decimal places
}

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
</body>
</html>