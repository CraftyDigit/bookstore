<?php

namespace App\Controllers;

use App\Framework\Config;
use App\Framework\Controller;
use App\Framework\Repository;

class CatalogController extends Controller
{

    /**
     * @return void
     */
    public function render()
    {
        $config = Config::getInstance();
        $templateData['categories'] = $config->catalog_categories;

        $productsRepo = new Repository('products');
        $templateData['products'] = $productsRepo->getAll();

        $templateData['pageTitle'] = 'Catalog';

        $this->output('catalog', $templateData);
    }

}