<?php

namespace App\Controller\Admin;

use App\Entity\Activite;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ActiviteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Activite::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('nom'),
            TextareaField::new('detail'),
            AssociationField::new('disciplines'),
        

        ];
    }
    
}
