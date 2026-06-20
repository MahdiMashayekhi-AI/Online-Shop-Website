<?php

namespace Core;

use App\Helpers;

class Router {

  private static array $routes = [];

  private static function addRoute(string $route, string $controller, string $action, string $method): void{
    self::$routes[$method][$route] = ["Controller" => $controller, "Action" => $action];
  }

  public static function get($route, $controller, $action): void {
    self::addRoute($route, $controller, $action, "GET");
  }
  
  public static function post($route, $controller, $action): void {
    self::addRoute($route, $controller, $action, "POST");
  }

  public static function dispatch(){
    $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    $method = $_SERVER["REQUEST_METHOD"];

    if(isset(self::$routes[$method][$uri])){
        if ($method === "POST"){
            if (!Helpers::validateCsrfToken($_POST['_token'] ?? null)) {
                http_response_code(403);
                die("CSRF Attack Detected!");
            }
        }
      $controller = self::$routes[$method][$uri]["Controller"];
      $action = self::$routes[$method][$uri]["Action"];

      $controller = new $controller;
      $controller->$action();
    }else{
      http_response_code(404);
      die("404 - Not Found!");
    }
  }
}