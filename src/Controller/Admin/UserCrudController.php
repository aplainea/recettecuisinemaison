<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW, Action::DELETE);
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            IntegerField::new('id', 'ID')
                ->onlyOnIndex(),
            TextField::new('email', 'Email'),
            TextField::new('pseudo', 'Pseudo'),
            TextField::new('name', 'Nom'),
            TextField::new('firstname', 'Prenom'),
            DateTimeField::new('updated', 'Modifiée le')
                ->setFormat('dd/MM/yyyy à H:m'),
        ];

    }
}
