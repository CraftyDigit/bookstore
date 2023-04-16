<?php

namespace App\Controllers\Front;

use CraftyDigit\Puff\Attributes\Controller;
use CraftyDigit\Puff\Attributes\Route;
use CraftyDigit\Puff\Container\ContainerExtendedInterface;
use CraftyDigit\Puff\Controller\AbstractController;
use CraftyDigit\Puff\DataHandler\DataHandlerInterface;
use CraftyDigit\Puff\Enums\DataSourceType;

#[Controller('catalog')]
final class CatalogController extends AbstractController
{
    public function __construct(
        private readonly ContainerExtendedInterface $container,
        private readonly DataHandlerInterface $DataHandler,
    )
    {
        $this->container->callMethod(parent::class, '__construct', target:  $this);
    }

    #[Route('/catalog', 'catalog')]
    public function catalog(): void
    {
        $jsonEntityManager = $this->DataHandler->getEntityManager(DataSourceType::JSON);
        
        $categoriesRepo = $jsonEntityManager->getRepository('categories');
        $templateData['categories'] = $categoriesRepo->findAll();

        $productsRepo = $jsonEntityManager->getRepository('products');
        $templateData['products'] = $productsRepo->findAll();

        $templateData['pageTitle'] = 'Catalog';
        
        $this->templateEngine->display('Front/catalog', $templateData);
    }
}