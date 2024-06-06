<?php

include 'Controller/HomeController.php';

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
//echo $uri;
switch ($uri){
    case '/':
        HomeController::show();
        break;
    case '/about':
        HomeController::about();
        break;
    case '/contact':
        HomeController::contact();
        break;
    default:
        require 'Views/404.php';
        break;
}
