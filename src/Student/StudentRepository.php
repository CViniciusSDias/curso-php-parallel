<?php

namespace Alura\Threads\Student;

interface StudentRepository
{
    /** @return Student[] */
    public function all(): array;
}