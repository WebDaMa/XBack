<?php

namespace App\Controller\Admin;

use App\Entity\SuitSize;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SuitSizeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SuitSize::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('SuitSize')
            ->setEntityLabelInPlural('SuitSize')
            ->setSearchFields(['sizeId', 'id', 'name'])
            ->setPaginatorPageSize(200);
    }

    public function configureFields(string $pageName): iterable
    {
        $sizeId = IntegerField::new('sizeId');
        $name = TextField::new('name');
        $beltSize = AssociationField::new('beltSize');
        $helmSize = AssociationField::new('helmSize');
        $suitCustomers = AssociationField::new('suitCustomers');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$sizeId, $name, $beltSize, $helmSize, $suitCustomers];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$sizeId, $id, $name, $suitCustomers, $beltSize, $helmSize];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$sizeId, $name, $beltSize, $helmSize, $suitCustomers];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$sizeId, $name, $beltSize, $helmSize, $suitCustomers];
        }
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::INDEX, 'ROLE_ADMIN')
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
            ->setPermission(Action::DETAIL, 'ROLE_ADMIN')
            ->setPermission(Action::NEW, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN')
            ->setPermission(Action::BATCH_DELETE, 'ROLE_ADMIN');
    }
}
