<?php

namespace App\Controllers;

use App\Helpers;
use App\Models\CategoryModel;
use App\Models\CommentModel;
use App\Models\ProductModel;
use Core\Controller;

class ProductsController extends Controller{
    public function index()
    {
        $cat = (int)($_GET['cat'] ?? 0);
        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 6;
        $where = ["is_active" => 1];

        if ($cat > 0) $where["category_id"] = $cat;

        $totalProducts = ProductModel::count($where);
        $totalPages = max(1, ceil($totalProducts / $limit));
        $page = min($page, $totalPages);
        $offset = ($page - 1) * $limit;

        $products = ProductModel::select(
            "*",
            $where,
            ["price", "DESC"],
            $limit,
            $offset
        );

        $categories = CategoryModel::select(
            "id, name",
            ["is_active" => 1],
            ["id", "DESC"]
        );

        $search = trim($_GET['search'] ?? '');
        $title = "محصولات";

        if ($search !== '')
            $products = ProductModel::search($search);

        $this->view("Products",
            compact(
                "products",
                "categories",
                "totalProducts",
                "totalPages",
                "page",
                "cat",
                "title",
            )
        );
    }

    public function show(){
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) Helpers::redirect("/products");

        $product = ProductModel::find($id);
        if (!$product) Helpers::redirect("/products");

        $search = trim($_GET['search'] ?? '');
        $title = $product['name'];
        $category = CategoryModel::find($product['category_id']);
        $comments = CommentModel::getByProduct($product['id']);
        $noComments = CommentModel::count();
        $meanComments = CommentModel::getAverageRating($product['id']);
        $relatedProducts = ProductModel::relatedProducts($product['category_id'], $product['id']);

        $this->view("ProductDetails",
            compact(
                "product",
                "search",
                        "title",
                        "category",
                        "comments",
                        "noComments",
                        "meanComments",
                        "relatedProducts"));
    }

    public function storeComment()
    {
        if (empty($_SESSION['user']))
            Helpers::redirect("/login");

        $productId = (int)$_POST['product_id'];
        $rating = (int)$_POST['rating'];
        $comment = trim($_POST['comment']);

        if ($rating < 1 || $rating > 5 || $comment === '') {
            Helpers::setSession("error", "اطلاعات نامعتبر میباشد");
            Helpers::redirect("/products?id={$productId}");
        }

        CommentModel::insert([
            "product_id" => $productId,
            "user_id" => $_SESSION['user']['id'],
            "comment" => $comment,
            "rating" => $rating,
            "created_at" => time()
        ]);

        Helpers::redirect("/products?id={$productId}");
    }
}