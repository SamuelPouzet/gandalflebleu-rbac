<?php

namespace Gandalflebleu\Rbac\Adapter;

use Doctrine\ORM\EntityManager;
use Gandalflebleu\Rbac\Entity\User;

class AuthAdapter
{

    protected string $login;
    protected string $password;
    protected bool $rememberMe;

    protected Result $result;
    protected EntityManager $entityManager;

    public function __construct(Result $result, EntityManager $entityManager)
    {
        $this->result = $result;
        $this->entityManager = $entityManager;
    }

    public function hydrate(array $data): self
    {
        foreach ($data as $key=>$value) {
            $action = sprintf('set%1$s', ucfirst(strtolower($key) ));
            if(method_exists(static::class, $action)) {
                $this->$action($value);
            }
        }
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
     * @return AuthAdapter
     */
    public function setLogin(string $login): AuthAdapter
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
     * @return AuthAdapter
     */
    public function setPassword(string $password): AuthAdapter
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRememberMe(): bool
    {
        return $this->rememberMe;
    }

    /**
     * @param bool $rememberMe
     * @return AuthAdapter
     */
    public function setRememberMe(bool $rememberMe): AuthAdapter
    {
        $this->rememberMe = $rememberMe;
        return $this;
    }

    public function authenticate(): Result
    {
        try {
            //is existing User
            if(! isset($this->login)) {
                return $this->populateResult(Result::USER_NOT_FOUND, 'user credential not provided' );
            }

            $accounts = $this->entityManager->getRepository(User::class)->findBy([
                'login'=> $this->login,
            ]);

            if( count($accounts) > 1) {
                return $this->populateResult(Result::FAILURE_IDENTITY_AMBIGUOUS, 'more thant one user found with that identifier, did you configure a non unique column?' );
            }elseif(count($accounts) < 1){
                return $this->populateResult(Result::USER_NOT_FOUND, 'user not found in database' );
            }

            $account = $accounts[0];
            //check password
            //@todo bcrypt password_verify
            if($this->password !== $account->getpassword()) {
                return $this->populateResult(Result::PASSWORD_REJECTED, 'wrong password given' );
            }

            throw new \Exception('test');
        }catch (\Exception $exception) {
            return $this->populateResult(Result::CONF_ERROR, $exception->getMessage() );
        }
    }

    protected function populateResult(int $code, string $message): Result
    {
        $this->result->setCode($code);
        $this->result->setMessage($message);

        return $this->result;
    }

}