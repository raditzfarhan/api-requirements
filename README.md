# api-requirements

## Description
We want you to implement a REST API endpoint that given a list of products, applies some
discounts to them and can be filtered.
You are free to choose whatever language and tools you are most comfortable with, but, we value you to use laravel since our main platform is also on laravel / php.
We will value your ability to apply the following rules on the corresponding layers following Domain Driven Design. 
Please add instructions on how to run it and publish it on your fork.

## Deliverable 

Fork the project, work on the solution and send us back a link to your forked GitHub project to examine your answer to this test.

## Conditions 


The prices are integers for example, 100.00€ would be 10000.
  
1. [x] You can store the products as you see fit (json file, in memory, rdbms of choice)
2. [x] Products in the "insurance" category have a 30% discount.
3. [x] The product with sku = 000003 has a 15% discount.
4. [x] Provide a single endpoint. GET /products.
5. [x] Can be filtered by category as a query string parameter.
6. [x] (optional) Can be filtered by price as a query string parameter, this filter applies before discounts are applied.
7. [x] Returns a list of Products with the given discounts applied when necessary Product model.
8. [x] price.currency is always EUR.
9. [x] When a product does not have a discount, price.final and price.original should be the same number and discount_percentage should be null.
10. [x] When a product has a discount, price.original is the original price, price.final is the amount with the discount applied and discount_percentage represents the applied discount with the % sign.

Example product with a discount of 30% applied:  
`    {
      "sku": "000001",
      "name": "Full coverage insurance",
      "category": "insurance",
      "price": {
          "original": 89000,
          "final": 62300,
          "discount_percentage": "30%",
          "currency": "EUR"
      }
    }`
  
  Example product without a discount:
  
      `{
        "sku": "000002",
        "name": "Compact Car X3",
        "category": "vehicle",
        "price": {
            "original": 89000,
            "final": 89000,
            "discount_percentage": null,
            "currency": "EUR"
        }
      }`
      
## Dataset       
The following dataset is the only dataset you need to be able to serve on the API: 

`{
    "products": [
      {
        "sku": "000001",
        "name": "Full coverage insurance",
        "category": "insurance",
        "price": 89000
      },
      {
        "sku": "000002",
        "name": "Compact Car X3",
        "category": "vehicle",
        "price": 99000
      },
      {
        "sku": "000003",
        "name": "SUV Vehicle, high end",
        "category": "vehicle",
        "price": 150000
      },
      {
        "sku": "000004",
        "name": "Basic coverage",
        "category": "insurance",
        "price": 20000
      },
      {
        "sku": "000005",
        "name": "Convertible X2, Electric",
        "category": "vehicle",
        "price": 250000
      }
    ]
  }`


## How to run?
This API was made using Laravel. So you can install it like any other Laravel project. Or you can follow Installation steps below. You may skip to next section if you already know these steps.

## Installation
1. First, clone the repo.
2. Then, copy the .env.example to .env
```sh
cp .env.example .env
```
3. Run composer to install all of the dependencies.
```sh
composer install
```
4. Generate the application key.
```sh
php artisan key:generate
```
> This app uses sqlite database with zero configuration. 
## Initialize the app
Run `php artisan app:init` to initialize the application with all the necessary data. Optionally, if you want to use the built-in PHP development server, you may run `php artisan serve`.

## Test the API
### Get all products
Get list of all products. You may also filter the results by specifying some query string parameters. 

```
GET /api/products
```

| Parameters | Type        | Description                                                                                                             | E.g.                                  |
|------------|-------------|-------------------------------------------------------------------------------------------------------------------------|---------------------------------------|
| sku        | string      | Filter exact value of SKU                                                                                               | `sku=000001`                          |
| name       | string      | Filter product name                                                                                                     | `name=compact`                        |
| category   | string      | Filter by category name                                                                                                 | `category=insurance`                  |
| price      | int\|string | Filter by exact price or price range. For price range, you may put min value follow by comma(,) and then the max value. | `price=89000` or  `price=89000,99000` |
| sort       | string      | Sort the list by specifying the parameters. Add minus(-) symbol for sort by descending order.                           | `sort=name,-category`                 |
| limit      | int         | Limit the search result.                                                                                                | `limit=1`                             |

#### Examples

***Example 1***

Request
```
GET /api/products?category=insurance&sort=name
```

Response
```json
[
  {
    "sku": "000004",
    "name": "Basic coverage",
    "category": "insurance",
    "price": {
      "original": 20000,
      "final": 14000,
      "discount_percentage": "30%",
      "currency": "EUR"
    }
  },
  {
    "sku": "000001",
    "name": "Full coverage insurance",
    "category": "insurance",
    "price": {
      "original": 89000,
      "final": 62300,
      "discount_percentage": "30%",
      "currency": "EUR"
    }
  }
]
```

***Example 2***

Request
```
GET /api/products?name=coverage&limit=1
```

Response
```json
[
  {
    "sku": "000001",
    "name": "Full coverage insurance",
    "category": "insurance",
    "price": {
      "original": 89000,
      "final": 62300,
      "discount_percentage": "30%",
      "currency": "EUR"
    }
  }
]
```

***Example 3***

Request
```
GET /api/products?price=89000,99000
```

Response 
```json
[
  {
    "sku": "000001",
    "name": "Full coverage insurance",
    "category": "insurance",
    "price": {
      "original": 89000,
      "final": 62300,
      "discount_percentage": "30%",
      "currency": "EUR"
    }
  },
  {
    "sku": "000002",
    "name": "Compact Car X3",
    "category": "vehicle",
    "price": {
      "original": 99000,
      "final": 99000,
      "discount_percentage": null,
      "currency": "EUR"
    }
  }
]
```

> This app comes with complete CRUD api for products, you can test the other api routes by enabling it in the api routes file.

