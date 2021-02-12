<?php

namespace App\Controller\Admin;


//use App\Entity\SportType;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER);
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            //IdField::new('id'),


            TextField::new('Username'),
            TextField::new('password'),
            TextField::new('email'),
            TextField::new('lastName'),
            TextField::new('FirstName'),
            TextField::new('FirstName'),
            //TextEditorField::new('description'),
            BooleanField::new('verified'),
            DateTimeField::new('verifiedAt'),
            BooleanField::new('suspended'),
            BooleanField::new('deleted')
        ];
    }
    
}
