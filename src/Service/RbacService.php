<?php

namespace Gandalflebleu\Rbac\Service;

use Doctrine\ORM\EntityManager;
use Gandalflebleu\Rbac\Entity\Permission;
use Gandalflebleu\Rbac\Entity\Role;
use Gandalflebleu\Rbac\Entity\User;
use Laminas\Cache\Storage\StorageInterface;

class RbacService
{
    protected array $content = [
        'roles' => [],
        'permissions' => [],
    ];

    public function __construct(
        protected EntityManager    $entityManager,
        protected StorageInterface $storage
    )
    {
        $this->init();
    }

    protected function removeContent(): void
    {
        $this->content = [
            'roles' => [],
            'permissions' => [],
        ];
    }

    public function init()
    {
        $this->removeContent();

        $roles = $this->entityManager->getRepository(Role::class)->findBy([
            'is_active' => true
        ]);

        foreach ($roles as $role) {
            $roleId = $role->getId();
            $this->addRole($roleId, $roleId);
            $permissions = $role->getPermissions();
            foreach($permissions as $permission) {
                $this->addPermission($roleId, $permission->getId() );
            }
            $this->getChildrenRoles($roleId, $role);
        }
    }

    protected function getChildrenRoles(int $parentRoleId, Role $role): void
    {
        $children = $role->getChildren();
        foreach ($children as $child) {
            $childId = $child->getId();
            if ($this->isRegisteredRole($parentRoleId, $childId)) {
                //avoiding loops
                continue;
            }
            $this->addRole($parentRoleId, $childId);
            $permissions = $child->getPermissions();
            foreach($permissions as $permission) {
                $this->addPermission($parentRoleId, $permission->getId() );
            }
            $this->getChildrenRoles($parentRoleId, $child);
        }
    }

    protected function addRole(int $key, int $value): void
    {
        $this->content['roles'][$key][] = $value;
    }

    protected function isRegisteredRole(int $key, int $role): bool
    {
        return isset($this->content['roles'][$key][$role]);
    }

    public function userHasRole(?User $user, string $role): bool
    {
        if(! $user ) {
            return false;
        }
        $role = $this->entityManager->getRepository(Role::class)->findOneBy([
            'code' => $role
        ]);
        if(! $role) {
            return false;
        }
        $userRoles = $user->getRoles();
        foreach ($userRoles as $userRole) {
            $acceptablesRoles = $this->getRole($userRole);
            if (in_array($role->getId(), $acceptablesRoles)) {
                return true;
            }
        }
        return false;
    }

    public function getRoles()
    {
        return $this->content['roles'];
    }

    protected function getRole(Role $role): array
    {
        return $this->content['roles'][$role->getId()];
    }

    protected function addPermission(int $key, int $value): void
    {
        $this->content['permissions'][$key][] = $value;
    }

    protected function isRegisteredPermission(int $key, int $role): bool
    {
        return isset($this->content['permissions'][$key][$role]);
    }

    public function getPermissions()
    {
        return $this->content['permissions'];
    }

    public function getPermissionsByRole(Role $role)
    {
        return $this->content['permissions'][$role->getId()];
    }

    public function userHasPermission(User $user, string $permission): bool
    {
        $permission = $this->entityManager->getRepository(Permission::class)->findOneBy([
            'code' => $permission
        ]);
         if(! $permission) {
            return false;
        }
        $userRoles = $user->getRoles();

        foreach ($userRoles as $userRole) {
            $acceptablesPermissions = $this->getPermissionsByRole($userRole);
            var_dump($acceptablesPermissions);
            if (in_array($permission->getId(), $acceptablesPermissions)) {
                return true;
            }
        }
        return false;
    }
}