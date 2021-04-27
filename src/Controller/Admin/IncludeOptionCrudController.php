<?php

namespace App\Controller\Admin;

use App\Entity\IncludeOption;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class IncludeOptionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return IncludeOption::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('IncludeOption')
            ->setEntityLabelInPlural('IncludeOption')
            ->setHelp('index', 'Alle programma\'s waarbij de opties(raft/canyon) reeds inbegrepen zijn.')
            ->setHelp('edit', 'Alle programma\'s waarbij de opties(raft/canyon) reeds inbegrepen zijn.')
            ->setHelp('detail', 'Alle programma\'s waarbij de opties(raft/canyon) reeds inbegrepen zijn.')
            ->setHelp('new', 'Alle programma\'s waarbij de opties(raft/canyon) reeds inbegrepen zijn.')
            ->setSearchFields(['id'])
            ->setPaginatorPageSize(200);
    }

    public function configureFields(string $pageName): iterable
    {
        $programType = AssociationField::new('programType');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$programType];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $programType];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$programType];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$programType];
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
