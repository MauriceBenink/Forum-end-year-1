<?php

if(!isset($_SESSION)){
    session_start();
}

if(isset($_POST["level_down"])&&!empty($_POST["level_down"])){
    $level = explode("%%",$_POST['level_down']);
    if($level[1]!=''){
        $holder = explode("/",$level[1]);
        $holder[] = $level[0];
    }else{
        $holder = [$level[0]];
    }
    $holder = implode("/",$holder);
    echo "false%%<script>window.location.replace('landing.php?path=$holder');</script>";
}


if(isset($_POST["level_up"])&&!empty($_POST["level_up"])){
    $holder = explode("/",$_POST['level_up']);
    unset($holder[count($holder)-1]);
    $holder = implode("/",$holder);
    echo "false%%<script>window.location.replace('landing.php?path=$holder');</script>";
}

if((isset($_POST["to_top"]))){
    echo "false%%<script>window.location.replace('landing.php');</script>";
}

if(isset($_POST['edit_button'])&&!empty($_POST['edit_button'])) {
    $path = explode('/', $_SESSION['path']);
    if (count($path) == 3) {
        include("nice_edit.php");
        $rest = '<input class = "geustsee" type="checkbox" name="cansee"> geusts can see this comment<br><button id = "edit_comment">edit</button>';
        $title = '<input class = "title" name = "title" type = "text" placeholder="comment title">';
        $type = "comment";
        echo "false%%<script>
title = '$title';
element = $(document).find('div#{$_POST['edit_button']} > .comment-content-container > .comment-content');
elementTitle = $(element).find('.comment-title').html();
title = $(title).val(elementTitle);
console.log(title);
elementComment = $(element).find('.comment-comment').html();
$(document).find('#Insert-container').html('$niceEdit'+elementComment+'</div></div>'+'$rest').children().eq(0).before(title);


        $(document).find('#edit_comment').click(function(){comment_click()});
        
            
            
        function comment_click(){
            element =  $(document).find('#edit_comment').parent().find('div > .nicEdit-main').html();
            element2 =  $(document).find('#edit_comment').parent().find('.title').val();
            element3 =  $(document).find('#edit_comment').parent().find('.geustsee').prop('checked');
            
            console.log(element);           
            elementsend = element +'**'+ element2 +'**'+element3+'**'+{$_POST['edit_button']};
            
                                    
            try{if(((element2.match(/[\<\>\{\}\[\]]/)).length>0)){
                alert('the following symbols arent allowed []{}<>');
            }}
            catch(err){
                    if(element.replace(/<br>|&amp;|&lt;|&gt;|&nbsp;/g,'1').length >=25){
                        ajax_processer('edit_comment',elementsend);
                    }else{
                        alert('comment text is too short!');
                    }
                }
            }

</script>";
    } else {
        $return = "false%%";
        include_once "{$_SERVER['DOCUMENT_ROOT']}/forum/classes/database/database.php";
        if (database::getConn() == '') {
            new database();
        }
        switch (count($path)) {
            case 1:
                $data = database::standard("SELECT * FROM sub_topics WHERE id ={$_POST['edit_button']}");
                $content ='<br><br>';
                $elementcont = "elementcont = kasdhjkashdjkahskjdhaskjhjsahkjdhaksjdhjahdskajshdjkashdjkahsdjkahkjdshkjashdjkahsjkdhasjkdhakhsdkajsdhkahsdkjdshakjdhaksjdh;";
                break;
            case 2:
                $data = database::get_post($_POST['edit_button']);
                $content = "'<textarea placeholder = \"post content\">{$data['content']}</textarea><br>'";
                $elementcont = "elementcont = $(element).children().eq(4).val();";
                break;
            default:
                $data = database::standard("SELECT * FROM main_topics WHERE id ={$_POST['edit_button']}");
                $content ='<br><br>';
                $elementcont = "elementcont = kasdhjkashdjkahskjdhaskjhjsahkjdhaksjdhjahdskajshdjkashdjkahsdjkahkjdshkjashdjkahsjkdhasjkdhakhsdkajsdhkahsdkjdshakjdhaksjdh;";
                break;

        }
        if($data['user_level_req_vieuw'] == 8){
            $checked = "checked";
        }else{
            $checked = '';
        }

        $return .= "<script>
                    $(document).find('#Insert-container').html('' +
                        '<input placeholder = \"post title\" value = \"{$data['name']}\">' +
                        '<br>' +
                        '<input placeholder = \"post description\" value = \"{$data['description']}\">' +
                        '<br>' +                    
                        $content +
                        '<input class = \'geustsee\' type = \'checkbox\' $checked>geusts cant see '+
                        '<br>' +
                        '<button id = \'edit-post\'>edit post</button>'
                    );
                     $(document).find('#edit-post').click(function(){post_send()});
                     
                     
                     
                     
           function post_send(){
            element = $(document).find('#Insert-container');
            elementtitle = $(element).children().eq(0).val();
            elementdesc = $(element).children().eq(2).val();
            $elementcont;
                elementcheck = $(element).children().eq(6).prop('checked');
                console.log(elementtitle + '||'+elementdesc+'||'+elementcont);
                console.log(elementtitle.length + '||'+elementdesc.length+'||'+elementcont.length);
                try{if((((elementtitle+''+elementdesc+''+elementcont).match(/[\<\>\{\}\[\]\;]/)).length>0)){
                    alert('the following symbols arent allowed []{}<>;');
                }}
                catch(err){
                    if(elementtitle.length >= 10&&elementtitle.length <50 && elementdesc.length >= 10 && elementdesc.length < 100 && elementcont.length >= 50 && elementcont.length < 2000){
                        elementsend = elementtitle+'**'+elementdesc+'**'+elementcont+'**'+elementcheck+'**'+'{$_POST['edit_button']}';
                        ajax_processer('edit_post',elementsend);
                    }else{
                        alert('too long or too short');
                    }

                }
            }
                </script>";

        echo $return;
    }
}

if(isset($_POST['edit_post'])&&!empty($_POST['edit_post'])){
    $_SESSION['edit_post'] = $_POST['edit_post'];
    echo "true";
}

if(isset($_POST['edit_comment'])&&!empty($_POST['edit_comment'])){
    $_SESSION['edit_comment'] = $_POST['edit_comment'];
    echo "true";
}



if(isset($_POST['remove_button'])&&!empty($_POST['remove_button'])){
    $url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    echo "false%%";
    $check = explode(",",$_POST['remove_button']);
    if(isset($check[1])&&!empty($check[1])&&$check[1]!="null") {
        $_SESSION['delete'] = $_POST['remove_button'];
    }
    // update of post to banned in database + given reason + id of person who banned him
}

if(isset($_POST['status_button'])&&!empty($_POST['status_button'])){
    //for future order .
    // update status in the database to something else
}

if(isset($_POST['mod_button'])&&!empty($_POST['mod_button'])){
    echo 'false'."%%<script>alert('mods')</script>";
    //add/remove mods from a post by updating the affected user his class info
}

if(isset($_POST['new_comment'])&&!empty($_POST['new_comment'])) {
    $element = explode('%%', $_POST['new_comment']);
    include_once "{$_SERVER['DOCUMENT_ROOT']}/forum/classes/database/database.php";
    include_once "{$_SERVER['DOCUMENT_ROOT']}/forum/Php/global_functions.php";
    if(database::getConn() == ''){
        new database();
    }
    $user = database::get_user($_SESSION['id']);
    if($user[0]['level'] != 9) {
        $path = $_SESSION['path'];
        $path = explode("/", $path);
        if ($element[2]) {
            $vieuw = 8;
        } else {
            $vieuw = 9;
        }
        if (!preg_match('/[\(\)\[\]\}\{\<\>]/', $element[1]) && strlen($element[1]) > 10) {
            if (!preg_match('/<script>/', $element[0]) && strlen($element[0]) > 25) {
                if (blacklist($element[0] . '' . $element[1])) {
                    database::add_comment($element[1], $element[0], $user, $path[2], $vieuw);
                }
            }
        }
    }

    echo 'true' . "%%";
}

if(isset($_POST['new_post'])&&!empty($_POST['new_post'])) {
    echo "true";
    $_SESSION['new_post'] = explode("%%",$_POST['new_post']);
}

if(isset($_POST['pass-req-remove'])&&!empty($_POST['pass-req-remove'])) {
    include_once "{$_SERVER['DOCUMENT_ROOT']}/forum/classes/database/database.php";
    include_once "{$_SERVER['DOCUMENT_ROOT']}/forum/Php/global_functions.php";
    if(database::getConn() == ''){
        new database();
    }
    $id = $_SESSION['id'];
    database::no_return("UPDATE users SET status = '1,NULL' WHERE users.id = $id");
    echo "true";
}



?>
