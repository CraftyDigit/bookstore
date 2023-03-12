<?php

namespace App\Controllers\Admin;

use CraftyDigit\Puff\Attributes\Controller;
use CraftyDigit\Puff\Attributes\Route;
use CraftyDigit\Puff\Controller\AbstractController;
use CraftyDigit\Puff\Exceptions\ClassNotFoundException;
use CraftyDigit\Puff\Exceptions\RouteNotFoundException;
use CraftyDigit\Puff\Model\Model;
use CraftyDigit\Puff\Repository\RepositoryManager;
use CraftyDigit\Puff\Repository\RepositoryManagerInterface;
use CraftyDigit\Puff\Router\Router;
use Exception;

#[Controller('dashboard')]
final class DashboardController extends AbstractController
{
    /**
     * @param Router|null $router
     * @param RepositoryManagerInterface $repositoryManager
     * @throws Exception
     */
    public function __construct(
        private ?Router $router = null,
        private readonly RepositoryManagerInterface $repositoryManager = new RepositoryManager()
    )
    {
        parent::__construct();
        
        $this->router = Router::getInstance();
    }

    /**
     * @return void
     * @throws Exception
     */
    #[Route('/admin/dashboard', 'dashboard')]
    public function dashboard(): void
    {
        $this->router->followRouteByName('products_list');
    }

    /**
     * @return void
     * @throws Exception
     */
    #[Route('/admin/dashboard/products/edit', 'product_edit', 'POST')]
    public function productEdit(): void
    {
        $productsRepo =  $this->repositoryManager->getRepository('products');

        $product = $productsRepo->getOneById($_POST['product']['id']);

        foreach ($_POST['product'] as $fieldName => $fieldValue) {
            if ($fieldName === 'id') {
                continue;
            }

            $product->$fieldName = $fieldValue;
        }

        $productsRepo->updateItem($product);

        $this->router->redirectToRouteByName('product_info', ['id' => $product->id]);
    }

    /**
     * @return void
     * @throws Exception
     */
    #[Route('/admin/dashboard/products/add', 'product_add', 'POST')]
    public function productAdd(): void
    {
        $productsRepo =  $this->repositoryManager->getRepository('products');

        $product = new Model($_POST['product']);
        $product = $productsRepo->addItem($product);

        $this->router->redirectToRouteByName('product_info', ['id' => $product->id]);
    }

    /**
     * @return void
     * @throws Exception
     */
    #[Route('/admin/dashboard/products/delete', 'product_delete', 'POST')]
    public function productDelete(): void
    {
        $productsRepo =  $this->repositoryManager->getRepository('products');
        $product = $productsRepo->getOneById($_POST['product']['id']);

        if ($product) {
            $productsRepo->deleteItem($product);
        }

        $this->router->redirectToRouteByName('products_list');
    }

    /**
     * @return void
     * @throws Exception
     */
    #[Route('/admin/dashboard/products', 'products_list')]
    public function productsList(): void
    {
        $categoriesRepo = $this->repositoryManager->getRepository('categories');
        $categories = $categoriesRepo->getAll();

        $templateData['categories'] = [];

        foreach ($categories as $category) {
            $templateData['categories'][$category->id] = $category->name;
        }

        $productsRepo =  $this->repositoryManager->getRepository('products');
        $templateData['products'] = $productsRepo->getAll();

        $templateData['pageTitle'] = 'Dashboard';

        $this->output($templateData);
    }

    /**
     * @return void
     * @throws ClassNotFoundException
     * @throws Exception
     */
    #[Route('/admin/dashboard/products/info', 'product_info')]
    public function productInfo(): void
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            throw new RouteNotFoundException('Product id not specified');
        }
        
        $itemId = $_GET['id'];
        
        $productsRepo = $this->repositoryManager->getRepository('products');
        $categoriesRepo = $this->repositoryManager->getRepository('categories');

        $templateData['product'] = $productsRepo->getOneById($itemId);
        
        if ($templateData['product'] === null) {
            throw new RouteNotFoundException('Product with id = ' . $itemId . ' not found');
        }
        
        $templateData['categories'] = $categoriesRepo->getAll();
        $templateData['pageTitle'] = 'Product #' . $templateData['product']->id;

        $template = $this->templateManager->getTemplate('Admin/product');
        
        $this->render($template, $templateData);
    }

    /**
     * @return void
     * @throws Exception
     */
    #[Route('/admin/dashboard/products/add', 'new_product')]
    public function newProduct(): void
    {
        $productsRepo = $this->repositoryManager->getRepository('products');
        $categoriesRepo = $this->repositoryManager->getRepository('categories');

        $templateData['product'] = $productsRepo->getBlankItem();
        $templateData['categories'] = $categoriesRepo->getAll();
        $templateData['pageTitle'] = 'New product';

        $template = $this->templateManager->getTemplate('Admin/product');
        
        $this->render($template, $templateData);
    }
}