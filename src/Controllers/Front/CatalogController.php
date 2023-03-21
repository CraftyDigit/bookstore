<?php

namespace App\Controllers\Front;

use CraftyDigit\Puff\Attributes\Controller;
use CraftyDigit\Puff\Attributes\Route;
use CraftyDigit\Puff\Container\ContainerExtendedInterface;
use CraftyDigit\Puff\Controller\AbstractController;
use CraftyDigit\Puff\Repository\RepositoryManagerInterface;
use Exception;

#[Controller('catalog')]
final class CatalogController extends AbstractController
{
    /**
     * @param ContainerExtendedInterface $container
     * @param RepositoryManagerInterface $repositoryManager
     */
    public function __construct(
        protected ContainerExtendedInterface $container,
        private readonly RepositoryManagerInterface $repositoryManager
    )
    {
        $this->container->callMethod(parent::class, '__construct', target:  $this);
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