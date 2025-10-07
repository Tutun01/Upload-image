<?php

require_once __DIR__ . "/models/images.php";

$image = new Images();

$imageSize = $_FILES['profileImage']['size'];

if(!$image ->isValidSize($imageSize)) {
    die ("Slika je golema");    
} 

$imageType = pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION);
if(!$image->isValidExtension($imageType)) {
    die("Nije dobra ekstenzija slike");
} 

list($width, $height) = getimagesize($_FILES['profileImage']['tmp_name']);
if(!$image->isValidDimensions($width, $height)) {
    die("Slika je presiroka | previsoka");
} 

$randomName = $image->generateRandomName('jpg');
if (!is_dir('./uploads') ) {
    mkdir('./uploads', 0755, true);
}

$image->upload($_FILES['profileImage']['tmp_name'], $randomName, "uploads");


$connection = mysqli_connect("localhost", "root", "root", "php23", 8889);

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$imageName = $connection->real_escape_string($randomName);
$query = "INSERT INTO images (image) VALUES ('$imageName')";

if ($connection->query($query)) {
    echo "Image uploaded successfully!";
} else {
    echo "Database error: " . $connection->error;
}

?>
