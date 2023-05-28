<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Homework 5</title>
    </head>
    <body>
        <?php
            $rows = 10;
            for ($i = $rows; $i >= 1; $i--) {
                for ($j = 1; $j <= $i; $j++) {
                    echo " * ";
                }
            echo "<br>";
            }
        ?>
    </body>
</html>