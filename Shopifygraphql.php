<?php
/**
 * Author: Gulshan <gulshans09@outlook.com>
 * Project: Shopifygraphql
 * Date: 2025-04-08
 */
include_once 'config.php'; // Ensure this file contains the SHOPIFY_GRAPHQL constant

class Shopifygraphql
{
    /**
     * Execute a cURL request to the Shopify API.
     *
     * @param string $apiEndPoint The API endpoint to call.
     * @param array $params The parameters to send with the request.
     * @param string $method The HTTP method to use (GET, POST, DELETE, PUT).
     * @param int $shopifyAccount The Shopify account index.
     * @return array The response from the Shopify API.
     */

    public function fetchShopifyGraphQLData($query, $variables = [],$shopifyAccount = 0){
        $url='';
        $headerToken='';
		if(isset(SHOPIFY_GRAPHQL[$shopifyAccount])){
			$shopifyAccountInfo = SHOPIFY_GRAPHQL[$shopifyAccount];
			$url = $shopifyAccountInfo['ShopifyUrl'];
			$headerToken= $shopifyAccountInfo['SHOPIFY_API_ACCESS_TOKEN'];
		}
        if(empty($url) || empty($headerToken)){
            throw new \Exception('Shopify account configuration is missing or incomplete.');
        }
        $headers = [
            "Content-Type: application/json; charset=utf-8",
            'X-Shopify-Access-Token:'.$headerToken,
        ];
        $postData = [
            'query' => $query
        ];
        if($variables){
            $postData['variables'] = $variables;
        }
        $postData = json_encode($postData);
        
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
             throw new \Exception('Request Error: ' . curl_error($ch));
        }
        $decoded = json_decode($response, true);

        if (isset($decoded['errors'])) {
            throw new \Exception('GraphQL Errors: ' . print_r($decoded['errors'], true));
        }
        return $decoded['data'] ?? [];
    }
}