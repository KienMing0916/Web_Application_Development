<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
    <title>Exercise 3</title>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col fs-4">
                <?php
                $sum = 0;

                echo '<div class="container">';
                echo '<p>';
                for ($num = 1; $num <= 100; $num++) {
                    if ($num % 2 === 0) {
                        echo '<b>' . $num . '</b>';
                    } else {
                        echo $num;
                    }

                    if ($num !== 100) {
                        echo ' + ';
                    }

                    $sum += $num;
                }
                echo ' = ' . $sum;
                echo '</p>';
                echo '</div>';
                ?></div>
        </div>
    </div>
</body>

</html>