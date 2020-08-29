<?php

use Alura\Threads\Student\InMemoryStudentRepository;

require_once 'vendor/autoload.php';

$repository = new InMemoryStudentRepository();
$studentList = $repository->all();

foreach ($studentList as $student) {
    echo 'Resizing ' . $student->fullName() . ' profile picture' . PHP_EOL;

    resizeTo200PixelsWidth($student->profilePicturePath());

    echo 'Finished resizing ' . $student->fullName() . ' profile picture' . PHP_EOL;
}

function resizeTo200PixelsWidth($imagePath)
{
    [$width, $height] = getimagesize($imagePath);

    $ratio = $height / $width;

    $newWidth = 200;
    $newHeight = 200 * $ratio;

    $sourceImage = imagecreatefromjpeg($imagePath);
    $destinationImage = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($destinationImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    imagejpeg($destinationImage, __DIR__ . '/storage/resized/' . basename($imagePath));
}
