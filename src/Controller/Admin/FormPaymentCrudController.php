<?php

namespace App\Controller\Admin;

use App\Entity\Payment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FormPaymentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Payment::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['id', 'price', 'description'])
            ->setPaginatorPageSize(200);
    }

    public function configureFields(string $pageName): iterable
    {
        $customer = AssociationField::new('customer');
        $description = TextField::new('description');
        $price = NumberField::new('price');
        $id = IntegerField::new('id', 'ID');
        $createdAt = DateTimeField::new('created_at');
        $modifiedAt = DateTimeField::new('modified_at');
        $createdBy = AssociationField::new('created_by');
        $updatedBy = AssociationField::new('updated_by');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$customer, $description, $price];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $price, $description, $createdAt, $modifiedAt, $customer, $createdBy, $updatedBy];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$customer, $description, $price];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$customer, $description, $price];
        }
    }
}
