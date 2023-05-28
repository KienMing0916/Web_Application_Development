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
    <title>Homework 1</title>
    <style>
        select option {
        font-size: 18px;
        background-color: #f0f0f0;
        }
  </style>
</head>

<body>
    <div class="container-fluid mt-3">
        <div class="row">
            
            <div class="col-sm">
                <select class="form-select form-select-lg mb-3 bg-info" aria-label=".form-select-lg example">
                <option value="day" disabled selected hidden>DAY</option>";
                    <?php
                        for ($day = 1; $day <= 31; $day++) {
                            echo "<option value=\"numberofday\"> $day </option>";
                        } 
                    ?>
                </select>
            </div>

            <div class="col-sm">
                <select class="form-select form-select-lg mb-3 bg-warning text-dark" aria-label=".form-select-lg example">
                <option value="month" disabled selected hidden>MONTH</option>";
                    <?php
                        for ($month = 1; $month <= 12; $month++) {
                            echo "<option value=\"numberofday\"> $month </option>";
                        } 
                    ?>
                </select>
            </div>

            <div class="col-sm">
                <select class="form-select form-select-lg mb-3 bg-danger text-dark" aria-label=".form-select-lg example">
                <option value="year" disabled selected hidden>YEAR</option>";
                    <?php
                        for ($year = 1900; $year <= 2023; $year++) {
                            echo "<option value=\"numberofyear\"> $year </option>";
                        } 
                    ?>
                </select>
            </div>
        </div>
    </div>
</body>

</html>