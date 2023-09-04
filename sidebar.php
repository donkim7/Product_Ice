<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="dashboard.css">
    <title>Management Website</title>
</head>
<body>


<div class="sidebar">
        <h2>Management</h2>
        <ul>
        <h3><a href="dashboard.php" ><i class="dashboard-link"></i> Dashboard</a></h3>

            <li class="dropdown">
                <a><i class="fas fa-box"></i> Products</a>
                <ul class="dropdown-content">
                    <li><a href="add product.php">Add Product</a></li>
                    <li><a href="product history.php">Product List</a></li>
                    <!-- <li><a href="stock count.php" >Stock Count</a></li> -->
                    <li><a href="adjust product.php" >Adjust Product</a></li>
                </ul>
            </li>
    
            <li class="dropdown">
                <a><i class="fas fa-shopping-cart"></i> Purchase</a>
                <ul class="dropdown-content">
                    <li><a href="add purchase.php">Add Purchase</a></li>
                    <li><a href="purchase history.php">Purchase History</a></li>
                </ul>
            </li>
    
            <li class="dropdown">
                <a><i class="fas fa-chart-line"></i> Sales</a>
                <ul class="dropdown-content">
                    <li><a href="new sales.php">New Sale</a></li>
                    <li><a href="sale history.php">Sale History</a></li>
                </ul>
            </li>
    
            <li class="dropdown">
                <a><i class="fas fa-money-bill-alt"></i> Expenses</a>
                <ul class="dropdown-content">
                    <li><a href="add expense.php">Add Expense</a></li>
                    <li><a href="expense history.php">Expense List</a></li>
                </ul>
            </li>
            <li>
                <i class="fas fa-sign-out-alt"></i><a href="logout.php">Logout</a>

            </li>
        </ul>
    </div>
    <script src="js.js"></script>
