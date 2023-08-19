<?php
include 'menu/validate_login.php';
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Customer Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container p-0 bg-light">
        <?php
            include 'menu/nav.php';
        ?>

        <div class="page-header p-3 pb-1">
            <h1>Customer Details</h1>
        </div>
         
        <?php
        $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        if ($action == 'record_saved') {
            echo "<div class='alert alert-success m-3'>Customer record was saved.</div>";
        }

        if ($action == 'record_updated') {
            echo "<div class='alert alert-success m-3'>Customer record was updated.</div>";
        }

        include 'config/database.php';
        try {
            $query = "SELECT Customer_ID, username, firstname, lastname, gender, birthdate, registrationdatetime, email, status, profile_image FROM customers WHERE Customer_ID = :id ";
            $stmt = $con->prepare( $query );
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            $username = $row['username'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $gender = $row['gender'];
            $birthdate = $row['birthdate'];
            $registrationdatetime = $row['registrationdatetime'];
            $email = $row['email'];
            $status = $row['status'];
            $image = $row['profile_image'];
            $img_directory = "uploaded_customer_img/" . $image;
        }
        catch(PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <div class="p-3">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td class='col-3'>Username</td>
                    <td><?php echo htmlspecialchars($username, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>First name</td>
                    <td><?php echo htmlspecialchars($firstname, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Last name</td>
                    <td><?php echo htmlspecialchars($lastname, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td><?php echo htmlspecialchars($gender, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Date of Birth</td>
                    <td><?php echo htmlspecialchars($birthdate, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><?php echo htmlspecialchars($email, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Registration Time</td>
                    <td><?php echo htmlspecialchars($registrationdatetime, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td><?php echo htmlspecialchars($status, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Profile Image</td>
                    <td>
                        <img src="<?php echo htmlspecialchars($img_directory, ENT_QUOTES); ?>" alt="<?php echo htmlspecialchars($username, ENT_QUOTES); ?>" width="200" height="200">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <a href='customer_read.php' class='btn btn-danger'>Back to customer list</a>
                    </td>
                </tr>
            </table>
        </div>   
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>

