<?php
/**
 * Created by PhpStorm.
 * User: @htinlynn
 * Date: 04/07/2021
 * Time: 14:33
 */

class ProductService
{
    private $error;
    private $errorMessage;

    /**
     * ProductService constructor.
     */
    public function __construct()
    {
        $this->error = false;
        $this->errorMessage = [];
    }

    /**
     * get Products [GET]
     * @param $items
     * return echo json
     */
    public function getProducts($items)
    {
        $lists = $items->getProducts();
        $itemCount = $lists->rowCount();

        if ($itemCount > 0) {

            $productArr["data"] = [];
            $productArr["itemCount"] = $itemCount;

            while ($row = $lists->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $e = array(
                    "id" => $id,
                    "name" => $name,
                    "price" => $price,
                    "quantity" => $quantity,
                    "description" => $description,
                    "created" => $created
                );

                $productArr["data"][] = $e;
            }
            echo json_encode($productArr);
        } else {

            http_response_code(404);
            echo json_encode(["message" => "No record found."]);
        }

    }

    /**
     * store product (POST)
     * @param $items
     */
    public function storeProduct($items)
    {
        $this->validationProducts();
        if ($this->error) {
            http_response_code(422);
            echo json_encode(
                ['message' => $this->errorMessage]
            );
        } else {
            $result = $this->createProduct($items);
            if ($result) {
                http_response_code(201);
                echo json_encode([
                    'message' => 'successfully create products'
                ]);
            } else {
                http_response_code(500);
                echo json_encode(["message" => "Something Wrong."]);
            }
        }
    }

    /**
     * validation check for input params
     */
    private function validationProducts()
    {
        if (empty($_POST['name'])) {
            $this->error = true;
            $this->errorMessage['name'] = 'name is required to fill';
        } elseif (!is_string($_POST['name'])) {
            $this->error = true;
            $this->errorMessage['name'] = 'name field is must be string';
        } elseif (strlen($_POST['name']) > 255) {
            $this->error = true;
            $this->errorMessage['name'] = 'name field is must not greater then 255 string';
        }

        if (empty($_POST['description'])) {
            $this->error = true;
            $this->errorMessage['description'] = 'description is required to fill';
        } elseif (!is_string($_POST['description'])) {
            $this->error = true;
            $this->errorMessage['name'] = 'description field is must be string';
        }

        if (empty($_POST['price'])) {
            $this->error = true;
            $this->errorMessage['price'] = 'price is required to fill';
        }
    }

    /**
     * @param $items
     * @return mixed|null
     */
    private function createProduct($items)
    {
        $productExist = $items->checkProduct($_POST['name'], $_POST['price']);
        $result = null;
        if ($productExist) {
            //increase quantity
            $result = $items->updateIncrementQuantity($productExist['product_quantity_id']);
        } else {
            //create new for create product quantity first
            $resultProductQuantityId = $items->createProductQuantity();
            if ($resultProductQuantityId) {
                // create product
                $product = $_POST;
                $product['date'] = date('Y-m-d H:i:s');
                $result = $items->createProduct($product, $resultProductQuantityId);
            }
        }
        return $result;
    }
}
