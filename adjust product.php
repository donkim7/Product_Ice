<?php

include('functions.php');
check_login();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$success = false; // Initialize the success flag
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
        $success = true; // Set the success flag to true

    }
}
    // else {
    //     // If not submitted, get the product data from the database
    //     $product_id = filter_var($_GET['product_id'], FILTER_SANITIZE_NUMBER_INT);
    //     $product = get_products_by_id($product_id);
    //     if (!$product) {
    //         header('Location: product history.php');
    //         die();
    //     }
    // } 

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
    
    <form class="add-expense-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <h2>Update Product</h2>
        <input type="hidden" id="productId" name="product_id" required><br>
        
        <label for="productName">Product Name:</label>
        <div id="saleItemContainer">
        <input list="productList" type="text" id="productName" name="productName" required autocomplete="off" onkeyup="search()" ><br>
        <div id="resultsDropdown"></div>
        </div>

        <label for="productCost">Product Cost:</label>
        <input type="number"  min="0" id="productCost" name="productCost" required ><br>

        <label for="productPrice">Product Price:</label>
        <input type="number"  min="0" id="productPrice" name="productPrice" required><br>

        <label for="productUnit">Product Unit:</label>
        <input type="number" id="productUnit" min="0" name="productUnit" required><br>

        <label for="saleUnit">Sale Price:</label>
        <input type="number" id="saleUnit"  min="0" name="saleUnit" required><br>

        <button type="submit" name="update_products">Update Product</button>
    </form>
</div>
    <div id="popup" class="popup">
    <div class="popup-content">
        <h2>Success</h2>
        <p>Your product has been updated successfully.</p>
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



<script>



function search() {
    var input = document.getElementById("productName").value;
    var resultsDropdown = document.getElementById("resultsDropdown");

    if (input.length === 0) {
        resultsDropdown.innerHTML = "";
        return;
    }

    // Make an AJAX request to the server to get search results
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            resultsDropdown.innerHTML = this.responseText;
            
// Attach a click event to each dropdown option
var dropdownOptions = resultsDropdown.getElementsByClassName("dropdown-option");
for (var i = 0; i < dropdownOptions.length; i++) {
    dropdownOptions[i].addEventListener("click", function() {
        document.getElementById("productName").value = this.textContent;
        var saleUnit = this.getAttribute("data-price");
        document.getElementById("saleUnit").value = saleUnit;
        var productCost = this.getAttribute("data-cost");
        document.getElementById("productCost").value = productCost;
        var productPrice = this.getAttribute("data-total");
        document.getElementById("productPrice").value = productPrice;
        var productUnit = this.getAttribute("data-unit");
        document.getElementById("productUnit").value = productUnit;
        var productId = this.getAttribute("data-id");
        document.getElementById("productId").value = productId;
        resultsDropdown.innerHTML = "";
    });
}

        }
    };
    xmlhttp.open("GET", "search.php?q=" + input, true);
    xmlhttp.send();
}

// ... (existing code)

// Add a click event listener to the document
document.addEventListener("click", function(event) {
    var saleItemContainer = document.getElementById("saleItemContainer");
    var resultsDropdown = document.getElementById("resultsDropdown");

    // Check if the clicked element is outside the saleItemContainer and the resultsDropdown
    if (!saleItemContainer.contains(event.target) && !resultsDropdown.contains(event.target)) {
        resultsDropdown.innerHTML = ""; // Hide the dropdown
    }
});


</script>
</body>
</html>
