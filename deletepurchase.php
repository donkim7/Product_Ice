<?php

include 'functions.php';
check_login();


    if(isset($_POST['delete_purchases'])) {
        $purchase_id = $_POST['purchase_id'];
        delete_purchases($purchase_id);
        header('Location: purchase history.php');
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
    <h2>Delete purchase</h2>
    <input type="hidden" name="purchase_id" value="<?php echo $_GET['purchase_id']; ?>">
    
    <button type="submit" style="background-color: brown;" name="delete_purchases" class="yesdelete" onclick='return confirm("Are you sure you want to delete this purchase?")'>Delete</button>
    <button class="nodelete" > <a href="purchase history.php">No, cancel</a></button>
</form>

</div>

