<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Week 6 Q1</title>
</head>
<body>
    <div class="container">
        <h1 class="my-3">Question 1</h1>
        <form method="POST" action="">
            
            <div class="row my-2">
                <label for="dateofbirth">Date of birth:</label>
                <div class="col-sm">
                    <select class="fs-6 form-select form-select-lg mb-2" name="selected_day" aria-label=".form-select-lg example" required>
                        <option value="" disabled selected hidden>DAY</option>
                        <?php
                        for ($day = 1; $day <= 31; $day++) {
                            $paddedDay = str_pad($day, 2, '0', STR_PAD_LEFT);
                            echo "<option value=\"$paddedDay\">$paddedDay</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-sm">
                    <select class="fs-6 form-select form-select-lg mb-2" name="selected_month" aria-label=".form-select-lg example" required>
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
                    <select class="fs-6 form-select form-select-lg mb-2" name="selected_year" aria-label=".form-select-lg example" required>
                        <option value="" disabled selected hidden>YEAR</option>
                        <?php
                        for ($year = 1900; $year <= date('Y') ; $year++) {
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
            //current year
            date_default_timezone_set('Asia/Kuala_Lumpur');
            $currentYear = date('Y');
            $currentMonth = date('m');
            $currentDay = date('d');

            $selectedDay = $_POST['selected_day'];
            $selectedMonth = $_POST['selected_month'];
            $selectedYear = $_POST['selected_year'];

            if (!empty($selectedDay) && !empty($selectedMonth) && !empty($selectedYear)) {
                
                $age = $currentYear - $selectedYear;
                $zodiac = array("Monkey", "Rooster", "Dog", "Pig", "Rat", "Ox", "Tiger", "Rabbit", "Dragon", "Snake", "Horse", "Goat");

                if (($selectedMonth == 4 && $selectedDay >= 19) || ($selectedMonth == 5 && $selectedDay <= 13)) {
                    $constellation = "Aries";
                }else if(($selectedMonth == 5 && $selectedDay >= 14) || ($selectedMonth == 6 && $selectedDay <= 19)) {
                    $constellation = "Taurus";
                }else if(($selectedMonth == 6 && $selectedDay >= 20) || ($selectedMonth == 7 && $selectedDay <= 20)) {
                    $constellation = "Gemini";
                }else if(($selectedMonth == 7 && $selectedDay >= 21) || ($selectedMonth == 8 && $selectedDay <= 9)) {
                    $constellation = "Cancer";
                }else if(($selectedMonth == 8 && $selectedDay >= 10) || ($selectedMonth == 9 && $selectedDay <= 15)) {
                    $constellation = "Leo";
                }else if(($selectedMonth == 9 && $selectedDay >= 16) || ($selectedMonth == 10 && $selectedDay <= 30)) {
                    $constellation = "Virgo";
                }else if(($selectedMonth == 10 && $selectedDay >= 31) || ($selectedMonth == 11 && $selectedDay <= 22)) {
                    $constellation = "Libra";
                }else if(($selectedMonth == 11 && $selectedDay >= 23) || ($selectedMonth == 11 && $selectedDay <= 29)) {
                    $constellation = "Scorpio";
                }else if(($selectedMonth == 11 && $selectedDay >= 30) || ($selectedMonth == 12 && $selectedDay <= 17)) {
                    $constellation = "Ophiuchus";
                }else if(($selectedMonth == 12 && $selectedDay >= 18) || ($selectedMonth == 1 && $selectedDay <= 18)) {
                    $constellation = "Sagittarius";
                }else if(($selectedMonth == 1 && $selectedDay >= 19) || ($selectedMonth == 2 && $selectedDay <= 15)) {
                    $constellation = "Capricorn";
                }else if(($selectedMonth == 2 && $selectedDay >= 16) || ($selectedMonth == 3 && $selectedDay <= 11)) {
                    $constellation = "Aquarius";
                }else if(($selectedMonth == 3 && $selectedDay >= 12) || ($selectedMonth == 4 && $selectedDay <= 18)) {
                    $constellation = "Pisces";
                }
        
                if (checkdate($selectedMonth, $selectedDay, $selectedYear)){
                    echo '<div class="alert alert-success" role="alert">' . "Your age is " . $age . ".<br>Your Chinese zodiac is " . $zodiac[$selectedYear % 12] . ".<br>Your constellation is " . $constellation . "." . '</div>';  
                } else {
                    echo '<div class="alert alert-danger" role="alert">' . "Invalid date of birth." . '</div>'; 
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">' . "Please select a valid date of birth." . '</div>'; 
            }
        }
        ?>
    </div>
</body>
</html>