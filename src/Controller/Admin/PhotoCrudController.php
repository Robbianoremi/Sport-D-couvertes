<?php

namespace App\Controller\Admin;

use App\Entity\Photo;
use App\Controller\VichImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PhotoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Photo::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            
            TextField::new('title'),
            TextEditorField::new('description'),
            DateTimeField::new('updatedAt', 'Créé le'),
            ImageField::new('imageName', 'Photos')
                ->setBasePath('/images/photos')
                ->setUploadDir('public/images/photos')
                ->onlyOnIndex(),
            VichImageField::new('imageFile', 'Image')
                ->setTemplatePath('admin/field/vich_image_widget.html.twig')
                ->hideOnIndex(),
        ];
    }
}
