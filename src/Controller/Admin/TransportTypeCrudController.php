<?php

namespace App\Controller\Admin;

use App\Entity\TransportType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TransportTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TransportType::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('TransportType')
            ->setEntityLabelInPlural('TransportType')
            ->setSearchFields(['id', 'name'])
            ->setPaginatorPageSize(200);
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $travelTypes = AssociationField::new('travelTypes');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$name, $travelTypes];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $travelTypes];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $travelTypes];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $travelTypes];
        }
    }
}
