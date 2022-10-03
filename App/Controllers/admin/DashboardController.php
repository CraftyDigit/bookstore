<?php

namespace App\Controllers\admin;

use App\Framework\Config;
use App\Framework\Controller;
use App\Framework\Model;
use App\Framework\Repository;

class DashboardController extends Controller
{

    public $isAdminController = true;

    /**
     * @return void
     */
    public function render()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ( !empty($_POST['point']) ) {
                if  ($_POST['point'] === 'product_save') {
                    $productsRepo = new Repository('products');

                    $product = $productsRepo->getOneById($_POST['product']['id']);

                    foreach ($_POST['product'] as $fieldName => $fieldValue) {

                        if ($fieldName === 'id') {
                            continue;
                        }

                        $product->$fieldName = $fieldValue;
                    }

                    $productsRepo->setDataItem($product);

                    $this->renderItem($product->id);
                } else if ($_POST['point'] === 'product_add') {
                    $productsRepo = new Repository('products');

                    $product = new Model($_POST['product']);
                    $product = $productsRepo->addDataItem($product);

                    $this->renderItem($product->id);
                } else if ($_POST['point'] === 'product_delete') {
                    $productsRepo = new Repository('products');
                    $product = $productsRepo->getOneById($_POST['product']['id']);

                    if ($product) {
                        $productsRepo->deleteDataItem($product);
                    }

                    $this->renderList();
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
     */
    private function renderList()
    {
        $config = Config::getInstance();
        $categoriesRaw = $config->catalog_categories;
        $templateData['categories'] = [];

        foreach ($categoriesRaw as $categoryData) {
            $templateData['categories'][$categoryData['id']] = $categoryData['name'];
        }

        $productsRepo = new Repository('products');
        $templateData['products'] = $productsRepo->getAll();

        $templateData['pageTitle'] = 'Dashboard';

        $this->output('dashboard', $templateData);
    }

    /**
     * @param int $itemId
     * @return void
     */
    private function renderItem(int $itemId)
    {
        $productsRepo = new Repository('products');
        $templateData['product'] = $productsRepo->getOneById($itemId);

        $config = Config::getInstance();
        $categoriesRaw = $config->catalog_categories;
        $categoryList = '';

        foreach ($categoriesRaw as $categoryData) {
            $categoryList .= ', ' . $categoryData['id'] .' - '.ucfirst($categoryData['name']);
        }

        $pos = strpos($categoryList, ', ');
        if ($pos !== false) {
            $templateData['categoryList'] = substr_replace($categoryList, '', $pos, 2);
        }

        $templateData['pageTitle'] = 'Product #' . $templateData['product']->id;

        $this->output('product', $templateData);
    }


    /**
     * @return void
     */
    private function renderItemAdd()
    {
        $productsRepo = new Repository('products');
        $templateData['product'] = $productsRepo->getBlankItem();

        $config = Config::getInstance();
        $categoriesRaw = $config->catalog_categories;
        $categoryList = '';

        foreach ($categoriesRaw as $categoryData) {
            $categoryList .= ', ' . $categoryData['id'] .' - '.ucfirst($categoryData['name']);
        }

        $pos = strpos($categoryList, ', ');
        if ($pos !== false) {
            $templateData['categoryList'] = substr_replace($categoryList, '', $pos, 2);
        }

        $templateData['pageTitle'] = 'New product';

        $this->output('product', $templateData);
    }

}