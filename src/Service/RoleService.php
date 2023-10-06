<?php

namespace Gandalflebleu\Rbac\Service;

use Doctrine\ORM\EntityManager;
use Gandalflebleu\Rbac\Entity\Role;
use Gandalflebleu\Rbac\Entity\User;
use Laminas\Cache\Storage\StorageInterface;
use Laminas\Permissions\Rbac\Rbac;

class RoleService
{

    protected ?Rbac $rbac = null;

    public function __construct(
        protected readonly StorageInterface $cacheManager,
        protected readonly EntityManager $entityManager
    )
    {}

    public function userHasRole(User $user, string $role): bool
    {
        if (!$this->rbac) {
            $this->init();
        }


    }

    protected function init(bool $reset = false): void
    {
        if($reset) {
            $this->cacheManager->removeItem('rbac_container');
        }

        $result = false;
        $this->rbac = $this->cacheManager->getItem('rbac_container', $result);

        if (!$result) {
            $this->rbac = new Rbac();

            $roles = $this->entityManager->getRepository(Role::class)->findBy([
                'is_active' => true,
            ]);

            foreach ($roles as $role) {
                $parents = $this->addParentsRecursive($role);
                $this->rbac->addRole($role, $parents);
            }
            $this->cacheManager->setItem('rbac_container', $this->rbac);
        }
    }

    /**
     * @param Role $role
     * @param array $return
     * @return array|mixed
     */
    protected function addParentsRecursive(Role $role, array $return = []): array
    {
        $parents = $role->getParents();
        foreach ($parents as $parent) {
            if (!in_array($parent, $return)) {
                //avoid loop
                $return[] = $parent;
                $return = $this->addParentsRecursive($parent, $return);
            }

        }
        return $return;
    }

}