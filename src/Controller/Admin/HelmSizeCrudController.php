<?php

namespace App\Controller\Admin;

use App\Entity\HelmSize;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HelmSizeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HelmSize::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('HelmSize')
            ->setEntityLabelInPlural('HelmSize')
            ->setSearchFields(['id', 'name'])
            ->setPaginatorPageSize(200);
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $helmSuitSizes = AssociationField::new('helmSuitSizes');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$name, $helmSuitSizes];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $helmSuitSizes];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $helmSuitSizes];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $helmSuitSizes];
        }
    }
}
