<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserByEmail(string $email): User
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if ($user)
        {
            return $user;
        } else {
            throw new HttpException(404, 'Not Found');
        }
    }
}