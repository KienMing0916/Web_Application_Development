<?php
include 'menu/validate_login.php';
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Update Order Details</title>
    <script async src="js/scripts.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <div class="container p-0 bg-light">
        <?php
        include 'menu/nav.php';
        ?>

        <div class="page-header p-3 pb-1">
            <h1>Update Order</h1>
        </div>

        <?php
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $orderDate = date('Y-m-d H:i:s');

        include 'config/database.php';

        try {
            // get the customer name of the order form
            $customerNameQuery = "SELECT customers.firstname, customers.lastname FROM customers JOIN order_summary ON customers.Customer_ID = order_summary.Customer_ID WHERE order_summary.Order_ID = :id";
            $customerNameStmt = $con->prepare($customerNameQuery);
            $customerNameStmt->bindParam(":id", $id);
            $customerNameStmt->execute();
            $customer = $customerNameStmt->fetch(PDO::FETCH_ASSOC);
            $firstname = $customer['firstname'];
            $lastname = $customer['lastname'];
            // get all the products in database
            $productQuery = "SELECT Product_ID, name FROM products";
            $productStmt = $con->prepare($productQuery);
            $productStmt->execute();
            $products = $productStmt->fetchAll(PDO::FETCH_ASSOC);
            $productsRowCount = $productStmt->rowCount();
            // get all the ordered products in order form based on order_id
            $selectedProductQuery = "SELECT products.Product_ID, products.name, order_details.quantity FROM products JOIN order_details ON products.Product_ID = order_details.Product_ID WHERE order_details.Order_ID = :id ORDER BY order_details.OrderDetail_ID ASC";
            $selectedProductStmt = $con->prepare($selectedProductQuery);
            $selectedProductStmt->bindParam(":id", $id);
            $selectedProductStmt->execute();
            $selectedProducts = $selectedProductStmt->fetchAll(PDO::FETCH_ASSOC);
            $selectedProductRow = $selectedProductStmt->rowCount();
        }
        catch(PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        }

        if ($_POST) {
            try {
                $selectedCustomerID = isset($_POST['customer']) ? $_POST['customer'] : '';
                $selectedProductQuantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

                if(isset($_POST['product'])){
                    $selectedProductID = $_POST['product'];
                    $selectedProductRow = count($_POST['product']);
                }else{
                    $selectedProductID = '';
                }

                include 'menu/validate_function.php';
                $errorMessage = validateOrderForm($selectedProductRow, $selectedCustomerID, $selectedProductID, $selectedProductQuantity, $products);

                if(!empty($errorMessage)) {
                    echo "<div class='alert alert-danger m-3'>";
                        foreach ($errorMessage as $displayErrorMessage) {
                            echo $displayErrorMessage . "<br>";
                        }
                    echo "</div>";
                }else {
                    $deleteOrderDetailQuery = "DELETE FROM order_details WHERE Order_ID=:id";
                    $deleteOrderDetailStmt = $con->prepare($deleteOrderDetailQuery);
                    $deleteOrderDetailStmt->bindParam(":id", $id);
                    $deleteOrderDetailStmt->execute();

                    $updateOrderDateQuery = "UPDATE order_summary SET order_date=:order_date WHERE Order_ID=:id";
                    $updateOrderDateStmt = $con->prepare($updateOrderDateQuery);
                    $updateOrderDateStmt->bindParam(":order_date", $orderDate);
                    $updateOrderDateStmt->bindParam(":id", $id);
                    $updateOrderDateStmt->execute();
    
                    for ($i = 0; $i < $selectedProductRow; $i++) {
                        $orderDetailsQuery = "INSERT INTO order_details SET Order_ID=:id, Product_ID=:product_id, quantity=:quantity";
                        $orderDetailsStmt = $con->prepare($orderDetailsQuery);
                        $orderDetailsStmt->bindParam(":id", $id);
                        $orderDetailsStmt->bindParam(":product_id", $selectedProductID[$i]);
                        $orderDetailsStmt->bindParam(":quantity", $selectedProductQuantity[$i]);
                        $orderDetailsStmt->execute();
                    }
    
                    echo "<div class='alert alert-success m-3'>Order updated successfully.</div>";
                }
            } catch (PDOException $exception) {
                echo "<div class='alert alert-danger m-3'>Unable to update the order.</div>";
            }
        }
        ?>

        <div>
            <form class="p-3" action="" method="POST">
                <div class="mb-3">                    
                    <input type='text' name='customer' value="<?php echo htmlspecialchars($firstname . ' ' . $lastname, ENT_QUOTES); ?>" class='form-control' readonly/>
                </div>

                <table class="table table-hover table-responsive table-bordered" id="order-table">
                    <tr>
                        <th class="col-1">No.</th>
                        <th class="col-6">Product</th>
                        <th class="col-3">Quantity</th>
                        <th class="col-2">Action</th>
                    </tr>
                    <?php for ($x = 0; $x < $selectedProductRow; $x++): ?>
                        <tr class="product-row">
                            <td class="col-1" style="vertical-align: middle;">
                                <?php echo $x + 1; ?>
                            </td>
                            <td>
                                <select name="product[]" id="product" class="form-select" value>
                                    <option value="" selected hidden>Choose a product</option>
                                    <?php
                                    for ($i = 0; $i < $productsRowCount; $i++) {
                                        //$selected = $products[$i]['Product_ID'] == $selectedProducts[$x]['Product_ID'] ? "selected" : "";
                                        //$selected = isset($_POST["product"]) && $products[$i]['Product_ID'] == $selectedProductID[$x] ? "selected" : "";
                                        if(!isset($_POST["product"])){
                                            $selected = $products[$i]['Product_ID'] == $selectedProducts[$x]['Product_ID'] ? "selected" : "";
                                        }else{
                                            $selected = $products[$i]['Product_ID'] == $selectedProductID[$x] ? "selected" : "";
                                        }
                                        echo "<option value='{$products[$i]['Product_ID']}' $selected>{$products[$i]['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" class="form-control" name="quantity[]" id="quantity" value="<?php echo isset($_POST['quantity']) ? $selectedProductQuantity[$x] : $selectedProducts[$x]['quantity']; ?>" min="1" max="10">
                            </td>
                            <td>
                                <input type="button" href='#' onclick='deleteRow(this)' class='btn btn-danger' value="Delete" />
                            </td>

                        </tr>
                    <?php endfor; ?>
                </table>
                <div class="pt-2">
                    <button type="button" class="btn btn-success add_one">Add more product</button>
                    <a href="order_read.php" class="btn btn-danger">Back to order summary list</a>
                    <button type="submit" class="btn btn-primary">Update order</button>

                </div>
            </form>    
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
