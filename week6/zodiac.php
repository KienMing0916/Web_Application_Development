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
            $selectedDay = $_POST['selected_day'];
            $selectedMonth = $_POST['selected_month'];
            $selectedYear = $_POST['selected_year'];

            //current year
            date_default_timezone_set('Asia/Kuala_Lumpur');
            $currentYear = date('Y');
            $currentMonth = date('m');
            $currentDay = date('d');

            $age = $currentYear - $selectedYear;


            $zodiac = array("Monkey", "Rooster", "Dog", "Pig", "Rat", "Ox", "Tiger", "Rabbit", "Dragon", "Snake", "Horse", "Goat");
            $mmdd = $selectedMonth.$selectedDay;
            $constellation = "";

            if ($mmdd >= "0419" && $mmdd <= "0513") {
                $constellation = "Aries";
            }else if ($mmdd >= "0514" && $mmdd <= "0619") {
                $constellation = "Taurus";
            }else if ($mmdd >= "0620" && $mmdd <= "0720") {
                $constellation = "Gemini";
            }else if ($mmdd >= "0721" && $mmdd <= "0809") {
                $constellation = "Cancer";
            }else if ($mmdd >= "0810" && $mmdd <= "0915") {
                $constellation = "Leo";
            }else if ($mmdd >= "0916" && $mmdd <= "1030") {
                $constellation = "Virgo";
            }else if ($mmdd >= "1031" && $mmdd <= "1122") {
                $constellation = "Libra";
            }else if ($mmdd >= "1123" && $mmdd <= "1129") {
                $constellation = "Scorpio";
            }else if ($mmdd >= "1130" && $mmdd <= "1217") {
                $constellation = "Ophiuchus";
            } else if (($mmdd >= "1218" && $mmdd <= "1231") || ($mmdd >= "0101" && $mmdd <= "0118")) {
                $constellation = "Sagittarius";
            } else if ($mmdd >= "0119" && $mmdd <= "0215") {
                $constellation = "Capricorn";
            } else if ($mmdd >= "0216" && $mmdd <= "0311") {
                $constellation = "Aquarius";
            } else if ($mmdd >= "0312" && $mmdd <= "0418") {
                $constellation = "Pisces";
            }


            if (checkdate($selectedMonth, $selectedDay, $selectedYear)){
                echo '<div class="alert alert-success" role="alert">' . "Your age is " . $age . ".". '</div>'; 
                echo '<div class="alert alert-success" role="alert">' . "Your chinese zodiac is " . $zodiac[$selectedYear % 12] . "." . '</div>'; 
                echo '<div class="alert alert-success" role="alert">' . "Your constellation is $constellation.". '</div>'; 
            }else{
                echo '<div class="alert alert-danger" role="alert">' . "Invalid date of birth." . '</div>'; 
            }
        }
        ?>
    </div>
</body>
</html>