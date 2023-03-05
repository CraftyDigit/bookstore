# 'Simple bookstore' - demo site for 'CraftyDigit/Puff' framework 

Demo site made as a showcase for 'CraftyDigit/Puff' framework.

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
2. Open the terminal and in the project root folder execute a command:
    - ``` docker-compose up --d ```
    
## Installation with Composer (without Docker):

#### Requirements:
- Apache 2.4 (with mod_rewrite)
- PHP 8.2
- Composer 2.4.4

#### Installation process:
1. Copy code from the project repository.
2. Open the terminal and in the project root folder execute a command:
    - ``` composer install --prefer-source ```