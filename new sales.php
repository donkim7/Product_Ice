<?php
ini_set('display_errors', 3);
error_reporting(E_ALL);

require "functions.php";
check_login();



$errors = array();
$success = false;
if($_SERVER['REQUEST_METHOD'] == "POST")
{

	$errors = sales($_POST);


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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link rel="stylesheet" href="styles.css">
    <title>Management Website</title>


</head>
<body>
<?php include "sidebar.php" ?>

<div class="content">
    
    <form class="add-expense-form" method="post">
        <h2>New Sale</h2>
        <label for="saleDate">Date:</label>
        <input type="date" id="saleDate" name="saleDate" required>

        <label for="saleItem">Item:</label>

        <div id="saleItemContainer">
        <input list="productList" type="text" id="saleItem" name="saleItem" required autocomplete="off" onkeyup="search()">
        <div id="resultsDropdown"></div>
        </div>

        <label for="clientName">Client's Name:</label>
        <input type="text" id="clientName" name="clientName" required>
        
        <label for="saleQuantity">Quantity:</label>
<input type="number" id="saleQuantity" min="0" name="saleQuantity" required oninput="calculateTotalPrice()">
<input type="hidden" id="productUnit">
<span id="productUnitDisplay" style="color: grey;"></span>


        <label for="saleUnit">Unit Price:</label>
        <input type="number" id="saleUnit"  min="0" name="saleUnit" required oninput="calculateTotalPrice()">

        <label for="salePrice">Total Price:</label>
        <input type="number" style="color: blue;"  min="0" id="salePrice" name="salePrice" value="" required readonly>

        <button type="submit" name="sales">Add Sale</button>

    </form>
</div>

</div>
    <div id="popup" class="popup">
    <div class="popup-content">
        <h2>Success</h2>
        <p>Your Sale has been added successfully.</p>
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
function calculateTotalPrice() {
    // Get the values of saleQuantity, saleUnit, and productUnit
    var quantityInput = document.getElementById("saleQuantity");
    var unitPriceInput = document.getElementById("saleUnit");
    var productUnitInput = document.getElementById("productUnit");

    var quantity = parseFloat(quantityInput.value);
    var unitPrice = parseFloat(unitPriceInput.value);
    var productUnit = parseFloat(productUnitInput.value);

    // Check if the input values are valid numbers
    if (isNaN(quantity) || isNaN(unitPrice) || isNaN(productUnit)) {
        return; // Exit the function if any input is not a number
    }

    // Calculate the total price
    var totalPrice = quantity * unitPrice;

    // Update the salePrice field with the calculated total price
    document.getElementById("salePrice").value = totalPrice.toFixed(2); // Format to two decimal places

    // Calculate the remaining productUnit and update the display
    var remainingProductUnit = productUnit - quantity;
    var productUnitDisplay = document.getElementById("productUnitDisplay");
    productUnitDisplay.textContent = "Remaining: " + remainingProductUnit;

    // Change text color to red if quantity is greater than productUnit
    if (remainingProductUnit < 0) {
        productUnitDisplay.style.color = "red";
    } else {
        productUnitDisplay.style.color = "grey";
    }
}








function search() {
    var input = document.getElementById("saleItem").value;
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
        document.getElementById("saleItem").value = this.textContent;
        var saleUnit = this.getAttribute("data-price");
        document.getElementById("saleUnit").value = saleUnit;

        var productUnit = this.getAttribute("data-unit");
        document.getElementById("productUnit").value = productUnit;       
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
