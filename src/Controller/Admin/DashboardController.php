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
use App\Utils\Calculations;
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
        $periodId = Calculations::getCurrentPeriodId();

        yield MenuItem::section('Imports', 'fas fa-file-import');
        yield MenuItem::linktoRoute('Planning Import', 'fas fa-file-import', 'admin_import_planning');
        yield MenuItem::linktoRoute('BO Import', 'fas fa-file-import', 'admin_import_bo');

        yield MenuItem::section('Exports', 'fas fa-file-upload');
        yield MenuItem::linktoRoute('Rafting Period Export', 'fas fa-file-upload', 'admin_export_rafting_period');
        yield MenuItem::linktoRoute('Rafting Yearly Export', 'fas fa-file-upload', 'admin_export_rafting_year');
        yield MenuItem::linktoRoute('Afrekening Export', 'fas fa-file-upload', 'admin_export_bill');

        yield MenuItem::section('Forms', 'fas fa-clipboard-list');
        yield MenuItem::linkToCrud('FormBill', 'fas fa-file-invoice', Customer::class)
            ->setController(FormBillCrudController::class)
            ->setQueryParameter('filters[periodId][comparison]', '=')
            ->setQueryParameter('filters[periodId][value]', $periodId);
        yield MenuItem::linkToCrud('FormCheckin', 'fas fa-user-check', Customer::class)
            ->setController(FormCheckinCrudController::class)
            ->setQueryParameter('filters[periodId][comparison]', '=')
            ->setQueryParameter('filters[periodId][value]', $periodId);
        yield MenuItem::linkToCrud('FormGroupLayout', 'fas fa-users', Customer::class)
            ->setController(FormGroupLayoutCrudController::class)
            ->setQueryParameter('filters[periodId][comparison]', '=')
            ->setQueryParameter('filters[periodId][value]', $periodId);
        yield MenuItem::linkToCrud('FormLodgingLayout', 'fas fa-campground', Customer::class)
            ->setController(FormLodgingLayoutCrudController::class)
            ->setQueryParameter('filters[periodId][comparison]', '=')
            ->setQueryParameter('filters[periodId][value]', $periodId);
        yield MenuItem::linkToCrud('FormOptions', 'fas fa-clipboard-list', Customer::class)
            ->setController(FormOptionsCrudController::class)
            ->setQueryParameter('filters[periodId][comparison]', '=')
            ->setQueryParameter('filters[periodId][value]', $periodId);
        yield MenuItem::linkToCrud('FormPayment', 'fas fa-shopping-cart', Payment::class)
            ->setController(FormPaymentCrudController::class);
        yield MenuItem::linkToCrud('FormSizes', 'fas fa-tshirt', Customer::class)
            ->setController(FormSizesCrudController::class)
            ->setQueryParameter('filters[periodId][comparison]', '=')
            ->setQueryParameter('filters[periodId][value]', $periodId);

        yield MenuItem::section('Entities', 'fas fa-folder-open');
        yield MenuItem::linkToCrud('Activity', 'fas fa-folder-open', Activity::class)
            ->setController(ActivityCrudController::class);
        yield MenuItem::linkToCrud('Agency', 'fas fa-folder-open', Agency::class)
            ->setController(AgencyCrudController::class);
        yield MenuItem::linkToCrud('Customer', 'fas fa-folder-open', Customer::class)
            ->setController(CustomerCrudController::class)
            ->setQueryParameter('filters[periodId][comparison]', '=')
            ->setQueryParameter('filters[periodId][value]', $periodId);
        yield MenuItem::linkToCrud('Groep', 'fas fa-folder-open', Groep::class)
            ->setController(GroepCrudController::class);
        yield MenuItem::linkToCrud('Guide', 'fas fa-folder-open', Guide::class)
            ->setController(GuideCrudController::class);
        yield MenuItem::linkToCrud('IncludeOption', 'fas fa-folder-open', IncludeOption::class)
            ->setController(IncludeOptionCrudController::class);
        yield MenuItem::linkToCrud('Location', 'fas fa-folder-open', Location::class)
            ->setController(LocationCrudController::class);
        yield MenuItem::linkToCrud('Planning', 'fas fa-folder-open', Planning::class)
            ->setController(PlanningCrudController::class);
        yield MenuItem::linkToCrud('Program', 'fas fa-folder-open', Program::class)
            ->setController(ProgramCrudController::class);
        yield MenuItem::linkToCrud('ProgramActivity', 'fas fa-folder-open', ProgramActivity::class)
            ->setController(ProgramActivityCrudController::class);
        yield MenuItem::linkToCrud('User', 'fas fa-folder-open', User::class)
            ->setController(UserCrudController::class);

        yield MenuItem::section('Types', 'fas fa-folder-open');
        yield MenuItem::linkToCrud('ActivityGroup', 'fas fa-folder-open', ActivityGroup::class)
            ->setController(ActivityGroupCrudController::class);
        yield MenuItem::linkToCrud('AllInType', 'fas fa-folder-open', AllInType::class)
            ->setController(AllInTypeCrudController::class);
        yield MenuItem::linkToCrud('BeltSize', 'fas fa-folder-open', BeltSize::class)
            ->setController(BeltSizeCrudController::class);
        yield MenuItem::linkToCrud('InsuranceType', 'fas fa-folder-open', InsuranceType::class)
            ->setController(InsuranceTypeCrudController::class);
        yield MenuItem::linkToCrud('HelmSize', 'fas fa-folder-open', HelmSize::class)
            ->setController(HelmSizeCrudController::class);
        yield MenuItem::linkToCrud('GroupType', 'fas fa-folder-open', GroupType::class)
            ->setController(GroupTypeCrudController::class);
        yield MenuItem::linkToCrud('LodgingType', 'fas fa-folder-open', LodgingType::class)
            ->setController(LodgingTypeCrudController::class);
        yield MenuItem::linkToCrud('ProgramGroup', 'fas fa-folder-open', ProgramGroup::class)
            ->setController(ProgramGroupCrudController::class);
        yield MenuItem::linkToCrud('ProgramType', 'fas fa-folder-open', ProgramType::class)
            ->setController(ProgramTypeCrudController::class);
        yield MenuItem::linkToCrud('SuitSize', 'fas fa-folder-open', SuitSize::class)
            ->setController(SuitSizeCrudController::class);
        yield MenuItem::linkToCrud('TransportType', 'fas fa-folder-open', TransportType::class)
            ->setController(TransportTypeCrudController::class);
        yield MenuItem::linkToCrud('TravelType', 'fas fa-folder-open', TravelType::class)
            ->setController(TravelTypeCrudController::class);
    }
}
