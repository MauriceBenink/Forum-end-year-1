<?php
if (isset($_SESSION['id']) && isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800  )) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time
    session_destroy();   // destroy session data in storage
    header("Location:".$_SERVER['PHP_SELF']."");
}
$_SESSION['LAST_ACTIVITY'] = time();

function debug_r($input){
    echo "<br><pre>";
    print_r($input);
    echo "</pre>";
}

function array_r($input){
    print_r(var_dump($input));
}


function blacklist($input)
{
    global $register_error_message;
    $blacklist = file_get_contents("{$_SERVER['DOCUMENT_ROOT']}/forum/misc/blacklist.txt");
    $blacklist = explode("\r\n", $blacklist);
    $x = 0;
    do {
        if (str_split($blacklist[$x])[0] != '#') {
            if (preg_match("/$blacklist[$x]/i", $input, $match)) {
                $explodecont = explode(' ', $input);
                $y = 0;
                do {
                    if (str_split($blacklist[$x][0] === '$')) {
                        $fixstring = str_replace("$","",$blacklist[$x]);
                        if (preg_match("/\b$fixstring\b/i", $explodecont[$y], $match)) {
                            if (whitelist($explodecont[$y])) {
                                $register_error_message = "please do not use the word :\"$explodecont[$y]\" in your name";
                                return false;
                            }
                        }
                    }
                    if (preg_match("/$blacklist[$x]/i", $explodecont[$y], $match)) {
                        if (whitelist($explodecont[$y])) {
                            $register_error_message = "please do not use the word :\"$explodecont[$y]\" in your name";
                            return false;
                        }
                    }
                    if(count($explodecont) - 2 < $y){
                        $abe = false;
                    }else{
                        $abe = true;
                    }
                    ++$y;
                }while($abe);
            }
        }
        if (count($blacklist) - 2 < $x) {
            $abc = false;
        } else {
            $abc = true;
        }
        ++$x;
    } while ($abc);
    return [true];
}

//check if field is filled and give appropriate error as return
function check_POST($x,$tolowercase){
    global $register_error_message;
    if (!preg_match('/[\(\)\[\]\}\{\<\>]/', $_POST[$x])) {
        if (isset($_POST[$x]) && !empty($_POST[$x])) {
            if ($tolowercase) {
                return fullLower($_POST[$x]);
            } else {
                return $_POST[$x];
            }
        } else {
            if ($register_error_message === '') {
                $register_error_message = "<br> please enter your desired $x ";
            } else {
                $register_error_message = $register_error_message . ",$x ";
            }

        }
    }else {
        $register_error_message = "<br>use of (){}[]<> are prohibited ";
    }
}

function whitelist($input)
{

    $whitelist = file_get_contents("{$_SERVER['DOCUMENT_ROOT']}/forum/misc/whitelist.txt");
    $whitelist = explode("\r\n", $whitelist);
    $x = 0;
    do {
        if (str_split($whitelist[$x])[0] != '#') {
            if (str_split($whitelist[$x][0] === '$')) {
                $fixstring = str_replace("$","",$whitelist[$x]);
                if (preg_match("/\b$fixstring\b/i", $input, $match)) {
                    return false;
                }
            }else{
                if (preg_match("/$whitelist[$x]/i", $input, $match)) {
                    return false;
                }
            }
        }
        if (count($whitelist) - 2 < $x) {
            $abc = false;
        } else {
            $abc = true;
        }
        ++$x;
    } while ($abc);
    return true;

}

//taken from : http://php.net/manual/en/function.strtolower.php
function fullLower($str){
    // convert to entities
    $subject = htmlentities($str,ENT_QUOTES);
    $pattern = '/&([a-z])(uml|acute|circ';
    $pattern.= '|tilde|ring|elig|grave|slash|horn|cedil|th);/e';
    $replace = "'&'.strtolower('\\1').'\\2'.';'";
    $result = preg_replace($pattern, $replace, $subject);
    // convert from entities back to characters
    $htmltable = get_html_translation_table(HTML_ENTITIES);
    foreach($htmltable as $key => $value) {
        $result = ereg_replace(addslashes($value),$key,$result);
    }
    return(strtolower($result));
}

function user_by_id($id){
    global $conn;
    $send_to_database = $conn->prepare("SELECT * FROM users WHERE id ='$id'");
    $send_to_database->execute();
    $result = $send_to_database->fetchAll();
    return $result[0];
}
function select_all_main_topic(){
    global $conn;
    $send_to_database = $conn->prepare("SELECT * FROM main_topics");
    $send_to_database->execute();
    $result = $send_to_database->fetchAll();
    return $result;
}

?>