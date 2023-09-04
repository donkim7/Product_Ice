<?php
require "functions.php";
check_login();

$purchases = get_all_purchases();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
   <link rel="stylesheet" href="styles.css">
    <title>Management Website</title>
    <style>
    button a {
    color: white;
    text-decoration: none;
}
</style>
</head>
<body>
<?php include "sidebar.php" ?>

    <div class="history-list" >
    <h2>Purchases List</h2>
    <input type="text" placeholder="Search" id="myInput" >
    <div class="date-range-dropdown">
        <label for="dateRange">Select Date Range:</label>
        <select id="dateRange">
            <option value="today">Today</option>
            <option value="yesterday">Yesterday</option>
            <option value="weekly">Weekly</option>
            <option value="monthly">Monthly</option>
        </select>
    </div>
    <table class="product-table" id="myTable" >
    <thead>
            <tr>
                <th>Date</th>
                <th>Items</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                    // Loop through the data and display it in the table
                    foreach ($purchases as $purchase) {
                        echo "<tr>";
                        echo "<td>" . $purchase->purchaseDate . "</td>";
                        echo "<td>" . $purchase->itemsPurchased . "</td>";
                        echo "<td>" . $purchase->purchasePrice . "</td>";
                        echo "<td>" . $purchase->purchaseQuantity . "</td>";
                        echo "<td>";
                        echo "<button><a href='editpurchase.php?purchase_id=" . $purchase->purchase_id . "' class='edit-button'>Edit</a> </button>";
                        echo "<button> <a href='deletepurchase.php?purchase_id=" . $purchase->purchase_id . "' class='delete-button'>Delete</a></button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
            <!-- Add more rows here as needed -->
        </tbody>
    </table>
</div>
<script>
function searchTable() {
    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those that don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1]; // Search in the first column (Product Name)
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

// Attach the search function to the input field's "keyup" event
document.getElementById("myInput").addEventListener("keyup", searchTable);





// Function to initially show only today's expenses
function showTodaysExpenses() {
    var table, tr, td, i, dateCell, dateString;
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        dateCell = tr[i].getElementsByTagName("td")[0]; // Date is in the 3rd column
        if (dateCell) {
            dateString = dateCell.textContent || dateCell.innerText;
            
            if (dateString === getCurrentDate()) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
// Call the function to show only today's expenses when the page is loaded
showTodaysExpenses();



// Function to filter by date range
function filterByDateRange(range) {
    var table, tr, td, i, dateCell, dateString;
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        dateCell = tr[i].getElementsByTagName("td")[0]; // Date is in the 3rd column
        if (dateCell) {
            dateString = dateCell.textContent || dateCell.innerText;

            // Adjust the condition based on the selected range
            if (range === "today" && dateString === getCurrentDate()) {
                tr[i].style.display = "";
            } else if (range === "yesterday" && dateString === getYesterdayDate()) {
                tr[i].style.display = "";
            } else if (range === "weekly" && isDateInCurrentWeek(dateString)) {
                tr[i].style.display = "";
            } else if (range === "monthly" && isDateInCurrentMonth(dateString)) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}


// Attach change event to the date range dropdown
document.getElementById("dateRange").addEventListener("change", function () {
    var selectedRange = this.value;
    console.log("Selected Range: " + selectedRange); // Debugging line
    if (selectedRange === "today") {
        showTodaysExpenses();
    } else {
        filterByDateRange(selectedRange);
    }
});



// Function to get the current date in YYYY-MM-DD format
function getCurrentDate() {
    var today = new Date();
    var yyyy = today.getFullYear();
    var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
    var dd = String(today.getDate()).padStart(2, '0');
    return yyyy + '-' + mm + '-' + dd;
}

// Function to get yesterday's date in YYYY-MM-DD format
function getYesterdayDate() {
    var today = new Date();
    today.setDate(today.getDate() - 1);
    var yyyy = today.getFullYear();
    var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
    var dd = String(today.getDate()).padStart(2, '0');
    return yyyy + '-' + mm + '-' + dd;
}


// Function to check if a date is in the current week
function isDateInCurrentWeek(dateString) {
    var date = new Date(dateString);
    var today = new Date();

    var currentWeek = getWeekNumber(today);
    var dateWeek = getWeekNumber(date);

    return currentWeek === dateWeek;
}

// Function to check if a date is in the current month
function isDateInCurrentMonth(dateString) {
    var date = new Date(dateString);
    var today = new Date();

    return (
        date.getFullYear() === today.getFullYear() &&
        date.getMonth() === today.getMonth()
    );
}

// Function to get the week number of a date
function getWeekNumber(date) {
    var d = new Date(Date.UTC(date.getFullYear(), date.getMonth(), date.getDate()));
    var dayNum = d.getUTCDay() || 7;
    d.setUTCDate(d.getUTCDate() + 4 - dayNum);
    var yearStart = new Date(Date.UTC(d.getUTCFullYear(), 0, 1));
    return Math.ceil((((d - yearStart) / 86400000) + 1) / 7);
}


</script>