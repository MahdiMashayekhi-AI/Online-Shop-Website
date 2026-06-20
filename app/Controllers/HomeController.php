<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use Core\Controller;

class HomeController extends Controller {

  public function index(){
    $title = "فروشگاه آنلاین";

    $popularCategories = CategoryModel::popular(4);
    $mostExpensiveProducts = ProductModel::getMostExpensiveProducts(3);
    $newestProducts = ProductModel::getNewestProducts(4);

    $this->view("Home",
        compact(
            "title",
            'popularCategories',
            'mostExpensiveProducts',
            'newestProducts'));
  }
}