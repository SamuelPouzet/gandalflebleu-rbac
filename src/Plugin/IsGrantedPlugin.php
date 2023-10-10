<?php

namespace Gandalflebleu\Rbac\Plugin;

use Gandalflebleu\Rbac\Entity\User;
use Gandalflebleu\Rbac\Service\RbacService;
use Laminas\Mvc\Controller\Plugin\AbstractPlugin;

class IsGrantedPlugin extends AbstractPlugin
{

    public function __construct(
        protected RbacService $rbacService
    )
    {}

    public function __invoke(User $user, string $permission): bool
    {
        return $this->rbacService->userHasPermission($user, $permission);
    }

}