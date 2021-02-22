<?php

namespace App\Controller\Admin;

use App\Entity\ActivityGroup;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ActivityGroupCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ActivityGroup::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('ActivityGroup')
            ->setEntityLabelInPlural('ActivityGroup')
            ->setSearchFields(['id', 'name'])
            ->setPaginatorPageSize(200);
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $activities = AssociationField::new('activities');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$name, $activities];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $activities];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $activities];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $activities];
        }
    }
}
