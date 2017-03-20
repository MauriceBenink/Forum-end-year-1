<!DOCTYPE html>
<html lang = "nl">
<head>
</head>
<?php
session_start();
include "php/forum.php";
include "php/global_functions.php";
include "php/login/recovery_functions.php";
include "php/login/reg_functions.php";
?>


<?php

$register_error_message = '';
$username = '';
$email = '';
$code = '';
$password = '';
$confirmpassword = "";

if(!isset($_SESSION['id'])) {
    if(isset($_POST['username'])&&isset($_POST['email'])&&(empty($_POST['code'])||!isset($_POST['code']))) {
        $username = check_POST('username',true);
        $email = check_POST('email',true);
        $result = check_password_recovery($username,$email);
        if(empty($register_error_message)){
            $status = explode(",", $result['status']);
            if($status[0]!=2) {
                $hash = $random_hash = md5(uniqid(rand(), true));
                //send mail to users given email with the hash code with link to reseting password page
                update_status($result['id'], $hash);
                $register_error_message = "a mail has been send to your email";
            }else{
                $register_error_message = "a email already has been send, please be patient untill the email arrives, if it did not arrive at all please contact us";
            }
        }

    }else if(isset($_POST['username'])&&isset($_POST['email'])&&isset($_POST['code'])){
        $username = check_POST('username',true);
        $email = check_POST('email',true);
        $code = check_POST('code',false);
        $password = check_POST('password',false);
        $confirmpassword = check_POST('confirmpassword',false);
        if(empty($register_error_message)) {
            if ($password === $confirmpassword) {
                if (($password === $confirmpassword) && check_req('password', $password)) {
                    password_reset($username, $email, $code, $password);
                } else {
                    $register_error_message = "passwords didnt match, or password didnt match the requirements (7-20 length, must contain 1 capital, 1 lowercase and 1 number and (){}[] are prohibited)";
                }
            }
        }else{
            $register_error_message = "Email's didnt match";
        }
    }
}else{
    header("Location: landing.php?");
}


echo '<br>'.$register_error_message;

?>
<div>Login name is not case sensitive, password is case sensitive</div><br>
<body>
<form method="post">
    <div>Username:<input class = 'rowz' name="username" type="text" placeholder="name used to login"></div>
    <div>Email adress:<input class = 'rowz' name="email" type="text" placeholder="this@is_a.example"></div>
    <div>the following area's are not required for getting the code, only for ressting the password</div>
    <div>code:<input class = 'rowz' name="code" type="text" ></div>
    <div>new password:<input class = 'rowz' name="password" type="password" ></div>
    <div>confirm password:<input class = 'rowz' name="confirmpassword" type="password" ></div>
    <input name="Submit" type="Submit" value="Submit" >
</form>
<form action = "index.php"><input type="submit" value="Back"></form>

</body>
</html>