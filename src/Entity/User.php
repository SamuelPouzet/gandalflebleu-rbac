<?php

namespace Gandalflebleu\Rbac\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gandalflebleu\Rbac\Element\UserStatus;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
{

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected int $id;

    /**
     * @ORM\Column(name="login")
     */
    protected string $login;

    /**
     * @ORM\Column(name="password")
     */
    protected string $password;

    /**
     * @ORM\Column(name="status")
     */
    protected string $status;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     * @return User
     */
    public function setLogin(string $login): User
    {
        $this->login = $login;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return UserStatus
     */
    public function getStatus(): UserStatus
    {
        $statusName = $this->status;
        return UserStatus::$statusName;
    }

    /**
     * @param UserStatus $status
     * @return User
     */
    public function setStatus(UserStatus $status): User
    {
        $this->status = $status->name;
        return $this;
    }

}