<?php
class HomeController{
    public static function show(){
        include 'Views/home.php';
    }
    public static function contact(){
        include 'Views/contact.php';
    }
    public static function about(){
        include 'Views/about.php';
    }
    public static function showLoginForm(){
        include 'Views/login.php';
    }
    public static function showUserDashboard(){
        include 'Views/userDashboard.php';
    }
    public static function showAdminDashboard(){
        include 'Views/adminDashboard.php';
    }
    public static function showRegister(){
        include 'Views/register.php';
    }

}
