<?php

require_once "DB.php";

class Images extends DB {
    const ALLOWE_EXTENSION = ["jpg", "jpeg", "png", "gif"];
    const MAX_FILE_SIZE = 5 * 1024 * 1024;
    const MAX_IMAGE_WIDTH = 1920;
    const MAX_IMAGE_HEIGHT = 1024;

    public function upload($image, $finalName, $destination) {

        $finalDestination = $destination."/".$finalName;
        move_uploaded_file($image, $finalDestination);

        $finalName = $this->connection->real_escape_string($finalName);
        $this->connection->query("INSERT INTO images (image) VALUES ('$finalName')");
    }

    public function isValidDimensions ($width, $height) {
        if($width > self::MAX_IMAGE_WIDTH || $height> self::MAX_IMAGE_HEIGHT){
            return false;
        }
        return true;
    }

    public function isValidExtension($extension) {
        if(!in_array($extension, self::ALLOWE_EXTENSION)) {
            return false;
        }
        return true;
    }

    public function isValidSize($size) {

        if($size > self::MAX_FILE_SIZE) {
            return false;
        }
        return true;
    }

     public function generateRandomName($extension) {

        return uniqid('img_'). "." .$extension;

    }

}