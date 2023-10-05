<?php

namespace Gandalflebleu\Rbac\Service;

use Gandalflebleu\Rbac\Adapter\AuthAdapter;
use Gandalflebleu\Rbac\Adapter\Result;
use Gandalflebleu\Rbac\Manager\UserManager;
use Laminas\Session\Container;
use Laminas\Session\SessionManager;

class AuthenticationService
{

    protected UserManager $userManager;

    protected AuthAdapter $authAdapter;

    protected Container $sessionContainer;

    public function __construct(UserManager $userManager, AuthAdapter $authAdapter, Container $sessionContainer)
    {
        $this->userManager = $userManager;
        $this->authAdapter = $authAdapter;
        $this->sessionContainer = $sessionContainer;
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
            $this->sessionContainer->user = $result->getUser();
//            if ($data['remember_me']) {
//                $this->sessionContainer->rememberMe();
//            }
        }

        return $result;
    }

    public function isAuthenticated()
    {
        var_dump($this->sessionContainer->user);
        return $this->sessionContainer->user !== null;
    }

}