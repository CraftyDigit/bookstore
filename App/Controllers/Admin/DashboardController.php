<?php

namespace App\Controllers\Admin;

use App\Core\Controller\AbstractController;
use App\Core\Model\Model;
use App\Core\Repository\RepositoryManager;
use App\Core\Repository\RepositoryManagerInterface;
use Exception;

final class DashboardController extends AbstractController
{
    /**
     * @param RepositoryManagerInterface $repositoryManager
     * @param bool $isAdminController
     */
    public function __construct(
        public bool $isAdminController = true,
        private RepositoryManagerInterface $repositoryManager = new RepositoryManager()
    )
    {
        parent::__construct($isAdminController);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function render(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ( !empty($_POST['point']) ) {
                if  ($_POST['point'] === 'product_save') {
                    $this->productSave();
                } else if ($_POST['point'] === 'product_add') {
                    $this->productAdd();
                } else if ($_POST['point'] === 'product_delete') {
                    $this->productDelete();
                }
            }
        } else if ( !empty($_GET['productId']) ) {
            if ($_GET['productId'] == 'new') {
                $this->renderItemAdd();
            } else {
                $this->renderItem($_GET['productId']);
            }
        } else {
            $this->renderList();
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    private function productSave(): void
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

        $this->renderItem($product->id);
    }

    /**
     * @return void
     * @throws Exception
     */
    private function productAdd(): void
    {
        $productsRepo =  $this->repositoryManager->getRepository('products');

        $product = new Model($_POST['product']);
        $product = $productsRepo->addItem($product);

        $this->renderItem($product->id);
    }

    /**
     * @return void
     * @throws Exception
     */
    private function productDelete(): void
    {
        $productsRepo =  $this->repositoryManager->getRepository('products');
        $product = $productsRepo->getOneById($_POST['product']['id']);

        if ($product) {
            $productsRepo->deleteItem($product);
        }

        $this->renderList();
    }

    /**
     * @return void
     * @throws Exception
     */
    private function renderList(): void
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
     * @param int $itemId
     * @return void
     * @throws Exception
     */
    private function renderItem(int $itemId): void
    {
        $productsRepo = $this->repositoryManager->getRepository('products');

        $templateData['product'] = $productsRepo->getOneById($itemId);
        $templateData['categoriesList'] = $this->getCategoriesList();
        $templateData['pageTitle'] = 'Product #' . $templateData['product']->id;

        $this->template = $this->templateManager->getTemplate('product', true);
        $this->output($templateData);
    }

    /**
     * @return void
     * @throws Exception
     */
    private function renderItemAdd(): void
    {
        $productsRepo = $this->repositoryManager->getRepository('products');

        $templateData['product'] = $productsRepo->getBlankItem();
        $templateData['categoriesList'] = $this->getCategoriesList();
        $templateData['pageTitle'] = 'New product';

        $this->template = $this->templateManager->getTemplate('product', true);
        $this->output($templateData);
    }

    /**
     * Get a string with a numbered list of categories
     *
     * @return string
     * @throws Exception
     */
    private function getCategoriesList(): string
    {
        $categoriesRepo = $this->repositoryManager->getRepository('categories');
        $categories = $categoriesRepo->getAll();
        $categoriesList = '';

        foreach ($categories as $category) {
            $categoriesList .= ', ' . $category->id .' - '.ucfirst($category->name);
        }

        $pos = strpos($categoriesList, ', ');
        if ($pos !== false) {
            $categoriesList = substr_replace($categoriesList, '', $pos, 2);
        }

        return $categoriesList;
    }
}