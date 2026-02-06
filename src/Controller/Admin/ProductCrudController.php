<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\Image;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }



//    public function configureMenuItems(): iterable
//    {
//        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
//        yield MenuItem::linkToCrud('Products', 'fa fa-box', Product::class);
//    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name'),
            ImageField::new('image')
                ->setUploadDir('public/uploads/images')   // Where original is saved
                ->setBasePath('uploads/images')           // URL prefix for Twig/frontend
                ->setRequired(false)
                ->setFileConstraints(new Image(maxSize: '9M')),  // Allow images up to 5 MB (default was 2 MiB)
            TextareaField::new('description')->hideOnIndex(),
            NumberField::new('price')->setNumDecimals(2),
            BooleanField::new('isActive', 'Active'),
            DateTimeField::new('createdAt', 'Дата создания')->hideOnIndex()->onlyWhenUpdating()->setFormTypeOption('disabled', true),
            DateTimeField::new('updatedAt', 'Дата обновления')->hideOnIndex()->onlyWhenUpdating()->setFormTypeOption('disabled', true),
        ];
    }

}
