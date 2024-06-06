<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit1'])) {
        echo "submit1";
    } else if (isset($_POST['submit2'])) {
        echo "submit2";
    }
}
?>

<form action="" method="post">
    <input type="text" placeholder="asdf">
    <button type="submit" name="submit1" value="submit1">Submit 1</button>
</form>

<form action="" method="post">
    <input type="text" placeholder="asdf">
    <button type="submit" name="submit2" value="submit2">Submit 2</button>
</form>
