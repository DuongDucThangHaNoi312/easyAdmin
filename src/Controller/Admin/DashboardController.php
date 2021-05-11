<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Product;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

// redirect to some CRUD controller
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        return $this->redirect($routeBuilder->setController(PostCrudController::class)->generateUrl());


    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('TRANG ADMIN');
    }

    public function configureMenuItems(): iterable
    {

        yield MenuItem::linktoDashboard('Home', 'fa fa-home');

        yield MenuItem::linkToCrud('Post', 'fas fa-file-pdf', Post::class);
        yield MenuItem::linkToCrud('Category', 'fab fa-adn', Category::class);
        yield MenuItem::linkToCrud('Product', 'fab fa-product-hunt', Product::class);
       if($this->isGranted('ROLE_ADMIN')) {
           yield MenuItem::linkToCrud('User', 'fas fa-users', User::class);
       }


    }
}
