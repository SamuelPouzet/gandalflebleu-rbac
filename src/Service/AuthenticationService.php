<?php

namespace Gandalflebleu\Rbac\Service;

use Gandalflebleu\Rbac\Adapter\AuthAdapter;
use Gandalflebleu\Rbac\Manager\UserManager;

class AuthenticationService
{

    protected UserManager $userManager;

    protected AuthAdapter $authAdapter;

    public function __construct(UserManager $userManager, AuthAdapter $authAdapter)
    {
        $this->userManager = $userManager;
        $this->authAdapter = $authAdapter;
    }

    public function createAccount(array $data): void
    {
        //@todo check integrity
        $this->userManager->addUser($data);
    }

    public function authenticate(array $data)
    {
        return $this->authAdapter->hydrate($data)->authenticate();
    }

}