<?php

namespace App\Controllers\Front;

use CraftyDigit\Puff\Attributes\Controller;
use CraftyDigit\Puff\Attributes\Route;
use CraftyDigit\Puff\Container\ContainerExtendedInterface;
use CraftyDigit\Puff\Controller\AbstractController;
use CraftyDigit\Puff\DataHandler\DataHandlerManagerInterface;
use CraftyDigit\Puff\Enums\DataHandler;

#[Controller('catalog')]
final class CatalogController extends AbstractController
{
    public function __construct(
        protected ContainerExtendedInterface $container,
        private readonly DataHandlerManagerInterface $dataHandlerManager
    )
    {
        $this->container->callMethod(parent::class, '__construct', target:  $this);
    }

    #[Route('/catalog', 'catalog')]
    public function catalog(): void
    {
        $jsonEntityManager = $this->dataHandlerManager->getEntityManager(DataHandler::JSON);
        
        $categoriesRepo = $jsonEntityManager->getRepository('categories');
        $templateData['categories'] = $categoriesRepo->getAll();

        $productsRepo = $jsonEntityManager->getRepository('products');
        $templateData['products'] = $productsRepo->getAll();

        $templateData['pageTitle'] = 'Catalog';

        $this->output($templateData);
    }
}