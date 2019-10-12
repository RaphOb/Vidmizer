<?php


namespace App\Services;


use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    private $em;
    private $userRepo;

    public function __construct(EntityManagerInterface $em, UserRepository $userRepo)
    {
        $this->em = $em;
        $this->userRepo = $userRepo;
    }

    public function saveUser($data)
    {
        $this->em->persist($data);
        $this->em->flush();
    }

}