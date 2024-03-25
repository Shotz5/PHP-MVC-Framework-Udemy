<?php

namespace App\Controllers;

use App\Models\Product;
use Framework\Viewer;

class Products
{
    public function __construct(private Viewer $viewer)
    {
    }

    public function index()
    {
        $model = new Product;

        $products = $model->getData();

        echo $this->viewer->render("shared/header.php", [
            "title" => "Products",
        ]);

        echo $this->viewer->render("Products/index.php", [
            "products" => $products,
        ]);
    }

    public function show(string $id)
    {
        $viewer = new Viewer;

        echo $viewer->render("shared/header.php", [
            "title" => "Product",
        ]);

        echo $viewer->render("Products/show.php", [
            "id" => $id
        ]);
    }

    public function showPage(string $title, string $id, string $page)
    {
        echo $title, " ", $id, " ", $page;
    }
}
