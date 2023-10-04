<?php

namespace Gandalflebleu\Rbac\Controller;

use Gandalflebleu\Rbac\Form\SignInForm;
use Gandalflebleu\Rbac\Form\SignUpForm;
use Gandalflebleu\Rbac\Manager\UserManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class LogController extends AbstractActionController
{

    protected UserManager $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

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
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
           // var_dump($form->isValid());die;
            if ($form->isValid()) {
                $this->userManager->addUser($form->getData());
            }
        }


        return new ViewModel([
            'form'=>$form,
        ]);

    }

}