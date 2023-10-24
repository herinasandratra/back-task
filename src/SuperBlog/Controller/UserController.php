<?php

namespace SuperBlog\Controller;
use SuperBlog\Model\User;
use SuperBlog\Model\UserRepository;

/**
 * Summary of UserController
 */
class UserController
{
    /**
     * Summary of userRepository
     * @var 
     */
    private $userRepository;
    /**
     * Summary of __construct
     * @param \SuperBlog\Model\UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * Summary of create
     * @return void
     */
    public function create()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = User::makeFromArray([
            'name' => $name, 
            'email' => $email,
            'password' => $password
        ]);
        $this->userRepository->create($user);
    }
}
