<?php
include 'menu/validate_login.php';
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>PDO - Create a Customer - PHP CRUD Tutorial</title>
    <link rel="icon" type="image/x-icon" href="img/factorylogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>  
    <div class="container p-0 bg-light">
        <?php
            include 'menu/nav.php';
        ?>

        <div class="page-header p-3 pb-1">
            <h1>Create Customer</h1>
        </div>
      
        <?php
        if($_POST){
            include 'config/database.php';
            include 'menu/validate_function.php';

            try{
                $query = "INSERT INTO customers SET username=:username, password=:password, firstname=:firstname, lastname=:lastname, gender=:gender, birthdate=:birthdate ,email=:email, status=:status, profile_image=:image";
                // prepare query for execution
                $stmt = $con->prepare($query);
                $username = $_POST['username'];
                $password = $_POST['password'];
                $confirmpassword = $_POST['confirmpassword'];
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $birthdate = $_POST['birthdate'];
                $email = $_POST['email'];
                $status = $_POST['status'];
                $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
                //image field
                $image = !empty($_FILES["image"]["name"]) ? "uploaded_customer_img/" . sha1_file($_FILES['image']['tmp_name']) . basename($_FILES["image"]["name"]) : "uploaded_customer_img/defaultcustomerimg.jpg";
                $image = htmlspecialchars(strip_tags($image));

                $errorMessage = validateCreateCustomerForm($username, $password, $confirmpassword, $firstname, $lastname, $gender, $birthdate, $email, $status, $image);

                if(!empty($errorMessage)) {
                    echo "<div class='alert alert-danger m-3'>";
                        foreach ($errorMessage as $displayErrorMessage) {
                            echo $displayErrorMessage . "<br>";
                        }
                    echo "</div>";
                }else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':password', $hashedPassword);
                    $stmt->bindParam(':firstname', $firstname);
                    $stmt->bindParam(':lastname', $lastname);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':birthdate', $birthdate);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':status', $status);
                    $stmt->bindParam(':image', $image);
                    
                    // Execute the query
                    if ($stmt->execute()) {
                        //record saved
                        $customer_id = $con->lastInsertId();
                        header("Location: customer_read_one.php?id={$customer_id}&action=record_saved");
                        exit();
                    }else {
                        echo "<div class='alert alert-danger m-3'>Unable to save the customer record.</div>";
                    }
                }
            }
            catch(PDOException $exception){
                if ($exception->getCode() == 23000){
                    //error code 23000 could be a duplicate username or email. Find keyword username or email to differentiate the error message.
                    if (strpos($exception->getMessage(), 'username') != false) {
                        echo "<div class='alert alert-danger m-3'>Username already taken. Please enter a new username.</div>";
                    }else if (strpos($exception->getMessage(), 'email') != false) {
                        echo "<div class='alert alert-danger m-3'>Email already taken. Please enter a new email.</div>";
                    }
                }else{
                    echo "<div class='alert alert-danger m-3'>ERROR: " . $exception->getMessage() . "</div>";
                    //die('ERROR: ' . $exception->getMessage());
                }
            }
        }
        ?>

        <div class="p-3">
            <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST" enctype="multipart/form-data">
                <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td class="col-4">Username</td>
                        <td class="col-8"><input type='text' name='username' id='username' class='form-control' minlength="5" maxlength="20" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td><input type='password' name='password' id='password' class='form-control' value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Confirm Password</td>
                        <td><input type='password' name='confirmpassword' id='confirmpassword' class='form-control' value="<?php echo isset($_POST['confirmpassword']) ? $_POST['confirmpassword'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>First Name</td>
                        <td><input type='text' name='firstname'  id='firstname' class='form-control' maxlength="30" value="<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Last Name</td>
                        <td><input type='text' name='lastname' id='lastname' class='form-control' maxlength="30" value="<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="gender" value="male" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'male') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="gender">
                                    Male
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="gender" value="female" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'female') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="gender">
                                    Female
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Date of Birth</td>
                        <td><input type='date' name='birthdate' class='form-control' value="<?php echo isset($_POST['birthdate']) ? $_POST['birthdate'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><input type='email' name='email' id='email' class='form-control' value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Account Status</td>
                        <td>
                            <select name="status" class="form-select">
                                <option value="" selected hidden>Choose an account status</option>
                                <option value="Active" <?php echo (isset($_POST['status']) && $_POST['status'] === 'Active') ? 'selected' : ''; ?>>Active</option>
                                <option value="Inactive" <?php echo (isset($_POST['status']) && $_POST['status'] === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                                <option value="Pending" <?php echo (isset($_POST['status']) && $_POST['status'] === 'Pending') ? 'selected' : ''; ?>>Pending</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Profile Image</td>
                        <td><input type="file" name="image" class="form-control" accept="image/*"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type='submit' value='Save' class='btn btn-primary' />
                            <a href='customer_read.php' class='btn btn-danger'>Back to customer list</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div> 
</body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
