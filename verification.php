<!DOCTYPE html>
<html lang = "nl">
<head>
</head>
<?php
session_start();
include "php/forum.php";
include "php/reg_functions.php";
include "php/global_functions.php";
?>


<?php
if(isset($_COOKIE['id'])) {
    $register_error_message = '';
    $verification = '';
    if (isset($_POST['verification']) && !empty($_POST['verification'])) {
        $verification = $_POST['verification'];
        $user = user_by_id($_COOKIE['id']);
        $status = explode(",", $user['status']);
        if ($status[0] == 0) {
            if ($status[1] == $verification) {
                echo "<br>verification code accepted, welkom !";
                activate_account($user['id']);
                header("Location: index.php?");
            } else {
                echo "<br>wrong code please try again";
            }
        } else {
            echo "<br>verification code has already been enterd";
        }
    }
    if (isset($_REQUEST['logout'])) {
        setcookie('id', 'die', 1);
        header("Location: index.php?");
    }
}else{
    header("Location: index.php?");
}
?>
<form method="post">
    <div>verification :<input class = 'rowz' name="verification" type="text" placeholder="name used to login"></div>
    <input name="Submit" type="Submit" value="Register" >
</form>
<form method="post">
    <input name="logout" type="Submit" value="logout" >
</form>

</body>
</html>