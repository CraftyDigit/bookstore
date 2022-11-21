# Simple bookstore

Simple site backbone made on PHP. 

Features:
* High extendability. 
* Front-end and administration panel. 
* JSON files as data sources.
* Prod and dev versions.
* Deployment with or without docker.
* Core classes covered with tests.

## Entry points:

* **'/'** - Homepage
* **'/catalog'** - Catalog page. 
    - Products displayed by categories.
* **'/admin/dashboard'** - Admin panel dashboard. 
    - "Add product" button.
    - Products table. Product names - links to product edit page. 
* **'/admin/dashboard?productId=0'** - Product edit page.
* If no controller for the entry point is found - the 404 error page will be displayed.

## Installation with Docker:

#### Requirements:
- Docker

#### Installation process:
1. Copy code from the project repository.
2. In the project root folder execute commands:
    - (dev version) ``` docker-compose up --d ```
    - (prod version) ``` docker-compose -f docker-compose_prod.yaml up --d ```

## Installation with Composer (without Docker):

#### Requirements:
- Apache 2.4 (with mod_rewrite)
- PHP 8.1
- Сomposer 2.4.4

#### Installation process:
1. Copy code from the project repository.
2. In the project root folder execute commands:
    - (dev version) ``` composer install --prefer-source ```
    - (prod version) ``` composer install --no-dev --prefer-source ```
