<?php


namespace App\Patterns\Profile;


use App\Models\User;
use App\Patterns\Profile\Classes\AdvisorProfile;
use App\Patterns\Profile\Classes\StudentProfile;
use App\Patterns\Profile\Classes\TeacherProfile;


class Factory
{
    public function getItem(int $role)
    {
        switch ($role) {
            case User::ROLE_ADVISOR;
                return new AdvisorProfile();
                break;
            case User::ROLE_STUDENT:
                return new StudentProfile();
                break;
            case User::ROLE_TEACHER;
                return new TeacherProfile();
                break;
        }
    }
}
