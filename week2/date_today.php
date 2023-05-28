<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
            crossorigin="anonymous"></script>
        <title>Homework 4</title>
        <style>
            .brown-text { color: #AD813B;}
            h1 {font-size: 40px; font-weight: bold;}
            select option {font-size: 18px; background-color: #f0f0f0;}
        </style>    
    </head>
    <body>
        <div class="container-fluid">
            <div class="row m-3">
                <h1>
                    <?php
                        date_default_timezone_set('Asia/Kuala_Lumpur');
                        $date = date("F d, Y");
                        $month = date("F");
                        echo str_replace($month, '<span class="brown-text">' . $month . '</span>', $date);
                    ?>
                </h1>

                <h1><?php echo date("H:i:s"); ?></h1>
            </div>
            
            <div class="row">
            
            <div class="col-sm">
                <select class="form-select form-select-lg mb-3 bg-info" aria-label=".form-select-lg example">
                    <?php
                        echo "<option value=\"$day\" disabled hidden>DAY</option>";
                        $currentDay = date("d");
                        for ($day = 1; $day <= 31; $day++) {
                            $selected = ($day == $currentDay) ? "selected" : "";
                            echo "<option value=\"$day\" $selected> $day </option>";
                        } 
                    ?>
                </select>
            </div>

            <div class="col-sm">
                <select class="form-select form-select-lg mb-3 bg-warning text-dark" aria-label=".form-select-lg example">
                    <?php
                        echo "<option value=\"$month\" disabled hidden>MONTH</option>";
                        $currentMonth = date("F");
                        $month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                        for ($i = 0; $i < count($month); $i++) {
                            $selected = ($month[$i] == $currentMonth) ? "selected" : "";
                            echo "<option value=\"$month[$i]\" $selected> $month[$i] </option>";
                        }
                    ?>
                </select>
            </div>

            <div class="col-sm">
                <select class="form-select form-select-lg mb-3 bg-danger text-dark" aria-label=".form-select-lg example">
                    <?php
                        echo "<option value=\"$year\" disabled hidden>YEAR</option>";
                        $currentYear = date("Y");
                        for ($year = 1900; $year <= 2023; $year++) {
                            $selected = ($year == $currentYear) ? "selected" : "";
                            echo "<option value=\"$year\" $selected> $year </option>";
                        } 
                    ?>
                </select>
            </div>
        </div>
    </body>
</html>