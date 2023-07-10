<!DOCTYPE HTML>
<html>
<head>
    <title>PDO - Create a Customer - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>  
    <!-- container -->
    <div class="container p-0 bg-light">
        <?php
            include 'menu.php';
        ?>

        <div class="page-header p-3 pb-1">
            <h1>Create Customer</h1>
        </div>
      
        <?php
        if($_POST){
            // include database connection
            include 'config/database.php';
            try{
                // insert query
                $query = "INSERT INTO customers SET username=:username, password=:password, firstname=:firstname, lastname=:lastname, gender=:gender, birthdate=:birthdate ,email=:email, status=:status";
                // prepare query for execution
                $stmt = $con->prepare($query);
                $username = $_POST['username'];
                $password = $_POST['password'];
                $confirmpassword = $_POST['confirmpassword'];
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $gender = $_POST['gender'];
                $birthdate = $_POST['birthdate'];
                $email = $_POST['email'];
                $status = $_POST['status'];

                $errorMessage = array();

                if(empty($username)) {
                    $errorMessage[] = "Username field is empty.";
                }
                if(empty($password)) {
                    $errorMessage[] = "Password field is empty.";
                }else {
                    $passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/";
                    if (!preg_match($passwordPattern, $password)) {
                        $errorMessage[] = "Password must be at least 6 characters long and contain at least one uppercase letter, one lowercase letter, and one number. No special symbols allowed.";
                    }
                }
                if (empty($confirmpassword)) {
                    $errorMessage[] = "Confirm password field is empty.";
                }
                if (!empty($password) && !empty($confirmpassword)) {
                    if ($password !== $confirmpassword) {
                        $errorMessage[] = "Password and confirm password do not match.";
                    }
                }
                if(empty($firstname)) {
                    $errorMessage[] = "First name field is empty.";
                }
                if(empty($lastname)) {
                    $errorMessage[] = "Last name field is empty.";
                }
                if(empty($gender)) {
                    $errorMessage[] = "Gender field is empty.";
                }
                if (empty($birthdate)) {
                    $errorMessage[] = "Date of birth field is empty.";
                } else {
                    $currentDate = date('Y-m-d');
                    if ($birthdate > $currentDate) {
                        $errorMessage[] = "Date of birth cannot be in the future.";
                    }
                }
                if(empty($email)) {
                    $errorMessage[] = "Email field is empty.";
                }else {
                    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errorMessage[] = "Invalid email format.";
                    }
                }

                if(!empty($errorMessage)) {
                    echo "<div class='alert alert-danger m-3'>";
                        foreach ($errorMessage as $displayErrorMessage) {
                            echo $displayErrorMessage . "<br>";
                        }
                    echo "</div>";
                }else {
                    // Bind the parameters
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':password', $hashedPassword);
                    $stmt->bindParam(':firstname', $firstname);
                    $stmt->bindParam(':lastname', $lastname);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':birthdate', $birthdate);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':status', $status);
                    
                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success m-3'>Customer record was saved.</div>";
                        $_POST = array();
                    } else {
                        echo "<div class='alert alert-danger m-3'>Unable to save the customer record.</div>";
                    }
                }
            }
            // show error
            catch(PDOException $exception){
                if ($exception->getCode() == 23000){
                    echo "<div class='alert alert-danger m-3'>Username has been taken. Please enter a new username.</div>";
                }else{
                    echo "<div class='alert alert-danger m-3'>ERROR: " . $exception->getMessage() . "</div>";
                    //die('ERROR: ' . $exception->getMessage());
                }
            }
        }
        ?>

        <div class="p-3">
            <!-- html form here where the customer information will be entered -->
            <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
                <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td class="col-4">Username</td>
                        <td class="col-8"><input type='text' name='username' id='username' class='form-control' value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" /></td>
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
                        <td><input type='text' name='firstname'  id='firstname' class='form-control' value="<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Last Name</td>
                        <td><input type='text' name='lastname' id='lastname' class='form-control' value="<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="gender" value="male" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'male') ? 'checked' : 'checked'; ?>>
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
                            <option value="Active" <?php echo (isset($_POST['status']) && $_POST['status'] === 'Active') ? 'selected' : ''; ?>>Active</option>
                            <option value="Inactive" <?php echo (isset($_POST['status']) && $_POST['status'] === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                            <option value="Pending" <?php echo (isset($_POST['status']) && $_POST['status'] === 'Pending') ? 'selected' : ''; ?>>Pending</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type='submit' value='Save' class='btn btn-primary' />
                            <a href='index.php' class='btn btn-danger'>Back to customer list</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div> 
    <!-- end container -->  
</body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
