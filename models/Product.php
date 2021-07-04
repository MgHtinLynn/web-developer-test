<?php
/**
 * Created by PhpStorm.
 * User: @htinlynn
 * Date: 04/07/2021
 * Time: 14:17
 */
class Product
{
    // Connection
    private $conn;

    // Table
    private $db_table = "products";
    private $join_table = "product_quantities";
    private $quantity = 1;

    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }
    /**
     * GET all product with left join
     * @return mixed
     */
    public function getProducts()
    {
        $sqlQuery = "SELECT ".$this->db_table.".*,".$this->join_table.".quantity
                    FROM ".$this->db_table.
            " LEFT JOIN ".$this->join_table.
            " ON ".$this->db_table.".product_quantity_id=".$this->join_table.".id";

        $lists = $this->conn->prepare($sqlQuery);
        $lists->execute();
        return $lists;
    }

    /**
     * @param $name
     * @param $price
     * @return mixed
     */
    public function checkProduct($name, $price)
    {
        $sqlQuery = "SELECT
                        product_quantity_id
                      FROM
                        ".$this->db_table."
                    WHERE 
                       name = :name AND price = :price
                    LIMIT 0,1";
        $list = $this->conn->prepare($sqlQuery);
        $list->bindParam(':name', $name);
        $list->bindParam(':price', $price);
        $list->execute();
        return $list->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param $productQuantityId
     * Increment Quantity column
     * @return false | [Query]
     */
    public function updateIncrementQuantity($productQuantityId)
    {
        try {
            $sqlQuery = "UPDATE ".$this->join_table." 
                    SET quantity = quantity + 1
                    WHERE id = '".$productQuantityId."'";

            $list = $this->conn->prepare($sqlQuery);
            $list->execute();
            return $list;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @return false| "lastInsertId"
     */
    public function createProductQuantity()
    {
        try {
            $sqlQuery = "INSERT INTO
                        ".$this->join_table."
                    SET
                        quantity = :quantity";

            $list = $this->conn->prepare($sqlQuery);
            $list->bindParam(':quantity', $this->quantity);
            $list->execute();
            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            return false;
        }
    }


// CREATE

    /**
     * @param $product
     * @param $productQuantityId
     * @return false| [Query]
     */
    public function createProduct($product, $productQuantityId)
    {
        try {
            $sqlQuery = "INSERT INTO
                        ".$this->db_table."
                    SET
                        name = :name,
                        description = :description,
                        price = :price,
                        created = :created,
                        product_quantity_id = :product_quantity_id";

            $list = $this->conn->prepare($sqlQuery);

            $list->bindParam(':name', $product['name']);
            $list->bindParam(':description', $product['description']);
            $list->bindParam(':price', $product['price']);
            $list->bindParam(':created', $product['date']);
            $list->bindParam(':product_quantity_id', $productQuantityId);
            $list->execute();
            return $list;
        } catch (Exception $e) {
            return false;
        }
    }

}
