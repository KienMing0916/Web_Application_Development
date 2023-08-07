<?php
include 'menu/validate_login.php';
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Update Order Details</title>
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
            // get the customer name and order date of the order form
            $customerQuery = "SELECT order_summary.order_date, customers.firstname, customers.lastname FROM order_details INNER JOIN order_summary ON order_details.Order_ID = order_summary.Order_ID INNER JOIN customers ON order_summary.Customer_ID = customers.Customer_ID WHERE order_details.Order_ID = :id ORDER BY order_details.OrderDetail_ID ASC";
            $customerStmt = $con->prepare($customerQuery);
            $customerStmt->bindParam(":id", $id);
            $customerStmt->execute();
            $customerRow = $customerStmt->fetch(PDO::FETCH_ASSOC);
            $firstname = $customerRow['firstname'];
            $lastname = $customerRow['lastname'];
            $orderDateTime = $customerRow['order_date'];
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
                $selectedCustomerID = "No changing available for customer name.";
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
                    header("Location: order_details_read.php?id={$id}");
                    exit();
                }
            } catch (PDOException $exception) {
                echo "<div class='alert alert-danger m-3'>Unable to update the order.</div>";
            }
        }
        ?>

        <div>
            <form class="p-3" action="" method="POST">
                <div class='d-flex justify-content-between'>
                    <p class='pt-3 ps-1'><strong>Customer Name: <?php echo $firstname . " " . $lastname; ?></strong></p>
                    <p class='pt-3 pe-1'><strong>Order Date: <?php echo $orderDateTime; ?></strong></p>
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
    <script>
        // start of add and delete product rows
        const orderTable = document.getElementById("order-table");
        const addRowBtn = document.querySelector('.add_one');
        addRowBtn.addEventListener('click', addRow);

        function addRow() {
            var rows = document.getElementsByClassName('product-row');
            var lastRow = rows[rows.length - 1];
            const lastRowProductsSelect = lastRow.querySelector('select[name="product[]"]');
            const lastRowSelectedProduct = lastRowProductsSelect.value;
            // Clone the last row
            var clone = lastRow.cloneNode(true);
            const [productsSelect, quantityInput] = clone.querySelectorAll('select[name="product[]"], input[name="quantity[]"]');
            productsSelect.value = "";
            quantityInput.value = 1;
            // Insert the clone after the last row
            lastRow.insertAdjacentElement('afterend', clone);

            // Loop through the rows
            for (let i = 0; i < rows.length; i++) {
                // Set the inner HTML of the first cell to the current loop iteration number
                rows[i].cells[0].innerHTML = i + 1;
            }
        }
        function deleteRow(deleteBtn) {
            const productsRowCount = orderTable.querySelectorAll('.product-row').length;
            if (productsRowCount > 1) {
                const row = deleteBtn.closest("tr");
                const productsSelect = row.querySelector("select[name='product[]']");
                row.remove();

                const rows = orderTable.getElementsByClassName('product-row');
                for (let i = 0; i < rows.length; i++) {
                    // Set the inner HTML of the first cell to the current loop iteration number
                    rows[i].cells[0].textContent = i + 1;
                }
            } else {
                alert("You need order at least one item.");
            }
        }
        // end of add and delete product rows
    </script>
</body>
</html>
