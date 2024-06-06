<?php
require 'includes/__header.php';
require 'includes/sidebar.php';
include 'Controller/UserController.php';

$username_error = $password_error = $email_error = $phone_error = $balance_error = $StateCode_error = $TownshipCode_error = '';

if (isset($_SESSION['msg'])) {
    echo "<h3>" . $_SESSION['msg'] . "</h3>";
    unset($_SESSION['msg']);
}

if (isset($_POST['submit'])) {
    $username = $password = $email = $phone = $balance = $StateCode = $TownshipCode = '';

    if (empty($_POST['username'])) {
        $username_error = 'Please fill username';
    } else {
        $username = htmlspecialchars($_POST['username']);
    }
    if (empty($_POST['password'])) {
        $password_error = 'Please fill password';
    } else {
        $password = htmlspecialchars($_POST['password']);
    }
    if (empty($_POST['email'])) {
        $email_error = 'Please fill email';
    } else {
        $email = htmlspecialchars($_POST['email']);
    }
    if (empty($_POST['phone'])) {
        $phone_error = 'Please fill phone';
    } else {
        $phone = htmlspecialchars($_POST['phone']);
    }
    if (empty($_POST['balance'])) {
        $balance_error = 'Please fill balance';
    } else {
        $balance = htmlspecialchars($_POST['balance']);
    }
    if (empty($_POST['StateCode'])) {
        $StateCode_error = 'Please fill StateCode';
    } else {
        $StateCode = htmlspecialchars($_POST['StateCode']);
    }
    if (empty($_POST['TownshipCode'])) {
        $TownshipCode_error = 'Please fill TownshipCode';
    } else {
        $TownshipCode = htmlspecialchars($_POST['TownshipCode']);
    }

    if ($username_error == '' && $password_error == '' && $email_error == '' && $phone_error == '' && $balance_error == '' && $StateCode_error == '' && $TownshipCode_error == '') {
        $user = new UserController();
        $user->register($username, $password, $email, $phone, $balance, $StateCode, $TownshipCode);
    }
}
?>

<div class="userRightbar">
    <div>
        <form method="post" class="registerForm">
            <label for="username">Username</label>
            <span><?php if(isset($username_error)) echo $username_error;?></span>
            <input type="text" placeholder="username" name="username">

            <label for="password">Password</label>
            <span><?php if(isset($password_error)) echo $password_error; ?></span>
            <input type="password" placeholder="password" name="password">

            <label for="email">Email</label>
            <span><?php if(isset($email_error)) echo $email_error; ?></span>
            <input type="email" placeholder="email" name="email">

            <label for="phone">Phone</label>
            <span><?php if(isset($phone_error)) echo $phone_error; ?></span>
            <input type="number" placeholder="phone" name="phone">

            <label for="balance">Balance</label>
            <span><?php if(isset($balance_error)) echo $balance_error; ?></span>
            <input type="number" placeholder="balance" name="balance">

            <label for="StateCode">StateCode</label>
            <span><?php if(isset($StateCode_error)) echo $StateCode_error; ?></span>
            <input type="number" placeholder="StateCode" name="StateCode">

            <label for="TownshipCode">TownshipCode</label>
            <span><?php if(isset($TownshipCode_error)) echo $TownshipCode_error; ?></span>
            <input type="number" placeholder="TownshipCode" name="TownshipCode">

            <button type="submit" name="submit" value="submit">Submit</button>
        </form>
    </div>
</div>

<?php
require 'includes/__footer.php';
?>
