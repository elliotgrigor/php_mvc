<?php

class PageController
{
    public static function index($req, $res) {
        return $res->view('pages/home/index');
    }

    public static function about($req, $res) {
        return $res->view('pages/about');
    }

    public static function products($req, $res) {
        $data  = array();
        $model = new ProductModel();

        if (isset($req->args[':id'])) {
            $arg_id  = $req->args[':id'];
            $product = $model->getProduct($arg_id);

            if (!is_null($product)) {
                // save ProductModel object
                $data['product'] = $product;
            } else {
                // return a 404?
                // return Router::notFound();
            }
        } else {
            $products = $model->getProductsArray();
            // save array of ProductModel objects
            $data['products'] = $products;
        }

        return $res->view('pages/products', $data);
    }
}