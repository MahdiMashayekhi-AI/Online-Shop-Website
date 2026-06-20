<?php

namespace App\Controllers;

use Core\Controller;

class AboutController extends Controller{
    public function index(){
        $title = "درباره ما";

        $this->view("About", compact("title"));
    }
}