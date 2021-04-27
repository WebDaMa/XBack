<?php

namespace App\Controller\Admin;

use App\Entity\ProgramActivity;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class ProgramActivityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProgramActivity::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('ProgramActivity')
            ->setEntityLabelInPlural('ProgramActivity')
            ->setSearchFields(['id'])
            ->setPaginatorPageSize(200);
    }

    public function configureFields(string $pageName): iterable
    {
        $programType = AssociationField::new('programType');
        $activity = AssociationField::new('activity');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $programType, $activity];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $programType, $activity];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$programType, $activity];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$programType, $activity];
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
