<?php
/**
 * Created by PhpStorm.
 * User: @htinlynn
 * Date: 04/07/2021
 * Time: 13:53
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../models/Product.php';
include_once '../services/ProductService.php';

$database = new Database();
$db = $database->getConnection();

$items = new Product($db);
$productService = new productService();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // create products
    $productService->storeProduct($items);
} else {
    //get products
    $productService->getProducts($items);
}




