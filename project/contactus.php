<!DOCTYPE HTML>
<html>
<head>
    <title>Contact Form</title>
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
            <h1>Contact Us</h1>
        </div>
      
        <?php
        if($_POST){
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $phonenumber = $_POST['phonenumber'];
            $address = $_POST['address'];
            $message = $_POST['message'];

            $errorMessage = array();

            if(empty($firstName)) {
                $errorMessage[] = "First name field is empty.";
            }
            if(empty($lastName)) {
                $errorMessage[] = "Last name field is empty.";
            }
            if(empty($email)) {
                $errorMessage[] = "Email field is empty.";
            }else {
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errorMessage[] = "Invalid email format.";
                }
            }
            if(empty($phonenumber)) {
                $errorMessage[] = "Phone number field is empty.";
            }
            if(empty($address)) {
                $errorMessage[] = "Address field is empty.";
            }
            if(empty($message)) {
                $errorMessage[] = "Message field is empty.";
            }


            if(!empty($errorMessage)) {
                echo "<div class='alert alert-danger m-3'>";
                foreach ($errorMessage as $displayErrorMessage) {
                    echo $displayErrorMessage . "<br>";
                }
                echo "</div>";
            } else {
                //Send the email
                // $to = 'your-email@example.com';
                // $subject = 'Contact Form Submission';
                // $messageBody = "First Name: $firstName\n";
                // $messageBody .= "Last Name: $lastName\n";
                // $messageBody .= "Email: $email\n";
                // $messageBody .= "phonenumber: $phonenumber\n";
                // $messageBody .= "Address: $address\n";
                // $messageBody .= "Message: $message\n";
                // $headers = "From: $email";

                if (mail($to, $subject, $messageBody, $headers)) {
                    echo "<div class='alert alert-success m-3'>Message sent successfully!</div>";
                } else {
                    echo "<div class='alert alert-danger m-3'>Failed to send the message. Please try again.</div>";
                }
            }
        }
        ?>

        <div class="container p-3">
            <form method="post">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo isset($_POST['firstName']) ? $_POST['firstName'] : ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo isset($_POST['lastName']) ? $_POST['lastName'] : ''; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="phonenumber" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phonenumber" name="phonenumber" value="<?php echo isset($_POST['phonenumber']) ? $_POST['phonenumber'] : ''; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="5"><?php echo isset($_POST['message']) ? $_POST['message'] : ''; ?></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <!-- end container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
