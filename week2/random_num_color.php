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
    <title>Exercise 2</title>
</head>

<body>
    <div class="container-fluid">
            <?php
            $num_x = rand(1, 100);
            $num_y = rand(1, 100);
            
            if ($num_x > $num_y) {
                echo "<div class=\"row \">
                    <div class = \"col-sm fs-1 fw-bold bg-primary my-1\">
                        <p>First number: $num_x</p>
                    </div>
                    <div class =\"col-sm fs-2 fw-bold bg-secondary my-1\">
                        <p>Second number: $num_y</p>
                    </div>
                </div>";
            } else if ($num_y > $num_x){
                echo "<div class=\"row\">
                    <div class = \"col-sm fs-2 fw-bold bg-secondary my-1\">
                        <p>First number: $num_x</p>
                    </div>
                    <div class =\"col-sm fs-1 fw-bold bg-primary my-1\">
                        <p>Second number: $num_y</p>
                    </div>
                </div>";
            } else {
                echo "<div class=\"row\">
                    <div class = \"col-sm fs-1 fw-bold bg-primary my-1\">
                        <p>First number: $num_x</p>
                    </div>
                    <div class =\"col-sm fs-1 fw-bold bg-primary my-1\">
                        <p>Second number: $num_y</p>
                    </div>
                </div>";
            }
            ?>
        </div>
    </div>
</body>
</html>