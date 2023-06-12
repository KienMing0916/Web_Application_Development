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
    <title>Week 4 Q3</title>
</head>
<body>
    <div class="container">
        <h1 class="my-3">Question 3</h1>
        <form method="POST" action="">
            <div class="form-group my-1">
                <label for="firstNumber">First Number:</label>
                <input type="text" class="form-control" id="firstNumber" name="firstNumber">
            </div>
            <div class="form-group my-1">
                <label for="secondNumber">Second Number:</label>
                <input type="text" class="form-control" id="secondNumber" name="secondNumber">
            </div>
            <button type="submit" class="btn btn-primary my-2" name="submit">Submit</button>
        </form>

        <?php
        if(isset($_POST['submit'])) {
            $firstNumber = $_POST['firstNumber'];
            $secondNumber = $_POST['secondNumber'];

            if (!is_numeric($firstNumber) || !is_numeric($secondNumber)) {
                echo '<div class = "alert alert-danger">'. "Please fill in a number." . '</div>';
            }else {
                echo '<div class = "alert alert-success role="alert">' . "The sum of two numbers is: " . $firstNumber + $secondNumber . '</div>';
            }
        }
        ?>
    </div>
</body>
</html>