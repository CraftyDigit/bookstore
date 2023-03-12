<?php

namespace App\Controllers\Front;

use CraftyDigit\Puff\Attributes\Controller;
use CraftyDigit\Puff\Attributes\Route;
use CraftyDigit\Puff\Controller\AbstractController;
use CraftyDigit\Puff\Repository\RepositoryManager;
use CraftyDigit\Puff\Repository\RepositoryManagerInterface;
use Exception;

#[Controller('catalog')]
final class CatalogController extends AbstractController
{
    /**
     * @param RepositoryManagerInterface $repositoryManager
     * @throws Exception
     */
    public function __construct(
        private readonly RepositoryManagerInterface $repositoryManager = new RepositoryManager()
    )
    {
        parent::__construct();
    }

    /**
     * @return void
     * @throws Exception
     */
    #[Route('/catalog', 'catalog')]
    public function catalog(): void
    {
        $categoriesRepo = $this->repositoryManager->getRepository('categories');
        $templateData['categories'] = $categoriesRepo->getAll();

        $productsRepo = $this->repositoryManager->getRepository('products');
        $templateData['products'] = $productsRepo->getAll();

        $templateData['pageTitle'] = 'Catalog';

        $this->output($templateData);
    }
}