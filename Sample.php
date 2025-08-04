<?php

/**
 * Author: Gulshan <gulshans09@outlook.com>
 * Project: Shopifygraphql
 * Date: 2025-04-08
 * Sample.php - Example usage of Shopifygraphql to fetch Shopify orders via GraphQL API.
 * This file demonstrates how to use the Shopifygraphql class to query order data from Shopify.
 */
include_once 'Shopifygraphql.php'; // Ensure this file contains the Shopifygraphql class
class Sample
{
    protected $shopifyGraphQl;

    public function __construct()
    {
        $this->shopifyGraphQl = new Shopifygraphql();
    }

    public function getOrders()
    {
        // Example query: Fetch first 5 orders
        $query = <<<GQL
            query getOrders(\$first: Int!, \$query: String) {
                orders(first: \$first, query: \$query) {
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
        GQL;

        try {
            $variables = [
                'first' => 5,
                'query' => 'status:open'
            ];
            $response = $this->shopifyGraphQl->fetchShopifyGraphQLData($query, $variables);
            return $response;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}