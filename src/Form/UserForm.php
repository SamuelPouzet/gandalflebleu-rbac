<?php

namespace Gandalflebleu\Rbac\Form;

use Gandalflebleu\Rbac\Entity\User;
use Laminas\Form\Form;
use Laminas\Validator\Hostname;

class UserForm extends Form
{

    /**
     * Constructor.
     */
    public function __construct(
        protected string $context,
        protected User $user=new User()
    )
    {
        // Define form name
        parent::__construct('login-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        $this->addElements();
       // $this->addInputFilter();
    }

    public function getContext(): string
    {
        return $this->context;
    }

    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements()
    {
        // Add "email" field
        $this->add([
            'type'  => 'text',
            'name' => 'login',
            'attributes'=>[
                'value'=>$this->context === 'update'?$this->user->getLogin():'',
            ],
            'options' => [
                'label' => 'User Login',
            ],
        ]);

        if($this->context === 'create') {
            // Add "password" field
            $this->add([
                'type'  => 'password',
                'name' => 'password',
                'options' => [
                    'label' => 'User Password',
                ],
            ]);

        }



        // Add the CSRF field
        $this->add([
            'type' => 'csrf',
            'name' => 'csrf',
            'options' => [
                'csrf_options' => [
                    'timeout' => 600
                ]
            ],
        ]);

        // Add the Submit button
        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Sign Up',
                'id' => 'submit',
            ],
        ]);
    }

    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter()
    {
        // Create main input filter
        $inputFilter = $this->getInputFilter();

        // Add input for "email" field
        $inputFilter->add([
            'name'     => 'email',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'EmailAddress',
                    'options' => [
                        'allow' => Hostname::ALLOW_DNS,
                        'useMxCheck' => false,
                    ],
                ],
            ],
        ]);

        // Add input for "password" field
        $inputFilter->add([
            'name'     => 'password',
            'required' => true,
            'filters'  => [
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 6,
                        'max' => 64
                    ],
                ],
            ],
        ]);

        // Add input for "remember_me" field
        $inputFilter->add([
            'name'     => 'remember_me',
            'required' => false,
            'filters'  => [
            ],
            'validators' => [
                [
                    'name'    => 'InArray',
                    'options' => [
                        'haystack' => [0, 1],
                    ]
                ],
            ],
        ]);

        // Add input for "redirect_url" field
        $inputFilter->add([
            'name'     => 'redirect_url',
            'required' => false,
            'filters'  => [
                ['name'=>'StringTrim']
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 0,
                        'max' => 2048
                    ]
                ],
            ],
        ]);
    }
}