<?php
require 'includes/__header.php';

if(isset($_SESSION['msg'])){
    echo "<h3>" . $_SESSION['msg'] . "</h3>";
    unset($_SESSION['msg']);
}
?>

<form action="loginUser" method="post" class="form">
    <img src="assets/img/user2.png" alt="">
    <input type="text" placeholder="username" name="email"><br>
    <input type="password" placeholder="password" name="password"><br>
    <input type="submit" value="submit">
</form>
<?php
require 'includes/__footer.php';
?>

