<?php
// database connection
$host = 'localhost';
$dbname = 'productice';
$user = 'root';
$pass = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// get the date range from the user's selection
if (isset($_GET['range'])) {
    $range = $_GET['range'];
} else {
    $range = 'today'; // default value
}

switch ($range) {
    case 'today':
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d');
        break;
    case 'weekly':
        $startDate = date('Y-m-d', strtotime('-1 week'));
        $endDate = date('Y-m-d');
        break;
    case 'monthly':
        $startDate = date('Y-m-d', strtotime('-1 month'));
        $endDate = date('Y-m-d');
        break;
}



// Fetch revenue and income for the selected time range
$stmt = $db->prepare("SELECT saleDate, SUM(saleQuantity) AS totalSales FROM sales WHERE saleDate >= :startDate AND saleDate <= :endDate GROUP BY saleDate");
$stmt->execute(['startDate' => $startDate, 'endDate' => $endDate]);
$salesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch total expenses for the selected time range
$stmt = $db->prepare("SELECT expenseDate, SUM(expenseAmount) AS totalExpenses FROM expense WHERE expenseDate >= :startDate AND expenseDate <= :endDate GROUP BY expenseDate");
$stmt->execute(['startDate' => $startDate, 'endDate' => $endDate]);
$expensesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Combine sales and expenses data to calculate income
$incomeData = [];
foreach ($salesData as $saleItem) {
    $saleDate = $saleItem['saleDate'];
    $totalSales = $saleItem['totalSales'];

    // Find corresponding expenses data
    $matchingExpense = array_filter($expensesData, function ($expenseItem) use ($saleDate) {
        return $expenseItem['expenseDate'] === $saleDate;
    });

    $totalExpenses = empty($matchingExpense) ? 0 : reset($matchingExpense)['totalExpenses'];
    $income = $totalSales - $totalExpenses;

    $incomeData[] = ['saleDate' => $saleDate, 'income' => $income];
}

// Return revenue and income data as JSON
header('Content-Type: application/json');
echo json_encode(['revenue' => $salesData, 'income' => $incomeData]);


// // return data as a JSON object
// header('Content-Type: application/json');
// echo json_encode($data);
