<?php

require_once "models/db.php";

$db = new DB();


$connection = mysqli_connect("localhost", "root", "root", "php23");

$data = $connection->query("SELECT * FROM images");

?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <?php  foreach($data as $image): ?>
            <img width="150px" height="auto" src = "uploads/<?= $image['image'] ?>" />
        <?php endforeach ?>


    </body>
</html>