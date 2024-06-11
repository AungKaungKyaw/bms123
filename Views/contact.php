<?php
require 'includes/__header.php';
if(isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['contact-email']) && isset($_POST['contact-phone'])){
        if(empty($_POST['contact-email'])){
            $email_error = 'Please fill email';
        } else {
            $email = htmlspecialchars($_POST['contact-email']);
        }
        if(empty($_POST['contact-phone'])){
            $phone_error = 'Please fill phone';
        } else {
            $phone = htmlspecialchars($_POST['contact-phone']);
        }
        $user = new UserController();
        $user->contact($_POST['contact-email'],$_POST['contact-phone']);
    }
}

?>
<div class="">
    <div class="headingGetintouch">
        <h1>Get in Touch</h1>
    </div>
    <div class="contactMidContent">

        <div class="contactMidDiv">
            <i class="fa-regular fa-map fa-2x circle_icon"></i>
            <div class="contactInfoList">
                <h1>Shop 1</h1>
                <p>123 Main Street, Cityville, State, 12345</p>
                <h1>Shop 2</h1>
                <p>456 Elm Street, Townsville, State, 56789</p>
                <h1>Shop 3</h1>
                <p>789 Oak Avenue, Villagetown, State, 98765</p>
            </div>
        </div>
        <div class="contactMidDiv">
            <i class="fa-solid fa-phone fa-2x circle_icon"></i>
            <div class="contactInfoList">
                <h1>Phone 1</h1>
                <p>123-456-7890</p>
                <h1>Phone 2</h1>
                <p>456-789-0123</p>
                <h1>Phone 3</h1>
                <p>789-012-3456</p>
            </div>
        </div>
        <div class="contactMidDiv">
            <i class="fa-solid fa-reply fa-2x circle_icon"></i>
            <div class="contactInfoList">
                <h1>Email 1</h1>
                <p>example1@example.com</p>
                <h1>Email 2</h1>
                <p>example2@example.com</p>
                <h1>Email 3</h1>
                <p>example3@example.com</p>
            </div>
        </div>


    </div>
    <div class="containerLeave">
        <h2>Contact Us</h2>
        <form action="#" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <span><?php if(isset($email_error)) echo $email_error; ?></span>
                <input type="email" id="email" name="contact-email" placeholder="Your email address" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <span><?php if(isset($phone_error)) echo $phone_error; ?></span>
                <input type="number" id="phone" name="contact-phone" placeholder="Your phone number" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>
</div>

<?php
require 'includes/__footer.php';

?>


