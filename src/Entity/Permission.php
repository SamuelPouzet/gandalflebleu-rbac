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
     * @ORM\Column (name="name")
     */
    protected string $name;

    /**
     * @ORM\Column (name="code")
     */
    protected string $code;

    /**
     * @ORM\Column (name="description")
     */
    protected string $description;

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Role
     */
    public function setName(string $name): Permission
    {
        $this->name = $name;
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

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return Permission
     */
    public function setCode(string $code): Permission
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Permission
     */
    public function setDescription(string $description): Permission
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    /**
     * @param Collection $roles
     * @return Permission
     */
    public function setRoles(Collection $roles): Permission
    {
        $this->roles = $roles;
        return $this;
    }

}