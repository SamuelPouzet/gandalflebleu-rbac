<?php

namespace Gandalflebleu\Rbac\Controller;

use Gandalflebleu\Rbac\Adapter\Result;
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
        $error = null;

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if ($form->isValid()) {
                $result = $this->authenticationService->authenticate($form->getData());
                if($result->getCode() !== Result::ACCESS_GRANTED) {
                    $error = $result;
                }
            }
        }

        return new ViewModel([
            'form'=>$form,
            'error'=>$error,
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