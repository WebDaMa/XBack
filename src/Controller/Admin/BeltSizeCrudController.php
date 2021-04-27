<?php

namespace App\Controller\Admin;

use App\Entity\BeltSize;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BeltSizeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BeltSize::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('BeltSize')
            ->setEntityLabelInPlural('BeltSize')
            ->setSearchFields(['id', 'name'])
            ->setPaginatorPageSize(200);
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $beltSuitSizes = AssociationField::new('beltSuitSizes');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$name, $beltSuitSizes];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $beltSuitSizes];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $beltSuitSizes];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $beltSuitSizes];
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
