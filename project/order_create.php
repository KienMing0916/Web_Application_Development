<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Order Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container bg-light">
        <?php
        include 'menu/nav.php';
        ?>

        <div class="page-header p-3 pb-1">
            <h1>Order Form</h1>
        </div>

        <?php
        include 'config/database.php';
        $productQuery = "SELECT Product_ID, name, promotion_price FROM products";
        $productStmt = $con->prepare($productQuery);
        $productStmt->execute();
        $products = $productStmt->fetchAll(PDO::FETCH_ASSOC);
        $totalAmount = 0;
        
        if ($_POST) {
            function requiredFieldsAreFilled($fields) {
                foreach ($fields as $field) {
                    if (!isset($_POST[$field])) {
                        return false;
                    }
                }
                return true; 
            }
            function handleError($error) {
                echo '<div class="alert alert-danger m-3" role="alert">' . $error . '</div>';
            }

            $requiredFields = ['customerSelectionBox'];
            for ($i = 1; $i <= 3; $i++) {
                $requiredFields[] = "product{$i}";
                $requiredFields[] = "quantity{$i}";
            }

            try {
                if (!requiredFieldsAreFilled($requiredFields)) {
                    throw new Exception("Please select all the fields.");
                }
                $selectedCustomerID = $_POST['customerSelectionBox'];
                $orderSummaryQuery = "INSERT INTO order_summary SET Customer_ID=:customer_id";
                $orderSummaryStmt = $con->prepare($orderSummaryQuery);
                $orderSummaryStmt->bindParam(':customer_id', $selectedCustomerID);
                $orderSummaryStmt->execute();  
                $order_id = $con->lastInsertId();
        
                for ($i = 1; $i <= 3; $i++) {
                    $product_id = $_POST["product{$i}"];
                    $quantity = $_POST["quantity{$i}"];
        
                    $orderDetailsQuery = "INSERT INTO order_details SET Order_ID=:order_id, Product_ID=:product_id, quantity=:quantity"; // secpnd execute
                    $orderDetailsStmt = $con->prepare($orderDetailsQuery);
                    $orderDetailsStmt->bindParam(':order_id', $order_id);
                    $orderDetailsStmt->bindParam(':product_id', $product_id);
                    $orderDetailsStmt->bindParam(':quantity', $quantity);
                    $orderDetailsStmt->execute();
                }
                echo "<div class='alert alert-success m-3'>Order placed successfully.</div>";
                $_POST = array();
            } catch (Exception $exception) {
                handleError($exception->getMessage());
                // echo "<div class='alert alert-danger m-3'>Unable to place the order.</div>";
            }
        }
        ?>

        <form class="p-3" action="" method="post">
            <div class="mb-3">
                <select name="customerSelectionBox" id="customerSelectionBox" class="form-select">
                    <option value="" disabled selected hidden>Choose a customer</option>
                    <?php
                    try {
                        $customerQuery = "SELECT Customer_ID, username FROM customers";
                        $customerStmt = $con->prepare($customerQuery);
                        $customerStmt->execute();
                        $customers = $customerStmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($customers as $customer) {
                            $selected = isset($_POST['customerSelectionBox']) && $_POST['customerSelectionBox'] == $customer['Customer_ID'] ? 'selected' : '';
                            echo "<option value='{$customer['Customer_ID']}' $selected>{$customer['username']}</option>";
                        }
                    } catch (PDOException $exception) {
                        echo "<option value='' selected>Error loading customers</option>";
                    }
                    ?>
                </select>
            </div>

            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td class="col-1"><b>No</b></td>
                    <td class="col-4"><b>Product</b></td>
                    <td class="col-3"><b>Price (RM)</b></td>
                    <td class="col-1"><b>Quantity</b></td>
                    <td class="col-3"><b>Amount (RM)</b></td>
                </tr>
                <?php for ($i = 1; $i <= 3; $i++): ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td>
                            <select name="product<?php echo $i; ?>" class="form-select" onchange="updateRow(<?php echo $i; ?>)">
                                <option value="" disabled selected hidden>Choose a product</option>
                                <?php
                                $selectedProduct = isset($_POST["product{$i}"]) ? $_POST["product{$i}"] : '';
                                $selectedProductPrice = $selectedProduct ? $products[$selectedProduct - 1]['promotion_price'] : '';
                                $selectedQuantity = isset($_POST["quantity{$i}"]) ? $_POST["quantity{$i}"] : 1;
                                $selectedAmount = $selectedProduct ? $selectedProductPrice * $selectedQuantity : '0';
                                $totalAmount += $selectedAmount;
                                foreach ($products as $product) {
                                    $selected = $selectedProduct == $product['Product_ID'] ? 'selected' : '';
                                    echo "<option value='" . $product['Product_ID'] . "' data-product-price='" . $product['promotion_price'] . "' $selected>" . $product['name'] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <?php
                                echo '<input type="number" id="price' . $i . '" value="' . number_format((float)$selectedProductPrice, 2) . 
                                    '" readonly class="form-control' . ($selectedProduct ? '' : ' d-none') . '">';
                            ?>
                        </td>
                        <td>
                            <input type="number" name="quantity<?php echo $i; ?>" value="<?php echo $selectedQuantity; ?>" min="1" max="10" class="form-control" onchange="updateRow(<?php echo $i; ?>)">
                        </td>
                        <td>
                            <?php
                                echo '<input type="number" id="amount' . $i . '" value="' . number_format((float)$selectedAmount, 2) . 
                                    '" readonly class="form-control' . ($selectedProduct ? '' : ' d-none') . '">';

                            ?>
                        </td>

                    </tr>
                <?php endfor; ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b>Total amount: RM <span id="totalAmount"><?php echo number_format((float)$totalAmount, 2); ?></span></b></td>
                </tr>
            </table>
            <input type='submit' value='Place Order' class='btn btn-primary' />
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>

    function updateRow(index) {
        const selectedProduct = document.querySelector(`select[name="product${index}"]`);
        const selectedOption = selectedProduct.options[selectedProduct.selectedIndex];
        const priceField = document.getElementById(`price${index}`);
        const selectedPrice = parseFloat(selectedOption.getAttribute("data-product-price")).toFixed(2); // Convert to two decimal places
        priceField.value = selectedPrice;

        const quantityField = document.querySelector(`input[name="quantity${index}"]`);
        const quantity = parseInt(quantityField.value);
        const amountField = document.getElementById(`amount${index}`);
        const amount = (selectedPrice * quantity).toFixed(2);
        amountField.value = amount;

        if (selectedProduct.value !== "") {
            priceField.classList.remove("d-none");
            priceField.classList.add("d-block");
            amountField.classList.remove("d-none");
            amountField.classList.add("d-block");
        } else {
            priceField.classList.remove("d-block");
            priceField.classList.add("d-none");
            amountField.classList.remove("d-block");
            amountField.classList.add("d-none");
        }

        let totalAmount = 0;
        for (let i = 1; i <= 3; i++) {
            const amountField = document.getElementById(`amount${i}`);
            const amountValue = parseFloat(amountField.value);
            if (!isNaN(amountValue)) {
                totalAmount += amountValue;
            }
        }
        document.getElementById("totalAmount").textContent = totalAmount.toFixed(2);
    }
    </script>
</body>
</html>
