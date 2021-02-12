<?php

namespace App\Controller\Admin;

use App\Entity\SportEvent;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SportEventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SportEvent::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('sportType'),
            TextField::new('location'),
            TextField::new('competition'),
            DateTimeField::new('datet'),
            TextField::new('TimeZone'),

        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
                ->setSearchFields(['id']);
    }
    
}
