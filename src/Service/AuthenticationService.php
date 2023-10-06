<?php

namespace Gandalflebleu\Rbac\Service;

use Doctrine\ORM\EntityManager;
use Gandalflebleu\Rbac\Adapter\AuthAdapter;
use Gandalflebleu\Rbac\Adapter\Result;
use Gandalflebleu\Rbac\Entity\User;
use Gandalflebleu\Rbac\Manager\UserManager;
use Laminas\Session\Container;
use Laminas\Session\SessionManager;

class AuthenticationService
{

    protected UserManager $userManager;

    protected AuthAdapter $authAdapter;

    protected Container $sessionContainer;

    protected EntityManager $entityManager;

    protected ?User $user = null;

    public function __construct(
        UserManager $userManager,
        AuthAdapter $authAdapter,
        Container $sessionContainer,
        EntityManager $entityManager
    )
    {
        $this->userManager = $userManager;
        $this->authAdapter = $authAdapter;
        $this->sessionContainer = $sessionContainer;
        $this->entityManager = $entityManager;
    }

    public function createAccount(array $data): void
    {
        //@todo check integrity
        $this->userManager->addUser($data);
    }

    public function authenticate(array $data)
    {
        $result =  $this->authAdapter->hydrate($data)->authenticate();

        if($result->getCode() === Result::ACCESS_GRANTED) {
            $this->sessionContainer->user = $result->getUser()->getId();
//            if ($Data['remember_me']) {
//                $this->sessionContainer->rememberMe();
//            }
        }

        return $result;
    }

    public function isAuthenticated()
    {
        return $this->sessionContainer->user !== null;
    }

    public function getAuthentication(): User
    {
        if(!$this->user) {
            $this->user = $this->entityManager->getRepository(User::class)->find($this->sessionContainer->user);
        }
        return $this->user;
    }

}