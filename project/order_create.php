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
        
        if ($_POST) {
            try {
                $user_id = $_SESSION['user_id'];
                $orderSummaryQuery = "INSERT INTO order_summary SET Customer_ID=:user_id";
                $orderSummaryStmt = $con->prepare($orderSummaryQuery);
                $orderSummaryStmt->bindParam(':user_id', $user_id);
                $orderSummaryStmt->execute();   // first execute
                $order_id = $con->lastInsertId(); // Get the Order_ID from the last inserted row
        
                // insert data into order_details table for each product
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
            }catch (PDOException $exception) {
                echo "<div class='alert alert-danger m-3'>Unable to place the order.</div>";
            }
        }
        ?>

        <form class="p-3" action="" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td><b>No</b></td>
                    <td><b>Product</b></td>
                    <td><b>Price</b></td>
                    <td><b>Quantity</b></td>
                    <td><b>Amount</b></td>
                </tr>
                <!-- Repeat the product rows dynamically -->
                <?php for ($i = 1; $i <= 3; $i++): ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td>
                            <select name="product<?php echo $i; ?>" class="form-select" onchange="updateRow(<?php echo $i; ?>)">
                                <?php
                                foreach ($products as $product) {
                                    echo "<option value='{$product['Product_ID']}' product-price='{$product['promotion_price']}'>{$product['name']}</option>";
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <input type="text" id="price<?php echo $i; ?>" value="<?php echo $products[0]['promotion_price']; ?>" readonly class="form-control">
                        </td>
                        <td>
                            <input type="number" name="quantity<?php echo $i; ?>" value="1" min="1" max="10" class="form-control" onchange="updateRow(<?php echo $i; ?>)">
                        </td>
                        <td>
                            <input type="text" id="amount<?php echo $i; ?>" value="<?php echo $products[0]['promotion_price']; ?>" readonly class="form-control">
                        </td>
                    </tr>
                <?php endfor; ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b>Total amount: RM<span id="totalAmount">0.00</span></b></td>
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
            const selectedPrice = parseFloat(selectedOption.getAttribute("product-price")).toFixed(2); // Convert to two decimal places
            priceField.value = `RM ${selectedPrice}`;

            const quantityField = document.querySelector(`input[name="quantity${index}"]`);
            const quantity = parseInt(quantityField.value);
            const amountField = document.getElementById(`amount${index}`);
            const amount = (selectedPrice * quantity).toFixed(2);
            amountField.value = `RM ${amount}`;

            // Calculate the total amount
            let totalAmount = 0;
            for (let i = 1; i <= 3; i++) {
                const amountField = document.getElementById(`amount${i}`);
                const amountValue = parseFloat(amountField.value.replace("RM ", ""));
                if (!isNaN(amountValue)) {
                    totalAmount += amountValue;
                }
            }

            // Update the total amount in the span element
            document.getElementById("totalAmount").textContent = totalAmount.toFixed(2);
        }
    </script>
</body>
</html>
