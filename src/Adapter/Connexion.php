<?php

namespace Gandalflebleu\Rbac\Adapter;

class Connexion
{

    const ALLOWED = 1;

    const NEEDS_CONNEXION = 2;

    const DENIED = 3;

    protected string $code;

    protected string $message;

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return Connexion
     */
    public function setCode(string $code): Connexion
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Connexion
     */
    public function setMessage(string $message): Connexion
    {
        $this->message = $message;
        return $this;
    }

}