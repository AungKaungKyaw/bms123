<?php
require 'includes/__header.php';
if(isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>
<div class="midContent">
    <h1>Banking Solution</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, fuga id. Adipisci aliquam amet consequuntur, eaque eligendi explicabo fugiat impedit inventore iusto laboriosam, nemo porro rerum sapiente temporibus voluptate voluptatibus.</p>
    <ul>
        <li><a href="deposit">Deposit</a></li>
        <li><a href="withdraw">Withdraw</a></li>
        <li><a href="userDashboard">Dashboard</a></li>
        <li><a href="serviceSupport">Service Support</a></li>
    </ul>
</div>


<?php
require 'includes/__footer.php';
?>
