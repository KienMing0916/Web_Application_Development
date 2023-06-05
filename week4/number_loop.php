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
    <title>Week 4 Q4</title>
</head>
<body>
    <div class="container">
        <h1 class="my-3">Question 4</h1>
        <form method="POST" action="">
            <div class="form-group my-1">
                <label for="number">Number:</label>
                <input type="text" class="form-control" id="number" name="number">
            </div>
            <button type="submit" class="btn btn-primary my-2" name="submit">Submit</button>
        </form>

        <?php
        if(isset($_POST['submit'])) {
            $number = $_POST['number'];
            $sum = 0;

            if (empty($number)){
                echo '<div class = "alert alert-danger role="alert">'. "Please fill in the text box." . '</div>';
            }else if (!is_numeric($number)) {
                echo '<div class = "alert alert-danger role="alert">'. "Please fill in a number." . '</div>';
            }else if ($number <= 1){
                echo '<div class = "alert alert-danger role="alert">'. "Please fill in a number larger than 1." . '</div>';
            }else {
                for ($i = $number; $i >= 1; $i--) {
                    $sum += $i;
                }
                $result = implode(' + ', range(1, $number)) . ' = ' . $sum;
                echo '<div class = "alert alert-success role="alert">' . $result . '</div>';
            }
        }
        ?>
    </div>
</body>
</html>