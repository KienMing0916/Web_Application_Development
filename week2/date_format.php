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
        <title>Homework 3</title>
        <style>
            .brown-text { color: #AD813B;}
            h1 {font-size: 50px; font-weight: bold;}
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
        </div>
    </body>
</html>