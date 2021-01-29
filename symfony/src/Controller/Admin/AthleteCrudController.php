<?php

namespace App\Controller\Admin;

use App\Entity\Athlete;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AthleteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Athlete::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
