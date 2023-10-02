<?php

namespace Gandalflebleu\Rbac\Controller;

use Gandalflebleu\Rbac\Form\SignInForm;
use Gandalflebleu\Rbac\Form\SignUpForm;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class LogController extends AbstractActionController
{

    public function IndexAction()
    {

    }

    public function signInAction(): ViewModel
    {

        $form = new SignInForm();


        return new ViewModel([
            'form'=>$form,
        ]);

    }

    public function signUpAction(): ViewModel
    {

        $form = new SignUpForm();


        return new ViewModel([
            'form'=>$form,
        ]);

    }

}