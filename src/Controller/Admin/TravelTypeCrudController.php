<?php

namespace App\Controller\Admin;

use App\Entity\TravelType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TravelTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TravelType::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('TravelType')
            ->setEntityLabelInPlural('TravelType')
            ->setSearchFields(['startPoint', 'id', 'code', 'description'])
            ->setPaginatorPageSize(200);
    }

    public function configureFields(string $pageName): iterable
    {
        $startPoint = TextField::new('startPoint');
        $code = TextField::new('code');
        $description = TextField::new('description');
        $transportType = AssociationField::new('transportType');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$startPoint, $id, $code, $description, $transportType];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$startPoint, $id, $code, $description, $transportType];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$startPoint, $code, $description, $transportType];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$startPoint, $code, $description, $transportType];
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
