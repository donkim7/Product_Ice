<?php

include 'functions.php';
check_login();


    if(isset($_POST['delete_expenses'])) {
        $expense_id = $_POST['expense_id'];
        delete_expenses($expense_id);
        header('Location: expense history.php');
        die();
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
    <style>
    .nodelete a {
    color: white;
    text-decoration: none;
}
</style>
</head>
<body>

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
        <form method="post" class="add-expense-form">
    <h2>Delete expense</h2>
    <input type="hidden" name="expense_id" value="<?php echo $_GET['expense_id']; ?>">
    
    <button type="submit" style="background-color: brown;" name="delete_expenses" class="yesdelete" onclick='return confirm("Are you sure you want to delete this expense?")'>Delete</button>
    <button class="nodelete" > <a href="expense history.php">No, cancel</a></button>
</form>

</div>

