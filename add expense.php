<?php

require "functions.php";
check_login();


$errors = array();
$success = false;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $errors = expenses($_POST);

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
            <h2>Add Expense</h2>
            <label for="expenseName">Expense Name:</label>
            <input type="text" id="expenseName" name="expenseName" required>
            
            <label for="expenseAmount">Amount:</label>
            <input type="number"  min="0" id="expenseAmount" name="expenseAmount" required autocomplete="off">
            
            <label for="expenseDate">Date:</label>
            <input type="date" id="expenseDate" name="expenseDate" required>
            
            <button type="submit" name="expenses" type="submit" >Add Expense</button>
        </form>
    </div>
    <div id="popup" class="popup">
    <div class="popup-content">
        <h2>Success</h2>
        <p>Your expense has been added successfully.</p>
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



</body>
</html>
