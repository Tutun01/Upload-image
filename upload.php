<?php

if (!isset($_FILES['profileImage'])) {
    die("No profile image was provided!");
}

// Check file size
$imageSize = $_FILES['profileImage']['size'];
$maxFileSize = 2 * 1024 * 1024; // 2MB

if ($imageSize > $maxFileSize) {
    die("The image file is too large!");
}

// The image can be a maximum of 1980px wide and 1024px high
$maxWidth = 1980;
$maxHeight = 1024;

list($width, $height) = getimagesize($_FILES['profileImage']['tmp_name']);

if ($width > $maxWidth || $height > $maxHeight) {
    die("The image is too large! Maximum allowed width is $maxWidth px and height is $maxHeight px.");
}

// Check file extension
$allowedExtensions = ["jpg", "jpeg", "png", "gif"];
$imageType = pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION);

if (!in_array(strtolower($imageType), $allowedExtensions)) {
    die("Invalid image format! Allowed formats are: " . implode(', ', $allowedExtensions));
}

$imageName = time() . "." . $imageType;

$finalPath = "./uploads/$imageName";
$tempFileName = $_FILES['profileImage']['tmp_name'];

// Create uploads directory if it doesn't exist
if (!is_dir('./uploads')) {
    mkdir('./uploads', 0755, true);
}

// Move uploaded file
$imageUploaded = move_uploaded_file($tempFileName, $finalPath);

if ($imageUploaded) {
    die("Image uploaded successfully!");
} else {
    die("Failed to upload the image!");
}
