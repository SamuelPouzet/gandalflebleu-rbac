<?php

namespace Gandalflebleu\Rbac\Manager;

use Doctrine\ORM\EntityManager;
use Gandalflebleu\Rbac\Element\UserStatus;
use Gandalflebleu\Rbac\Entity\User;

class UserManager
{

    protected EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addUser($data): User
    {
        $user = new User();

        $user->setLogin($data['login']);
        $user->setPassword($data['password']);
        $user->setStatus(UserStatus::Active);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

}