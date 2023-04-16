<?php

namespace App\Controllers\Admin;

use CraftyDigit\Puff\Attributes\Controller;
use CraftyDigit\Puff\Attributes\Route;
use CraftyDigit\Puff\Container\ContainerExtendedInterface;
use CraftyDigit\Puff\Controller\AbstractController;
use CraftyDigit\Puff\DataHandler\DataHandlerInterface;
use CraftyDigit\Puff\Enums\DataSourceType;
use CraftyDigit\Puff\Exceptions\RouteNotFoundException;
use CraftyDigit\Puff\Router\Router;
use CraftyDigit\Puff\Model\Model;

#[Controller('dashboard')]
final class DashboardController extends AbstractController
{
    public function __construct(
        private readonly ContainerExtendedInterface $container,
        private readonly Router $router,
        private readonly DataHandlerInterface $DataHandler,
        private ?object $jsonEntityManager = null,
    )
    {
        $this->container->callMethod(parent::class, '__construct', target: $this);
        
        $this->jsonEntityManager = $this->DataHandler->getEntityManager(DataSourceType::JSON);
    }

    #[Route('/admin/dashboard', 'dashboard')]
    public function dashboard(): void
    {
        $this->router->followRouteByName('products_list');
    }

    #[Route('/admin/dashboard/products/edit', 'product_edit', 'POST')]
    public function productEdit(): void
    {
        $productsRepo =  $this->jsonEntityManager->getRepository('products');

        $product = $productsRepo->find($_POST['product']['id']);

        foreach ($_POST['product'] as $fieldName => $fieldValue) {
            if ($fieldName === 'id') {
                continue;
            }

            $product->$fieldName = $fieldValue;
        }

        $productsRepo->updateItem($product);

        $this->router->redirectToRouteByName('product_info', ['id' => $product->id]);
    }

    #[Route('/admin/dashboard/products/add', 'product_add', 'POST')]
    public function productAdd(): void
    {
        $productsRepo =  $this->jsonEntityManager->getRepository('products');

        $product = $this->container->get(Model::class, ['data' => $_POST['product']]);
        $product = $productsRepo->addItem($product);

        $this->router->redirectToRouteByName('product_info', ['id' => $product->id]);
    }

    #[Route('/admin/dashboard/products/delete', 'product_delete', 'POST')]
    public function productDelete(): void
    {
        $productsRepo =  $this->jsonEntityManager->getRepository('products');
        $product = $productsRepo->find($_POST['product']['id']);

        if ($product) {
            $productsRepo->deleteItem($product);
        }

        $this->router->redirectToRouteByName('products_list');
    }

    #[Route('/admin/dashboard/products', 'products_list')]
    public function productsList(): void
    {
        $categoriesRepo = $this->jsonEntityManager->getRepository('categories');
        $categories = $categoriesRepo->findAll();

        $templateData['categories'] = [];

        foreach ($categories as $category) {
            $templateData['categories'][$category->id] = $category->name;
        }

        $productsRepo =  $this->jsonEntityManager->getRepository('products');
        $templateData['products'] = $productsRepo->findAll();

        $templateData['pageTitle'] = 'Dashboard';

        $this->templateEngine->display('Admin/dashboard', $templateData);
    }

    #[Route('/admin/dashboard/products/info', 'product_info')]
    public function productInfo(): void
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            throw new RouteNotFoundException('Product id not specified');
        }
        
        $itemId = $_GET['id'];
        
        $productsRepo = $this->jsonEntityManager->getRepository('products');
        $categoriesRepo = $this->jsonEntityManager->getRepository('categories');

        $templateData['product'] = $productsRepo->find($itemId);
        
        if ($templateData['product'] === null) {
            throw new RouteNotFoundException('Product with id = ' . $itemId . ' not found');
        }
        
        $templateData['categories'] = $categoriesRepo->findAll();
        $templateData['pageTitle'] = 'Product #' . $templateData['product']->id;

        $this->templateEngine->display('Admin/product', $templateData);
    }

    #[Route('/admin/dashboard/products/add', 'new_product')]
    public function newProduct(): void
    {
        $productsRepo = $this->jsonEntityManager->getRepository('products');
        $categoriesRepo = $this->jsonEntityManager->getRepository('categories');

        $templateData['product'] = $productsRepo->getBlankItem();
        $templateData['categories'] = $categoriesRepo->findAll();
        $templateData['pageTitle'] = 'New product';
        
        $this->templateEngine->display('Admin/product', $templateData);
    }
}