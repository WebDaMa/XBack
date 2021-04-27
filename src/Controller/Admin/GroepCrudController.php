<?php

namespace App\Controller\Admin;

use App\Entity\Groep;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GroepCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Groep::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Groep')
            ->setEntityLabelInPlural('Groep')
            ->setSearchFields(['id', 'groupIndex', 'groupId', 'name', 'periodId'])
            ->setPaginatorPageSize(200);
    }

    public function configureFields(string $pageName): iterable
    {
        $groupId = IntegerField::new('groupId');
        $periodId = IntegerField::new('periodId');
        $name = TextField::new('name');
        $location = AssociationField::new('location');
        $plannings = AssociationField::new('plannings');
        $groupCustomers = AssociationField::new('groupCustomers');
        $id = IntegerField::new('id', 'ID');
        $groupIndex = IntegerField::new('groupIndex');
        $createdAt = DateTimeField::new('created_at');
        $modifiedAt = DateTimeField::new('modified_at');
        $agency = AssociationField::new('agency');
        $createdBy = AssociationField::new('created_by');
        $updatedBy = AssociationField::new('updated_by');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$groupId, $periodId, $name, $location, $plannings, $groupCustomers];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $groupIndex, $groupId, $name, $periodId, $createdAt, $modifiedAt, $plannings, $groupCustomers, $location, $agency, $createdBy, $updatedBy];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$groupId, $periodId, $name, $location, $plannings, $groupCustomers];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$groupId, $periodId, $name, $location, $plannings, $groupCustomers];
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
