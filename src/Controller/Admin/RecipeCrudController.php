<?php

namespace App\Controller\Admin;

use App\Entity\Recipe;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RecipeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recipe::class;
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            IntegerField::new('id', 'ID')
                ->onlyOnIndex(),
            TextField::new('name', 'Nom'),
            SlugField::new('slug', 'Slug')
                ->setTargetFieldName('name'),
            TextareaField::new('description', 'Description'),
            TextareaField::new('ingredient', 'Ingrédient'),
            IntegerField::new('nbperson', 'Pour combien de personne ?'),
            TextField::new('preparationtime', 'Temps de préparation'),
            IntegerField::new('price', 'Prix (en euro)'),
            Field::new('imageFile', "Image")
                ->setFormType(VichImageType::class),
            AssociationField::new('category', 'Categorie'),
            AssociationField::new('user', "Fait par (utilisateur)"),
        ];

    }
}
