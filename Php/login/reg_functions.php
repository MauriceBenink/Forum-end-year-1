<?php


function check_req($type,$input)
{
    global $register_error_message;
    switch ($type) {
        case "password":
            if ((count(str_split($input)) >= 7)&&(count(str_split($input)) <= 20)) {
                if ((preg_match('/[0123456789]/', $input)) && (!preg_match('/[\(\)\[\]\}\{\<\>\;]/', $input)) && (preg_match('/[ABCDEFGHIJKLMNOPQRSTUVWXYZ]/', $input)) && (preg_match('/[abcdefghijklmnopqrstuvwxyz]/', $input))) {


                    return true;
                } else {
                    $register_error_message = "Please make sure your password contains atleast :1 capital letter, 1 lowercase letter and 1 number. the following symbols are prohibited! (){}<>[]";
                }

            } else {
                $register_error_message = ucfirst($type).": \"".preg_replace("/./",'*',$input)."\" is too long or too short, please use 7-20 charachters";
            }
            break;
        case "displayname":
        case "username":
            if ((count(str_split($input)) >= 5)&&(count(str_split($input)) <= 20)) {
                if (!preg_match('/[\(\)\[\]\}\{\<\>\;]/', $input)) {


                    return true;
                } else {
                    $register_error_message = "Use of :\"{}[]()<>\" in ".ucfirst($type)." are prohibited!";
                }
            } else {
                $register_error_message = ucfirst($type).": \"".ucfirst($input)."\" is too long or too short, please use 5-20 charachters";
            }
            break;
        case "email":
            if ((count(str_split($input)) >= 5)&&(count(str_split($input)) <= 50)) {
                if (!preg_match('/[\(\)\[\]\}\{/</>\;]/', $input)) {
                    if((preg_match('/[@]/',$input))&&(preg_match('/[.]/',$input))){


                        return true;
                    }else{
                        $register_error_message = "Please use a valid emailadress";
                    }
                } else {
                    $register_error_message = "Use of :\"{}[]()<>\" in". ucfirst($type)." are prohibited!";
                }
            }else{
                $register_error_message = ucfirst($type).": \"".ucfirst($input)."\" is too long or too short, please use 5-50 charachters";
            }
            break;
    }
    return false;

}
function check_reg_input($username,$displayname,$password,$confirmpassword,$email)
{
    global $register_error_message;
    if (($username != fullLower($displayname)) && ($username != fullLower($password)) && (fullLower($displayname) != fullLower($password)) && ($password === $confirmpassword)) {
        if ((check_req("username", $username)) && (check_req("displayname", $displayname)) && (check_req("password", $password)) && (check_req("email", $email))) {
            return true;
        }else{
            return false;
        }


    } else {
        if ($username != fullLower($displayname)) {
        } else {
            $register_error_message = "$register_error_message <br> Username cannot be the same as your Displayname ";
        }
        if ($username != fullLower($password)) {
        } else {
            $register_error_message = "$register_error_message <br> Username cannot be the same as your password ";
        }
        if (fullLower($displayname) != fullLower($password)) {
        } else {
            $register_error_message = "$register_error_message <br> Displayname cannot be the same as your password ";
        }
        if ($password === $confirmpassword) {
        } else {
            $register_error_message = "$register_error_message <br>  Passwords did not match ";

        }
        return false;
    }
}

function check_reg_unique($checkme,$type)
{
    global $register_error_message;
    global $conn;
    switch ($type) {
        case "username":
            $location = "login_name";
            break;
        case "displayname":
            $location = "display_name";
            break;
        case "email":
            $location = "email";
            break;
    }
    if ($location === "login_name") {
        $send_to_database = $conn->prepare("SELECT * FROM users WHERE $location = SHA1('$checkme')");
    } else {
        $send_to_database = $conn->prepare("SELECT * FROM users WHERE $location ='$checkme'");
    }
    $send_to_database->execute();
    $result = $send_to_database->fetchAll();
    if (!empty($result)) {
        $register_error_message = ucfirst($type)." is already in use";
        return false;
    } else {
        return true;
    }
}

function reg_account($username, $displayname, $password, $email,$hash){
    global $conn;
    $inert_into_database = $conn->prepare("INSERT INTO users (login_name, display_name, password, email,status)
    VALUES (SHA1('$username'), '$displayname', SHA1('$password'),'$email','0,$hash' )");
    $inert_into_database->execute();
    // use exec() because no results are returned

    echo "New record created successfully";
}

function activate_account($id){
    global $conn;
    $update_database = $conn->prepare( "UPDATE users SET status = '1,NULL' WHERE users.id = $id");
    $update_database->execute();
}
?>