<?php

namespace Gandalflebleu\Rbac\Controller;

use Doctrine\ORM\EntityManager;
use Gandalflebleu\Rbac\Entity\Role;
use Gandalflebleu\Rbac\Entity\User;
use Gandalflebleu\Rbac\Form\UserForm;
use Gandalflebleu\Rbac\Manager\UserManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use PHPUnit\Util\Exception;

class AdminController extends AbstractActionController
{

    public function __construct(
        protected EntityManager $entityManager,
        protected UserManager $userManager
    ){}

    public function userListAction(): ViewModel
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();

        return new ViewModel(
            ['users'=>$users]
        );
    }

    public function userCreateAction(): ViewModel
    {

        $form = new UserForm('create');

        if($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if($form->isValid()) {
                $data = $form->getData();
                $this->userManager->addUser($data);
                $this->redirect()->toRoute('rbac-manager');
            }
        }

        return new ViewModel(
            [
                'form'=>$form,
            ]
        );
    }

    public function userEditAction(): ViewModel
    {
        $userId = $this->params()->fromRoute('id', 0);
        $user = $this->entityManager->getRepository(User::class)->find($userId);

        if(! $user) {
            throw new Exception(sprintf('user not found with id %1$s', $userId));
        }

        $form = new UserForm('update',$user);

        return new ViewModel(
            [
                'user'=>$user,
                'form'=>$form,
            ]
        );
    }

    public function userEditPasswordAction(): ViewModel
    {
        $userId = $this->params()->fromRoute('id', 0);
        $user = $this->entityManager->getRepository(User::class)->find($userId);

        if(! $user) {
            throw new Exception(sprintf('user not found with id %1$s', $userId));
        }

        $form = new UserForm($user);

        return new ViewModel(
            [
                'user'=>$user,
                'form'=>$form,
            ]
        );
    }

    public function roleListAction(): ViewModel
    {
        $roles = $this->entityManager->getRepository(Role::class)->findAll();

        return new ViewModel(
            ['roles'=>$roles]
        );
    }
}