<?php
session_start();
if (isset($_SESSION['user_id'])) {
  header("Location: index.php");
  exit();
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    
</head>
<body>
    <div class="container p-0" style="background: linear-gradient(to bottom, #f2f2f2, #d9d9d9);">     
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="d-flex align-items-center ms-1">
                <img src="img/factorylogo.png" alt="factorylogo" width="50" height="40" class="d-inline-block align-text-top ms-3 m-1">
                <a class="navbar-brand ms-2" href="#">KM</a>
            </div>
        </nav>

        <?php
        if ($_POST) {
            include 'config/database.php';

            $useraccountinput = $_POST['username'];
            $userpasswordinput = $_POST['password'];
            $errorMessage = array();

            if(empty($useraccountinput)) {
                $errorMessage[] = "Please enter your username.";
            }

            if(empty($userpasswordinput)) {
                $errorMessage[] = "Please enter your password.";
            }

            if(!empty($errorMessage)) {
                echo "<div class='alert alert-danger m-3'>";
                    foreach ($errorMessage as $displayErrorMessage) {
                        echo $displayErrorMessage . "<br>";
                    }
                echo "</div>";
            }else {
                try {
                    $query = "SELECT Customer_ID, password, status FROM customers WHERE username=:username OR email=:username";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':username', $useraccountinput);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($row) {
                        if (password_verify($userpasswordinput, $row['password'])) {
                            if ($row['status'] == 'Active') {
                                $_SESSION['user_id'] = $row['Customer_ID'];
                                header("Location: index.php");
                                exit();
                            }else {
                                echo "<div class='alert alert-danger m-3'>" . $row['status'] . " account.</div>";
                            }
                        }else {
                            echo "<div class='alert alert-danger m-3'>Password incorrect.</div>";
                        }
                    }else {
                        echo "<div class='alert alert-danger m-3'>Username or email not found.</div>";
                        $_POST = array();
                    }
                }catch (PDOException $exception) {
                    echo "<div class='alert alert-danger m-3'>ERROR: " . $exception->getMessage() . "</div>";
                }
            }            
        }
        ?>

        <div class="row m-3 p-5 d-flex justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10 col-12 p-5 border border-dark border-2 rounded bg-light">
                <h2 class="text-center pb-3">Login</h2>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username / Email</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
