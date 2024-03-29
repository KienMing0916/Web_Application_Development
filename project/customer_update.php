<?php
include 'menu/validate_login.php';
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Update Customer Details</title>
    <link rel="icon" type="image/x-icon" href="img/factorylogo.png">
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

        } catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }

        if (isset($_POST['delete_image'])) {
            include 'menu/validate_function.php';
            try {           
                $query = "UPDATE customers SET firstname=:firstname, lastname=:lastname, gender=:gender, birthdate=:birthdate, email=:email, status=:status, profile_image=:image";       
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
                $defaultImage = 'uploaded_customer_img/defaultcustomerimg.jpg';     
                $image = !empty($_FILES["image"]["name"]) ? "uploaded_customer_img/" . sha1_file($_FILES['image']['tmp_name']) . basename($_FILES["image"]["name"]) : "";

                // Check if the email already exists
                $emailQuery = "SELECT COUNT(*) FROM customers WHERE email = :email AND Customer_ID != :id";
                $emailStmt = $con->prepare($emailQuery);
                $emailStmt->bindParam(':email', $email);
                $emailStmt->bindParam(':id', $id);
                $emailStmt->execute();
                $emailCount = $emailStmt->fetchColumn();

                $errorMessage = validateUpdateCustomerForm($username, $firstname, $lastname, $gender, $birthdate, $email, $emailCount, $status, $db_password, $current_password, $new_password, $confirm_new_password, $image);
                if($uploadedImage === 'uploaded_customer_img/defaultcustomerimg.jpg'){
                    $errorMessage[] = "No profile image found.";
                }

                if (!empty($errorMessage)) {
                    echo "<div class='alert alert-danger m-3'>";
                    foreach ($errorMessage as $displayErrorMessage) {
                        echo $displayErrorMessage . "<br>";
                    }
                    echo "</div>";
                } else {
                    if (!empty($current_password) && !empty($new_password) && !empty($confirm_new_password)) {
                        $query .= ", password=:password ";
                        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    }

                    $query .= " WHERE Customer_ID = :id";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':firstname', $firstname);
                    $stmt->bindParam(':lastname', $lastname);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':birthdate', $birthdate);
                    $stmt->bindParam(':status', $status);
                    $stmt->bindParam(':image', $defaultImage);
                    $stmt->bindParam(':id', $id);

                    if (!empty($hashed_password)) {
                        $stmt->bindParam(':password', $hashed_password);
                    }                    

                    if ($uploadedImage !== 'uploaded_customer_img/defaultcustomerimg.jpg') {
                        if (file_exists($uploadedImage)) {
                            unlink($uploadedImage);
                        }
                    }

                    if ($stmt->execute()) {
                        header("Location: customer_read_one.php?id={$id}&action=record_updated");
                        exit();
                    } else {
                        echo "<div class='alert alert-danger m-3'>Unable to update record. Please try again.</div>";
                    }
                }

            } catch (PDOException $exception) {
                echo "<div class='alert alert-danger m-3'>ERROR: " . $exception->getMessage() . "</div>";
                die('ERROR: ' . $exception->getMessage());
            }
        }

        if(isset($_POST['save_changes'])){
            include 'menu/validate_function.php';
            try {
                $query = "UPDATE customers SET firstname=:firstname, lastname=:lastname, gender=:gender, birthdate=:birthdate, email=:email, status=:status, profile_image=:image";       
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
                $image = !empty($_FILES["image"]["name"]) ? "uploaded_customer_img/" . sha1_file($_FILES['image']['tmp_name']) . basename($_FILES["image"]["name"]) : "";
                
                // Check if the email already exists
                $emailQuery = "SELECT COUNT(*) FROM customers WHERE email = :email AND Customer_ID != :id";
                $emailStmt = $con->prepare($emailQuery);
                $emailStmt->bindParam(':email', $email);
                $emailStmt->bindParam(':id', $id);
                $emailStmt->execute();
                $emailCount = $emailStmt->fetchColumn();

                $errorMessage = validateUpdateCustomerForm($username, $firstname, $lastname, $gender, $birthdate, $email, $emailCount, $status, $db_password, $current_password, $new_password, $confirm_new_password, $image);         

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
                    $stmt->bindParam(':firstname', $firstname);
                    $stmt->bindParam(':lastname', $lastname);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':birthdate', $birthdate);
                    $stmt->bindParam(':status', $status);
                    $stmt->bindParam(':id', $id);
                    
                    if($image === ""){
                        $stmt->bindParam(':image', $uploadedImage);
                    }else{
                        $stmt->bindParam(':image', $image);
                    }
            
                    if (!empty($hashed_password)) {
                        $stmt->bindParam(':password', $hashed_password);
                    }

                    if ($uploadedImage !== 'uploaded_customer_img/defaultcustomerimg.jpg' && $image !== $uploadedImage) {
                        // Remove the existing image
                        if (file_exists($uploadedImage) && $image !== "") {
                            unlink($uploadedImage);
                        }
                    }
            
                    if ($stmt->execute()) { 
                        // record updated
                        header("Location: customer_read_one.php?id={$id}&action=record_updated");
                        exit();
                    } else {
                        echo "<div class='alert alert-danger m-3'>Unable to update record. Please try again.</div>";
                    }
                } 

            }catch(PDOException $exception){
                echo "<div class='alert alert-danger m-3'>ERROR: " . $exception->getMessage() . "</div>";
                die('ERROR: ' . $exception->getMessage());
            }
        }

        ?>

        <form class="p-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post" enctype="multipart/form-data">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td class="col-4">Username</td>
                    <td><input type='text' name='username' minlength="5" maxlength="20" value="<?php echo htmlspecialchars($username, ENT_QUOTES); ?>" class='form-control' readonly/></td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td><input type='text' name='firstname' maxlength="30" value="<?php echo htmlspecialchars($firstname, ENT_QUOTES); ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type='text' name='lastname' maxlength="30" value="<?php echo htmlspecialchars($lastname, ENT_QUOTES); ?>" class='form-control' /></td>
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
                        <img src="<?php echo htmlspecialchars($uploadedImage, ENT_QUOTES); ?>" width="200" height="200">
                        <br><br>
                        <input type="file" name="image" class="form-control" accept="image/*">
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
                        <button type="submit" name="save_changes" class="btn btn-primary">Save Changes</button>
                        <button type="submit" name="delete_image" class="btn btn-secondary">Delete profile image</button>
                        <a href='customer_read.php' class='btn btn-danger'>Back to customer list</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>