<?php

class ProductModel
{
    private $table;

    /** table columns **/
    public $id;
    public $name;
    public $description;
    /** ************* **/

    public function __construct(
        $id = null,
        $name = null,
        $description = null
    ) {
        $this->table = new Table('products');
        // below only used for creating model instances
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    public function getProductsArray() {
        $rows     = $this->table->getAll();
        $products = array();

        foreach ($rows as $row) {
            array_push($products,
                new ProductModel(
                    $row['id'],
                    $row['name'],
                    $row['description'],
                )
            );
        }

        return $products;
    }

    public function getProduct($id) {
        if (is_int($id) && $id > 0) {
            $product = $this->table->get($id);

            if ($product) {
                return new ProductModel(
                    $product['id'],
                    $product['name'],
                    $product['description'],
                );
            }
        }

        return null;
    }

    public function save($model) {
        // use model object to save to database
    }
}