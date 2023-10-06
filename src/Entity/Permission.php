<?php

namespace Gandalflebleu\Rbac\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table (name="permissions")
 */
class Permission
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column (name="id")
     */
    protected int $id;

    /**
     * @ORM\Column (name="permission")
     */
    protected string $permission;

    /**
     * @ORM\Column (name="active")
     */
    protected string $is_active;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="Role", mappedBy="permissions")
     */
    protected Collection $roles;

    /**
     *
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Role
     */
    public function setId(int $id): Permission
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getPermission(): string
    {
        return $this->permission;
    }

    /**
     * @param string $name
     * @return Role
     */
    public function setName(string $name): Permission
    {
        $this->permission = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsActive(): string
    {
        return $this->is_active;
    }

    /**
     * @param string $is_active
     * @return Role
     */
    public function setIsActive(string $is_active): Permission
    {
        $this->is_active = $is_active;
        return $this;
    }


}