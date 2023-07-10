<!DOCTYPE HTML>
<html>
<head>
    <title>Read Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container p-0 bg-light">
        <?php
            include 'menu.php';
        ?>

        <div class="page-header p-3 pb-1">
            <h1>Read Customer</h1>
        </div>
         
        <?php
        $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        include 'config/database.php';
        // read current record's data
        try {
            // prepare select query
            $query = "SELECT Customer_ID, username, firstname, lastname, gender, birthdate, RegistrationDateTime, status FROM customers WHERE Customer_ID = :id ";
            $stmt = $con->prepare( $query );
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
            // values to fill up our form
            $username = $row['username'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $gender = $row['gender'];
            $birthdate = $row['birthdate'];
            $RegistrationDateTime = $row['RegistrationDateTime'];
            $status = $row['status'];
        }
        
        // show error
        catch(PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <div class="p-3">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Username</td>
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
                    <td>Registration Time</td>
                    <td><?php echo htmlspecialchars($RegistrationDateTime, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td><?php echo htmlspecialchars($status, ENT_QUOTES);  ?></td>
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

