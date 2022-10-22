<?php

namespace App\Controllers\Front;

use App\Core\Controller;
use App\Core\Repository\RepositoryManager;
use Exception;

class CatalogController extends Controller
{
    /**
     * @var RepositoryManager
     */
    private RepositoryManager $repositoryManager;

    public function __construct()
    {
        parent::__construct();

        $this->repositoryManager = new RepositoryManager();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function render(): void
    {
        $categoriesRepo = $this->repositoryManager->getRepository('categories');
        $templateData['categories'] = $categoriesRepo->getAll();

        $productsRepo = $this->repositoryManager->getRepository('products');
        $templateData['products'] = $productsRepo->getAll();

        $templateData['pageTitle'] = 'Catalog';

        $this->output('catalog', $templateData);
    }
}