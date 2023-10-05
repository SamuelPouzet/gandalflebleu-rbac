<?php

namespace Gandalflebleu\Rbac\Plugin;

use Gandalflebleu\Rbac\Entity\User;
use Gandalflebleu\Rbac\Service\AuthenticationService;
use Laminas\Mvc\Controller\Plugin\AbstractPlugin;

class UserPlugin extends AbstractPlugin
{
    protected ?User $user=null;

    protected AuthenticationService $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function __invoke()
    {
        if(null !== $this->user) {
            return $this->user;
        }

        $this->user = $this->authenticationService->getAuthentication();
        return $this->user;
    }

}