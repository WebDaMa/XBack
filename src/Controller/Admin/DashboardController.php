<?php

namespace App\Controller\Admin;

use App\Entity\Activity;
use App\Entity\ActivityGroup;
use App\Entity\Agency;
use App\Entity\AllInType;
use App\Entity\BeltSize;
use App\Entity\Customer;
use App\Entity\Groep;
use App\Entity\GroupType;
use App\Entity\Guide;
use App\Entity\HelmSize;
use App\Entity\IncludeOption;
use App\Entity\InsuranceType;
use App\Entity\Location;
use App\Entity\LodgingType;
use App\Entity\Payment;
use App\Entity\Planning;
use App\Entity\Program;
use App\Entity\ProgramActivity;
use App\Entity\ProgramGroup;
use App\Entity\ProgramType;
use App\Entity\SuitSize;
use App\Entity\TransportType;
use App\Entity\TravelType;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin")
     */
    public function index(): Response
    {
        // redirect to some CRUD controller
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(CustomerCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('LifeLong Exploring Administration');
    }

    public function configureCrud(): Crud
    {
        return Crud::new();
    }

    public function configureMenuItems(): iterable
    {

        yield MenuItem::section('Imports', 'fas fa-folder-open');
        yield MenuItem::linktoRoute('Planning Import', 'fas fa-folder-open', 'admin_planning_upload');
        yield MenuItem::linktoRoute('BO Import', 'fas fa-folder-open', 'admin_bo_upload');

        yield MenuItem::section('Exports', 'fas fa-folder-open');
        yield MenuItem::linktoRoute('Rafting Export', 'fas fa-folder-open', 'admin_export_rafting');
        yield MenuItem::linktoRoute('Afrekening Export', 'fas fa-folder-open', 'admin_export_bill');

        yield MenuItem::section('Forms', 'fas fa-folder-open');
        yield MenuItem::linkToCrud('FormBill', 'fas fa-folder-open', Customer::class);
        yield MenuItem::linkToCrud('FormCheckin', 'fas fa-folder-open', Customer::class);
        yield MenuItem::linkToCrud('FormGroupLayout', 'fas fa-folder-open', Customer::class);
        yield MenuItem::linkToCrud('FormLodgingLayout', 'fas fa-folder-open', Customer::class);
        yield MenuItem::linkToCrud('FormOptions', 'fas fa-folder-open', Customer::class);
        yield MenuItem::linkToCrud('FormPayment', 'fas fa-folder-open', Payment::class);
        yield MenuItem::linkToCrud('FormSizes', 'fas fa-folder-open', Customer::class);

        yield MenuItem::section('Entities', 'fas fa-folder-open');
        yield MenuItem::linkToCrud('Activity', 'fas fa-folder-open', Activity::class);
        yield MenuItem::linkToCrud('Agency', 'fas fa-folder-open', Agency::class);
        yield MenuItem::linkToCrud('Customer', 'fas fa-folder-open', Customer::class);
        yield MenuItem::linkToCrud('Groep', 'fas fa-folder-open', Groep::class);
        yield MenuItem::linkToCrud('Guide', 'fas fa-folder-open', Guide::class);
        yield MenuItem::linkToCrud('IncludeOption', 'fas fa-folder-open', IncludeOption::class);
        yield MenuItem::linkToCrud('Location', 'fas fa-folder-open', Location::class);
        yield MenuItem::linkToCrud('Planning', 'fas fa-folder-open', Planning::class);
        yield MenuItem::linkToCrud('Program', 'fas fa-folder-open', Program::class);
        yield MenuItem::linkToCrud('ProgramActivity', 'fas fa-folder-open', ProgramActivity::class);
        yield MenuItem::linkToCrud('User', 'fas fa-folder-open', User::class);

        yield MenuItem::section('Types', 'fas fa-folder-open');
        yield MenuItem::linkToCrud('ActivityGroup', 'fas fa-folder-open', ActivityGroup::class);
        yield MenuItem::linkToCrud('AllInType', 'fas fa-folder-open', AllInType::class);
        yield MenuItem::linkToCrud('BeltSize', 'fas fa-folder-open', BeltSize::class);
        yield MenuItem::linkToCrud('InsuranceType', 'fas fa-folder-open', InsuranceType::class);
        yield MenuItem::linkToCrud('HelmSize', 'fas fa-folder-open', HelmSize::class);
        yield MenuItem::linkToCrud('GroupType', 'fas fa-folder-open', GroupType::class);
        yield MenuItem::linkToCrud('LodgingType', 'fas fa-folder-open', LodgingType::class);
        yield MenuItem::linkToCrud('ProgramGroup', 'fas fa-folder-open', ProgramGroup::class);
        yield MenuItem::linkToCrud('ProgramType', 'fas fa-folder-open', ProgramType::class);
        yield MenuItem::linkToCrud('SuitSize', 'fas fa-folder-open', SuitSize::class);
        yield MenuItem::linkToCrud('TransportType', 'fas fa-folder-open', TransportType::class);
        yield MenuItem::linkToCrud('TravelType', 'fas fa-folder-open', TravelType::class);
    }
}
