<?php
function check_password_recovery($username,$email){
    global $conn;
    global $register_error_message;
    $send_to_database = $conn->prepare("SELECT * FROM users WHERE login_name = SHA1('$username') AND email = '$email'");
    $send_to_database->execute();
    $result = $send_to_database->fetchAll();
    if (count($result) == 1) {
        return $result[0];
    }else{
        $register_error_message = "no account found with this email and/or username";
    }
}

function update_status($id,$hash){
    global $conn;
    $update_database = $conn->prepare( "UPDATE users SET status = '2,$hash' WHERE users.id = $id");
    $update_database->execute();

}
function password_reset($username,$email,$hash,$password){
    global $conn;
    global $register_error_message;
    $send_to_database = $conn->prepare("SELECT * FROM users WHERE login_name = SHA1('$username') AND email = '$email'");
    $send_to_database->execute();
    $result = $send_to_database->fetchAll();
    if(count($result)==1) {
        $status = explode(",", $result[0]['status']);
        if($status[0]==2){
            if($status[1]==$hash){
                $id = $result[0]['id'];
                $update_database = $conn->prepare("UPDATE users SET status = '1,NULL' WHERE users.id = $id");
                $update_database->execute();
                $update_database = $conn->prepare("UPDATE users SET password = SHA1('$password') WHERE users.id = $id");
                $update_database->execute();
                $register_error_message ="password sucsessfully changed";
            }else{
                $register_error_message ="inccorect code";
            }

        }else{
            $register_error_message = "this account has not been set to resetpassword, check your email and username";
        }
    }
}
?>