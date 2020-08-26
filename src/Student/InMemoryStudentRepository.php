<?php

namespace Alura\Threads\Student;

class InMemoryStudentRepository implements StudentRepository
{
    public function all(): array
    {
        return array_map(
            fn ($i) => new Student("Student Number $i", new ProfilePicture(__DIR__ . "/../../storage/$i.jpg")),
            range(1, 50)
        );
    }
}