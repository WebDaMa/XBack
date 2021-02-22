<?php

namespace App\Controller\Admin;

use App\Entity\ProgramGroup;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProgramGroupCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProgramGroup::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('ProgramGroup')
            ->setEntityLabelInPlural('ProgramGroup')
            ->setSearchFields(['id', 'name'])
            ->setPaginatorPageSize(200);
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $programs = AssociationField::new('programs');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$name, $programs];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $programs];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $programs];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $programs];
        }
    }
}
