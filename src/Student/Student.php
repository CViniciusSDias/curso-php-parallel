<?php

namespace Alura\Threads\Student;

class Student
{
    private string $fullName;
    private ProfilePicture $profilePicture;

    public function __construct(string $fullName, ProfilePicture $profilePicture)
    {
        $this->fullName = $fullName;
        $this->profilePicture = $profilePicture;
    }
}
