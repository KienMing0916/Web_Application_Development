<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Week 5 Q2</title>
</head>

<body>
    <div class="container p-3 my-sm-5 mx-auto bg-light border border-3">
        <h2 class="my-3">Registration Form</h2>
        <form method="POST" action="">
            <div class="row mt-4">
                <div class="col-sm">
                    <label for="firstName">First Name:</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo isset($_POST['firstName']) ? $_POST['firstName'] : ''; ?>" required>
                </div>
                <div class="col-sm">
                    <label for="lastName">Last Name:</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo isset($_POST['lastName']) ? $_POST['lastName'] : ''; ?>" required>
                </div>
            </div>
            
            <div class="row my-3">
                <label for="dateofbirth">Date of birth:</label>
                <div class="col-sm my-sm-0 my-2">
                    <select class="fs-6 form-select form-select-lg" name="selected_day" aria-label=".form-select-lg example" required>
                        <option value="" <?php if (!isset($_POST['selected_day'])) echo 'selected'; ?> disabled hidden>DAY</option>
                        <?php
                        for ($day = 1; $day <= 31; $day++) {
                            $selected = (isset($_POST['selected_day']) && $_POST['selected_day'] == $day) ? 'selected' : '';
                            echo "<option value=\"$day\" $selected>$day</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-sm my-sm-0 my-2">
                    <select class="fs-6 form-select form-select-lg" name="selected_month" aria-label=".form-select-lg example" required>
                        <option value="" <?php if (!isset($_POST['selected_month'])) echo 'selected'; ?> disabled hidden>MONTH</option>
                        <?php
                        $month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                        for ($i = 0; $i < count($month); $i++) {
                            $selected = (isset($_POST['selected_month']) && $_POST['selected_month'] == ($i + 1)) ? 'selected' : '';
                            echo "<option value=\"" . ($i + 1) . "\" $selected>$month[$i]</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-sm my-sm-0 my-2">
                    <select class="fs-6 form-select form-select-lg" name="selected_year" aria-label=".form-select-lg example" required>
                        <option value="" <?php if (!isset($_POST['selected_year'])) echo 'selected'; ?> disabled hidden>YEAR</option>
                        <?php
                        for ($year = 1900; $year <= date('Y') ; $year++) {
                            $selected = (isset($_POST['selected_year']) && $_POST['selected_year'] == $year) ? 'selected' : '';
                            echo "<option value=\"$year\" $selected>$year</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-sm my-3">
                <label for="gender" class="d-block my-2">Gender:</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'male') ? 'checked' : ''; ?> required>
                    <label class="form-check-label" for="male">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="female" value="female" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'female') ? 'checked' : ''; ?> required>
                    <label class="form-check-label" for="female">Female</label>
                </div>
            </div>

            <div class="row">
                <div class="col-sm">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" required>
                </div>                
                <div class="col-sm">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
                </div>
            </div>

            <div class="row my-2">
                <div class="col-sm">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="col-sm">
                    <label for="confirmPassword">Confirm Password:</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary my-2" name="submit">Submit</button>
        </form>

        <?php
            if (isset($_POST['submit'])) {
                $firstName = $_POST['firstName'];
                $lastName = $_POST['lastName'];
                $selectedDay = $_POST['selected_day'];
                $selectedMonth = $_POST['selected_month'];
                $selectedYear = $_POST['selected_year'];
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $confirmPassword = $_POST['confirmPassword'];

                $usernamePattern = "/^[A-Za-z][A-Za-z0-9_-]{5,}$/";
                $emailPattern = "/^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$/";
                $passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/";

                if (!preg_match($usernamePattern, $username)) {
                    echo '<div class="alert alert-danger" role="alert">' . "Username must be at least 6 characters long, start with a letter, and can only contain letters, digits, '_', or '-'." . '</div>'; 
                }else if (!preg_match($emailPattern, $email)) {
                    echo '<div class="alert alert-danger" role="alert">' . "Invalid email format." . '</div>'; 
                }else if (!preg_match($passwordPattern, $password)) {
                    echo '<div class="alert alert-danger" role="alert">' . "Password must be at least 6 characters long and contain at least one uppercase letter, one lowercase letter, and one number. No special symbols allowed." . '</div>'; 
                }else if ($password !== $confirmPassword) {
                    echo '<div class="alert alert-danger" role="alert">' . "Password do not match." . '</div>'; 
                }else {
                    echo '<div class="alert alert-success" role="alert">' . "Registration success.<br>Welcome " . $username . "." . '</div>';
                    echo '<script>document.getElementById("firstName").value = "";</script>';
                    echo '<script>document.getElementById("lastName").value = "";</script>';
                    echo '<script>document.getElementsByName("selected_day")[0].selectedIndex = 0;</script>';
                    echo '<script>document.getElementsByName("selected_month")[0].selectedIndex = 0;</script>';
                    echo '<script>document.getElementsByName("selected_year")[0].selectedIndex = 0;</script>';
                    echo '<script>document.getElementById("male").checked = false;</script>';
                    echo '<script>document.getElementById("female").checked = false;</script>';
                    echo '<script>document.getElementById("username").value = "";</script>';
                    echo '<script>document.getElementById("email").value = "";</script>';
                    echo '<script>document.getElementById("password").value = "";</script>';
                    echo '<script>document.getElementById("confirmPassword").value = "";</script>';
                }
            }
        ?>
    </div>
</body>
</html>
