<?php

namespace App\Controllers\Front;

use CraftyDigit\Puff\Controller\AbstractController;
use CraftyDigit\Puff\Repository\RepositoryManager;
use CraftyDigit\Puff\Repository\RepositoryManagerInterface;
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