<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise 1</title>
    <style>
        body{
            font-size: 25px;
        }

        .line1 {
            color:green;
            font-style: italic;
        }
        .line2 {
            color:blue;
            font-style: italic;
        }
        .line3 {
            color:red;
            font-weight: bold;
        }
        .line4 {
            font-weight: bold;
            font-style: italic;
        }
    </style>
</head>

<body>
    <?php
    $num_x = rand (100,200);
    $num_y = rand (100,200);

    echo "<h3 class=line1> First random number is " . $num_x . "." . "<br><br></h3>";
    echo "<h3 class=line2> Second random number is " . $num_y . "." . "<br><br></h3>";
    echo "<h3 class=line3> The sum of two random number is " . $num_x + $num_y . "." . "<br><br></h3>";
    echo "<h3 class=line4> The multiplication of two random number is " . $num_x * $num_y . "." . "<br><br></h3>"; 
    ?>

</body>
</html>