<!DOCTYPE html>
<html lang = "nl">
<head>
</head>
<?php
session_start();
include "php/forum.php";
include "php/login/reg_functions.php";
include "php/global_functions.php";
?>




<?php
$naam = POST_isset('naam');

function POST_isset($x){
    if(!empty($_POST["$x"])&&isset($_POST["$x"])){
        return $_POST["$x"];
    }else {
        return "";
    }
}


$register_error_message = '';
$username = '';
$displayname = '';
$password = '';
$confirmpassword = '';
$email = '';
$confirmemail = '';

if(!isset($_SESSION['id'])) {
    if (isset($_REQUEST['Submit'])) {
        //check if everything has been enterd correctly and if all is correct it will send it off to next function to check inputs else it will give $register_error_message a value/message
        $username = check_POST('username',true);
        $displayname = check_POST('displayname',false);
        $password = check_POST('password',false);
        $confirmpassword = check_POST('confirmpassword',false);
        $email = check_POST('email',true);
        $confirmemail = check_POST('confirmemail',true);
        if ($register_error_message != '') {
            $register_error_message = $register_error_message . "<br><br>";
        } else {
            //checks if there are any forbidden words in the name
            if ($email === $confirmemail) {
                if (blacklist($username . ' ' . $displayname)) {
                    //check if all inputfield comply with the requirements
                    if (check_reg_input($username, $displayname, $password, $confirmpassword, $email)) {
                        //check $username, $displayname and $email on being unique in the database
                        if ((check_reg_unique($username, "username")) && (check_reg_unique($displayname, "displayname")) && (check_reg_unique($email, "email"))) {

                            $hash = $random_hash = md5(uniqid(rand(), true));
                            reg_account($username, $displayname, $password, $email, $hash);
                            //send a email to the given emailadress with the $hash code !
                            echo "<br> a mail has been send to: $email with a vertification code, upon login youll be taken to the vartification page automaticly<script>setTimeout(function(){window.location.href ='Index.php'},2500)</script>";
                        }
                    }
                }
            }else{
                $register_error_message = "Emails didnt match";
            }
        }
    }
}else{
    header("Location: landing.php?");
}


echo '<br>'.$register_error_message;

?>
<div>Login name is not case sensitive, password is case sensitive</div><br
<body>
<form method="post">
    <div>Username:<input class = 'rowz' name="username" type="text" placeholder="name used to login"></div>
    <div>Display Name:<input class = 'rowz' name="displayname" type="text" placeholder="name displayed on site"></div>
    <div>Password:<input class = 'rowz' name="password" type="password" placeholder="insert password" ></div>
    <div>confirm Password:<input class = 'rowz' name="confirmpassword" type="password" placeholder="repeat password" ></div>
    <div>Email adress:<input class = 'rowz' name="email" type="text" placeholder="this@is_a.example"></div>
    <div>confirm Email adress:<input class = 'rowz' name="confirmemail" type="text" placeholder="this@is_a.example"></div>
    <input name="Submit" type="Submit" value="Register" >
</form>
<form action = "index.php"><input type="submit" value="back to Login"></form>

</body>
</html>