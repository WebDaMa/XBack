<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('User')
            ->setEntityLabelInPlural('User')
            ->setSearchFields(['username', 'email', 'confirmationToken', 'roles', 'id', 'usernameCanonical', 'emailCanonical'])
            ->setPaginatorPageSize(200)
            ->setHelp('index', 'ROLE_USER => gids, ROLE_KV => Kamp verantwoordelijke, ROLE_STV => Stations verantwoordelijke, ROLE_CMS => beperkte administratie CMS, ROLE_ADMIN => volledig beheer CMS, ROLE_SUPER_ADMIN => volledige toegang');
    }

    public function configureFields(string $pageName): iterable
    {
        $username = TextField::new('username');
        $email = TextField::new('email');
        $enabled = Field::new('enabled');
        $plainPassword = Field::new('plainPassword');
        $roles = ArrayField::new('roles')->setHelp('ROLE_USER => gids, ROLE_KV => Kamp verantwoordelijke, ROLE_STV => Stations verantwoordelijke, ROLE_CMS => beperkte administratie CMS, ROLE_ADMIN => volledig beheer CMS, ROLE_SUPER_ADMIN => volledige toegang');
        $salt = TextField::new('salt');
        $password = TextField::new('password');
        $lastLogin = DateTimeField::new('lastLogin');
        $confirmationToken = TextField::new('confirmationToken');
        $passwordRequestedAt = DateTimeField::new('passwordRequestedAt');
        $id = IntegerField::new('id', 'ID');
        $usernameCanonical = TextField::new('usernameCanonical');
        $emailCanonical = TextField::new('emailCanonical');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$username, $email, $enabled, $roles];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$username, $email, $enabled, $salt, $password, $lastLogin, $confirmationToken, $passwordRequestedAt, $roles, $id, $usernameCanonical, $emailCanonical];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$username, $email, $enabled, $plainPassword, $roles];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$username, $email, $enabled, $plainPassword, $roles];
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
