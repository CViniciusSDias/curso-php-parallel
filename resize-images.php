<?php

use Alura\Threads\Student\InMemoryStudentRepository;
use Alura\Threads\Student\Student;
use parallel\Runtime;

require_once 'vendor/autoload.php';

$repository = new InMemoryStudentRepository();
$studentList = $repository->all();

$runtimes = [];
foreach ($studentList as $i => $student) {
    $runtimes[$i] = new Runtime();
    $runtimes[$i]->run(function (Student  $student) {
        echo 'Resizing ' . $student->fullName() . ' profile picture' . PHP_EOL;

        [$width, $height] = getimagesize($student->profilePicturePath());

        $ratio = $height / $width;

        $newWidth = 200;
        $newHeight = 200 * $ratio;

        $sourceImage = imagecreatefromjpeg($student->profilePicturePath());
        $destinationImage = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($destinationImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        imagejpeg($destinationImage, __DIR__ . '/storage/resized/' . basename($student->profilePicturePath()));
    }, [$student]);

    echo 'Finished resizing ' . $student->fullName() . ' profile picture' . PHP_EOL;
}
