<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="assets/css/mystyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<header class="container">
    <nav class="header_nav">
        <ul>
            <li><a href="/"><img class="imgLogo" src="assets/img/universe-high-resolution-logo.png" alt=""></a></li>
            <li><a href="home">Home</a></li>
            <li><a href="about">About</a></li>
            <li><a href="contact">Contact</a></li>
        </ul>
        <ul>

            <li><input class="inputHeader" type="text" placeholder="Search"></li>
            <?php if(!isset($_SESSION['login'])) : ?>
            <li><a href="login">login</a></li>
            <li><a href="signUp">sign up</a></li>
            <?php else : ?>
            <li><a href="logout">logout</a></li>
            <?php endif ?>

        </ul>
    </nav>
</header>
<section class="content container">


