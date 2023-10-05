<?php

namespace Gandalflebleu\Rbac\Controller;

use Gandalflebleu\Rbac\Form\SignInForm;
use Gandalflebleu\Rbac\Form\SignUpForm;
use Gandalflebleu\Rbac\Manager\UserManager;
use Gandalflebleu\Rbac\Service\AuthenticationService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class LogController extends AbstractActionController
{

    protected AuthenticationService $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function IndexAction()
    {

    }

    public function signInAction(): ViewModel
    {

        $form = new SignInForm();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if ($form->isValid()) {
                $result = $this->authenticationService->authenticate($form->getData());
                var_dump($result);
            }
        }

        return new ViewModel([
            'form'=>$form,
        ]);

    }

    public function signUpAction(): ViewModel
    {

        $form = new SignUpForm();
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if ($form->isValid()) {
                $this->authenticationService->createAccount($form->getData());
            }
        }


        return new ViewModel([
            'form'=>$form,
        ]);

    }

}