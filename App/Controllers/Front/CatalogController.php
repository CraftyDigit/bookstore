<?php

namespace App\Controllers\Front;

use App\Core\Controller\AbstractController;
use App\Core\Repository\RepositoryManager;
use App\Core\Repository\RepositoryManagerInterface;
use Exception;

final class CatalogController extends AbstractController
{
    /**
     * @param RepositoryManagerInterface $repositoryManager
     */
    public function __construct(private RepositoryManagerInterface $repositoryManager = new RepositoryManager())
    {
        parent::__construct();
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

        $this->output($templateData);
    }
}