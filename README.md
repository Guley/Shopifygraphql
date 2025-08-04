# Shopify-PHP

A PHP library for interacting with the Shopify GraphQL API.  
This project demonstrates how to fetch Shopify orders using GraphQL.

## Requirements

- PHP 7.4+
- cURL extension enabled
- Shopify store and API credentials

## 🚀 Tech Stack

### 💻 Programming Languages  
![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white)

## Setup

1. Clone this repository.
2. Add your Shopify API credentials to `Shopifygraphql.php`.
3. Use the `Sample.php` file as a reference for making API calls.

## Shopify GraphQL API Reference

- [Shopify GraphQL Admin API Docs](https://shopify.dev/docs/api/admin-graphql)
- [Order Object](https://shopify.dev/docs/api/admin-graphql/2023-10/objects/Order)
- [Customer Object](https://shopify.dev/docs/api/admin-graphql/2023-10/objects/Customer)
- [LineItem Object](https://shopify.dev/docs/api/admin-graphql/2023-10/objects/LineItem)

## Example Usage

### Fetch Orders

The `Sample` class provides a method to fetch orders from Shopify using GraphQL.

#### Function: `getOrders()`

Fetches the first 5 open orders with customer and line item details.

**Example:**
```php
include_once 'Sample.php';

$sample = new Sample();
$result = $sample->getOrders();

print_r($result);
```

**Returned Data:**
- Order ID, created/updated dates
- Customer info (ID, name, email)
- Total and subtotal price
- Line items (ID, title, quantity, prices, variant info)

**GraphQL Query Used:**
```graphql
query getOrders($first: Int!, $query: String) {
  orders(first: $first, query: $query) {
    edges {
      node {
        id
        updatedAt
        createdAt
        customer {
          id
          firstName
          lastName
          email
        }
        totalPriceSet {
          shopMoney {
            amount
            currencyCode
          }
        }
        subtotalPriceSet {
          shopMoney {
            amount
            currencyCode
          }
        }
        lineItems(first: 20) {
          edges {
            node {
              id
              title
              quantity
              discountedUnitPriceSet {
                presentmentMoney {
                  amount
                  currencyCode
                }
              }
              originalUnitPriceSet {
                presentmentMoney {
                  amount
                  currencyCode
                }
              }
              variant {
                id
                title
              }
            }
          }
        }
      }
    }
  }
}
```

## License

GNU GENERAL PUBLIC LICENSE

## 📫 How to Reach Me
- **Email**: gulshans09@outlook.com

## 📫 Connect With Me

[![LinkedIn](https://img.shields.io/badge/LinkedIn-blue?style=flat&logo=linkedin)](https://www.linkedin.com/in/guley)
[![X](https://img.shields.io/badge/Twitter-1DA1F2?style=flat&logo=twitter&logoColor=white)](https://x.com/_shakotu)
[![Portfolio](https://img.shields.io/badge/Portfolio-000?style=flat&logo=vercel&logoColor=white)](https://guley.github.io/portfolio/)
