<?php

require_once "DB.php";

class Images extends DB {
    const ALLOWE_EXTENSION = ["jpg", "jpeg", "png", "gif"];
    const MAX_FILE_SIZE = 5 * 1024 * 1024;
    const MAX_IMAGE_WIDTH = 1920;
    const MAX_IMAGE_HEIGHT = 1024;

    public function upload(string $image,string $finalName,string $destination):void {

        $finalDestination = $destination."/".$finalName;
        move_uploaded_file($image, $finalDestination);

        $finalName = $this->connection->real_escape_string($finalName);
        $this->connection->query("INSERT INTO images (image) VALUES ('$finalName')");
    }

    public function isValidDimensions (int $width, int $height):bool {
     
        return $width <= self::MAX_IMAGE_WIDTH || $height <= self::MAX_IMAGE_HEIGHT;
    }

    public function isValidExtension(string $extension):bool {
    
        return in_array($extension, self::ALLOWE_EXTENSION);
    }

    public function isValidSize(int $size):bool {
        return $size <= self::MAX_FILE_SIZE;
    }

     public function generateRandomName(string $extension):string {

        return uniqid('img_'). "." .$extension;

    }

}