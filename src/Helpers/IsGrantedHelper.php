<?php

namespace Gandalflebleu\Rbac\Helpers;

use Gandalflebleu\Rbac\Entity\User;
use Gandalflebleu\Rbac\Service\RbacService;
use Laminas\View\Helper\AbstractHelper;

class IsGrantedHelper extends AbstractHelper
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