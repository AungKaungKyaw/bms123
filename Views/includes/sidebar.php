<?php
?>
<div class="userDashboard">
    <div class="userSidebar">
        <div class="userProfile">
            <img src="assets/img/user2.png" alt="">
            <p><?php
                if(isset($_SESSION['username'])){
                    echo $_SESSION['username'];
                }else if(isset($_SESSION['admin'])){
                    echo $_SESSION['admin'];
                } ?>
            </p>
</div>
<ul>
    <li><a href="home">Home</a></li>
    <?php if(!isset($_SESSION['admin'])) : ?>
    <li><a href="serviceSupport">Service Support</a></li>
    <?php else : ?>
        <li><a href="register">Register</a></li>
    <?php endif ?>
    <li><a href="logout">Logout</a></li>
</ul>
</div>