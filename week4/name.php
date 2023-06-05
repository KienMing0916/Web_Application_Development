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
    <title>Week 4 Q1</title>
</head>
<body>
    <div class="container">
        <h1 class="my-3">Question 1</h1>
        <form method="POST" action="">
            <div class="form-group my-1">
                <label for="firstName">First Name:</label>
                <input type="text" class="form-control" id="firstName" name="firstName">
            </div>
            <div class="form-group my-1">
                <label for="lastName">Last Name:</label>
                <input type="text" class="form-control" id="lastName" name="lastName">
            </div>
            <button type="submit" class="btn btn-primary my-2" name="submit">Submit</button>
        </form>

        <?php
        if(isset($_POST['submit'])) {
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            // string to lower -> first character to upper
            $formattedFirstName = ucwords(strtolower($firstName));
            $formattedLastName = ucwords(strtolower($lastName));

            echo '<div class = "alert alert-success role="alert">' . "Name: " . $formattedLastName . " " . $formattedFirstName . '</div>';
        }
        ?>
    </div>
</body>
</html>