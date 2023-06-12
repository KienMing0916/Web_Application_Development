<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Week 5 Q1</title>
</head>
<body>
    <div class="container">
        <h1 class="my-3">Question 1</h1>
        <form method="POST" action="">
            <div class="form-group my-1">
                <label for="firstName">First Name:</label>
                <input type="text" class="form-control" id="firstName" name="firstName" required>
            </div>
            <div class="form-group my-1">
                <label for="lastName">Last Name:</label>
                <input type="text" class="form-control" id="lastName" name="lastName" required>
            </div>
            
            <div class="row my-3">
            
            <div class="col-sm">
                <select class="fs-6 form-select form-select-lg mb-3" name="selected_day" aria-label=".form-select-lg example" required>
                    <option value="" disabled selected hidden>DAY</option>
                    <?php
                    for ($day = 1; $day <= 31; $day++) {
                        echo "<option value=\"$day\">$day</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="col-sm">
                <select class="fs-6 form-select form-select-lg mb-3" name="selected_month" aria-label=".form-select-lg example" required>
                    <option value="" disabled selected hidden>MONTH</option>
                    <?php
                    $month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                    for ($i = 0; $i < count($month); $i++) {
                        echo "<option value=\"" . ($i + 1) . "\">$month[$i]</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="col-sm">
                <select class="fs-6 form-select form-select-lg mb-3" name="selected_year" aria-label=".form-select-lg example" required>
                    <option value="" disabled selected hidden>YEAR</option>
                    <?php
                    for ($year = 1900; $year <= 2023; $year++) {
                        echo "<option value=\"$year\">$year</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

            <button type="submit" class="btn btn-primary my-2" name="submit">Submit</button>
        </form>

        <?php
        if(isset($_POST['submit'])) {
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $selectedDay = $_POST['selected_day'];
            $selectedMonth = $_POST['selected_month'];
            $selectedYear = $_POST['selected_year'];

            // string to lower -> first character to upper
            $formattedFirstName = ucwords(strtolower($firstName));
            $formattedLastName = ucwords(strtolower($lastName));
            //current year
            date_default_timezone_set('Asia/Kuala_Lumpur');
            $currentYear = date('Y');
            $currentMonth = date('m');
            $currentDay = date('d');

            $age = $currentYear - $selectedYear;
            // haven't had birthday yet
            if ($selectedMonth > $currentMonth || ($selectedMonth == $currentMonth && $selectedDay > $currentDay)) {
                $age--;
            }

            if($age < 18){
                echo '<div class="alert alert-danger" role="alert">' . "Name: " . $formattedLastName . " " . $formattedFirstName . "<br>Birthday: " . $selectedDay . " " . $month[$selectedMonth - 1] . " " . $selectedYear . "<br>Age: " . $age . '</div>'; 
                echo '<div class = "alert alert-danger role="alert">'. "Your age is below 18." . '</div>';
            }else{
                echo '<div class="alert alert-success" role="alert">' . "Name: " . $formattedLastName . " " . $formattedFirstName . "<br>Birthday: " . $selectedDay . " " . $month[$selectedMonth - 1] . " " . $selectedYear . "<br>Age: " . $age . '</div>'; 
                echo '<div class="alert alert-success" role="alert">' . "Welcome" . '</div>'; 
            }


            //echo '<div class="alert alert-success" role="alert">' . "Name: " . $formattedLastName . " " . $formattedFirstName . "<br>Birthday: " . $selectedDay . " " . $month[$selectedMonth - 1] . " " . $selectedYear . "<br>Age: " . $age . '</div>';   
        }
        ?>
    </div>
</body>
</html>
