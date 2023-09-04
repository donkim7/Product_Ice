<?php 

session_start();

function database_run($query, $vars = array(), $fetch = true)
{
    $string = "mysql:host=localhost;dbname=productice";
    $con = new PDO($string, 'root', '');
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!$con) {
        echo "Database connection failed.";
        return false;
    }

    $stm = $con->prepare($query);

    try {
        $check = $stm->execute($vars);

        if ($check) {
            // For SELECT queries, fetch and return the result set
            if ($fetch) {
                $data = $stm->fetchAll(PDO::FETCH_OBJ);

                if (count($data) > 0) {
                    return $data;
                }
            }
            // For INSERT queries, return the success status
            else {
                return true;
            }
        } else {
            // Display the error message if execution fails
            $error_info = $stm->errorInfo();
            echo "Database error: " . $error_info[2];
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    return false;
}


function signup($data)
{
	$errors = array();
 
	//validate 

	if(!filter_var($data['email'],FILTER_VALIDATE_EMAIL)){
		$errors[] = "Please enter a valid email";
	}

	if(strlen(trim($data['password'])) < 5){
		$errors[] = "Password must be atleast 5 chars long";
	}


	if($data['password'] != $data['password2']){
		$errors[] = "Passwords must match!";
	}
    
	$check = database_run("select * from admin where email = :email limit 1",['email'=>$data['email']]);
	if(is_array($check)){
		$errors[] = "That email already exists";
	}

	//save
	if(count($errors) == 0){
		$arr['fullname'] = $data['fullname'];
		$arr['email'] = $data['email'];
		$arr['password'] = $data['password'];



		$query = "insert into admin (fullname,email,password) values 
		(:fullname,:email,:password)";

		database_run($query,$arr);
	}
	return $errors;
}




function login($data)
{
    $errors = array();
 
    // Validate

    if (strlen(trim($data['password'])) < 5) {
        $errors[] = "Password must be at least 5 characters long";
    }
 
    // Check
    if (count($errors) == 0) {

		$arr['email'] = $data['email'];
		$password =  $data['password'];

		$query = "select * from admin where email = :email limit 1";

		$row = database_run($query,$arr);

        if (is_array($row)) {
            $row = $row[0];

            if ($password === $row->password) {
                $_SESSION['USER'] = $row;
                $_SESSION['LOGGED_IN'] = true;
            } else {
                $errors[] = "Wrong email or password";
            }
        } else {
            $errors[] = "Wrong email or password";
        }
    }
    return $errors;
}


function check_login($redirect = true){

	if(isset($_SESSION['USER']) && isset($_SESSION['LOGGED_IN'])){

		return true;
	}

	if($redirect){
		header("Location: login.php");
		die;
	}else{
		return false;
	}
}

function products($data)
{
    $errors = array();

    // validate

    // Check if the required fields are present
    if (empty($data['productCost']) || empty($data['productPrice']) || empty($data['productUnit']) || empty($data['saleUnit'])) {
        $errors[] = "All fields are required.";
    }

    // Save
    if (count($errors) == 0) {
        $arr['productName'] = $data['productName'];
        $arr['productCost'] = $data['productCost'];
        $arr['productPrice'] = $data['productPrice'];
        $arr['productUnit'] = $data['productUnit'];
        $arr['saleUnit'] = $data['saleUnit'];

        $query = "INSERT INTO products (productName, productCost, productPrice, productUnit, saleUnit) 
                    VALUES (:productName, :productCost, :productPrice, :productUnit, :saleUnit)";

        database_run($query, $arr);
    }

    return $errors;
}


function sales($data)
{
    $errors = array();


    // validate
    // Check if the required fields are present
    if (empty($data['saleDate']) || empty($data['saleItem']) || empty($data['clientName']) || empty($data['saleQuantity']) || empty($data['saleUnit']) || empty($data['salePrice'])) {
        $errors[] = "All fields are required.";
    }

    // Save
    if (count($errors) == 0) {
        $arr['saleDate'] = $data['saleDate'];
        $arr['saleItem'] = $data['saleItem'];
        $arr['clientName'] = $data['clientName'];
        $arr['saleQuantity'] = $data['saleQuantity'];
        $arr['saleUnit'] = $data['saleUnit'];
        $arr['salePrice'] = $data['salePrice'];

        $query = "INSERT INTO sales (saleDate, saleItem, clientName, saleQuantity, saleUnit, salePrice) 
                    VALUES (:saleDate, :saleItem, :clientName, :saleQuantity, :saleUnit, :salePrice)";

        database_run($query, $arr);
    }

    return $errors;
}



function purchases($data)
{
    $errors = array();

    // validate

    // Check if the required fields are present
    if (empty($data['purchaseDate']) || empty($data['itemsPurchased']) || empty($data['purchasePrice']) || empty($data['purchaseQuantity'])) {
        $errors[] = "All fields are required.";
    }

    // Save
    if (count($errors) == 0) {
        $arr['purchaseDate'] = $data['purchaseDate'];
        $arr['itemsPurchased'] = $data['itemsPurchased'];
        $arr['purchasePrice'] = $data['purchasePrice'];
        $arr['purchaseQuantity'] = $data['purchaseQuantity'];

        $query = "INSERT INTO purchase (purchaseDate, itemsPurchased, purchasePrice, purchaseQuantity) 
                    VALUES (:purchaseDate, :itemsPurchased, :purchasePrice, :purchaseQuantity)";

        database_run($query, $arr);
    }

    return $errors;
}


function expenses($data)
{
    $errors = array();

    // validate

    // Check if the required fields are present
    if (empty($data['expenseName']) || empty($data['expenseAmount']) || empty($data['expenseDate'])) {
        $errors[] = "All fields are required.";
    }

    // Save
    if (count($errors) == 0) {
        $arr['expenseName'] = $data['expenseName'];
        $arr['expenseAmount'] = $data['expenseAmount'];
        $arr['expenseDate'] = $data['expenseDate'];

        $query = "INSERT INTO expense (expenseName, expenseAmount, expenseDate) 
                    VALUES (:expenseName, :expenseAmount, :expenseDate)";

        database_run($query, $arr);
    }

    return $errors;
}







function get_all_products()
{
	$query = "select * from products";
	return database_run($query);
}


function get_all_purchases()
{
	$query = "select * from purchase";
	return database_run($query);
}

function get_all_sales()
{
	$query = "select * from sales";
	return database_run($query);
}

function get_all_expenses()
{
	$query = "select * from expense";
	return database_run($query);
}

// function to retrieve a single product by ID from the database
function get_products_by_id($product_id)
{
	$query = "select * from products where product_id = :product_id limit 1";
	$result = database_run($query, array('product_id' => $product_id));
	return isset($result[0]) ? $result[0] : null;
}

// function to update a products
function update_product($product)
{
    $query = "UPDATE products SET productName = :productName, productCost = :productCost, productPrice = :productPrice, productUnit = :productUnit, saleUnit = :saleUnit  WHERE product_id = :product_id";
    return database_run($query, array(
        'product_id' => $product['product_id'],
        'productName' => $product['productName'],
        'productCost' => $product['productCost'],
        'productPrice' => $product['productPrice'],
        'productUnit' => $product['productUnit'],
        'saleUnit' => $product['saleUnit'],

    ));
}

// function to delete a product from the database
function delete_products($product_id)
{
	$query = "delete from products where product_id= :product_id";
	return database_run($query, array('product_id' => $product_id));
}



// function to retrieve a single purchase by ID from the database
function get_purchases_by_id($purchase_id)
{
	$query = "select * from purchase where purchase_id = :purchase_id limit 1";
	$result = database_run($query, array('purchase_id' => $purchase_id));
	return isset($result[0]) ? $result[0] : null;
}

// function to update a purchase
function update_purchase($purchase)
{
    $query = "UPDATE purchase SET purchaseDate = :purchaseDate, itemsPurchased = :itemsPurchased, purchasePrice = :purchasePrice, purchaseQuantity = :purchaseQuantity WHERE purchase_id = :purchase_id";
    return database_run($query, array(
        'purchase_id' => $purchase['purchase_id'],
        'purchaseDate' => $purchase['purchaseDate'],
        'itemsPurchased' => $purchase['itemsPurchased'],
        'purchasePrice' => $purchase['purchasePrice'],
        'purchaseQuantity' => $purchase['purchaseQuantity'],

    ));
}
// function to delete a purchase from the database
function delete_purchases($purchase_id)
{
	$query = "delete from purchases where purchase_id= :purchase_id";
	return database_run($query, array('purchase_id' => $purchase_id));
}

// function to retrieve a single sale by ID from the database
function get_sales_by_id($sales_id)
{
	$query = "select * from sales where sales_id = :sales_id limit 1";
	$result = database_run($query, array('sales_id' => $sales_id));
	return isset($result[0]) ? $result[0] : null;
}

// function to update a sale
function update_sale($sale)
{
    $query = "UPDATE sales SET saleDate = :saleDate, saleItem = :saleItem, clientName = :clientName, saleQuantity = :saleQuantity, saleUnit = :saleUnit, salePrice = :salePrice WHERE sales_id = :sales_id";
    return database_run($query, array(
        'sales_id' => $sale['sales_id'],
        'saleDate' => $sale['saleDate'],
        'saleItem' => $sale['saleItem'],
        'clientName' => $sale['clientName'],
        'saleQuantity' => $sale['saleQuantity'],
        'saleUnit' => $sale['saleUnit'],
        'salePrice' => $sale['salePrice'],

    ));
}
// function to delete a sale from the database
function delete_sales($sales_id)
{
	$query = "delete from sales where sales_id= :sales_id";
	return database_run($query, array('sales_id' => $sales_id));
}

// function to retrieve a single expense by ID from the database
function get_expense_by_id($expense_id)
{
	$query = "select * from expense where expense_id = :expense_id limit 1";
	$result = database_run($query, array('expense_id' => $expense_id));
	return isset($result[0]) ? $result[0] : null;
}

// function to update a expense
function update_expense($expense)
{
    $query = "UPDATE expense SET expenseDate = :expenseDate, expenseName = :expenseName, expenseAmount = :expenseAmount, expenseDate = :expenseDate WHERE expense_id = :expense_id";
    return database_run($query, array(
        'expense_id' => $expense['expense_id'],
        'expenseName' => $expense['expenseName'],
        'expenseAmount' => $expense['expenseAmount'],
        'expenseDate' => $expense['expenseDate'],

    ));
}
// function to delete a expense from the database
function delete_expenses($expense_id)
{
	$query = "delete from expense where expense_id= :expense_id";
	return database_run($query, array('expense_id' => $expense_id));
}




function getSoldQuantity($productName) {
    $query = "SELECT SUM(saleQuantity) AS soldQuantity FROM sales WHERE saleItem = :productName";
    $result = database_run($query, array(':productName' => $productName));

    if ($result) {
        return $result[0]->soldQuantity ?: 0;
    }

    return 0;
}

function getPurchasedQuantity($productName) {
    $query = "SELECT SUM(purchaseQuantity) AS purchasedQuantity FROM purchase WHERE itemsPurchased = :productName";
    $result = database_run($query, array(':productName' => $productName));

    if ($result) {
        return $result[0]->purchasedQuantity ?: 0;
    }

    return 0;
}





// Fetch top 5 most bought products
$query = "SELECT saleItem, SUM(saleQuantity) AS totalQuantity FROM sales GROUP BY saleItem ORDER BY totalQuantity DESC LIMIT 5";
$mostBoughtProducts = database_run($query);

// Fetch  created products
$query = "SELECT productName, SUM(productUnit) AS creationCount 
          FROM products 
          GROUP BY productName 
          ORDER BY productName ASC"; // ASC for ascending order (alphabetical)
$mostCreatedProducts = database_run($query);


// Fetch top 5 purchased products
$query = "SELECT itemsPurchased, SUM(purchaseQuantity) AS totalQuantity FROM purchase GROUP BY itemsPurchased ORDER BY totalQuantity DESC LIMIT 5";
$topPurchasedProducts = database_run($query);

// Fetch top 5 expenses
$query = "SELECT expenseName, COUNT(*) AS totalAmount FROM expense GROUP BY expenseName ORDER BY totalAmount DESC LIMIT 5";
$topExpenses = database_run($query);









