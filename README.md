# Laravel/vuejs products management app

Welcome to my Laravel/vuejs project! This project is designed to manage products and categories through both a command line interface (CLI) and a web interface.

## Prerequisites

Before you get started, make sure you have the following software installed on your machine:

- php  >= 7.3
- MySQL >= 5.7
- Composer

## Installation

1. Clone this repository to your local machine:
```console
git clone https://github.com/youssefhoussaf/YOUCAN_CODING_CHALLENGE.git
```
2. Navigate to the project directory:
```console
cd YOUCAN_CODING_CHALLENGE
```
3. Install the required dependencies:
```console
composer install
```
4. Create a copy of the .env.example file and rename it to .env. Update the .env file with your database and other configuration details.
5. Generate an application key:
```console
php artisan key:generate
```
6. Run the database migrations:
```console
php artisan migrate --seed
```
7. Create the symbolic link
```console
php artisan storage:link
```
8. Install frontend dependencies
```console
npm install
```

## usage

#### Web Interface
To use the web interface, start the development server:

```console
php artisan serve
```

You can then access the web interface at http://localhost:8000.

#### Command Line Interface (CLI)

1. To create a new Category , run the following command:

```console
php artisan create:category
```

Then Enter name and parent category(not required):

```console
Enter category name:
> 
Enter parent category id (not required):
> 
```

2. to delete a category , run the following command:

```console
php artisan delete:category
```

Then Enter id:

```console
Enter category id:
> 
```

3. To create a new product , run the following command:

```console
php artisan create:product
```

Then Enter name and description and price and category id:

```console
Enter product name:
> 
Enter product decription:
> 
Enter product price:
> 
Enter category id:
> 
```

4. to delete a product , run the following command:

```console
php artisan delete:product
```

Then Enter id:

```console
Enter product id:
> 
```

## Testing

To Test product creation, run the following command:
```console
php artisan test --filter ProductTest
```

## Architecture

```
app/
├── Console
|   ├── Commands
│   |   |── CreateCategory.php
│   |   |── CreateProduct.php
│   |   |── DeleteCategory.php
|   |   └── DeleteProduct.php
├── Http
│   ├── Controllers
│   │   ├── CategoryController.php
│   │   ├── Controller.php
│   │   ├── ProductController.php
│   │   └── UploadController.php
│   ├── Kernel.php
├── repositories
│   ├── CategoriesRepository.php
│   └── ProductsRepository.php
recources/
├── css
|   ├── app.css
├── js
|   ├── pages
│   |   |── Categories.vue
│   |   |── Home.vue
|   |   └── Products.vue
|   ├── router
|   |   └── index.js
|   ├── services
│   |   |── CategoriesProvider.js
│   |   |── ProductsProvider.js
|   |   └── UploadProvider.js
|   ├── app.js
|   ├── app.vue
│   └── bootstrap.js
├── views
│   └── app.blade.php
routes/
├── api.php
└── web.php
