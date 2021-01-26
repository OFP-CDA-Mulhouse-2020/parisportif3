<?php

namespace App\Controller\Admin;

use App\Entity\Bet;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bet::class;
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
