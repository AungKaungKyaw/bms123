<?php
session_start();
require 'config/init.php';
include 'Controller/HomeController.php';


$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
//echo $uri;
switch ($uri){
    case '/home':
    case '/':
        HomeController::show();
        break;
    case '/about':
        HomeController::about();
        break;
    case '/contact':
        HomeController::contact();
        break;
    case '/login':
        HomeController::showLoginForm();
        break;
    case '/loginUser':
        $user = new UserController();
        $user->login();
        break;
    case '/adminDashboard':
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == true){
            HomeController::showAdminDashboard();
        }else{
            $_SESSION['msg'] = 'login first';
            require 'Views/login.php';
        }
        break;
    case '/userDashboard':
        if((isset($_SESSION['login']) && $_SESSION['login'] == true) && (!isset($_SESSION['admin']))){
            HomeController::showUserDashboard();
        }else{
            $_SESSION['msg'] = 'Contact to admin team';
            require 'Views/login.php';
        }
        break;

    /*case '/depositForm':
        if(isset($_SESSION['login']) && $_SESSION['login'] == true){
            HomeController::showDepositForm();
        }else{
            $_SESSION['msg'] = 'login first';
            require 'Views/login.php';
        }
        break;*/
    case '/logout':
        UserController::logout();
        break;
    case '/deposit':
        $user = new UserController();
        $user->deposit();
        break;
    case '/withdraw':
        $user = new UserController();
        $user->withdraw();
        break;
    case '/transfer':
        $user = new UserController();
        $user->transfer();
        break;
    case '/register':
        HomeController::showRegister();
        break;

    default:
        require 'Views/404.php';
        break;
}

