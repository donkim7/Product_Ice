<?php

include 'functions.php';
check_login();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();
    
    // Sanitize input fields
    $expense_id = filter_var($_POST['expense_id'], FILTER_SANITIZE_NUMBER_INT);
    $expenseName = filter_var($_POST['expenseName'], FILTER_SANITIZE_STRING);
    $expenseAmount = filter_var($_POST['expenseAmount'], FILTER_SANITIZE_STRING);
    $expenseDate = filter_var($_POST['expenseDate'], FILTER_SANITIZE_STRING);

    // Validate input fields
    if (empty($expenseDate)) {
        $errors[] = 'full name is required';
    }
    

    // If no errors, update the $expense in the database
    if (empty($errors)) {
        $expense = array(
            'expense_id' => $expense_id ,
            'expenseName' => $expenseName,
            'expenseAmount' => $expenseAmount,
            'expenseDate' => $expenseDate,
        );
        update_expense($expense);
        header('Location: expense history.php');
        die();
    }
}
    else {
        // If not submitted, get the expense data from the database
        $expense_id = filter_var($_GET['expense_id'], FILTER_SANITIZE_NUMBER_INT);
        $expense = get_expense_by_id($expense_id);
        if (!$expense) {
            header('Location: expense history.php');
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
    <h2>Edit expense</h2>
    <input type="hidden" name="expense_id" value="<?php echo $expense->expense_id; ?>">
    
    <label for="expenseCost">Expense Name:</label>
    <input type="text" id="expenseCost" name="expenseName" required value="<?php echo htmlspecialchars($expense->expenseName); ?>"><br>
    
    <label for="expenseAmount">Amount:</label>
    <input type="number"  min="0" id="expenseAmount" name="expenseAmount" required value="<?php echo htmlspecialchars($expense->expenseAmount); ?>"><br>
    
    <label for="expenseDate">Date:</label>
    <input type="date" id="expenseDate" name="expenseDate" required value="<?php echo htmlspecialchars($expense->expenseDate); ?>" ><br>

    <button type="submit" name="update_expense">Edit expense</button>
</form>

</div>

