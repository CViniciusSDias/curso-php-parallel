<?php

use Alura\Threads\Activity\Activity;
use Alura\Threads\Student\InMemoryStudentRepository;
use Alura\Threads\Student\Student;
use parallel\Runtime;

require_once 'vendor/autoload.php';

$repository = new InMemoryStudentRepository();
$studentList = $repository->all();

$totalPoints = 0;
$runtimes = [];
foreach ($studentList as $i => $student) {
    $activities = $repository->activitiesInADay($student);

    $runtimes[$i] = new Runtime(__DIR__ . '/vendor/autoload.php');

    $runtimes[$i]->run(function (array $activities, Student $student, int &$totalOfPointsOfTheDay) {
        $totalOfPointsOfTheDay += $points = array_reduce(
            $activities,
            fn (int $total, Activity $activity) => $total + $activity->points(),
            0
        );

        printf('%s made %d points today%s', $student->fullName(), $points, PHP_EOL);
    }, [$activities, $student, $totalPoints]);
}

printf('We had a total of %d points today%s', $totalPoints, PHP_EOL);