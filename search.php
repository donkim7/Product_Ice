<?php
// Connect to the database (replace with your own credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "productice";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search query from the URL parameter
$query = $_GET["q"];

// Perform a database query to fetch product names and prices
$sql = "SELECT product_id, productName, productCost, productPrice, productUnit, saleUnit FROM products WHERE productName LIKE '%$query%' LIMIT 15";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display search results as dropdown options
    while ($row = $result->fetch_assoc()) {
        // echo "<p class='dropdown-option' data-price='" . $row["saleUnit"] . "'>" . $row["productName"] . "</p>";
        echo "<p class='dropdown-option' data-price='" . $row["saleUnit"] . "' data-cost='" . $row["productCost"] . "' data-total='" . $row["productPrice"] . "' data-unit='" . $row["productUnit"] . "' data-id='" . $row["product_id"] . "'>" . $row["productName"] . "</p>";

    }
} else {
    echo "No results found";
}
$result = $conn->query($sql);

if (!$result) {
    die("Query error: " . $conn->error);
}
$conn->close();

?>




