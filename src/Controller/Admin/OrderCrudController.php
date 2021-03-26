<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW, Action::DETAIL, Action::DELETE);
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            IntegerField::new('id', 'ID')
                ->onlyOnIndex(),
            DateTimeField::new('date', 'Faite le')
                ->setFormat('dd/MM/yyyy'),
            AssociationField::new('user', 'Utilisateur'),
            AssociationField::new('recipe', "Recette"),
        ];

    }
}
