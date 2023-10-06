<?php

namespace Gandalflebleu\Rbac\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table (name="role")
 */
class Role
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
     * @ORM\ManyToMany(targetEntity="User", mappedBy="users")
     */
    protected Collection $users;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="children")
     * @ORM\JoinTable(name="role_hierarchy",
     *   joinColumns={@ORM\JoinColumn(name="child_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="parent_id", referencedColumnName="id")}
     * )
     */
    protected Collection $parents;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="Role", mappedBy="parents")
     */
    protected Collection $children;

    /**
     *
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->parents = new ArrayCollection();
        $this->children = new ArrayCollection();
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
    public function setId(int $id): Role
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
    public function setName(string $name): Role
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
    public function setIsActive(string $is_active): Role
    {
        $this->is_active = $is_active;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @param Collection $users
     * @return Role
     */
    public function setUsers(Collection $users): Role
    {
        $this->users = $users;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getParents(): Collection
    {
        return $this->parents;
    }

    /**
     * @param Collection $parents
     * @return Role
     */
    public function setParents(Collection $parents): Role
    {
        $this->parents = $parents;
        return $this;
    }

    /**
     * @param Role $role
     * @return Role
     */
    public function addParent(Role $role): Role
    {
        $this->parents[] = $role;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    /**
     * @param Collection $children
     * @return Role
     */
    public function setChildren(Collection $children): Role
    {
        $this->children = $children;
        return $this;
    }

    /**
     * @param Role $role
     * @return Role
     */
    public function addChild(Role $role): Role
    {
        $this->children[] = $role;
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
     * @return Role
     */
    public function setCode(string $code): Role
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
     * @return Role
     */
    public function setDescription(string $description): Role
    {
        $this->description = $description;
        return $this;
    }

}