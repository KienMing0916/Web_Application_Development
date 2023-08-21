<?php
include 'menu/validate_login.php';
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Update Customer Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container bg-light">
        <?php
        include 'menu/nav.php';
        ?>

        <div class="page-header p-3 pb-1">
            <h1>Update Customer</h1>
        </div>

        <?php
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        include 'config/database.php';
        try {
            $query = "SELECT Customer_ID, username, password, firstname, lastname, gender, birthdate, email, status, profile_image FROM customers WHERE Customer_ID = ? LIMIT 0,1";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $username = $row['username'];
            $db_password = $row['password'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $gender = $row['gender'];
            $birthdate = $row['birthdate'];
            $email = $row['email'];
            $status = $row['status'];
            $uploadedImage = $row['profile_image'];
            $img_directory = "uploaded_customer_img/" . $uploadedImage;

        } catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }

        if ($_POST) {
            include 'menu/validate_function.php';
            
            try {
                $query = "UPDATE customers SET username=:username, firstname=:firstname, lastname=:lastname, gender=:gender, birthdate=:birthdate, email=:email, status=:status, profile_image=:image";       
                $username = htmlspecialchars(strip_tags($_POST['username']));
                $firstname = htmlspecialchars(strip_tags($_POST['firstname']));
                $lastname = htmlspecialchars(strip_tags($_POST['lastname']));
                $gender = $_POST['gender'];
                $birthdate = $_POST['birthdate'];
                $email = htmlspecialchars(strip_tags($_POST['email']));
                $status = $_POST['status'];
                $current_password = $_POST['current_password'];
                $new_password = $_POST['new_password'];
                $confirm_new_password = $_POST['confirm_new_password'];
                // image field
                $image = !empty($_FILES["image"]["name"]) ? basename($_FILES["image"]["name"]) : $uploadedImage;
                $image = htmlspecialchars(strip_tags($image));

                $errorMessage = validateUpdateCustomerForm($username, $firstname, $lastname, $gender, $birthdate, $email, $status, $db_password, $current_password, $new_password, $confirm_new_password, $image);         

                if(!empty($errorMessage)) {
                    echo "<div class='alert alert-danger m-3'>";
                        foreach ($errorMessage as $displayErrorMessage) {
                            echo $displayErrorMessage . "<br>";
                        }
                    echo "</div>";
                }else {
                    if (!empty($current_password) && !empty($new_password) && !empty($confirm_new_password)) {
                        $query .= ", password=:password ";
                        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    }

                    $query .= " WHERE Customer_ID = :id";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':firstname', $firstname);
                    $stmt->bindParam(':lastname', $lastname);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':birthdate', $birthdate);
                    $stmt->bindParam(':status', $status);
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':image', $image);
            
                    if (!empty($hashed_password)) {
                        $stmt->bindParam(':password', $hashed_password);
                    }

                    if ($uploadedImage !== 'defaultcustomerimg.jpg' && $image !== $uploadedImage) {
                        // Remove the existing image
                        if (file_exists($img_directory)) {
                            unlink($img_directory);
                        }
                        // Upload the new image
                        $targetDirectory = "uploaded_customer_img/";
                        $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
                        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
                    }
            
                    if ($stmt->execute()) {
                        // record updated
                        header("Location: customer_read_one.php?id={$id}&action=record_updated");
                        exit();
                    } else {
                        echo "<div class='alert alert-danger m-3'>Unable to update record. Please try again.</div>";
                    }
                }   
            } catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>

        <form class="p-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post" enctype="multipart/form-data">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td class="col-4">Username</td>
                    <td><input type='text' name='username' value="<?php echo htmlspecialchars($username, ENT_QUOTES); ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td><input type='text' name='firstname' value="<?php echo htmlspecialchars($firstname, ENT_QUOTES); ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type='text' name='lastname' value="<?php echo htmlspecialchars($lastname, ENT_QUOTES); ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>
                        <div>
                            <input type="radio" name="gender" value="Male" <?php echo ($gender == 'Male') ? 'checked' : ''; ?>> Male
                        </div>
                        <div>
                            <input type="radio" name="gender" value="Female" <?php echo ($gender == 'Female') ? 'checked' : ''; ?>> Female
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Birthdate</td>
                    <td><input type='date' name='birthdate' value="<?php echo htmlspecialchars($birthdate, ENT_QUOTES); ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type='email' name='email' value="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status" class="form-select">
                            <option value="Active" <?php echo ($status == 'Active') ? 'selected' : ''; ?>>Active</option>
                            <option value="Inactive" <?php echo ($status == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                            <option value="Pending" <?php echo ($status == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Profile Image</td>
                    <td>
                        <img src="<?php echo htmlspecialchars($img_directory, ENT_QUOTES); ?>" width="200" height="200">
                        <br><br>
                        <input type="file" name="image"/>
                    </td>
                </tr>
                <tr>
                    <td>Current Password</td>
                    <td><input type='password' name='current_password' class='form-control' value="<?php echo isset($_POST['current_password']) ? $_POST['current_password'] : ''; ?>" /></td>
                </tr>
                <tr>
                    <td>New Password</td>
                    <td><input type='password' name='new_password' class='form-control' value="<?php echo isset($_POST['new_password']) ? $_POST['new_password'] : ''; ?>" /></td>
                </tr>
                <tr>
                    <td>Confirm New Password</td>
                    <td><input type='password' name='confirm_new_password' class='form-control' value="<?php echo isset($_POST['confirm_new_password']) ? $_POST['confirm_new_password'] : ''; ?>" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <a href='customer_read.php' class='btn btn-danger'>Back to customer list</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>